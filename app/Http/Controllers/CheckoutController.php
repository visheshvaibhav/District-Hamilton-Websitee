<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\DeliverySetting;
use App\Models\AddOn;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use App\Mail\OrderConfirmation;
use App\Mail\OrderReceived;
use App\Notifications\OrderStatusChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        // Get the cart from the session
        $cart = session()->get('cart', []);
        
        // If cart is empty, redirect to cart page
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
            // Add add-on prices if any
            if (isset($item['add_ons']) && is_array($item['add_ons']) && !empty($item['add_ons'])) {
                $addOnIds = $item['add_ons'];
                $addOns = AddOn::whereIn('id', $addOnIds)->get();
                $addOnTotal = $addOns->sum('price') * $item['quantity'];
                $subtotal += $addOnTotal;
            }
        }
        
        // Calculate tax and total
        $taxRate = config('app.tax_rate', 0.13); // Default to 13%
        $tax = $subtotal * $taxRate;
        $total = $subtotal + $tax;
        
        // Set up Stripe if needed
        $stripeKey = config('services.stripe.key');
        
        return view('checkout.index', compact('cart', 'subtotal', 'tax', 'total', 'stripeKey'));
    }
    
    /**
     * Process the checkout form submission.
     */
    public function process(Request $request)
    {
        // Validate the checkout form
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address_street' => 'nullable|string|max:255',
            'address_city' => 'nullable|string|max:100',
            'address_postcode' => 'nullable|string|max:20',
            'payment_method' => 'required|in:credit_card,cash',
            'pickup_time' => 'nullable|date_format:Y-m-d H:i:s',
            'special_instructions' => 'nullable|string|max:500',
            'stripe_payment_id' => 'nullable|string',
            'tip_percentage' => 'nullable|integer|min:0|max:100',
        ]);
        
        // Get the cart items
        $cart = session()->get('cart', []);
        
        // If cart is empty, redirect back
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
        
        // Calculate totals
        $subtotal = 0;
        
        foreach ($cart as $itemId => $item) {
            $itemTotal = $item['price'] * $item['quantity'];
            $addOnTotal = 0;
            
            // Add add-on prices if any
            if (isset($item['add_ons']) && is_array($item['add_ons']) && !empty($item['add_ons'])) {
                $addOnIds = $item['add_ons'];
                $addOns = AddOn::whereIn('id', $addOnIds)->get();
                $addOnTotal = $addOns->sum('price') * $item['quantity'];
                $itemTotal += $addOnTotal;
            }
            
            $subtotal += $itemTotal;
        }
        
        // Calculate tax and total
        $taxRate = config('app.tax_rate', 0.13); // Default to 13%
        $tax = $subtotal * $taxRate;
        
        // Add delivery fee if applicable
        $deliveryFee = 0;
        $tipPercentage = 0;
        $tipAmount = 0;
        
        if ($request->order_type === 'delivery') {
            // Get delivery fee from settings
            $deliverySettings = DeliverySetting::getSettings();
            $deliveryFee = $deliverySettings->delivery_fee;
            
            // Handle tip if provided
            if ($request->filled('tip_percentage') && $request->tip_percentage > 0) {
                $tipPercentage = (int) $request->tip_percentage;
                $tippingSettings = \App\Models\TippingSetting::getSettings();
                
                if ($tippingSettings->isTippingEnabled()) {
                    try {
                        // Get available percentages (should be a flat array of numbers)
                        $availablePercentages = $tippingSettings->getAvailableTipPercentages();
                        
                        // Validate the percentage is in the available options
                        if (in_array($tipPercentage, $availablePercentages)) {
                            $tipAmount = $tippingSettings->calculateTipAmount($subtotal, $tipPercentage);
                        } else {
                            // If not a valid percentage, set to 0
                            $tipPercentage = 0;
                            $tipAmount = 0;
                        }
                    } catch (\Exception $e) {
                        // If any error occurs during tip calculation, log it and set tip to 0
                        Log::error('Tip calculation error: ' . $e->getMessage());
                        $tipPercentage = 0;
                        $tipAmount = 0;
                    }
                }
            }
        }
        
        $total = $subtotal + $tax + $deliveryFee + $tipAmount;
        
        // Format address if delivery
        $address = null;
        if ($request->order_type === 'delivery' && $request->address_street) {
            $address = $request->address_street . ', ' . 
                       $request->address_city . ', ' . 
                       $request->address_postcode;
        }
        
        // Process payment if credit card was selected
        $paymentStatus = 'pending';
        $stripePaymentId = null;
        
        if ($request->payment_method === 'credit_card') {
            try {
                // Set Stripe API key
                Stripe::setApiKey(config('services.stripe.secret'));
                
                // Create or confirm payment intent
                if ($request->filled('stripe_payment_id')) {
                    $paymentIntent = PaymentIntent::retrieve($request->stripe_payment_id);
                    
                    // Confirm the payment if needed
                    if ($paymentIntent->status !== 'succeeded') {
                        $paymentIntent->confirm();
                    }
                    
                    if ($paymentIntent->status === 'succeeded') {
                        $paymentStatus = 'paid';
                        $stripePaymentId = $paymentIntent->id;
                    }
                } else {
                    // Handle the case where no payment ID was provided
                    return redirect()->back()->with('error', 'Payment processing failed. Please try again.');
                }
            } catch (ApiErrorException $e) {
                Log::error('Stripe payment error: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Payment processing failed: ' . $e->getMessage());
            }
        }
        
        // Generate a unique order number
        $orderNumber = Order::generateOrderNumber();
        
        // Map 'takeout' to 'pickup' to match the database enum constraint
        $orderType = $request->order_type === 'takeout' ? 'pickup' : $request->order_type;
        
        // Create the order
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_name' => $request->name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'order_type' => $orderType,
            'delivery_address' => $address,
            'tip_percentage' => $tipPercentage,
            'tip_amount' => $tipAmount,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_fee' => $deliveryFee,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_status' => $paymentStatus,
            'status' => 'pending',
            'stripe_payment_id' => $stripePaymentId,
            'pickup_time' => $request->pickup_time,
            'notes' => $request->special_instructions,
        ]);
        
        // Create order items
        foreach ($cart as $cartItem) {
            $orderItem = new OrderItem([
                'menu_item_id' => $cartItem['item_id'],
                'name' => $cartItem['name'],
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price'],
                'subtotal' => $cartItem['price'] * $cartItem['quantity'],
                'special_instructions' => $cartItem['special_instructions'] ?? null,
            ]);
            
            $order->items()->save($orderItem);
            
            // Save add-ons if any
            if (isset($cartItem['add_ons']) && !empty($cartItem['add_ons'])) {
                $orderItem->addOns()->attach($cartItem['add_ons']);
            }
        }
        
        // Clear the cart
        session()->forget('cart');
        
        // Store the order ID in the session for the success page
        session()->put('last_order_id', $order->id);
        
        // Redirect to success page
        return redirect()->route('checkout.success');
    }
    
    /**
     * Handle Stripe payment intent creation.
     */
    public function createPaymentIntent(Request $request)
    {
        // Validate request
        $request->validate([
            'amount' => 'required|numeric|min:0.50',
            'tip_percentage' => 'nullable|integer|min:0|max:100',
        ]);
        
        try {
            // Set Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => round($request->amount * 100), // Convert to cents
                'currency' => 'cad',
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'tip_percentage' => $request->tip_percentage ?? 0,
                ],
            ]);
            
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe payment intent error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Display the order success page.
     */
    public function success()
    {
        // Get the last order ID from the session
        $orderId = session()->get('last_order_id');
        
        // If no order ID is found, redirect to home
        if (!$orderId) {
            return redirect()->route('home');
        }
        
        // Find the order with its items
        $order = Order::with('items')->find($orderId);
        
        // If order not found, redirect to home
        if (!$order) {
            return redirect()->route('home');
        }
        
        return view('checkout.success', compact('order'));
    }
} 