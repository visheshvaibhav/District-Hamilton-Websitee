@extends('layouts.app')

@section('title', 'About Us')

@section('content')
    <!-- About Header Section -->
    <section class="bg-primary-color text-white py-12" style="background-color: var(--primary-color);">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl font-bold text-center">About The District</h1>
            <p class="text-xl text-center mt-4 max-w-2xl mx-auto">Our story, mission, and passion for authentic Spanish cuisine.</p>
        </div>
    </section>
    
    <!-- Our Story Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold mb-8 text-center">Our Story</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <p class="text-lg mb-6">Welcome to The District Tapas + Bar, where bold global flavours meet Hamilton’s vibrant spirit. Located in the heart of the city at 61 Barton Street East, we are redefining the local dining experience with a creative, shareable menu that invites conversation and connection.</p>
                        <p class="text-lg mb-6">At The District, food is more than sustenance—it’s a celebration. Our internationally inspired tapas are crafted to delight.Whether you're in for brunch, dinner, or drinks, every dish is designed to excite your palate and spark discovery.</p>
                    </div>
                    <div class="rounded-lg overflow-hidden shadow-xl">
                        <img src="{{ asset('images/Restaurant_food/int-2.jpg') }}" alt="The District Interior" class="w-full h-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Philosophy Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold mb-8 text-center">Our Philosophy</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-accent-color text-4xl mb-4 flex justify-center" style="color: var(--accent-color);">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-center">Fresh Ingredients</h3>
                        <p class="text-gray-700">We source the freshest, highest-quality ingredients from local producers whenever possible, supporting our community while ensuring exceptional flavor in every dish.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-accent-color text-4xl mb-4 flex justify-center" style="color: var(--accent-color);">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-center">Authentic Recipes</h3>
                        <p class="text-gray-700">Our menu stays true to traditional Spanish cooking techniques and flavor profiles, while incorporating creative twists that make each dish uniquely ours.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="text-accent-color text-4xl mb-4 flex justify-center" style="color: var(--accent-color);">
                            <i class="fas fa-users"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-center">Community Focus</h3>
                        <p class="text-gray-700">We believe food brings people together. Our space is designed to foster conversation and connection, whether you're sharing tapas with friends or making new ones at our bar.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Meet the Team Section
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold mb-8 text-center">Meet Our Team</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4">
                            <img src="{{ asset('images/chef-maria.jpg') }}" alt="Chef Maria Rodriguez" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/300x300?text=Chef+Maria'">
                        </div>
                        <h3 class="text-xl font-bold">Maria Rodriguez</h3>
                        <p class="text-accent-color" style="color: var(--accent-color);">Founder & Executive Chef</p>
                    </div>
                    <div class="text-center">
                        <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4">
                            <img src="{{ asset('images/chef-carlos.jpg') }}" alt="Chef Carlos Diaz" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/300x300?text=Chef+Carlos'">
                        </div>
                        <h3 class="text-xl font-bold">Carlos Diaz</h3>
                        <p class="text-accent-color" style="color: var(--accent-color);">Head Chef</p>
                    </div>
                    <div class="text-center">
                        <div class="w-48 h-48 mx-auto rounded-full overflow-hidden mb-4">
                            <img src="{{ asset('images/elena-manager.jpg') }}" alt="Elena Kwan" class="w-full h-full object-cover" onerror="this.src='https://placehold.co/300x300?text=Elena'">
                        </div>
                        <h3 class="text-xl font-bold">Elena Kwan</h3>
                        <p class="text-accent-color" style="color: var(--accent-color);">General Manager</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
     -->
    <!-- Visit Us Section -->
    <section class="py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl font-bold mb-8 text-center">Visit Us</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold mb-3">Location</h3>
                            <p class="text-lg">61 Barton Street East<br>Hamilton, ON L8L 2V7</p>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-xl font-bold mb-3">Hours</h3>
                            <p class="text-lg">Monday: Closed<br>
                                Tuesday - Friday: 5:00 PM - 11:00 PM<br>
                                Saturday: 11:00 AM - 10:00 PM<br>
                                Sunday: 11:00 AM - 9:00 PM</p>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-3">Contact</h3>
                            <p class="text-lg">Phone: (905) 522-2580<br>
                                Email: thedistricthamilton@gmail.com</p>
                        </div>
                    </div>
                    <div class="rounded-lg overflow-hidden shadow-xl h-80">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2907.2631553510034!2d-79.8776914843762!3d43.258605779137074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882c9b83efa7fb19%3A0xb3bb81c8b578c6a!2s61%20Barton%20St%20E%2C%20Hamilton%2C%20ON%20L8L%202V7!5e0!3m2!1sen!2sca!4v1623331088837!5m2!1sen!2sca" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                        <div class="bg-gray-300 w-full h-full flex items-center justify-center">
                            <p class="text-gray-600">Map Location</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection 