<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Experience authentic Spanish tapas at The District Tapas + Bar in Hamilton. Our menu features traditional Spanish flavors with a modern twist, crafted with premium ingredients.">

    <title>{{ config('app.name', 'The District Tapas + Bar') }} | @yield('title', 'Premium Tapas')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Font preloading for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
    
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1KJXQC79GH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-1KJXQC79GH');
    </script>

    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Styles -->
    <style>
        :root {
            --primary-color: #B8860B;
            --primary-light: #D6AB39;
            --primary-dark: #9A7209;
            --secondary-color: #1A1A1A;
            --accent-color: #B8860B;
            --dark-color: #1A1A1A;
            --light-color: #FFFFFF;
            --gray-color: #F5F5F5;
            --text-color: #333333;
            --text-light: #666666;
        }
        
        html, body {
            overflow-x: hidden;
            width: 100%;
            -webkit-text-size-adjust: 100%;
            -webkit-font-smoothing: antialiased;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            color: var(--text-color);
            line-height: 1.7;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-text-size-adjust: none;
            text-size-adjust: none;
        }
        
        img, svg, video, canvas, iframe {
            max-width: 100%;
            height: auto;
            display: block;
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            max-width: 100%;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.875rem;
            border: 1px solid var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .btn-secondary {
            background-color: transparent;
            color: white;
            padding: 0.75rem 1.75rem;
            border-radius: 0.25rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.875rem;
            border: 1px solid white;
        }
        
        .btn-secondary:hover {
            background-color: rgba(184, 134, 11, 0.1);
            transform: translateY(-2px);
        }
        
        .accent-text {
            color: var(--primary-color);
        }
        
        .text-brand {
            color: var(--primary-color);
        }
        
        /* Header styling */
        .navbar {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 1.25rem 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .navbar .logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.3);
        }
        
        .navbar a:not(.logo) {
            color: var(--light-color);
            font-weight: 500;
            transition: color 0.3s ease, transform 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.95rem;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        
        .navbar a:hover:not(.logo) {
            color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        /* Hero section styling */
        .hero {
            background-size: cover;
            background-position: center;
            color: white;
            padding: 4rem 1rem;
            position: relative;
            width: 100%;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.1));
        }
        
        .hero-content {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: min(800px, 90%);
            margin: 0 auto;
            text-align: center;
            padding: 0 1rem;
        }
        
        .hero h1 {
            font-size: clamp(2rem, 5vw, 3.5rem);
            margin-bottom: 1rem;
            line-height: 1.2;
            color: white;
        }
        
        .hero p {
            font-size: clamp(1rem, 3vw, 1.25rem);
            margin-bottom: 1.5rem;
            max-width: min(600px, 100%);
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }
        
        /* Footer styling */
        .footer {
            background-color: var(--dark-color);
            color: var(--light-color);
            padding: 4rem 0 2rem;
        }
        
        .footer h3 {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            padding-bottom: 0.5rem;
        }
        
        .footer h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        .footer a {
            color: var(--light-color);
            transition: color 0.3s ease;
        }
        
        .footer a:hover {
            color: var(--primary-color);
        }
        
        /* Alert banner styling */
        .alert-banner {
            background-color: var(--primary-color);
            color: var(--light-color);
            padding: 0.75rem 0;
            text-align: center;
            font-weight: 600;
            letter-spacing: 0.05em;
        }
        
        /* Order now button */
        .order-now {
            background-color: var(--primary-color);
            color: var(--light-color);
            font-weight: 700;
            padding: 0.85rem 2.25rem;
            border-radius: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            transition: all 0.3s ease;
            border: 1px solid var(--primary-color);
            display: inline-block;
        }
        
        .order-now:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Mobile menu styling */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            background-color: var(--dark-color);
            z-index: 9999;
            padding: 1.5rem;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            overscroll-behavior: contain;
        }
        
        .mobile-menu.active {
            display: flex;
        }
        
        .mobile-menu a {
            color: var(--light-color);
            font-size: 1.125rem;
            padding: 1rem;
            width: 100%;
            text-align: center;
            transition: color 0.3s ease;
        }
        
        .mobile-menu a:active {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        @media (hover: hover) {
            .mobile-menu a:hover {
                color: var(--primary-color);
            }
        }
        
        /* Container improvements */
        .container {
            width: 100%;
            max-width: 100%;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
            box-sizing: border-box;
        }
        
        @media (min-width: 640px) {
            .container {
                max-width: min(640px, 95%);
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }
        }
        
        @media (min-width: 768px) {
            .container {
                max-width: min(768px, 95%);
                padding-left: 2rem;
                padding-right: 2rem;
            }
        }
        
        @media (min-width: 1024px) {
            .container {
                max-width: min(1024px, 95%);
            }
        }
        
        @media (min-width: 1280px) {
            .container {
                max-width: min(1280px, 95%);
            }
        }
        
        /* Cart badge styling */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--primary-color);
            color: var(--light-color);
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 700;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }
        
        /* Cart icon styling */
        .cart-icon {
            font-size: 1.2rem;
            margin-right: 0.5rem;
            position: relative;
            display: inline-flex;
            padding: 8px;
            background: rgba(184, 134, 11, 0.2);
            border-radius: 50%;
            color: var(--primary-color);
        }
        
        /* Section styling */
        .section {
            padding: 5rem 0;
        }
        
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-align: center;
            position: relative;
            display: inline-block;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 2px;
            background-color: var(--primary-color);
        }
        
        /* Card styling */
        .card {
            background-color: white;
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 0;
            }
            
            .navbar .logo {
                font-size: 1.4rem;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .section {
                padding: 3rem 0;
            }
        }
    </style>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    @stack('styles')
</head>
<body class="antialiased overflow-x-hidden">
    @if(App\Models\SiteSetting::getSettings()->alert_message)
    <div class="alert-banner">
        {{ App\Models\SiteSetting::getSettings()->alert_message }}
    </div>
    @endif
    
    <header class="navbar">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <a href="{{ route('home') }}" class="logo">The District <span class="accent-text">Tapas + Bar</span></a>
            
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('menu.index') }}" class="hover:text-primary transition">
                    <i class="fas fa-utensils mr-1"></i> Menu
                </a>
                <a href="{{ route('events') }}" class="hover:text-primary transition">
                    <i class="fas fa-glass-cheers mr-1"></i> Events
                </a>
                <a href="{{ route('about') }}" class="hover:text-primary transition">
                    <i class="fas fa-info-circle mr-1"></i> About
                </a>
                <a href="{{ route('contact') }}" class="hover:text-primary transition">
                    <i class="fas fa-envelope mr-1"></i> Contact
                </a>
                
                <a href="{{ route('cart.index') }}" class="hover:text-primary transition relative">
                    <span class="cart-icon"><i class="fas fa-shopping-cart"></i>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <span class="cart-badge">{{ count(session('cart')) }}</span>
                    @endif
                    </span>
                    Cart
                </a>
                
                @if(App\Models\SiteSetting::getSettings()->enable_french)
                <a href="{{ route('language.switch', app()->getLocale() == 'en' ? 'fr' : 'en') }}" class="hover:text-primary transition">
                    {{ app()->getLocale() == 'en' ? 'FR' : 'EN' }}
                </a>
                @endif
            </div>
            
            <div class="md:hidden">
                <button class="mobile-menu-btn text-white focus:outline-none" id="mobileMenuBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
    
    <div class="mobile-menu" id="mobileMenu">
        <button class="absolute top-4 right-4 text-white focus:outline-none" id="closeMenuBtn">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="flex flex-col items-center w-full">
            <a href="{{ route('home') }}" class="flex items-center justify-center">
                <i class="fas fa-home mr-2"></i> Home
            </a>
            <a href="{{ route('menu.index') }}" class="flex items-center justify-center">
                <i class="fas fa-utensils mr-2"></i> Menu
            </a>
            <a href="{{ route('events') }}" class="flex items-center justify-center">
                <i class="fas fa-glass-cheers mr-2"></i> Events
            </a>
            <a href="{{ route('about') }}" class="flex items-center justify-center">
                <i class="fas fa-info-circle mr-2"></i> About
            </a>
            <a href="{{ route('contact') }}" class="flex items-center justify-center">
                <i class="fas fa-envelope mr-2"></i> Contact
            </a>
            
            <a href="{{ route('cart.index') }}" class="flex items-center justify-center relative">
                <i class="fas fa-shopping-cart mr-2"></i> Cart
                @if(session()->has('cart') && count(session('cart')) > 0)
                <span class="ml-2 inline-block bg-primary text-white rounded-full w-6 h-6 text-center text-sm">{{ count(session('cart')) }}</span>
                @endif
            </a>
            
            @if(App\Models\SiteSetting::getSettings()->enable_french)
            <a href="{{ route('language.switch', app()->getLocale() == 'en' ? 'fr' : 'en') }}" class="flex items-center justify-center">
                <i class="fas fa-language mr-2"></i> {{ app()->getLocale() == 'en' ? 'Français' : 'English' }}
            </a>
            @endif
        </div>
    </div>

    <main>
        @yield('content')
    </main>
    
    <footer class="footer mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3>The District Tapas + Bar</h3>
                    <p class="mt-4 text-gray-300">Experience the finest tapas in Hamilton, with a fusion of traditional Spanish flavors and modern culinary techniques.</p>
                </div>
                
                <div>
                    <h3>Hours</h3>
                    <ul class="mt-4 space-y-2 text-gray-300">
                        <li><span class="text-primary font-semibold">Monday:</span> Closed</li>
                        <li><span class="text-primary font-semibold">Tuesday - Friday:</span> 5pm - 10pm</li>
                        <li><span class="text-primary font-semibold">Saturday:</span> 11am - 10pm</li>
                        <li><span class="text-primary font-semibold">Sunday:</span> 11am - 9pm</li>
                    </ul>
                </div>
                
                <div>
                    <h3>Contact</h3>
                    <ul class="mt-4 space-y-2 text-gray-300">
                        <li><i class="fas fa-map-marker-alt text-primary mr-2"></i> 61 Barton St E, Hamilton, ON L8L 2V7</li>
                        <li><i class="fas fa-phone text-primary mr-2"></i>(905) 522-2580</li>
                        <li><i class="fas fa-envelope text-primary mr-2"></i> thedistricthamilton@gmail.com</li>
                    </ul>
                </div>
                
                <div>
                    <h3>Follow Us</h3>
                    <div class="mt-4 flex space-x-4">
                        <a href="https://www.facebook.com/profile.php?id=61576713382021" class="text-2xl hover:text-primary transition-colors duration-300"><i class="fab fa-facebook"></i></a>
                        <a href="https://www.instagram.com/districttapasbarhamilton/" class="text-2xl hover:text-primary transition-colors duration-300"><i class="fab fa-instagram"></i></a>
                    </div>
                    <div class="mt-6">
                        <p class="text-sm text-gray-400">Subscribe to our newsletter</p>
                        <div class="mt-2 flex">
                            <input type="email" placeholder="Your email" class="px-3 py-2 w-full rounded-l-md focus:outline-none focus:ring-1 focus:ring-primary text-black">
                            <button class="bg-primary text-white px-3 py-2 rounded-r-md hover:bg-primary-dark transition">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="border-gray-700 my-8">
            
            <div class="flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} The District Tapas + Bar. All rights reserved.</p>
                <div class="mt-4 md:mt-0 flex space-x-4 text-gray-400">
                    <a href="{{ route('privacy') }}" class="hover:text-primary transition-colors duration-300">Privacy Policy</a>
                    <a href="{{ route('terms') }}" class="hover:text-primary transition-colors duration-300">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>
    
    <script>
        // Mobile menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const closeMenuBtn = document.getElementById('closeMenuBtn');
            const mobileMenu = document.getElementById('mobileMenu');
            
            mobileMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            closeMenuBtn.addEventListener('click', function() {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = '';
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 