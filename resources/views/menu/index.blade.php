@extends('layouts.app')

@section('title', 'Our Menu')

@section('content')
    <!-- Menu Header Section -->
    <section class="bg-primary-color text-white py-12" style="background-color: var(--primary-color);">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center">Our Menu</h1>
            <p class="text-xl text-center mt-4 max-w-2xl mx-auto">Explore our selection of authentic Spanish tapas, crafted with traditional recipes and the finest ingredients.</p>
        </div>
    </section>
    
    <!-- Menu Navigation -->
    <section class="bg-white py-6 shadow-md sticky top-0 z-10">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#all" class="category-filter px-4 py-2 rounded-full bg-secondary-color font-medium transition-colors hover:bg-accent-color active" 
                   style="background-color: var(--accent-color); color: var(--dark-color);"
                   data-category="all">
                    All Items
                </a>
                
                @foreach($categories as $category)
                <a href="#{{ $category->slug }}" class="category-filter px-4 py-2 rounded-full bg-gray-100 font-medium transition-colors hover:bg-accent-color" 
                   data-category="{{ $category->slug }}">
                    {{ $category->name }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    
    <!-- Menu Items Section -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            @foreach($categories as $category)
            <div id="{{ $category->slug }}" class="menu-category mb-16" data-category="{{ $category->slug }}">
                <h2 class="text-3xl font-bold mb-8 text-center">{{ $category->name }}</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($category->menuItems as $item)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden menu-item flex flex-col h-full">
                        <div class="relative w-full overflow-hidden">
                            <img src="{{ asset('storage/' . ($item->image_path ?: 'images/placeholder-food.jpg')) }}" 
                                alt="{{ $item->name }}" 
                                class="w-full h-48 object-cover">
                            
                            @if($item->is_featured)
                            <div class="absolute top-4 right-4 bg-accent-color text-dark px-3 py-1 rounded-full text-sm font-bold" style="background-color: var(--accent-color);">
                                Featured
                            </div>
                            @endif
                            
                            @if(!$item->is_available)
                            <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="text-white text-xl font-bold">Temporarily Unavailable</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-gray-900">{{ $item->name }}</h3>
                                <span class="text-lg font-bold text-brand ml-2">${{ number_format($item->price, 2) }}</span>
                            </div>
                            
                            <p class="text-gray-600 mb-4">{{ Str::limit($item->description, 100) }}</p>
                            
                            @if($item->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($item->tags as $tag)
                                <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">{{ $tag->tag_name }}</span>
                                @endforeach
                            </div>
                            @endif
                            
                            <div class="flex justify-between items-center mt-auto pt-4">
                                <a href="{{ route('menu.item', $item->slug) }}" class="text-brand font-medium hover:underline">View Details</a>
                                
                                @if($item->is_available)
                                <button 
                                    class="btn-primary add-to-cart-btn" 
                                    data-id="{{ $item->id }}" 
                                    data-name="{{ $item->name }}" 
                                    data-price="{{ $item->price }}">
                                    Add to Order
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
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
        // Category filtering
        const categoryFilters = document.querySelectorAll('.category-filter');
        const menuCategories = document.querySelectorAll('.menu-category');
        
        categoryFilters.forEach(filter => {
            filter.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all filters
                categoryFilters.forEach(f => f.classList.remove('active'));
                categoryFilters.forEach(f => f.style.backgroundColor = '');
                
                // Add active class to clicked filter
                this.classList.add('active');
                this.style.backgroundColor = 'var(--accent-color)';
                
                const selectedCategory = this.dataset.category;
                
                if (selectedCategory === 'all') {
                    // Show all categories
                    menuCategories.forEach(category => {
                        category.style.display = 'block';
                    });
                } else {
                    // Show only selected category
                    menuCategories.forEach(category => {
                        if (category.dataset.category === selectedCategory) {
                            category.style.display = 'block';
                        } else {
                            category.style.display = 'none';
                        }
                    });
                    
                    // Scroll to selected category
                    document.getElementById(selectedCategory).scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Add to cart functionality
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        const cartNotification = document.getElementById('cart-notification');
        const closeNotification = document.getElementById('close-notification');
        
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function() {
                const itemId = this.dataset.id;
                const itemName = this.dataset.name;
                const itemPrice = this.dataset.price;
                
                // Send AJAX request to add to cart
                fetch('{{ route('cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        quantity: 1,
                        special_instructions: ''
                    })
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
                        cartCountEl.textContent = currentCount + 1;
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
        });
        
        closeNotification.addEventListener('click', hideNotification);
        
        function hideNotification() {
            cartNotification.classList.add('translate-y-full', 'opacity-0');
            cartNotification.classList.remove('translate-y-0', 'opacity-100');
        }
    });
</script>
@endpush 