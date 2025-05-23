<?php

namespace App\Console\Commands;

use App\Mail\OrderConfirmation;
use App\Mail\OrderReceived;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTestEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:test {email? : The email address to send the test email to}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test order confirmation email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the email address from the command line or prompt for it
        $email = $this->argument('email') ?: $this->ask('What email address should receive the test email?');
        
        // Create a test order
        $order = Order::factory()->create([
            'order_number' => 'TEST-' . strtoupper(substr(uniqid(), -6)),
            'customer_name' => 'Test Customer',
            'customer_email' => $email,
            'customer_phone' => '123-456-7890',
            'order_type' => 'pickup',
            'subtotal' => 25.00,
            'tax' => 3.25,
            'total' => 28.25,
            'payment_method' => 'credit_card',
            'payment_status' => 'paid',
            'status' => 'pending',
        ]);
        
        // Create some test order items
        $orderItem = new OrderItem([
            'menu_item_id' => 1,
            'quantity' => 2,
            'price' => 12.50,
            'subtotal' => 25.00,
            'special_instructions' => 'Extra spicy please',
        ]);
        
        $order->items()->save($orderItem);
        
        // Send test emails
        try {
            // Send confirmation to customer
            Mail::to($email)->send(new OrderConfirmation($order));
            $this->info("Order confirmation email sent to {$email}");
            
            // Send notification to admin
            $adminEmail = config('mail.admin_email', 'admin@district-tapas.com');
            Mail::to($adminEmail)->send(new OrderReceived($order));
            $this->info("Order received email sent to {$adminEmail}");
            
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send emails: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
