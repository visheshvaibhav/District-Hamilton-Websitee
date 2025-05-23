<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Order Received</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #4F46E5;
            padding-bottom: 15px;
        }
        .logo {
            max-width: 150px;
            height: auto;
        }
        h1 {
            color: #4F46E5;
            margin-top: 0;
        }
        h2 {
            color: #4F46E5;
            margin-top: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .order-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .customer-info {
            background-color: #f0f0f0;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total-row {
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            background-color: #4F46E5;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/logo.png') }}" alt="The District Tapas Bar Logo" class="logo">
            <h1>New Order Received</h1>
        </div>
        
        <p>A new order has been received from {{ $customerName }}.</p>
        
        <div class="customer-info">
            <h2>Customer Information</h2>
            <p><strong>Name:</strong> {{ $customerName }}</p>
            <p><strong>Email:</strong> {{ $customerEmail }}</p>
            <p><strong>Phone:</strong> {{ $customerPhone }}</p>
            @if($orderType === 'delivery' && $deliveryAddress)
            <p><strong>Address:</strong> {{ $deliveryAddress }}</p>
            @endif
        </div>
        
        <div class="order-info">
            <h2>Order Details</h2>
            <p><strong>Order Number:</strong> {{ $orderNumber }}</p>
            <p><strong>Order Type:</strong> {{ ucfirst($orderType) }}</p>
            <p><strong>Order Status:</strong> {{ ucfirst($orderStatus) }}</p>
            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $paymentMethod)) }}</p>
            <p><strong>Payment Status:</strong> {{ ucfirst($paymentStatus) }}</p>
            
            @if($pickupTime)
            <p><strong>Pickup/Delivery Time:</strong> {{ $pickupTime->format('F j, Y, g:i a') }}</p>
            @else
            <p><strong>Pickup/Delivery Time:</strong> As soon as possible</p>
            @endif
            
            @if($notes)
            <p><strong>Special Instructions:</strong> {{ $notes }}</p>
            @endif
        </div>
        
        <h2>Order Items</h2>
        
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr>
                    <td>
                        {{ $item->menuItem->name ?? 'Unknown Item' }}
                        @if($item->special_instructions)
                        <br><small><em>Instructions: {{ $item->special_instructions }}</em></small>
                        @endif
                        @if($item->addOns->count() > 0)
                        <br><small>Add-ons: {{ $item->addOns->pluck('name')->join(', ') }}</small>
                        @endif
                    </td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->subtotal, 2) }}</td>
                </tr>
                @endforeach
                
                <tr>
                    <td colspan="2" align="right">Subtotal:</td>
                    <td>${{ $subtotal }}</td>
                </tr>
                <tr>
                    <td colspan="2" align="right">Tax:</td>
                    <td>${{ $tax }}</td>
                </tr>
                @if($deliveryFee > 0)
                <tr>
                    <td colspan="2" align="right">Delivery Fee:</td>
                    <td>${{ $deliveryFee }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="2" align="right">Total:</td>
                    <td>${{ $total }}</td>
                </tr>
            </tbody>
        </table>
        
        <p>
            <a href="{{ $orderUrl }}" class="btn">Manage Order</a>
        </p>
    </div>
</body>
</html> 