<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInquiry;
use App\Services\MailgunService;

class EventsController extends Controller
{
    protected $mailgunService;

    public function __construct(MailgunService $mailgunService)
    {
        $this->mailgunService = $mailgunService;
    }

    public function index()
    {
        return view('events');
    }
    
    public function inquiry(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'company' => 'nullable|string|max:255',
            'event_type' => 'required|string|max:255',
            'guest_count' => 'required|integer|min:1|max:65',
            'event_date' => 'required|date',
            'event_time' => 'required|string|max:255',
            'details' => 'nullable|string',
            'admin_email' => 'nullable|email'
        ]);
        
        // Save inquiry to database
        $inquiry = EventInquiry::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? null,
            'event_type' => $validated['event_type'],
            'guest_count' => $validated['guest_count'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'],
            'details' => $validated['details'] ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        // Get admin email from config or from the form
        $adminEmail = $validated['admin_email'] ?? config('mail.admin_email', config('mail.from.address'));
        
        // Prepare data for email
        $data = [
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company' => $validated['company'] ?? 'N/A',
            'event_type' => $validated['event_type'],
            'guest_count' => $validated['guest_count'],
            'event_date' => $validated['event_date'],
            'event_time' => $validated['event_time'],
            'details' => $validated['details'] ?? 'No additional details provided',
            'submission_date' => $inquiry->created_at->format('F j, Y, g:i a'),
            'inquiry_id' => $inquiry->id,
        ];
        
        // Send email using Laravel's Mail facade
        try {
            $this->mailgunService->sendEventInquiryNotification($inquiry);
            
            $successMessage = 'Thank you for your event inquiry! Our events team will contact you within 24 hours to discuss the details.';
            
            // Return JSON response for AJAX request, or redirect with flash message for regular form submission
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
            
            // Flash success message for non-AJAX requests
            return redirect()->route('events')->with('success', $successMessage);
        } catch (\Exception $e) {
            // Log error 
            \Log::error('Event inquiry email failed: ' . $e->getMessage());
            
            $errorMessage = 'Sorry, there was an issue submitting your inquiry. Please try again later or contact us directly.';
            
            // Return JSON response for AJAX request, or redirect with error for regular form submission
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }
            
            return redirect()->route('events')->with('error', $errorMessage);
        }
    }
} 