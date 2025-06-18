@extends('layouts.app')

@section('title', 'Premium Spanish Tapas in Hamilton')

@section('content')
    <!-- Hero Section -->
    <section class="hero" style="background-image: url('/images/Restaurant_food/hero.jpg');">
        <div class="container mx-auto px-4 hero-content">
            <h1 class="text-4xl md:text-5xl lg:text-6xl text-white">Experience Authentic <br class="hidden md:block">Spanish Tapas</h1>
            <p class="text-xl mb-8 mt-6">Discover the rich and vibrant flavors of Spain in the heart of Hamilton.<br class="hidden md:block"> From traditional tapas to modern fusion dishes.</p>
            <div class="flex gap-4 flex-col sm:flex-row justify-center">
                <a href="{{ route('menu.index') }}" class="order-now">View Our Menu</a>
                <a href="#reservation-widget" class="btn-secondary">Make a Reservation</a>
            </div>
        </div>
    </section>

    <!-- Daily Offers Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">Daily Offers</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Discover our exclusive weekday specials designed to enhance your dining experience.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Tuesday Offer -->
                <div class="offer-card" data-day="tuesday">
                    <div class="card-inner">
                        <div class="card-face card-front bg-gradient-to-br from-[#FF416C] to-[#FF4B2B] rounded-lg shadow-lg">
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-display font-bold text-white mb-3">Terrific Tuesday</h3>
                                <p class="text-white/90">Triple the taste, double the value</p>
                            </div>
                        </div>
                        <div class="card-face card-back bg-white rounded-lg shadow-lg">
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-display font-bold text-gray-900 mb-3">3 Tapas for 2</h3>
                                <p class="text-gray-600 mb-6">Choose any three tapas from our signature menu and only pay for two.</p>
                                <a href="{{ route('menu.index') }}" class="btn-primary inline-block">View Menu</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wednesday Offer -->
                <div class="offer-card" data-day="wednesday">
                    <div class="card-inner">
                        <div class="card-face card-front bg-gradient-to-br from-[#8E2DE2] to-[#4A00E0] rounded-lg shadow-lg">
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-display font-bold text-white mb-3">Wine Wednesday</h3>
                                <p class="text-white/90">Uncork the savings</p>
                            </div>
                        </div>
                        <div class="card-face card-back bg-white rounded-lg shadow-lg">
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-display font-bold text-gray-900 mb-3">50% Off Wines</h3>
                                <p class="text-gray-600 mb-6">Enjoy half-price bottles from our curated wine selection.</p>
                                <a href="{{ route('menu.index') }}#wines" class="btn-primary inline-block">View Wines</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Thursday Offer -->
                <div class="offer-card" data-day="thursday">
                    <div class="card-inner">
                        <div class="card-face card-front bg-gradient-to-br from-[#1CB5E0] to-[#000851] rounded-lg shadow-lg">
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-display font-bold text-white mb-3">Tapas Thursday</h3>
                                <p class="text-white/90">A feast for the senses</p>
                            </div>
                        </div>
                        <div class="card-face card-back bg-white rounded-lg shadow-lg">
                            <div class="p-8 text-center">
                                <h3 class="text-2xl font-display font-bold text-gray-900 mb-3">5 Tapas for $50</h3>
                                <p class="text-gray-600 mb-6">Create your perfect tapas combination with any five dishes.</p>
                                <a href="{{ route('menu.index') }}" class="btn-primary inline-block">View Menu</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .offer-card {
                height: 300px;
                perspective: 2000px;
                cursor: pointer;
            }

            .card-inner {
                position: relative;
                width: 100%;
                height: 100%;
                transform-style: preserve-3d;
                transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .offer-card:hover .card-inner {
                transform: rotateY(180deg);
            }

            .card-face {
                position: absolute;
                width: 100%;
                height: 100%;
                backface-visibility: hidden;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .card-back {
                transform: rotateY(180deg);
            }

            /* Mobile touch interaction */
            @media (max-width: 768px) {
                .offer-card.touched .card-inner {
                    transform: rotateY(180deg);
                }
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Handle touch interactions for mobile devices
                const offerCards = document.querySelectorAll('.offer-card');
                let touchStartTime;
                let touchTimeout;

                offerCards.forEach(card => {
                    card.addEventListener('touchstart', () => {
                        touchStartTime = Date.now();
                        touchTimeout = setTimeout(() => {
                            card.classList.add('touched');
                        }, 100);
                    });

                    card.addEventListener('touchend', () => {
                        if (Date.now() - touchStartTime < 100) {
                            clearTimeout(touchTimeout);
                        }
                    });

                    // Reset card state when another card is touched
                    card.addEventListener('touchstart', () => {
                        offerCards.forEach(otherCard => {
                            if (otherCard !== card) {
                                otherCard.classList.remove('touched');
                            }
                        });
                    });
                });

                // Highlight current day's offer
                const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
                const today = days[new Date().getDay()];
                const todayCard = document.querySelector(`.offer-card[data-day="${today}"]`);
                
                if (todayCard) {
                    todayCard.classList.add('today');
                    todayCard.style.transform = 'scale(1.02)';
                    todayCard.style.boxShadow = '0 20px 40px rgba(0, 0, 0, 0.3)';
                }
            });
        </script>
    </section>
    
    <!-- About Section Brief -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="section-title mx-auto">Welcome to The District</h2>
                <p class="text-gray-600 mt-8 text-lg">
                    At The District Tapas + Bar, we bring the essence of Spanish cuisine to Hamilton. Our carefully crafted menu features authentic tapas made with premium ingredients, complemented by a selection of fine wines and creative cocktails. Join us for an unforgettable culinary journey through Spain.
                </p>
                <div class="mt-8 flex justify-center">
                    <a href="{{ route('about') }}" class="inline-flex items-center text-primary font-semibold group">
                        <span>Learn more about our story</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Reservation Widget Section -->
    <section id="reservation-widget" class="py-16 bg-gray-50" style="overflow: visible; padding-bottom: 150px;">
        <div class="container mx-auto px-4" style="overflow: visible;">
            <div class="max-w-4xl mx-auto text-center" style="overflow: visible;">
                <h2 class="section-title mx-auto mb-8">Make a Reservation</h2>
                <div class="reservation-widget-container flex justify-center" style="overflow: visible;">
                    <script type='text/javascript' src='https://www.opentable.ca/widget/reservation/loader?rid=1431862&type=standard&theme=standard&color=1&dark=false&iframe=true&domain=ca&lang=en-CA&newtab=true&ot_source=Restaurant%20website&cfe=true'></script>
                    <style>
                        .reservation-widget-container iframe {
                            display: block;
                            height: 300px !important;
                            width: 100% !important;
                            overflow: visible !important;
                            border: none !important;
                        }

                        #reservation-widget,
                        #reservation-widget .container,
                        #reservation-widget .max-w-4xl {
                            overflow: visible !important;
                        }
                    </style>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Featured Menu Items -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">Featured Dishes</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Our chef's selection of extraordinary tapas that showcase the best of Spanish cuisine with a modern twist.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($featuredItems as $item)
                <div class="card group h-full flex flex-col">
                    <div class="relative overflow-hidden">
                        <img src="{{ asset('storage/' . ($item->image_path ?: 'images/placeholder-food.jpg')) }}"
                             alt="{{ $item->name }}"
                             class="w-full h-60 object-cover transition-transform duration-500 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-display font-bold text-gray-900 mb-2">{{ $item->name }}</h3>
                        <p class="text-gray-600 mb-6 flex-grow">{{ Str::limit($item->description, 100) }}</p>
                        <div class="flex justify-between items-center mt-auto pt-4 border-t border-gray-100">
                            <span class="text-xl font-bold text-primary">${{ number_format($item->price, 2) }}</span>
                            <a href="{{ route('menu.item', $item->slug) }}" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-primary-dark transition duration-300 transform hover:-translate-y-1">View Dish</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="text-center mt-12">
                <a href="{{ route('menu.index') }}" class="btn-primary inline-block">Explore Full Menu</a>
            </div>
        </div>
    </section>
    
    <!-- About Section -->
    <section id="about" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center gap-12">
                <div class="md:w-1/2 relative">
                    <img src='/images/Restaurant_food/int-6.jpg' alt="The District Tapas Bar Interior" class="rounded-lg shadow-lg z-10 relative">
                    <div class="absolute w-full h-full border-2 border-primary rounded-lg top-4 left-4 -z-0 hidden md:block"></div>
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl md:text-4xl font-display font-bold mb-6">Our Story</h2>
                    <div class="w-20 h-1 bg-primary mb-6"></div>
                    <p class="text-gray-700 mb-6 leading-relaxed">The District Tapas + Bar was born from a passion for Spanish cuisine and a desire to bring authentic tapas to Hamilton. Our chefs have trained in Spain and bring that expertise to every dish, combining traditional techniques with local ingredients.</p>
                    <p class="text-gray-700 mb-6 leading-relaxed">We believe in creating a warm, inviting atmosphere where friends and family can gather to share not just food, but experiences. Each plate is designed to be passed around the table, encouraging conversation and connection.</p>
                    <div class="flex items-center gap-4 mt-8">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                            <i class="fas fa-utensils text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Authentic Spanish Cuisine</h3>
                            <p class="text-gray-600">Made with traditional techniques</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="w-16 h-16 rounded-full bg-primary/10 flex items-center justify-center">
                            <i class="fas fa-wine-glass-alt text-2xl text-primary"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Premium Ingredients</h3>
                            <p class="text-gray-600">Locally sourced when possible</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">What Our Customers Say</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Don't just take our word for it. Here's what our customers have to say about their dining experience.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-lg relative">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-primary/10 flex items-center justify-center rounded-bl-lg">
                        <i class="fas fa-quote-right text-primary"></i>
                    </div>
                    <div class="flex items-center mb-6">
                        <span class="text-primary">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"We went to The District for the first time last night and it was fantastic! The food was amazing and the atmosphere even better. It was the first night they had a band and it was very busy. The server was alone and did a wonderful job keeping it all going. I highly recommend this place and will be going back regularly!"</p><br>
                    <br>
                    <div class="font-bold text-gray-900">— Jennifer S.</div>
                    <div class="text-sm text-gray-500">Hamilton, ON</div>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg relative">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-primary/10 flex items-center justify-center rounded-bl-lg">
                        <i class="fas fa-quote-right text-primary"></i>
                    </div>
                    <div class="flex items-center mb-6">
                        <span class="text-primary">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"WOW WOW. First off the food was amazing, service amazing. We were out of bagettes and someone from the kitchen noticed and brought us more. We didnt even have to ask. As soon as youre done with dishes they come and clear your table. Very friendly service, atmosphere is very relaxing. Cannot wait to have an excuse to go back to Hamilton just to eat here again!
Would highly recommend to everyone!"</p>
                    <div class="font-bold text-gray-900">— Crystal H.</div>
                    <div class="text-sm text-gray-500">London, ON</div>
                </div>
                
                <div class="bg-white p-8 rounded-lg shadow-lg relative">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-primary/10 flex items-center justify-center rounded-bl-lg">
                        <i class="fas fa-quote-right text-primary"></i>
                    </div>
                    <div class="flex items-center mb-6">
                        <span class="text-primary">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </span>
                    </div>
                    <p class="text-gray-700 mb-6 italic">"We went for dinner here on a Saturday. The atmosphere was very relaxing and cozy. The service was very friendly and welcoming. We got an assortment of tappas to share and they were all delicious. The drinks were also very tastey. Would recommend trying this spot out!"</p><br><br><br>
                    <div class="font-bold text-gray-900">— Evan P.</div>
                    <div class="text-sm text-gray-500">Hamilton, ON</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Gallery Section -->
    <section class="py-16 bg-white overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">A Taste of Our Atmosphere</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Step into our world of Spanish cuisine and vibrant dining experiences.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-6xl mx-auto">
                <div class="aspect-square w-full h-0 pb-[100%] relative overflow-hidden rounded-lg">
                    <img src="/images/Restaurant_food/int-1.jpg" alt="Restaurant interior" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square w-full h-0 pb-[100%] relative overflow-hidden rounded-lg">
                    <img src="/images/Restaurant_food/food-1.jpg" alt="Spanish paella" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square w-full h-0 pb-[100%] relative overflow-hidden rounded-lg">
                    <img src="/images/Restaurant_food/int-2.jpg" alt="Wine tasting" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square w-full h-0 pb-[100%] relative overflow-hidden rounded-lg">
                    <img src="/images/Restaurant_food/int-7.jpg" alt="Tapas selection" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-16 bg-dark text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-display font-bold mb-6">Ready to Experience Our Tapas?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto text-black">Whether you're dining in, taking out, or having it delivered, we're ready to serve you the best Spanish tapas in Hamilton.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="{{ route('menu.index') }}" class="order-now justify-center">Order Online</a>
                <a href="tel:+15551234567" class="btn-secondary">Call for Reservations</a>
            </div>
        </div>
    </section>
@endsection 