<?php

namespace App\Services;

use App\Models\Order;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class OrderNotificationService
{
    /**
     * Send an admin notification for a new order
     */
    public function sendAdminNewOrderNotification(Order $order): bool
    {
        $settings = SiteSetting::first();
        $adminEmail = $settings?->admin_email ?? config('mail.from.address');
        
        $subject = "New Order Received - #{$order->order_number}";
        $orderType = ucfirst($order->order_type);
        $html = "
            <h2>New {$orderType} Order Received</h2>
            <p>A new order (#{$order->order_number}) has been received.</p>
            <p>Customer: {$order->customer_name}</p>
            <p>Order Total: $" . number_format($order->total, 2) . "</p>
            <p>You can view and manage this order in the admin panel.</p>
        ";
        
        return $this->sendEmail($adminEmail, $subject, $html);
    }
    
    /**
     * Send customer notification when order status changes from pending to confirmed
     */
    public function sendOrderConfirmedNotification(Order $order): bool
    {
        if (!$this->shouldSendCustomerNotification($order)) {
            return false;
        }
        
        $subject = "Your Order #{$order->order_number} Has Been Confirmed";
        $html = view('emails.orders.status-confirmed', ['order' => $order])->render();
        
        return $this->sendEmail($order->customer_email, $subject, $html);
    }
    
    /**
     * Send customer notification when order status changes from confirmed to prepared
     */
    public function sendOrderPreparedNotification(Order $order): bool
    {
        if (!$this->shouldSendCustomerNotification($order)) {
            return false;
        }
        
        $subject = "Your Order #{$order->order_number} Has Been Prepared";
        $html = view('emails.orders.status-prepared', ['order' => $order])->render();
        
        return $this->sendEmail($order->customer_email, $subject, $html);
    }
    
    /**
     * Send customer notification when pickup order status changes from prepared to ready
     */
    public function sendOrderReadyForPickupNotification(Order $order): bool
    {
        if (!$this->shouldSendCustomerNotification($order) || !$order->isPickup()) {
            return false;
        }
        
        $subject = "Your Order #{$order->order_number} Is Ready For Pickup";
        $html = view('emails.orders.status-ready-pickup', ['order' => $order])->render();
        
        return $this->sendEmail($order->customer_email, $subject, $html);
    }
    
    /**
     * Send customer notification when delivery order status changes from prepared to out for delivery
     */
    public function sendOrderOutForDeliveryNotification(Order $order): bool
    {
        if (!$this->shouldSendCustomerNotification($order) || !$order->isDelivery()) {
            return false;
        }
        
        $subject = "Your Order #{$order->order_number} Is Out For Delivery";
        $html = view('emails.orders.status-out-for-delivery', ['order' => $order])->render();
        
        return $this->sendEmail($order->customer_email, $subject, $html);
    }
    
    /**
     * Check if customer notification should be sent
     */
    private function shouldSendCustomerNotification(Order $order): bool
    {
        return !empty($order->customer_email);
    }
    
    /**
     * Send email using Mailgun service
     */
    private function sendEmail(string $to, string $subject, string $html): bool
    {
        $mailgunService = new MailgunService();
        
        try {
            $response = $mailgunService->sendRawEmail($to, $subject, $html);
            return $response;
        } catch (\Exception $e) {
            Log::error('Failed to send order notification email: ' . $e->getMessage());
            return false;
        }
    }
} 