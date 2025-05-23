@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
    <!-- Cart Header Section -->
    <section class="bg-primary-color text-white py-12" style="background-color: var(--primary-color);">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center">Your Cart</h1>
            <p class="text-xl text-center mt-4 max-w-2xl mx-auto">Review your order before proceeding to checkout.</p>
        </div>
    </section>
    
    <!-- Cart Content -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            
            @if(empty($items))
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold mt-4">Your cart is empty</h2>
                    <p class="text-gray-600 mt-2">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('menu.index') }}" class="mt-6 inline-block bg-primary-color text-white px-6 py-3 rounded-lg font-semibold hover:bg-opacity-90 transition" style="background-color: var(--primary-color);">
                        Browse Our Menu
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 order-2 lg:order-1">
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200 hidden sm:table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Item
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($items as $id => $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if(isset($item['image_path']))
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}">
                                                </div>
                                                @endif
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $item['name'] }}
                                                    </div>
                                                    @if($item['selected_add_ons']->count() > 0)
                                                    <div class="text-sm text-gray-500">
                                                        Add-ons: {{ $item['selected_add_ons']->pluck('name')->implode(', ') }}
                                                    </div>
                                                    @endif
                                                    @if(!empty($item['special_instructions']))
                                                    <div class="text-sm text-gray-500">
                                                        Note: {{ $item['special_instructions'] }}
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">${{ number_format($item['price'], 2) }}</div>
                                            @if($item['selected_add_ons']->count() > 0)
                                            <div class="text-xs text-gray-500">
                                                + ${{ number_format($item['selected_add_ons']->sum('price'), 2) }} in add-ons
                                            </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <form class="quantity-form flex items-center" data-id="{{ $id }}">
                                                <button type="button" class="decrease-qty bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-l-md text-gray-700 font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class="fas fa-minus text-xs"></i>
                                                </button>
                                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-12 text-center border-t border-b border-gray-300 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" aria-label="Quantity">
                                                <button type="button" class="increase-qty bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-r-md text-gray-700 font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <i class="fas fa-plus text-xs"></i>
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">${{ number_format($item['item_total'], 2) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('cart.remove') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="item_id" value="{{ $id }}">
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Remove
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6 flex justify-between">
                            <a href="{{ route('menu.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-color">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                                </svg>
                                Continue Shopping
                            </a>
                            
                            <form action="{{ route('cart.clear') }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Clear Cart
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="order-1 lg:order-2">
                    <div>
                        <div class="bg-white rounded-lg shadow-lg p-6">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                            
                            <div class="border-t border-gray-200 py-4">
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900 font-medium">${{ number_format($subtotal, 2) }}</span>
                                </div>
                                
                                <div class="flex justify-between mb-2">
                                    <span class="text-gray-600">Tax (13%)</span>
                                    <span class="text-gray-900 font-medium">${{ number_format($subtotal * 0.13, 2) }}</span>
                                </div>
                                
                                <div class="border-t border-gray-200 pt-4 mt-2">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-bold">Estimated Total</span>
                                        <span class="text-lg font-bold">${{ number_format($subtotal + ($subtotal * 0.13), 2) }}</span>
                                    </div>
                                    <p class="text-gray-500 text-sm mt-1">Delivery fees and tip will be calculated at checkout</p>
                                </div>
                            </div>
                            
                            <div class="mt-6">
                                <a href="{{ route('checkout.index') }}" class="w-full flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-accent-color hover:bg-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-color" style="background-color: var(--accent-color); color: var(--dark-color);">
                                    Proceed to Checkout
                                </a>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <p class="text-sm text-gray-500">
                                    Need help with your order?<br>
                                    Call us at (905) 522-2580
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile view -->
                <div class="sm:hidden">
                    @foreach($items as $id => $item)
                    <div class="cart-row bg-white">
                        <div class="cart-item-details py-3">
                            <div class="flex items-center">
                                @if(isset($item['image_path']))
                                <div class="flex-shrink-0 h-14 w-14">
                                    <img class="h-14 w-14 rounded-full object-cover" src="{{ asset($item['image_path']) }}" alt="{{ $item['name'] }}">
                                </div>
                                @endif
                                <div class="ml-4">
                                    <div class="text-base font-medium text-gray-900">
                                        {{ $item['name'] }}
                                    </div>
                                    @if($item['selected_add_ons']->count() > 0)
                                    <div class="text-sm text-gray-500">
                                        Add-ons: {{ $item['selected_add_ons']->pluck('name')->implode(', ') }}
                                    </div>
                                    @endif
                                    @if(!empty($item['special_instructions']))
                                    <div class="text-sm text-gray-500">
                                        Note: {{ $item['special_instructions'] }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="cart-cell" data-label="Price">
                            <div class="text-gray-900">${{ number_format($item['price'], 2) }}
                                @if($item['selected_add_ons']->count() > 0)
                                <span class="text-xs text-gray-500">+ ${{ number_format($item['selected_add_ons']->sum('price'), 2) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="cart-cell" data-label="Quantity">
                            <form class="quantity-form flex items-center" data-id="{{ $id }}">
                                <button type="button" class="decrease-qty bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-l-md text-gray-700 font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-minus text-xs"></i>
                                </button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-12 text-center border-t border-b border-gray-300 py-2 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" aria-label="Quantity">
                                <button type="button" class="increase-qty bg-gray-200 hover:bg-gray-300 px-3 py-2 rounded-r-md text-gray-700 font-bold transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-plus text-xs"></i>
                                </button>
                            </form>
                        </div>
                        <div class="cart-cell" data-label="Total">
                            <div class="text-base font-medium text-gray-900">${{ number_format($item['item_total'], 2) }}</div>
                        </div>
                        <div class="cart-cell border-t border-gray-100 pt-2">
                            <form action="{{ route('cart.remove') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $id }}">
                                <button type="submit" class="text-red-600 hover:text-red-900 flex items-center justify-center w-full">
                                    <i class="fas fa-trash-alt mr-1"></i> Remove
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update quantity functionality
        const quantityForms = document.querySelectorAll('.quantity-form');
        
        quantityForms.forEach(form => {
            const itemId = form.dataset.id;
            const decreaseBtn = form.querySelector('.decrease-qty');
            const increaseBtn = form.querySelector('.increase-qty');
            const quantityInput = form.querySelector('input[name="quantity"]');
            
            // Decrease quantity
            decreaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    updateCartItem(itemId, currentValue - 1);
                }
            });
            
            // Increase quantity
            increaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                quantityInput.value = currentValue + 1;
                updateCartItem(itemId, currentValue + 1);
            });
            
            // Quantity input change
            quantityInput.addEventListener('change', function() {
                let newValue = parseInt(this.value);
                if (newValue < 1) {
                    this.value = 1;
                    newValue = 1;
                }
                updateCartItem(itemId, newValue);
            });
        });
        
        // Function to update cart item via AJAX
        function updateCartItem(itemId, quantity) {
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: quantity
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Reload the page to show updated cart
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                alert('There was an error updating your cart. Please try again.');
            });
        }
    });
</script>
@endpush

<style>
    @media (max-width: 640px) {
        .cart-table-header {
            display: none;
        }
        
        .cart-row {
            display: grid;
            grid-template-columns: 1fr;
            border-bottom: 1px solid #e5e7eb;
            padding: 1rem 0;
        }
        
        .cart-cell {
            padding: 0.5rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .cart-cell:before {
            content: attr(data-label);
            font-weight: 600;
            margin-right: 1rem;
        }
        
        .cart-item-details {
            grid-column: 1 / -1;
            padding: 0.5rem 1rem;
        }
        
        .quantity-form {
            margin: 0 auto;
        }
    }
</style> 