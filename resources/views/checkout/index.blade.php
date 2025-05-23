@extends('layouts.app')

@php
use App\Models\DeliverySetting;
use App\Models\TippingSetting;
@endphp

@section('title', 'Checkout')

@section('header')
    <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
@endsection

@push('styles')
    @if(isset($stripeKey))
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tailwindcss/forms@0.5.4/src/index.min.css">
    <style>
        .StripeElement {
            background-color: white;
            padding: 16px;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }

        .StripeElement--focus {
            border-color: #6366F1;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
        }

        .StripeElement--invalid {
            border-color: #EF4444;
        }

        .StripeElement--complete {
            border-color: #10B981;
        }

        .payment-method-card {
            @apply relative p-4 border rounded-lg transition-all duration-200 bg-white;
        }

        .payment-method-card.selected {
            @apply border-indigo-500 ring-1 ring-indigo-500 ring-opacity-50;
        }

        .payment-status-badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }

        .payment-status-badge.processing {
            @apply bg-blue-100 text-blue-800;
        }

        .payment-status-badge.success {
            @apply bg-green-100 text-green-800;
        }

        .payment-status-badge.error {
            @apply bg-red-100 text-red-800;
        }

        .card-brand-icon {
            width: 40px;
            height: 25px;
            object-fit: contain;
            transition: all 0.2s ease;
        }

        .card-brand-icon:hover {
            filter: grayscale(0) opacity(1);
        }

        .secure-badge {
            @apply flex items-center space-x-2 text-sm text-gray-600 bg-gray-50 px-3 py-2 rounded-lg border border-gray-200;
        }
    </style>
    @endif
@endpush

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if(empty($cart))
                        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6" role="alert">
                            <p class="font-bold">Your cart is empty</p>
                            <p class="text-sm">Please add some items to your cart before checking out.</p>
                            <div class="mt-4">
                                <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Browse our menu
                                </a>
                            </div>
                        </div>
                    @else
                        <div id="checkout-form-container">
                            <div class="flex flex-col lg:flex-row gap-8">
                                <div class="lg:w-2/3">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Details</h2>
                                    
                                    <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" class="space-y-6">
                                        @csrf
                                        
                                        <div>
                                            <label for="order_type" class="block text-sm font-medium text-gray-700">Order Type</label>
                                            <select id="order_type" name="order_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="pickup">Pickup</option>
                                                <option value="delivery">Delivery</option>
                                            </select>
                                        </div>
                                        
                                        <div id="table-number-container">
                                            <label for="table_number" class="block text-sm font-medium text-gray-700">Table Number</label>
                                            <input type="text" name="table_number" id="table_number" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        
                                        <div>
                                            <label for="scheduled_for" class="block text-sm font-medium text-gray-700">
                                                When would you like your order?
                                            </label>
                                            <select id="scheduled_time_option" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="now">As soon as possible</option>
                                                <option value="later">Schedule for later</option>
                                            </select>
                                        </div>
                                        
                                        <div id="scheduled-time-container" class="hidden">
                                            <label for="pickup_time" class="block text-sm font-medium text-gray-700">
                                                Schedule Time
                                            </label>
                                            <input type="datetime-local" name="pickup_time" id="pickup_time" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        
                                        <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700">
                                                    Full Name
                                                </label>
                                                <input type="text" name="name" id="name" autocomplete="name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            
                                            <div>
                                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                                    Phone Number
                                                </label>
                                                <input type="tel" name="phone" id="phone" autocomplete="tel" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                            
                                            <div class="sm:col-span-2">
                                                <label for="email" class="block text-sm font-medium text-gray-700">
                                                    Email
                                                </label>
                                                <input type="email" name="email" id="email" autocomplete="email" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        
                                        <div id="delivery-address-container" class="hidden">
                                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                                <div class="sm:col-span-2">
                                                    <label for="address_street" class="block text-sm font-medium text-gray-700">
                                                        Street Address
                                                    </label>
                                                    <input type="text" name="address_street" id="address_street" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label for="address_city" class="block text-sm font-medium text-gray-700">
                                                        City
                                                    </label>
                                                    <input type="text" name="address_city" id="address_city" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                                <div>
                                                    <label for="address_postcode" class="block text-sm font-medium text-gray-700">
                                                        Postcode
                                                    </label>
                                                    <input type="text" name="address_postcode" id="address_postcode" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <!-- Tip Selection for Delivery -->
                                        <div id="tip-container" class="hidden">
                                            @php
                                                $tippingSettings = TippingSetting::getSettings();
                                                $tipPercentages = $tippingSettings->getAvailableTipPercentages();
                                                $tippingEnabled = $tippingSettings->isTippingEnabled();
                                            @endphp
                                            
                                            @if($tippingEnabled)
                                                <div class="mt-4">
                                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                                        Add a tip?
                                                    </label>
                                                    <div class="flex flex-wrap gap-2">
                                                        <input type="hidden" name="tip_percentage" id="tip_percentage" value="0">
                                                        <button type="button" class="tip-option bg-white border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-percentage="0">
                                                            No Tip
                                                        </button>
                                                        @foreach($tipPercentages as $percentage)
                                                            @php
                                                                // Ensure percentage is a numeric value
                                                                $percentValue = is_array($percentage) && isset($percentage['percentage']) 
                                                                    ? $percentage['percentage'] 
                                                                    : (is_numeric($percentage) ? $percentage : null);
                                                            @endphp
                                                            @if($percentValue !== null)
                                                                <button type="button" class="tip-option bg-white border border-gray-300 rounded-md py-2 px-4 text-sm font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-percentage="{{ $percentValue }}">
                                                                    {{ $percentValue }}%
                                                                </button>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <label for="special_instructions" class="block text-sm font-medium text-gray-700">
                                                Special Instructions
                                            </label>
                                            <textarea name="special_instructions" id="special_instructions" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                        </div>
                                        
                                        <div>
                                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                            <select id="payment_method" name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                                <option value="cash">Cash</option>
                                                <option value="credit_card">Credit Card</option>
                                            </select>
                                        </div>
                                        
                                        <!-- Credit Card Form -->
                                        <div id="credit-card-container" class="hidden">
                                            @if(isset($stripeKey))
                                            <div class="space-y-6">
                                                <!-- Secure Checkout Badge -->
                                                <div class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-lg border border-gray-200">
                                                    <div class="flex items-center space-x-3">
                                                        <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-900">Guaranteed safe & secure checkout</p>
                                                            <p class="text-xs text-gray-500">Your payment information is encrypted</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Card Input Section -->
                                                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                                                    <div class="space-y-4">
                                                        <div class="flex justify-between items-center mb-4">
                                                            <label for="card-element" class="block text-sm font-medium text-gray-700">
                                                                Card details
                                                            </label>
                                                            <div class="flex items-center space-x-1.5">
                                                                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/visa.svg" class="card-brand-icon" alt="Visa">
                                                                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/mastercard.svg" class="card-brand-icon" alt="Mastercard">
                                                                <img src="https://cdn.jsdelivr.net/npm/payment-icons@1.1.0/min/flat/amex.svg" class="card-brand-icon" alt="American Express">
                                                                <div class="w-px h-4 bg-gray-200 mx-1"></div>
                                                                <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                                </svg>
                                                            </div>
                                                        </div>
                                                        <div class="relative">
                                                            <div id="card-element" class="w-full">
                                                                <!-- Stripe Card Element will be inserted here -->
                                                            </div>
                                                        </div>
                                                        <div id="card-errors" class="text-sm text-red-600 mt-2 min-h-[20px]" role="alert"></div>
                                                    </div>

                                                    <!-- Payment Status Indicator -->
                                                    <div id="payment-status" class="hidden mt-4">
                                                        <div class="flex items-center space-x-2">
                                                            <div class="payment-status-badge processing">
                                                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-800" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                                Processing payment...
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Additional Security Info -->
                                                <div class="grid grid-cols-2 gap-4">
                                                    <div class="secure-badge">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                        </svg>
                                                        <span>End-to-end encryption</span>
                                                    </div>
                                                    <div class="secure-badge">
                                                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                        </svg>
                                                        <span>Secure SSL connection</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="stripe_payment_id" id="stripe_payment_id">
                                            @else
                                            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                                                <p class="font-bold">Credit card processing unavailable</p>
                                                <p class="text-sm">Please choose cash payment or try again later.</p>
                                            </div>
                                            @endif
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="lg:w-1/3">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                        <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                                        
                                        <div id="cart-summary">
                                            <div id="summary-items" class="space-y-2 mb-4 max-h-60 overflow-y-auto">
                                                @foreach($cart as $id => $item)
                                                    <div class="flex justify-between">
                                                        <div>
                                                            <span class="font-medium">{{ $item['quantity'] }} x {{ $item['name'] }}</span>
                                                            @if(isset($item['add_ons']) && count($item['add_ons']) > 0)
                                                                <div class="text-sm text-gray-500">
                                                                    Add-ons: {{ implode(', ', array_map(function($addOn) {
                                                                        return \App\Models\AddOn::find($addOn)->name;
                                                                    }, $item['add_ons'])) }}
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            <div class="border-t border-gray-200 pt-4 space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Subtotal</span>
                                                    <span id="summary-subtotal" class="text-gray-900 font-medium">${{ number_format($subtotal, 2) }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Tax (13%)</span>
                                                    <span id="summary-tax" class="text-gray-900 font-medium">${{ number_format($tax, 2) }}</span>
                                                </div>
                                                <div id="delivery-fee-row" class="flex justify-between hidden">
                                                    <span class="text-gray-600">Delivery Fee</span>
                                                    <span id="summary-delivery-fee" class="text-gray-900 font-medium">$0.00</span>
                                                </div>
                                                <div id="tip-amount-row" class="flex justify-between hidden">
                                                    <span class="text-gray-600">Tip</span>
                                                    <span id="summary-tip-amount" class="text-gray-900 font-medium">$0.00</span>
                                                </div>
                                                <div class="border-t border-gray-200 my-2 pt-2"></div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-800 font-medium">Total</span>
                                                    <span id="summary-total" class="text-gray-900 font-bold">${{ number_format($total, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6">
                                            <button type="submit" form="checkout-form" id="checkout-button" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                Place Order
                                            </button>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <a href="{{ route('cart.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                &larr; Return to cart
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@if(isset($stripeKey))
@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Stripe setup
        const stripe = Stripe('{{ $stripeKey }}');
        const elements = stripe.elements();
        const cardElement = elements.create('card', {
            style: {
                base: {
                    fontSize: '16px',
                    fontFamily: '"Inter", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
                    fontSmoothing: 'antialiased',
                    color: '#1F2937',
                    backgroundColor: '#FFFFFF',
                    '::placeholder': {
                        color: '#6B7280',
                    },
                    ':-webkit-autofill': {
                        color: '#1F2937',
                    },
                },
                invalid: {
                    color: '#EF4444',
                    iconColor: '#EF4444',
                }
            },
            hidePostalCode: true
        });
        
        cardElement.mount('#card-element');
        
        // Handle real-time validation errors
        cardElement.on('change', (event) => {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
                displayError.classList.remove('hidden');
            } else {
                displayError.textContent = '';
                if (event.complete) {
                    displayError.textContent = '✓ Card details complete';
                    displayError.classList.remove('text-red-600');
                    displayError.classList.add('text-green-600');
                }
            }
        });

        // Order type change handler
        const orderTypeSelect = document.getElementById('order_type');
        const tableNumberContainer = document.getElementById('table-number-container');
        const deliveryAddressContainer = document.getElementById('delivery-address-container');
        const deliveryFeeRow = document.getElementById('delivery-fee-row');
        const deliveryFeeAmount = document.getElementById('summary-delivery-fee');
        const tipContainer = document.getElementById('tip-container');
        const tipAmountRow = document.getElementById('tip-amount-row');
        const tipAmountDisplay = document.getElementById('summary-tip-amount');
        const subtotalElement = document.getElementById('summary-subtotal');
        const taxElement = document.getElementById('summary-tax');
        const totalElement = document.getElementById('summary-total');
        
        // Payment method handler
        const paymentMethodSelect = document.getElementById('payment_method');
        const creditCardContainer = document.getElementById('credit-card-container');
        const paymentStatus = document.getElementById('payment-status');
        
        // Tip option handling
        const tipOptions = document.querySelectorAll('.tip-option');
        const tipPercentageInput = document.getElementById('tip_percentage');
        
        // Always hide table number container - we don't use it for pickup or delivery
        if (tableNumberContainer) {
            tableNumberContainer.classList.add('hidden');
        }

        // Initialize order type handling
        if (orderTypeSelect) {
            orderTypeSelect.addEventListener('change', function() {
                if (this.value === 'delivery') {
                    // Show delivery address fields
                    if (deliveryAddressContainer) {
                        deliveryAddressContainer.classList.remove('hidden');
                    }
                    
                    // Show tip options for delivery
                    if (tipContainer) {
                        tipContainer.classList.remove('hidden');
                        tipAmountRow.classList.remove('hidden');
                    }
                    
                    // Show delivery fee in summary
                    const deliveryFee = {{ DeliverySetting::getSettings()->delivery_fee ?? 0 }};
                    if (deliveryFeeRow) {
                        deliveryFeeAmount.textContent = '$' + deliveryFee.toFixed(2);
                        deliveryFeeRow.classList.remove('hidden');
                    }
                    
                    // Update total
                    updateTotal();
                } else {
                    // Hide delivery address fields
                    if (deliveryAddressContainer) {
                        deliveryAddressContainer.classList.add('hidden');
                    }
                    
                    // Hide tip options for pickup
                    if (tipContainer) {
                        tipContainer.classList.add('hidden');
                        if (tipAmountRow) tipAmountRow.classList.add('hidden');
                    }
                    
                    // Hide delivery fee in summary
                    if (deliveryFeeRow) {
                        deliveryFeeRow.classList.add('hidden');
                    }
                    
                    // Update total
                    updateTotal();
                }
            });
            
            // Trigger change event to set initial state
            orderTypeSelect.dispatchEvent(new Event('change'));
        }

        // Initialize scheduled time option handling
        const scheduledTimeOption = document.getElementById('scheduled_time_option');
        const scheduledTimeContainer = document.getElementById('scheduled-time-container');
        
        if (scheduledTimeOption && scheduledTimeContainer) {
            scheduledTimeOption.addEventListener('change', function() {
                if (this.value === 'later') {
                    scheduledTimeContainer.classList.remove('hidden');
                } else {
                    scheduledTimeContainer.classList.add('hidden');
                }
            });
            
            // Set initial state
            scheduledTimeOption.dispatchEvent(new Event('change'));
        }

        // Initialize tip option handling
        if (tipOptions.length > 0 && tipPercentageInput) {
            tipOptions.forEach(option => {
                option.addEventListener('click', function() {
                    // Remove active classes from all options
                    tipOptions.forEach(opt => {
                        opt.classList.remove('bg-indigo-100', 'border-2', 'border-indigo-600');
                        opt.classList.add('border', 'border-gray-300');
                    });
                    
                    // Add active classes to selected option
                    this.classList.remove('border', 'border-gray-300');
                    this.classList.add('bg-indigo-100', 'border-2', 'border-indigo-600');
                    
                    // Update hidden input with selected percentage
                    const percentage = parseInt(this.dataset.percentage);
                    tipPercentageInput.value = percentage;
                    
                    // Calculate and display tip amount
                    const subtotal = parseFloat(subtotalElement.textContent.replace('$', ''));
                    const tipAmount = (subtotal * percentage / 100).toFixed(2);
                    
                    if (tipAmountDisplay) {
                        tipAmountDisplay.textContent = '$' + tipAmount;
                    }
                    
                    // Update total
                    updateTotal();
                });
            });
            
            // Set "No Tip" as default selected
            if (tipOptions[0]) {
                tipOptions[0].click();
            }
        }

        // Function to update total based on current values
        function updateTotal() {
            if (!subtotalElement || !totalElement) return;
            
            const subtotal = parseFloat(subtotalElement.textContent.replace('$', ''));
            const tax = parseFloat(taxElement ? taxElement.textContent.replace('$', '') : 0);
            let total = subtotal + tax;
            
            // Add delivery fee if applicable
            if (deliveryFeeRow && !deliveryFeeRow.classList.contains('hidden') && deliveryFeeAmount) {
                const deliveryFee = parseFloat(deliveryFeeAmount.textContent.replace('$', ''));
                total += deliveryFee;
            }
            
            // Add tip if applicable
            if (tipAmountRow && !tipAmountRow.classList.contains('hidden') && tipAmountDisplay) {
                const tipAmount = parseFloat(tipAmountDisplay.textContent.replace('$', ''));
                total += tipAmount;
            }
            
            totalElement.textContent = '$' + total.toFixed(2);
        }
        
        if (paymentMethodSelect) {
            paymentMethodSelect.addEventListener('change', function() {
                if (this.value === 'credit_card') {
                    creditCardContainer.classList.remove('hidden');
                    cardElement.update({ disabled: false });
                } else {
                    creditCardContainer.classList.add('hidden');
                    cardElement.update({ disabled: true });
                }
            });
            
            // Set initial state
            paymentMethodSelect.dispatchEvent(new Event('change'));
        }

        // Checkout form handler
        const checkoutForm = document.getElementById('checkout-form');
        const checkoutButton = document.getElementById('checkout-button');
        const stripe_payment_id = document.getElementById('stripe_payment_id');
        
        if (checkoutForm) {
            checkoutForm.addEventListener('submit', async function(event) {
                if (paymentMethodSelect.value === 'credit_card') {
                    event.preventDefault();
                    
                    // Update UI to processing state
                    checkoutButton.disabled = true;
                    checkoutButton.classList.add('opacity-75', 'cursor-not-allowed');
                    checkoutButton.innerHTML = `
                        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Processing...
                    `;
                    paymentStatus.classList.remove('hidden');
                    
                    try {
                        // Create payment intent
                        const response = await fetch('{{ route("checkout.payment-intent") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                amount: parseFloat(document.getElementById('summary-total').textContent.replace('$', '')),
                                tip_percentage: parseInt(document.getElementById('tip_percentage')?.value || 0)
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.error) {
                            throw new Error(data.error);
                        }
                        
                        // Confirm payment
                        const { error, paymentIntent } = await stripe.confirmCardPayment(
                            data.clientSecret,
                            {
                                payment_method: {
                                    card: cardElement,
                                    billing_details: {
                                        name: document.getElementById('name').value,
                                        email: document.getElementById('email').value
                                    }
                                }
                            }
                        );
                        
                        if (error) {
                            throw error;
                        }
                        
                        // Payment successful
                        stripe_payment_id.value = data.paymentIntentId;
                        paymentStatus.innerHTML = `
                            <div class="payment-status-badge success">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Payment successful!
                            </div>
                        `;
                        
                        // Submit the form
                        checkoutForm.submit();
                        
                    } catch (error) {
                        // Handle error
                        console.error('Payment error:', error);
                        document.getElementById('card-errors').textContent = error.message;
                        paymentStatus.innerHTML = `
                            <div class="payment-status-badge error">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Payment failed
                            </div>
                        `;
                        
                        // Reset button state
                        checkoutButton.disabled = false;
                        checkoutButton.classList.remove('opacity-75', 'cursor-not-allowed');
                        checkoutButton.textContent = 'Place Order';
                    }
                }
            });
        }
    });
</script>
@endpush
@endif 