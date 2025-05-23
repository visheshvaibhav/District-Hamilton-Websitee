@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Privacy Policy</h1>
        
        <div class="prose prose-lg">
            <h2 class="text-2xl font-semibold mt-6 mb-4">1. Information We Collect</h2>
            <p>We collect information that you provide directly to us, including:</p>
            <ul class="list-disc ml-6 mb-4">
                <li>Name and contact information</li>
                <li>Delivery address</li>
                <li>Order history and preferences</li>
                <li>Payment information (processed securely through our payment providers)</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6 mb-4">2. How We Use Your Information</h2>
            <p>We use the information we collect to:</p>
            <ul class="list-disc ml-6 mb-4">
                <li>Process and deliver your orders</li>
                <li>Send you order confirmations and updates</li>
                <li>Improve our services and customer experience</li>
                <li>Communicate with you about promotions and special offers</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6 mb-4">3. Information Sharing</h2>
            <p>We do not sell or rent your personal information to third parties. We may share your information with:</p>
            <ul class="list-disc ml-6 mb-4">
                <li>Delivery partners to fulfill your orders</li>
                <li>Payment processors to complete transactions</li>
                <li>Service providers who assist our operations</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6 mb-4">4. Data Security</h2>
            <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, or disclosure.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">5. Cookies and Tracking</h2>
            <p>We use cookies and similar technologies to enhance your experience on our website and analyze usage patterns.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">6. Your Rights</h2>
            <p>You have the right to:</p>
            <ul class="list-disc ml-6 mb-4">
                <li>Access your personal information</li>
                <li>Correct inaccurate information</li>
                <li>Request deletion of your information</li>
                <li>Opt-out of marketing communications</li>
            </ul>

            <h2 class="text-2xl font-semibold mt-6 mb-4">7. Contact Us</h2>
            <p>If you have any questions about our Privacy Policy, please contact us through our website's contact form.</p>

            <div class="mt-8 text-sm text-gray-600">
                <p>Last updated: {{ date('F j, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 