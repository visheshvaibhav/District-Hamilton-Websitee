@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
    <!-- Hero Section for Cart -->
    <div class="hero" style="background-image: url('https://images.unsplash.com/photo-1555396273-367ea4eb4db5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2074&q=80');">
        <div class="hero-content">
            <h1>Your Cart</h1>
            <p>Review your selections and proceed to checkout when you're ready.</p>
        </div>
    </div>

    <div class="section py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-6 md:p-8">
                    <div id="cart-container">
                        <div id="empty-cart" class="text-center py-16 hidden">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="mt-6 text-2xl font-display font-bold text-gray-400">Your cart is empty</p>
                            <p class="mt-2 text-gray-500 max-w-md mx-auto">Looks like you haven't added any items to your cart yet.</p>
                            <div class="mt-8">
                                <a href="{{ route('menu') }}" class="btn-primary inline-flex items-center">
                                    <i class="fas fa-utensils mr-2"></i> Browse Our Menu
                                </a>
                            </div>
                        </div>
                        
                        <div id="cart-items" class="hidden">
                            <h2 class="text-2xl font-display font-bold mb-6 text-gray-900">Your Selected Items</h2>
                            
                            <div class="flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="overflow-hidden">
                                            <table class="min-w-full divide-y divide-gray-200">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                            Item
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                            Price
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                            Quantity
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500">
                                                            Subtotal
                                                        </th>
                                                        <th scope="col" class="relative px-6 py-3">
                                                            <span class="sr-only">Actions</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cart-table-body" class="bg-white divide-y divide-gray-200">
                                                    <!-- Cart items will be populated here by JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-12 flex flex-col lg:flex-row justify-between gap-8">
                                <div class="lg:w-1/2 xl:w-1/3 order-2 lg:order-1">
                                    <div class="bg-gray-50 p-6 rounded-lg shadow-sm border border-gray-100">
                                        <h3 class="text-xl font-display font-bold text-gray-900 mb-6 pb-4 border-b border-gray-200">Order Summary</h3>
                                        <div class="flex justify-between mb-4">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span id="cart-subtotal" class="text-gray-900 font-medium">$0.00</span>
                                        </div>
                                        <div class="flex justify-between mb-4">
                                            <span class="text-gray-600">Tax (13%)</span>
                                            <span id="cart-tax" class="text-gray-900 font-medium">$0.00</span>
                                        </div>
                                        <div class="border-t border-gray-200 my-4 pt-4"></div>
                                        <div class="flex justify-between mb-6">
                                            <span class="text-lg font-semibold text-gray-800">Total</span>
                                            <span id="cart-total" class="text-lg font-bold text-primary">$0.00</span>
                                        </div>
                                        <div class="mt-8">
                                            <a href="{{ route('checkout') }}" class="w-full py-3 flex justify-center items-center rounded-md bg-primary text-white font-semibold tracking-wide hover:bg-primary-dark transition duration-300 transform hover:-translate-y-1 shadow-md">
                                                <i class="fas fa-credit-card mr-2"></i> Proceed to Checkout
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="lg:w-1/2 xl:w-2/3 order-1 lg:order-2">
                                    <div class="flex flex-col sm:flex-row sm:justify-between gap-4">
                                        <button id="clear-cart" class="inline-flex items-center justify-center px-6 py-2 rounded-md text-gray-700 bg-white border border-gray-300 font-medium hover:bg-gray-50 transition duration-300">
                                            <i class="fas fa-trash-alt mr-2 text-gray-500"></i> Clear Cart
                                        </button>
                                        <a href="{{ route('menu') }}" class="inline-flex items-center justify-center px-6 py-2 rounded-md text-primary bg-white border border-primary font-medium hover:bg-primary/5 transition duration-300">
                                            <i class="fas fa-utensils mr-2"></i> Continue Shopping
                                        </a>
                                    </div>
                                    
                                    <div class="mt-8 p-6 bg-primary/5 rounded-lg border border-primary/20">
                                        <h4 class="font-display font-bold text-gray-800 mb-2">Note from The District Tapas + Bar</h4>
                                        <p class="text-sm text-gray-600 mb-2">Our dishes are crafted with fresh ingredients. If you have any dietary restrictions or special requests, please let us know in the "Special Instructions" field during checkout.</p>
                                        <p class="text-sm text-gray-600">For large group orders (8+ people), please consider calling us directly for a personalized experience.</p>
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
        // Initialize cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        updateCartDisplay();
        
        // Handle quantity changes
        function handleQuantityChange(id, newQuantity) {
            const itemIndex = cart.findIndex(item => item.id === id);
            
            if (itemIndex !== -1) {
                if (newQuantity <= 0) {
                    // Remove item if quantity is 0 or negative
                    cart.splice(itemIndex, 1);
                } else {
                    // Update quantity and recalculate subtotal
                    cart[itemIndex].quantity = newQuantity;
                    cart[itemIndex].subtotal = cart[itemIndex].price * newQuantity;
                }
                
                // Save to localStorage and update display
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
            }
        }
        
        // Handle item removal
        function handleRemoveItem(id) {
            const itemIndex = cart.findIndex(item => item.id === id);
            
            if (itemIndex !== -1) {
                cart.splice(itemIndex, 1);
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                
                // Add a nice notification
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-primary text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-y-20 opacity-0';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Item removed from cart</span>
                    </div>
                `;
                document.body.appendChild(notification);
                
                // Show notification with animation
                setTimeout(() => {
                    notification.classList.remove('translate-y-20', 'opacity-0');
                }, 100);
                
                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-y-20', 'opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 500);
                }, 3000);
            }
        }
        
        // Clear entire cart
        document.getElementById('clear-cart').addEventListener('click', () => {
            if (cart.length === 0) return;
            
            if (confirm('Are you sure you want to clear your cart?')) {
                cart = [];
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartDisplay();
                
                // Add a nice notification
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-primary text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-y-20 opacity-0';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>Cart cleared successfully</span>
                    </div>
                `;
                document.body.appendChild(notification);
                
                // Show notification with animation
                setTimeout(() => {
                    notification.classList.remove('translate-y-20', 'opacity-0');
                }, 100);
                
                // Remove notification after 3 seconds
                setTimeout(() => {
                    notification.classList.add('translate-y-20', 'opacity-0');
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 500);
                }, 3000);
            }
        });
        
        // Update cart display
        function updateCartDisplay() {
            const cartContainer = document.getElementById('cart-container');
            const emptyCart = document.getElementById('empty-cart');
            const cartItems = document.getElementById('cart-items');
            const cartTableBody = document.getElementById('cart-table-body');
            const cartSubtotal = document.getElementById('cart-subtotal');
            const cartTax = document.getElementById('cart-tax');
            const cartTotal = document.getElementById('cart-total');
            
            // Update cart badges in navigation
            const cartBadges = document.querySelectorAll('.cart-badge');
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            cartBadges.forEach(badge => {
                badge.textContent = count;
            });
            
            if (cart.length === 0) {
                emptyCart.classList.remove('hidden');
                cartItems.classList.add('hidden');
                return;
            }
            
            emptyCart.classList.add('hidden');
            cartItems.classList.remove('hidden');
            
            // Clear existing rows
            cartTableBody.innerHTML = '';
            
            // Calculate totals
            let subtotal = 0;
            
            // Add cart items to table
            cart.forEach(item => {
                subtotal += item.subtotal;
                
                const row = document.createElement('tr');
                row.className = 'hover:bg-gray-50';
                row.innerHTML = `
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-900">${item.name}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900">$${item.price.toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <button class="quantity-btn minus focus:outline-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded-l transition" data-id="${item.id}">
                                <i class="fas fa-minus text-xs"></i>
                            </button>
                            <span class="quantity-display bg-white px-4 py-1 border-t border-b text-center w-12">${item.quantity}</span>
                            <button class="quantity-btn plus focus:outline-none bg-gray-100 hover:bg-gray-200 text-gray-700 px-2 py-1 rounded-r transition" data-id="${item.id}">
                                <i class="fas fa-plus text-xs"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-900">$${item.subtotal.toFixed(2)}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <button class="remove-item text-gray-400 hover:text-red-600 focus:outline-none transition-colors duration-300" data-id="${item.id}">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </td>
                `;
                
                cartTableBody.appendChild(row);
            });
            
            // Calculate tax and total
            const tax = subtotal * 0.13; // 13% tax
            const total = subtotal + tax;
            
            // Update summary
            cartSubtotal.textContent = `$${subtotal.toFixed(2)}`;
            cartTax.textContent = `$${tax.toFixed(2)}`;
            cartTotal.textContent = `$${total.toFixed(2)}`;
            
            // Add event listeners for quantity buttons
            document.querySelectorAll('.quantity-btn.plus').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const item = cart.find(item => item.id === id);
                    if (item) {
                        handleQuantityChange(id, item.quantity + 1);
                    }
                });
            });
            
            document.querySelectorAll('.quantity-btn.minus').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    const item = cart.find(item => item.id === id);
                    if (item && item.quantity > 1) {
                        handleQuantityChange(id, item.quantity - 1);
                    } else if (item) {
                        handleRemoveItem(id);
                    }
                });
            });
            
            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-item').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    handleRemoveItem(id);
                });
            });
        }
    });
</script>
@endpush 