@extends('layouts.app')

@section('title', 'Our Menu')

@section('content')
    <!-- Hero Section for Menu -->
    <div class="hero" style="background-image: url('https://images.unsplash.com/photo-1514326640560-7d063ef2aed5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
        <div class="hero-content">
            <h1>Our Menu</h1>
            <p>Experience the authentic flavors of Spain with our carefully crafted tapas menu. Each dish tells a story of tradition and innovation.</p>
        </div>
    </div>

    <div class="section py-16 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Menu Introduction -->
            <div class="text-center mb-16">
                <h2 class="section-title mx-auto">Culinary Excellence</h2>
                <p class="mt-4 max-w-3xl mx-auto text-gray-600">Our menu reflects the passion of our chefs, combining traditional Spanish tapas with modern culinary techniques. We source only the finest ingredients to create memorable dining experiences.</p>
            </div>

            <!-- Featured Items Section -->
            <div class="mb-16">
                <h2 class="text-3xl font-display font-bold text-center mb-10">Featured Dishes</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach(\App\Models\MenuItem::getFeaturedItems() as $item)
                        <div class="card group hover:shadow-card-hover">
                            <div class="relative overflow-hidden">
                                @if($item->image_path)
                                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105">
                                @else
                                    <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No image</span>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-display font-bold text-gray-900">{{ $item->name }}</h3>
                                <p class="text-gray-600 mt-2 h-20">{{ Str::limit($item->description, 100) }}</p>
                                <div class="flex justify-between items-center mt-4">
                                    <span class="text-xl font-bold text-primary">${{ number_format($item->price, 2) }}</span>
                                    <button class="add-to-cart bg-primary text-white px-5 py-2 rounded-md hover:bg-primary-dark transition duration-300 transform hover:-translate-y-1"
                                            data-id="{{ $item->id }}" 
                                            data-name="{{ $item->name }}" 
                                            data-price="{{ $item->price }}">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Menu Categories Section -->
            <div>
                @foreach(\App\Models\Category::where('is_active', true)->orderBy('sort_order')->get() as $category)
                    <div class="mb-16" id="category-{{ $category->id }}">
                        <h2 class="text-3xl font-display font-bold text-center mb-4">{{ $category->name }}</h2>
                        <div class="w-24 h-1 bg-primary mx-auto mb-10"></div>
                        @if($category->description)
                            <p class="text-gray-600 mb-10 text-center max-w-3xl mx-auto">{{ $category->description }}</p>
                        @endif
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                            @foreach($category->getActiveMenuItems() as $item)
                                <div class="card group hover:shadow-card-hover">
                                    <div class="relative overflow-hidden">
                                        @if($item->image_path)
                                            <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="w-full h-56 object-cover transition-transform duration-500 group-hover:scale-105">
                                        @else
                                            <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400">No image</span>
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    <div class="p-6">
                                        <h3 class="text-xl font-display font-bold text-gray-900">{{ $item->name }}</h3>
                                        <p class="text-gray-600 mt-2 h-20">{{ Str::limit($item->description, 100) }}</p>
                                        <div class="flex justify-between items-center mt-4">
                                            <span class="text-xl font-bold text-primary">${{ number_format($item->price, 2) }}</span>
                                            <button class="add-to-cart bg-primary text-white px-5 py-2 rounded-md hover:bg-primary-dark transition duration-300 transform hover:-translate-y-1"
                                                    data-id="{{ $item->id }}" 
                                                    data-name="{{ $item->name }}" 
                                                    data-price="{{ $item->price }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-dark py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-display font-bold text-white mb-6">Ready to Experience Our Tapas?</h2>
            <p class="text-gray-300 mb-8 max-w-3xl mx-auto">Join us for an unforgettable culinary journey through the flavors of Spain. Make a reservation today or order online.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="btn-primary">Make a Reservation</a>
                <a href="tel:5551234567" class="btn-secondary">Call Us: (555) 123-4567</a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Initialize cart from localStorage
        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        updateCartCount();
        
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const price = parseFloat(button.getAttribute('data-price'));
                
                // Check if item already exists in cart
                const existingItem = cart.find(item => item.id === id);
                
                if (existingItem) {
                    existingItem.quantity += 1;
                    existingItem.subtotal = existingItem.price * existingItem.quantity;
                } else {
                    cart.push({
                        id,
                        name,
                        price,
                        quantity: 1,
                        subtotal: price
                    });
                }
                
                // Save to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                
                // Add a nicer notification
                const notification = document.createElement('div');
                notification.className = 'fixed bottom-4 right-4 bg-primary text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-500 translate-y-20 opacity-0';
                notification.innerHTML = `
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>${name} added to cart!</span>
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
            });
        });
        
        function updateCartCount() {
            const count = cart.reduce((total, item) => total + item.quantity, 0);
            const cartBadges = document.querySelectorAll('.cart-badge');
            cartBadges.forEach(badge => {
                badge.textContent = count;
            });
        }
    });
</script>
@endpush 