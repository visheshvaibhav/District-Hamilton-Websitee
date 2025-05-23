<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Out for Delivery</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #4a2511;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .content {
            padding: 20px;
            background-color: #fff;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        h1 {
            color: #4a2511;
            margin-top: 0;
        }
        .order-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #2196F3;
            color: white;
            border-radius: 3px;
            font-size: 14px;
        }
        .delivery-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #e3f2fd;
            border-radius: 5px;
            border-left: 4px solid #2196F3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>District Tapas Bar & Restaurant</h2>
        </div>
        
        <div class="content">
            <h1>Your Order Is Out for Delivery!</h1>
            
            <p>Hello {{ $order->customer_name }},</p>
            
            <p>Great news! Your order <strong>#{{ $order->order_number }}</strong> is now out for delivery.</p>
            
            <div class="status-badge">Out for Delivery</div>
            
            <div class="delivery-info">
                <h3>Delivery Information</h3>
                <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                <p><strong>Estimated Delivery Time:</strong> {{ $order->pickup_time->format('g:i A') }}</p>
            </div>
            
            <div class="order-details">
                <h3>Order Summary</h3>
                <p><strong>Order Type:</strong> Delivery</p>
                <p><strong>Order Total:</strong> ${{ number_format($order->total, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            </div>
            
            <p>Your order is on its way! Our delivery driver will be with you shortly.</p>
            
            <p>Thank you for choosing District Tapas Bar & Restaurant!</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} District Tapas Bar & Restaurant. All rights reserved.</p>
            <p>If you have any questions, please contact us at {{ config('restaurant.phone', '(XXX) XXX-XXXX') }}</p>
        </div>
    </div>
</body>
</html> 