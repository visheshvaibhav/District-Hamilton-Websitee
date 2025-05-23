<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Ready for Pickup</title>
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
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
            font-size: 14px;
        }
        .pickup-info {
            margin-top: 20px;
            padding: 15px;
            background-color: #e8f5e9;
            border-radius: 5px;
            border-left: 4px solid #4CAF50;
        }
        .important {
            font-weight: bold;
            color: #4a2511;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>District Tapas Bar & Restaurant</h2>
        </div>
        
        <div class="content">
            <h1>Your Order Is Ready for Pickup!</h1>
            
            <p>Hello {{ $order->customer_name }},</p>
            
            <p>Great news! Your order <strong>#{{ $order->order_number }}</strong> is now ready for pickup.</p>
            
            <div class="status-badge">Ready for Pickup</div>
            
            <div class="pickup-info">
                <h3>Pickup Information</h3>
                <p><strong>Order Number:</strong> #{{ $order->order_number }}</p>
                <p><strong>Restaurant Address:</strong> {{ config('restaurant.address', '123 Restaurant St, Hamilton, ON') }}</p>
                <p class="important">Please have your order number ready when you arrive.</p>
            </div>
            
            <div class="order-details">
                <h3>Order Summary</h3>
                <p><strong>Order Type:</strong> Pickup</p>
                <p><strong>Order Total:</strong> ${{ number_format($order->total, 2) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($order->payment_method) }}</p>
            </div>
            
            <p>Your order will be kept warm and ready for you. We recommend picking it up as soon as possible for the best quality.</p>
            
            <p>Thank you for choosing District Tapas Bar & Restaurant!</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} District Tapas Bar & Restaurant. All rights reserved.</p>
            <p>If you have any questions, please contact us at {{ config('restaurant.phone', '(XXX) XXX-XXXX') }}</p>
        </div>
    </div>
</body>
</html> 