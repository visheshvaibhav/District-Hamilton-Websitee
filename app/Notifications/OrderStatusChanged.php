<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The order instance.
     *
     * @var \App\Models\Order
     */
    protected $order;

    /**
     * The previous status.
     *
     * @var string
     */
    protected $oldStatus;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order, string $oldStatus)
    {
        $this->order = $order;
        $this->oldStatus = $oldStatus;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusMessages = [
            'pending' => 'Your order has been received and is pending processing.',
            'preparing' => 'We\'re now preparing your order!',
            'ready' => 'Your order is ready for pickup!',
            'out_for_delivery' => 'Your order is out for delivery and will arrive soon!',
            'delivered' => 'Your order has been delivered. Enjoy!',
            'completed' => 'Your order has been completed. Thank you for your business!',
            'cancelled' => 'Your order has been cancelled.',
        ];
        
        $statusMessage = $statusMessages[$this->order->status] ?? 'Your order status has been updated.';
        
        return (new MailMessage)
            ->subject('Order #' . $this->order->order_number . ' Status Updated')
            ->greeting('Hello ' . $this->order->customer_name . '!')
            ->line($statusMessage)
            ->line('Order Number: ' . $this->order->order_number)
            ->line('Order Type: ' . ucfirst($this->order->order_type))
            ->line('Total: $' . number_format($this->order->total, 2))
            ->action('View Order Details', url('/orders/' . $this->order->id))
            ->line('Thank you for choosing The District Tapas Bar & Restaurant!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'old_status' => $this->oldStatus,
            'new_status' => $this->order->status,
        ];
    }
}
