@extends('layouts.app')

@section('title', 'Checkout')

@section('header')
    <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div id="empty-cart-warning" class="hidden bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6" role="alert">
                        <p class="font-bold">Your cart is empty</p>
                        <p class="text-sm">Please add some items to your cart before checking out.</p>
                        <div class="mt-4">
                            <a href="{{ route('menu') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Browse our menu
                            </a>
                        </div>
                    </div>
                    
                    <div id="checkout-form-container">
                        <div class="flex flex-col lg:flex-row gap-8">
                            <div class="lg:w-2/3">
                                <h2 class="text-lg font-medium text-gray-900 mb-4">Order Details</h2>
                                
                                <form id="checkout-form" method="POST" action="{{ route('menu') }}" class="space-y-6">
                                    @csrf
                                    
                                    <div>
                                        <label for="order_type" class="block text-sm font-medium text-gray-700">Order Type</label>
                                        <select id="order_type" name="order_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="takeout">Takeout</option>
                                            <option value="delivery">Delivery</option>
                                        </select>
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
                                        <label for="scheduled_for" class="block text-sm font-medium text-gray-700">
                                            Schedule Time
                                        </label>
                                        <input type="datetime-local" name="scheduled_for" id="scheduled_for" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2">
                                        <div>
                                            <label for="customer_name" class="block text-sm font-medium text-gray-700">
                                                Full Name
                                            </label>
                                            <input type="text" name="customer_name" id="customer_name" autocomplete="name" required class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        
                                        <div>
                                            <label for="customer_phone" class="block text-sm font-medium text-gray-700">
                                                Phone Number
                                            </label>
                                            <input type="tel" name="customer_phone" id="customer_phone" autocomplete="tel" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                        
                                        <div class="sm:col-span-2">
                                            <label for="customer_email" class="block text-sm font-medium text-gray-700">
                                                Email
                                            </label>
                                            <input type="email" name="customer_email" id="customer_email" autocomplete="email" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                        </div>
                                    </div>
                                    
                                    <div id="delivery-address-container" class="hidden">
                                        <div class="sm:col-span-2">
                                            <label for="customer_address" class="block text-sm font-medium text-gray-700">
                                                Delivery Address
                                            </label>
                                            <textarea name="customer_address" id="customer_address" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">
                                            Special Instructions
                                        </label>
                                        <textarea name="notes" id="notes" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                    </div>
                                    
                                    <div>
                                        <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment Method</label>
                                        <select id="payment_method" name="payment_method" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                            <option value="cash">Cash</option>
                                            <option value="credit_card">Credit Card</option>
                                        </select>
                                    </div>
                                    
                                    <div id="card-element-container" class="hidden">
                                        <label for="card-element" class="block text-sm font-medium text-gray-700">
                                            Credit or debit card
                                        </label>
                                        <div id="card-element" class="mt-1 p-2 border border-gray-300 rounded-md">
                                            <!-- Stripe Elements Placeholder -->
                                            <p class="text-sm text-gray-500">Stripe payment integration will be implemented here</p>
                                        </div>
                                        <div id="card-errors" role="alert" class="mt-2 text-sm text-red-600"></div>
                                    </div>
                                    
                                    <input type="hidden" name="subtotal" id="input-subtotal" value="0">
                                    <input type="hidden" name="tax" id="input-tax" value="0">
                                    <input type="hidden" name="total" id="input-total" value="0">
                                    <input type="hidden" name="cart_items" id="input-cart-items" value="">
                                </form>
                            </div>
                            
                            <div class="lg:w-1/3">
                                <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                                    
                                    <div id="cart-summary">
                                        <div id="summary-items" class="space-y-2 mb-4 max-h-60 overflow-y-auto">
                                            <!-- Cart items will be populated here by JavaScript -->
                                        </div>
                                        
                                        <div class="border-t border-gray-200 pt-4 space-y-2">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Subtotal</span>
                                                <span id="summary-subtotal" class="text-gray-900 font-medium">$0.00</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Tax (13%)</span>
                                                <span id="summary-tax" class="text-gray-900 font-medium">$0.00</span>
                                            </div>
                                            <div class="border-t border-gray-200 my-2 pt-2"></div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-800 font-medium">Total</span>
                                                <span id="summary-total" class="text-gray-900 font-bold">$0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-6">
                                        <button type="submit" form="checkout-form" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Place Order
                                        </button>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <a href="{{ route('cart') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                            &larr; Return to cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Get cart from localStorage
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        // Check if cart is empty
        if (cart.length === 0) {
            document.getElementById('empty-cart-warning').classList.remove('hidden');
            document.getElementById('checkout-form-container').classList.add('hidden');
            return;
        }
        
        // Order type change handler
        const orderTypeSelect = document.getElementById('order_type');
        const deliveryAddressContainer = document.getElementById('delivery-address-container');
        
        orderTypeSelect.addEventListener('change', function() {
            if (this.value === 'delivery') {
                deliveryAddressContainer.classList.remove('hidden');
            } else {
                deliveryAddressContainer.classList.add('hidden');
            }
        });
        
        // Schedule time handler
        const scheduledTimeOption = document.getElementById('scheduled_time_option');
        const scheduledTimeContainer = document.getElementById('scheduled-time-container');
        
        scheduledTimeOption.addEventListener('change', function() {
            if (this.value === 'later') {
                scheduledTimeContainer.classList.remove('hidden');
            } else {
                scheduledTimeContainer.classList.add('hidden');
            }
        });
        
        // Payment method handler
        const paymentMethodSelect = document.getElementById('payment_method');
        const cardElementContainer = document.getElementById('card-element-container');
        
        paymentMethodSelect.addEventListener('change', function() {
            if (this.value === 'stripe') {
                cardElementContainer.classList.remove('hidden');
            } else {
                cardElementContainer.classList.add('hidden');
            }
        });
        
        // Populate order summary
        const summaryItemsContainer = document.getElementById('summary-items');
        const summarySubtotal = document.getElementById('summary-subtotal');
        const summaryTax = document.getElementById('summary-tax');
        const summaryTotal = document.getElementById('summary-total');
        
        const inputSubtotal = document.getElementById('input-subtotal');
        const inputTax = document.getElementById('input-tax');
        const inputTotal = document.getElementById('input-total');
        const inputCartItems = document.getElementById('input-cart-items');
        
        // Calculate totals
        let subtotal = 0;
        cart.forEach(item => {
            subtotal += item.subtotal;
            
            // Create summary item element
            const itemElement = document.createElement('div');
            itemElement.className = 'flex justify-between';
            itemElement.innerHTML = `
                <span class="text-sm text-gray-600">${item.quantity} x ${item.name}</span>
                <span class="text-sm text-gray-900">$${item.subtotal.toFixed(2)}</span>
            `;
            
            summaryItemsContainer.appendChild(itemElement);
        });
        
        // Calculate tax and total
        const tax = subtotal * 0.13; // 13% tax
        const total = subtotal + tax;
        
        // Update summary
        summarySubtotal.textContent = `$${subtotal.toFixed(2)}`;
        summaryTax.textContent = `$${tax.toFixed(2)}`;
        summaryTotal.textContent = `$${total.toFixed(2)}`;
        
        // Update hidden form inputs
        inputSubtotal.value = subtotal.toFixed(2);
        inputTax.value = tax.toFixed(2);
        inputTotal.value = total.toFixed(2);
        inputCartItems.value = JSON.stringify(cart);
        
        // Form submission handler
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, this would submit the form to the server
            alert('Order placed successfully! This is a demo implementation.');
            
            // Clear cart
            localStorage.removeItem('cart');
            
            // Redirect to home page
            window.location.href = '/menu';
        });
    });
</script>
@endpush 