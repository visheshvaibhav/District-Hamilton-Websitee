<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSubmission;
use App\Services\MailgunService;

class ContactController extends Controller
{
    protected $mailgunService;

    public function __construct(MailgunService $mailgunService)
    {
        $this->mailgunService = $mailgunService;
    }

    public function index()
    {
        return view('contact');
    }
    
    public function submit(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);
        
        // Save submission to database
        $submission = ContactSubmission::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'subject' => $validated['subject'] ?? 'Contact Form Submission',
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
        
        $this->mailgunService->sendContactNotification($submission);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Thank you for your message. We will get back to you within 24 hours.',
            ]);
        }

        return back()->with('success', 'Thank you for your message. We will get back to you within 24 hours.');
    }
} 