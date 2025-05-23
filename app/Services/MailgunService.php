<?php

namespace App\Services;

use App\Models\ContactSubmission;
use App\Models\EventInquiry;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MailgunService
{
    private ?string $apiKey = null;
    private ?string $domain = null;
    private ?string $adminEmail = null;

    public function __construct()
    {
        $settings = SiteSetting::first();
        $this->apiKey = $settings?->mailgun_api_key ?? config('services.mailgun.secret');
        $this->domain = config('services.mailgun.domain');
        $this->adminEmail = $settings?->admin_email ?? config('mail.from.address');
    }

    public function sendContactNotification(ContactSubmission $submission): bool
    {
        if (!$this->isConfigured()) {
            Log::warning('Mailgun is not properly configured. Email notification not sent.');
            return false;
        }

        $subject = "New Contact Form Submission";
        $html = view('emails.contact-submission', ['submission' => $submission])->render();
        
        return $this->sendEmail($subject, $html);
    }

    public function sendEventInquiryNotification(EventInquiry $inquiry): bool
    {
        if (!$this->isConfigured()) {
            Log::warning('Mailgun is not properly configured. Email notification not sent.');
            return false;
        }

        $subject = "New Event Inquiry Submission";
        $html = view('emails.event-inquiry', ['inquiry' => $inquiry])->render();
        
        return $this->sendEmail($subject, $html);
    }
    
    /**
     * Send a raw email to a specific recipient
     */
    public function sendRawEmail(string $to, string $subject, string $html): bool
    {
        if (!$this->isConfigured()) {
            Log::warning('Mailgun is not properly configured. Email notification not sent.');
            return false;
        }

        try {
            $response = Http::withBasicAuth('api', $this->apiKey)
                ->asForm()
                ->post("https://api.mailgun.net/v3/{$this->domain}/messages", [
                    'from' => config('mail.from.address'),
                    'to' => $to,
                    'subject' => $subject,
                    'html' => $html,
                ]);

            if (!$response->successful()) {
                Log::error('Mailgun API Error: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Mailgun API Error: ' . $e->getMessage());
            return false;
        }
    }

    private function sendEmail(string $subject, string $html): bool
    {
        if (!$this->isConfigured()) {
            return false;
        }

        try {
            $response = Http::withBasicAuth('api', $this->apiKey)
                ->asForm()
                ->post("https://api.mailgun.net/v3/{$this->domain}/messages", [
                    'from' => config('mail.from.address'),
                    'to' => $this->adminEmail,
                    'subject' => $subject,
                    'html' => $html,
                ]);

            if (!$response->successful()) {
                Log::error('Mailgun API Error: ' . $response->body());
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Mailgun API Error: ' . $e->getMessage());
            return false;
        }
    }

    private function isConfigured(): bool
    {
        if (empty($this->apiKey) || empty($this->domain) || empty($this->adminEmail)) {
            Log::warning('Mailgun configuration is incomplete. Required: API key, domain, and admin email.');
            return false;
        }

        return true;
    }
} 