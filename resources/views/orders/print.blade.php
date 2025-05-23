<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt #{{ $order->order_number }}</title>
    
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .receipt {
            max-width: 80mm;
            margin: 0 auto;
            padding: 5mm;
        }
        
        .header {
            text-align: center;
            margin-bottom: 10mm;
        }
        
        .header h1 {
            font-size: 16px;
            margin: 0;
            margin-bottom: 2mm;
        }
        
        .header p {
            margin: 0;
            font-size: 12px;
        }
        
        .order-info {
            margin-bottom: 10mm;
        }
        
        .order-info table {
            width: 100%;
        }
        
        .order-info table td {
            padding: 1mm 0;
        }
        
        .order-info table td:last-child {
            text-align: right;
        }
        
        .items {
            margin-bottom: 10mm;
        }
        
        .items table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .items table th {
            border-bottom: 1px solid #000;
            text-align: left;
            padding: 1mm 0;
            font-weight: normal;
        }
        
        .items table th:last-child,
        .items table td:last-child {
            text-align: right;
        }
        
        .items table td {
            padding: 1mm 0;
            vertical-align: top;
        }
        
        .item-description {
            font-size: 12px;
            color: #555;
        }
        
        .totals table {
            width: 100%;
        }
        
        .totals table td {
            padding: 1mm 0;
        }
        
        .totals table td:last-child {
            text-align: right;
        }
        
        .totals .total {
            font-weight: bold;
            font-size: 16px;
            border-top: 1px solid #000;
            padding-top: 2mm;
        }
        
        .footer {
            text-align: center;
            margin-top: 10mm;
            padding-top: 5mm;
            border-top: 1px solid #ccc;
            font-size: 12px;
        }
        
        @media print {
            @page {
                size: 80mm 297mm;
                margin: 0;
            }
            
            body {
                width: 80mm;
                margin: 5mm;
            }
            
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>{{ config('app.name', 'The District Tapas + Bar - Hamilton') }}</h1>
            <p>61 Barton St E, Hamilton, ON L8L 2V7</p>
            <p>+1 905-522-2580</p>
            <p>{{ now()->format('F j, Y h:i A') }}</p>
        </div>
        
        <div class="order-info">
            <table>
                <tr>
                    <td><strong>Order #:</strong></td>
                    <td>{{ $order->order_number }}</td>
                </tr>
                <tr>
                    <td><strong>Order Type:</strong></td>
                    <td>{{ ucfirst($order->order_type) }}</td>
                </tr>
                <tr>
                    <td><strong>Customer:</strong></td>
                    <td>{{ $order->customer_name }}</td>
                </tr>
                @if($order->order_type == 'delivery')
                <tr>
                    <td><strong>Address:</strong></td>
                    <td>{{ $order->delivery_address }}</td>
                </tr>
                @endif
                <tr>
                    <td><strong>Pickup/Delivery:</strong></td>
                    <td>{{ $order->pickup_time ? $order->pickup_time->format('F j, Y h:i A') : 'ASAP' }}</td>
                </tr>
                <tr>
                    <td><strong>Payment:</strong></td>
                    <td>{{ ucfirst($order->payment_method) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="items">
            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->name }}
                            @if($item->special_instructions)
                            <div class="item-description">{{ $item->special_instructions }}</div>
                            @endif
                            @if(isset($item->options['add_ons']) && count($item->options['add_ons']) > 0)
                            <div class="item-description">
                                Add-ons: {{ collect($item->options['add_ons'])->pluck('name')->implode(', ') }}
                            </div>
                            @endif
                        </td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="totals">
            <table>
                <tr>
                    <td>Subtotal</td>
                    <td>${{ number_format($order->subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Tax (13%)</td>
                    <td>${{ number_format($order->tax, 2) }}</td>
                </tr>
                @if($order->order_type == 'delivery')
                <tr>
                    <td>Delivery Fee</td>
                    <td>${{ number_format($order->delivery_fee, 2) }}</td>
                </tr>
                @endif
                @if($order->tip_amount > 0)
                <tr>
                    <td>Tip ({{ $order->tip_percentage }}%)</td>
                    <td>${{ number_format($order->tip_amount, 2) }}</td>
                </tr>
                @endif
                @if($order->gift_card_code_used)
                <tr>
                    <td>Gift Card</td>
                    <td>-${{ number_format($order->gift_card_amount ?? 0, 2) }}</td>
                </tr>
                @endif
                <tr class="total">
                    <td>TOTAL</td>
                    <td>${{ number_format($order->total, 2) }}</td>
                </tr>
            </table>
        </div>
        
        <div class="footer">
            <p>Thank you for dining with The District Tapas + Bar - Hamilton!</p>
            <p>Order placed on: {{ $order->created_at->format('F j, Y h:i A') }}</p>
            @if($order->status == 'completed')
            <p>Order completed on: {{ $order->updated_at->format('F j, Y h:i A') }}</p>
            @else
            <p>Order status: {{ ucfirst($order->status) }}</p>
            @endif
        </div>
        
        <div class="no-print" style="margin-top: 20mm; text-align: center;">
            <button onclick="window.print()">Print Receipt</button>
            <button onclick="window.close()">Close</button>
        </div>
    </div>
</body>
</html> 