@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
    <!-- Hero Section for Contact -->
    <div class="hero" style="background-image: url('/images/Restaurant_food/int-7.jpg');">
        <div class="hero-content">
            <h1>Contact Us</h1>
            <p>We'd love to hear from you. Reach out for reservations, inquiries, or feedback.</p>
        </div>
    </div>

    <!-- Contact Information Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <h2 class="text-3xl font-display font-bold mb-6">Get in Touch</h2>
                    <div class="w-20 h-1 bg-primary mb-8"></div>
                    
                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-map-marker-alt text-xl text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Location</h3>
                                <p class="text-gray-600">61 Barton St E<br>Hamilton, ON L8L 2V7<br>Canada</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-phone text-xl text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Phone</h3>
                                <p class="text-gray-600">
                                    <a href="tel:+19055222580" class="hover:text-primary transition-colors">(905)522-2580</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-envelope text-xl text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Email</h3>
                                <p class="text-gray-600">
                                    <a href="mailto:contact@thedistricttapas.com" class="hover:text-primary transition-colors">thedistricthamilton@gmail.com</a>
                                </p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center flex-shrink-0 mr-4">
                                <i class="fas fa-clock text-xl text-primary"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-display font-bold text-gray-900 mb-2">Hours</h3>
                                <p class="text-gray-600">
                                    <span class="font-semibold">Monday:</span> Closed.<br>
                                    <span class="font-semibold">Tuesday - Friday:</span> 5pm - 11pm<br>
                                    <span class="font-semibold">Saturday:</span> 11am - 10pm<br>
                                    <span class="font-semibold">Sunday:</span> 11am - 9pm
                                </p>
                            </div>
                        </div>
                        
                        <div class="mt-8">
                            <h3 class="text-xl font-display font-bold text-gray-900 mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/profile.php?id=61576713382021" class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center hover:bg-primary/20 transition-colors">
                                    <i class="fab fa-facebook-f text-xl text-primary"></i>
                                </a>
                                <a href="https://www.instagram.com/districttapasbarhamilton/" class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center hover:bg-primary/20 transition-colors">
                                    <i class="fab fa-instagram text-xl text-primary"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-3xl font-display font-bold mb-6">Send Us a Message</h2>
                    <div class="w-20 h-1 bg-primary mb-8"></div>
                    
                    <form id="contactForm" action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
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
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                            <input type="text" id="subject" name="subject"  
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition">
                        </div>
                        
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                            <textarea id="message" name="message" rows="4" required 
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 transition"></textarea>
                        </div>
                        
                        <div>
                            <button type="submit" class="btn-primary">
                                Send Message <i class="fas fa-paper-plane ml-2"></i>
                            </button>
                        </div>
                        
                        <div id="contactFormResponse" class="mt-4 hidden">
                            <div class="p-4 rounded-md">
                                <p class="text-center"></p>
                            </div>
                        </div>
                    </form>
                    
                    @if(session('success'))
                    <div class="mt-6 p-4 bg-green-100 border border-green-200 text-green-700 rounded-md">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-green-500"></i>
                            <p>{{ session('success') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    
    <!-- Map Section -->
    <section class="py-10 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="p-0 h-96">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2907.2631553510034!2d-79.8776914843762!3d43.258605779137074!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882c9b83efa7fb19%3A0xb3bb81c8b578c6a!2s61%20Barton%20St%20E%2C%20Hamilton%2C%20ON%20L8L%202V7!5e0!3m2!1sen!2sca!4v1623331088837!5m2!1sen!2sca" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy">
                    </iframe>
                </div>
            </div>
        </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title mx-auto">Frequently Asked Questions</h2>
                <p class="text-gray-600 max-w-2xl mx-auto mt-4">Find answers to some common questions about The District Tapas + Bar.</p>
            </div>
            
            <div class="max-w-3xl mx-auto divide-y divide-gray-200">
                <div class="py-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Do you take reservations?</h3>
                    <p class="text-gray-600">Yes, we accept reservations for all party sizes. For Groups larger than five, please contact us directly on our email to make arrangements.</p>
                </div>
                
                <div class="py-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Is there parking available?</h3>
                    <p class="text-gray-600">We have limited street parking in front of our restaurant, and there are several public parking lots within a short walking distance.</p>
                </div>
                
                <div class="py-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Do you offer vegetarian options?</h3>
                    <p class="text-gray-600">Yes, we have a variety of vegetarian tapas options. Our menu is clearly marked with dietary information, and our staff is happy to recommend vegetarian dishes.</p>
                </div>
                
                <div class="py-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Do you accommodate large groups?</h3>
                    <p class="text-gray-600">Yes, we can accommodate large groups and private events. Please contact us in advance to make arrangements. You can also check our Events page for more information.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    document.getElementById('contactForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const form = this;
        const submitButton = form.querySelector('button[type="submit"]');
        const responseDiv = document.getElementById('contactFormResponse');
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
            responseParagraph.textContent = 'Sorry, there was an error sending your message. Please try again.';
        })
        .finally(() => {
            // Re-enable submit button
            submitButton.disabled = false;
            submitButton.innerHTML = 'Send Message <i class="fas fa-paper-plane ml-2"></i>';
            
            // Scroll response into view
            responseDiv.scrollIntoView({ behavior: 'smooth', block: 'center' });
        });
    });
</script>
@endpush 