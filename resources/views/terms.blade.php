@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Terms and Conditions</h1>
        
        <div class="prose prose-lg">
            <h2 class="text-2xl font-semibold mt-6 mb-4">1. Acceptance of Terms</h2>
            <p>By accessing and using District Hamilton's website and services, you accept and agree to be bound by these Terms and Conditions. If you do not agree to these terms, please do not use our website or services.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">2. Use of Website</h2>
            <p>This website is provided for your personal and non-commercial use. You agree not to misuse the website or help anyone else do so.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">3. Online Ordering</h2>
            <p>All orders placed through our website are subject to availability and acceptance. We reserve the right to refuse service to anyone for any reason at any time.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">4. Pricing and Payment</h2>
            <p>All prices listed on the website are in Canadian dollars and are subject to change without notice. Payment is required at the time of ordering.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">5. Delivery and Pickup</h2>
            <p>Delivery times are estimates only. We are not responsible for delays beyond our control. Pickup orders should be collected at the specified time.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">6. Modifications to Service</h2>
            <p>We reserve the right to modify or discontinue any aspect of our service at any time without notice.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">7. Disclaimer of Warranties</h2>
            <p>Our services are provided "as is" without any warranties, expressed or implied.</p>

            <h2 class="text-2xl font-semibold mt-6 mb-4">8. Contact Information</h2>
            <p>For any questions regarding these terms, please contact us through our website's contact form.</p>

            <div class="mt-8 text-sm text-gray-600">
                <p>Last updated: {{ date('F j, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection 