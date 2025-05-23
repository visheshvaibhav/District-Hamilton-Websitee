@extends('layouts.app')

@section('title', 'Private Events')

@section('content')
    <!-- Hero Section for Events -->
    <div class="hero" style="background-image: url('https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');">
        <div class="hero-content">
            <h1>Private Events</h1>
            <p>Make your special occasion even more memorable with our customizable event spaces and exceptional service.</p>
        </div>
    </div>

    <!-- Events Introduction -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="section-title mx-auto">Host Your Next Event With Us</h2>
                <p class="text-gray-600 mt-8 text-lg leading-relaxed">
                    Our space is well-suited for a variety of gatherings. From private dinners to networking events to large group parties, our dining room can be arranged to accommodate your special day. Our experienced team will work with you to create a customized menu and atmosphere that perfectly matches your vision.
                </p>
            </div>
        </div>
    </section>
    
    <!-- Event Types Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
                <div class="order-2 lg:order-1">
                    <div class="bg-white p-6 sm:p-10 rounded-lg shadow-lg border-t-4 border-primary">
                        <h3 class="text-3xl font-display font-bold mb-6 text-gray-900">Standing Reception</h3>
                        <div class="w-16 h-1 bg-primary mb-6"></div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            The bar at The District is the ideal gathering point for standing receptions. Our beautifully crafted bar features premium finishes and provides an elegant backdrop for your event. The warm ambiance is perfect for socializing and networking while enjoying our exquisite tapas and cocktails.
                        </p>
                        <div class="flex items-center mt-8">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-users text-xl text-primary"></i>
                            </div>
                            <p class="text-gray-900 font-semibold">Capacity: Up to 65 Guests</p>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="aspect-w-16 aspect-h-9 rounded-lg shadow-lg overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1519671482749-fd09be7ccebf?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="Standing Reception" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center mb-20">
                <div>
                    <div class="aspect-w-16 aspect-h-9 rounded-lg shadow-lg overflow-hidden">
                        <img src="/images/Restaurant_food/int-3.jpg" alt="Seated Private Dining Reception" class="w-full h-full object-cover">
                    </div>
                </div>
                <div>
                    <div class="bg-white p-6 sm:p-10 rounded-lg shadow-lg border-t-4 border-primary">
                        <h3 class="text-3xl font-display font-bold mb-6 text-gray-900">Seated Private Dining Reception</h3>
                        <div class="w-16 h-1 bg-primary mb-6"></div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Our team will help customize a private dining experience just for you and your guests. Seated dinners are served family-style with multiple share plate courses so that guests may enjoy a number of different flavors and tastes throughout their meal. Our Spanish tapas concept is perfect for creating a communal and intimate dining experience.
                        </p>
                        <div class="flex items-center mt-8">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-chair text-xl text-primary"></i>
                            </div>
                            <p class="text-gray-900 font-semibold">Seated Dining Capacity: Up to 25 Guests</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <div class="order-2 lg:order-1">
                    <div class="bg-white p-6 sm:p-10 rounded-lg shadow-lg border-t-4 border-primary">
                        <h3 class="text-3xl font-display font-bold mb-6 text-gray-900">Midday Reception</h3>
                        <div class="w-16 h-1 bg-primary mb-6"></div>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            The District is happy to offer our event space for mid-day receptions between the hours of 2:30pm - 4:30pm. Whether you need a private space to host an executive meeting, a team building event, or a customer appreciation reception, we are happy to take care of every detail. Our bright space and tailored service create the perfect backdrop for your daytime event.
                        </p>
                        <div class="flex items-center mt-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-users text-xl text-primary"></i>
                            </div>
                            <p class="text-gray-900 font-semibold">Standing Capacity: Up to 25 Guests</p>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-chair text-xl text-primary"></i>
                            </div>
                            <p class="text-gray-900 font-semibold">Seated Dining Capacity: Up to 20 Guests</p>
                        </div>
                    </div>
                </div>
                <div class="order-1 lg:order-2">
                    <div class="aspect-w-16 aspect-h-9 rounded-lg shadow-lg overflow-hidden">
                        <img src='/images/Restaurant_food/food-4.jpg' alt="Midday Reception" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Gallery Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">Our Event Spaces</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Take a glimpse at our elegant event spaces that can be tailored to your specific needs.</p>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="aspect-square overflow-hidden rounded-lg shadow-md">
                <img src='/images/Restaurant_food/int-5.jpg' alt="Event space" class="w-full h-full object-cover object-bottom hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square overflow-hidden rounded-lg shadow-md">
                    <img src='/images/Restaurant_food/int-6.jpg' alt="Event setup" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square overflow-hidden rounded-lg shadow-md">
                    <img src='/images/Restaurant_food/int-7.jpg' alt="Private dining" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
                <div class="aspect-square overflow-hidden rounded-lg shadow-md">
                    <img src="/images/Restaurant_food/int-4.jpg" alt="Bar area" class="w-full h-full object-cover hover:scale-110 transition-transform duration-500">
                </div>
            </div>
        </div>
    </section>
    
    <!-- Inquiry Form Section -->
    <section class="py-16 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="p-8 sm:p-12 bg-primary bg-opacity-10">
                        <h2 class="text-3xl font-display font-bold mb-6 text-gray-900">Let Us Help You</h2>
                        <p class="text-gray-700 mb-8">
                            Fill in the form to help us better serve you. This will give us a starting point to help craft the best experience we can. Final details for dates, times, number of people, etc. will be worked out together.
                        </p>
                        
                        <div class="space-y-6">
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mr-4">
                                    <i class="fas fa-utensils text-xl text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Customized Menus</h3>
                                    <p class="text-gray-600">Our chef will work with you to create a personalized menu based on your preferences and dietary needs.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mr-4">
                                    <i class="fas fa-glass-cheers text-xl text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Bar Packages</h3>
                                    <p class="text-gray-600">From premium open bars to specialized cocktail menus, we have options to suit every event and budget.</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mr-4">
                                    <i class="fas fa-concierge-bell text-xl text-primary"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Dedicated Service</h3>
                                    <p class="text-gray-600">Our professional staff will ensure your event runs smoothly from start to finish.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-8 sm:p-12">
                        <h3 class="text-2xl font-display font-bold mb-6 text-gray-900">Event Inquiry Form</h3>
                        
                        <form id="eventForm" action="{{ route('events.inquiry') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name *</label>
                                    <input type="text" id="first_name" name="first_name" required 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                    <input type="text" id="last_name" name="last_name" required 
                                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                                </div>
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                                <input type="email" id="email" name="email" required 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                                <input type="tel" id="phone" name="phone" required 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                                <input type="text" id="company" name="company" 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="event_type" class="block text-sm font-medium text-gray-700 mb-1">Nature of the event *</label>
                                <input type="text" id="event_type" name="event_type" placeholder="Birthday, Office Gathering, Wedding, etc." required 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="guest_count" class="block text-sm font-medium text-gray-700 mb-1">Number of People *</label>
                                <input type="number" id="guest_count" name="guest_count" placeholder="Approx. (up to 65)" min="1" max="65" required 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="event_date" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                                <input type="date" id="event_date" name="event_date" required 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="event_time" class="block text-sm font-medium text-gray-700 mb-1">Time *</label>
                                <input type="text" id="event_time" name="event_time" placeholder="Start - End" required 
                                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                            </div>
                            
                            <div>
                                <label for="details" class="block text-sm font-medium text-gray-700 mb-1">Additional Details</label>
                                <textarea id="details" name="details" rows="4" placeholder="Let us know if you have something special in mind so we can help curate the best experience for you." 
                                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"></textarea>
                            </div>
                            
                            <input type="hidden" name="admin_email" value="admin@thedistricttapas.com">
                            
                            <div>
                                <button type="submit" class="btn-primary w-full">
                                    Submit Inquiry <i class="fas fa-paper-plane ml-2"></i>
                                </button>
                            </div>
                        </form>
                        
                        <div id="eventFormResponse" class="mt-4 hidden">
                            <div class="p-4 rounded-md">
                                <p class="text-center"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">What Our Event Hosts Say</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Read about the experiences of those who have hosted events with us.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-8 rounded-lg shadow relative">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-primary/10 flex items-center justify-center rounded-bl-lg">
                        <i class="fas fa-quote-right text-primary"></i>
                    </div>
                    <p class="text-gray-700 mb-8 italic">"We hosted our company's annual dinner at The District and it was exceptional. The staff was attentive, the food was amazing, and everyone had a wonderful time. They took care of every detail!"</p>
                    <div class="font-bold text-gray-900">— Christina L.</div>
                    <div class="text-sm text-gray-500">Corporate Event</div>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-lg shadow relative">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-primary/10 flex items-center justify-center rounded-bl-lg">
                        <i class="fas fa-quote-right text-primary"></i>
                    </div>
                    <p class="text-gray-700 mb-8 italic">"I celebrated my 40th birthday here with 25 friends. The tapas-style menu was perfect for the occasion, allowing everyone to try different dishes. The atmosphere was exactly what I wanted - upscale but comfortable."</p>
                    <div class="font-bold text-gray-900">— James R.</div>
                    <div class="text-sm text-gray-500">Birthday Celebration</div>
                </div>
                
                <div class="bg-gray-50 p-8 rounded-lg shadow relative">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-primary/10 flex items-center justify-center rounded-bl-lg">
                        <i class="fas fa-quote-right text-primary"></i>
                    </div>
                    <p class="text-gray-700 mb-8 italic">"We had our engagement party at The District and couldn't have been happier. They helped us create a custom menu that honored both of our cultural backgrounds. The space looked absolutely beautiful."</p>
                    <div class="font-bold text-gray-900">— Sophia & Daniel</div>
                    <div class="text-sm text-gray-500">Engagement Party</div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action -->
    <section class="py-16 bg-dark text-white">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-display font-bold mb-6 text-black">Ready to Plan Your Event?</h2>
            <p class="text-xl mb-8 max-w-3xl mx-auto text-black">Contact us today to start planning your next memorable gathering at The District Tapas + Bar.</p>
            <div class="flex flex-col md:flex-row justify-center gap-4">
                <a href="#" class="order-now" style="align-items: center;">Fill Out the Inquiry Form</a>
                <a href="tel:+15551234567" class="btn-secondary">Call Us Directly</a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('eventForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const responseDiv = document.getElementById('eventFormResponse');
        const responseParagraph = responseDiv.querySelector('p');
        
        // Disable submit button and show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Sending...';
        
        // Send form data via AJAX
        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: new FormData(form)
        })
        .then(response => response.json())
        .then(data => {
            // Show success message
            responseDiv.classList.remove('hidden');
            responseDiv.classList.add('bg-green-50');
            responseParagraph.classList.add('text-green-800');
            responseParagraph.textContent = data.message;
            
            // Reset form
            form.reset();
        })
        .catch(error => {
            // Show error message
            responseDiv.classList.remove('hidden');
            responseDiv.classList.add('bg-red-50');
            responseParagraph.classList.add('text-red-800');
            responseParagraph.textContent = 'Sorry, there was an error sending your inquiry. Please try again.';
        })
        .finally(() => {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Submit Inquiry <i class="fas fa-paper-plane ml-2"></i>';
            
            // Scroll response into view
            responseDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
</script>
@endpush 