@extends('layouts.app')

@section('title', $item->name)

@section('content')
    <!-- Item Detail Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <a href="{{ route('menu.index') }}" class="inline-flex items-center mb-8 text-brand font-medium hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Menu
            </a>
            
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-1/2">
                        <div class="relative aspect-square">
                            <img src="{{ asset('storage/' . ($item->image_path ?: 'images/placeholder-food.jpg')) }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-lg">
                            
                            @if($item->is_featured)
                            <div class="absolute top-4 right-4 bg-accent-color text-dark px-3 py-1 rounded-full text-sm font-bold" style="background-color: var(--accent-color);">
                                Featured
                            </div>
                            @endif
                            
                            @if(!$item->is_available)
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center rounded-lg">
                                <span class="text-white text-2xl font-bold">Temporarily Unavailable</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="lg:w-1/2 p-8">
                        <div class="flex justify-between items-start mb-4">
                            <h1 class="text-3xl font-bold">{{ $item->name }}</h1>
                            <span class="text-2xl font-bold text-brand">${{ number_format($item->price, 2) }}</span>
                        </div>
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Description</h3>
                            <p class="text-gray-600">{{ $item->description }}</p>
                        </div>
                        
                        @if($item->tags->count() > 0)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Dietary & Allergen Information</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($item->tags as $tag)
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm">{{ $tag->tag_name }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        @if($item->is_available)
                        <form id="add-to-cart-form" action="{{ route('cart.add') }}" method="POST" class="mt-8">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            
                            @if($item->addOns->count() > 0)
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-4">Available Add-ons</h3>
                                
                                <div class="space-y-3">
                                    @foreach($item->addOns as $addOn)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="add_ons[]" id="add-on-{{ $addOn->id }}" value="{{ $addOn->id }}" class="h-5 w-5 rounded border-gray-300 text-brand focus:ring-brand">
                                        <label for="add-on-{{ $addOn->id }}" class="ml-2 flex-1">
                                            {{ $addOn->name }}
                                        </label>
                                        <span class="text-gray-700 font-medium">${{ number_format($addOn->price, 2) }}</span>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">Special Instructions</h3>
                                <textarea name="special_instructions" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand" placeholder="Any special requests or instructions..."></textarea>
                            </div>
                            
                            <div class="flex items-center mb-6">
                                <label for="quantity" class="text-lg font-semibold mr-4">Quantity:</label>
                                <div class="flex border border-gray-300 rounded-md">
                                    <button type="button" id="decrease-quantity" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-l-md">-</button>
                                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="99" class="w-16 text-center border-l border-r border-gray-300 py-1">
                                    <button type="button" id="increase-quantity" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-r-md">+</button>
                                </div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <div class="text-xl font-bold">
                                    Total: $<span id="total-price">{{ number_format($item->price, 2) }}</span>
                                </div>
                                <button type="submit" class="btn-primary py-3 px-6" style="background-color: var(--primary-color);">Add to Order</button>
                            </div>
                        </form>
                        @else
                        <div class="mt-8 bg-red-50 p-4 rounded-md">
                            <p class="text-red-700 font-medium">This item is currently unavailable. Please check back later.</p>
                        </div>
                        @endif
                        
                        <!-- Preparation Time Info -->
                        <div class="mt-8 bg-secondary-color p-4 rounded-md" style="background-color: var(--secondary-color);">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="font-medium">Preparation Time: Approximately {{ $item->preparation_time_minutes }} minutes</span>
                            </div>
                            
                            @if($item->is_pickup_only)
                            <div class="flex items-center mt-2 text-red-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="font-medium">This item is available for pickup only</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Related Items -->
            @if($relatedItems->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold mb-8">You Might Also Like</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedItems as $relatedItem)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden flex flex-col h-full">
                        <div class="relative w-full h-48 overflow-hidden">
                            <img src="{{ asset($relatedItem->image_path ?: 'images/placeholder-food.jpg') }}"
                                 alt="{{ $relatedItem->name }}"
                                 class="w-full h-full object-cover">
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $relatedItem->name }}</h3>
                                <span class="text-lg font-bold text-brand ml-2">${{ number_format($relatedItem->price, 2) }}</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">{{ Str::limit($relatedItem->description, 80) }}</p>
                            
                            <div class="mt-auto pt-4">
                                <a href="{{ route('menu.item', $relatedItem->slug) }}" class="btn-primary inline-block">View Item</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
    
    <!-- Cart Notification -->
    <div id="cart-notification" class="fixed bottom-4 right-4 bg-accent-color text-dark-color p-4 rounded-lg shadow-lg transform translate-y-full opacity-0 transition-all duration-300" style="background-color: var(--accent-color); color: var(--dark-color);">
        <p class="font-medium">Item added to your order!</p>
        <div class="flex justify-between items-center mt-2">
            <a href="{{ route('cart.index') }}" class="font-bold hover:underline">View Cart</a>
            <button id="close-notification" class="text-dark-color hover:text-primary-color">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityInput = document.getElementById('quantity');
        const decreaseBtn = document.getElementById('decrease-quantity');
        const increaseBtn = document.getElementById('increase-quantity');
        const totalPrice = document.getElementById('total-price');
        const addOns = document.querySelectorAll('input[name="add_ons[]"]');
        const cartNotification = document.getElementById('cart-notification');
        const closeNotification = document.getElementById('close-notification');
        const addToCartForm = document.getElementById('add-to-cart-form');
        
        // Base price of the item
        const basePrice = {{ $item->price }};
        
        // Add-on prices
        const addOnPrices = {
            @foreach($item->addOns as $addOn)
            {{ $addOn->id }}: {{ $addOn->price }},
            @endforeach
        };
        
        // Update the total price
        function updateTotalPrice() {
            let quantity = parseInt(quantityInput.value);
            let price = basePrice;
            
            // Add the price of selected add-ons
            addOns.forEach(addOn => {
                if (addOn.checked) {
                    price += addOnPrices[addOn.value];
                }
            });
            
            // Multiply by quantity
            let total = price * quantity;
            
            // Update the total price display
            totalPrice.textContent = total.toFixed(2);
        }
        
        // Quantity controls
        decreaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value > 1) {
                quantityInput.value = value - 1;
                updateTotalPrice();
            }
        });
        
        increaseBtn.addEventListener('click', function() {
            let value = parseInt(quantityInput.value);
            if (value < 99) {
                quantityInput.value = value + 1;
                updateTotalPrice();
            }
        });
        
        quantityInput.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (value < 1) this.value = 1;
            if (value > 99) this.value = 99;
            updateTotalPrice();
        });
        
        // Add-on checkboxes
        addOns.forEach(addOn => {
            addOn.addEventListener('change', updateTotalPrice);
        });
        
        // Form submission
        if (addToCartForm) {
            addToCartForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Get form data
                const formData = new FormData(this);
                
                // Send AJAX request to add to cart
                fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(Object.fromEntries(formData))
                })
                .then(response => response.json())
                .then(data => {
                    // Show notification
                    cartNotification.classList.remove('translate-y-full', 'opacity-0');
                    cartNotification.classList.add('translate-y-0', 'opacity-100');
                    
                    // Update cart count in header if needed
                    const cartCountEl = document.querySelector('.cart-badge');
                    if (cartCountEl) {
                        const currentCount = parseInt(cartCountEl.textContent || '0');
                        cartCountEl.textContent = currentCount + parseInt(quantityInput.value);
                        cartCountEl.classList.remove('hidden');
                    }
                    
                    // Hide notification after 3 seconds
                    setTimeout(() => {
                        hideNotification();
                    }, 3000);
                })
                .catch(error => {
                    console.error('Error adding to cart:', error);
                    alert('There was an error adding the item to your cart. Please try again.');
                });
            });
        }
        
        // Close notification
        if (closeNotification) {
            closeNotification.addEventListener('click', hideNotification);
        }
        
        function hideNotification() {
            cartNotification.classList.add('translate-y-full', 'opacity-0');
            cartNotification.classList.remove('translate-y-0', 'opacity-100');
        }
    });
</script>
@endpush 