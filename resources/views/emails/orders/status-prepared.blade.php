<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Prepared</title>
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
            background-color: #FF9800;
            color: white;
            border-radius: 3px;
            font-size: 14px;
        }
        .next-steps {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>District Tapas Bar & Restaurant</h2>
        </div>
        
        <div class="content">
            <h1>Your Order Has Been Prepared</h1>
            
            <p>Hello {{ $order->customer_name }},</p>
            
            <p>Your order <strong>#{{ $order->order_number }}</strong> has been prepared.</p>
            
            <div class="status-badge">Prepared</div>
            
            <div class="order-details">
                <p><strong>Order Type:</strong> {{ ucfirst($order->order_type) }}</p>
                <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
            </div>
            
            <div class="next-steps">
                @if($order->isPickup())
                <h3>What's Next?</h3>
                <p>We'll notify you as soon as your order is ready for pickup.</p>
                <p>Please be prepared to provide your order number when you arrive.</p>
                @else
                <h3>What's Next?</h3>
                <p>Your order will be out for delivery shortly. We'll notify you when it's on the way.</p>
                @endif
            </div>
            
            <p>Thank you for choosing District Tapas Bar & Restaurant!</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} District Tapas Bar & Restaurant. All rights reserved.</p>
            <p>If you have any questions, please contact us at {{ config('restaurant.phone', '(XXX) XXX-XXXX') }}</p>
        </div>
    </div>
</body>
</html> 