<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed</title>
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
        .order-items {
            width: 100%;
            border-collapse: collapse;
        }
        .order-items th, .order-items td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .order-items th {
            background-color: #f2f2f2;
        }
        .totals {
            margin-top: 15px;
            text-align: right;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 3px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>District Tapas Bar & Restaurant</h2>
        </div>
        
        <div class="content">
            <h1>Your Order Has Been Confirmed</h1>
            
            <p>Hello {{ $order->customer_name }},</p>
            
            <p>Your order <strong>#{{ $order->order_number }}</strong> has been confirmed and is now being prepared.</p>
            
            <div class="status-badge">Confirmed</div>
            
            <div class="order-details">
                <p><strong>Order Type:</strong> {{ ucfirst($order->order_type) }}</p>
                @if($order->isPickup())
                <p><strong>Pickup Time:</strong> {{ $order->pickup_time->format('F j, Y \a\t g:i A') }}</p>
                @else
                <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
                <p><strong>Estimated Delivery Time:</strong> {{ $order->pickup_time->format('F j, Y \a\t g:i A') }}</p>
                @endif
                
                <h3>Order Items</h3>
                <table class="order-items">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <div class="totals">
                    <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                    <p><strong>Tax:</strong> ${{ number_format($order->tax, 2) }}</p>
                    @if($order->isDelivery())
                    <p><strong>Delivery Fee:</strong> ${{ number_format($order->delivery_fee, 2) }}</p>
                    @if($order->tip_amount > 0)
                    <p><strong>Tip:</strong> ${{ number_format($order->tip_amount, 2) }}</p>
                    @endif
                    @endif
                    <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                </div>
            </div>
            
            <p>We'll notify you when your order is ready for pickup or out for delivery.</p>
            
            <p>Thank you for choosing District Tapas Bar & Restaurant!</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} District Tapas Bar & Restaurant. All rights reserved.</p>
            <p>If you have any questions, please contact us at {{ config('restaurant.phone', '(XXX) XXX-XXXX') }}</p>
        </div>
    </div>
</body>
</html> 