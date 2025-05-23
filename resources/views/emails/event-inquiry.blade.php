<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Event Inquiry Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            color: #495057;
        }
        .value {
            margin-top: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 0.9em;
            color: #6c757d;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Event Inquiry</h2>
        <p>Received on {{ $inquiry->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="label">Name:</div>
            <div class="value">{{ $inquiry->first_name }} {{ $inquiry->last_name }}</div>
        </div>

        <div class="field">
            <div class="label">Email:</div>
            <div class="value">{{ $inquiry->email }}</div>
        </div>

        <div class="field">
            <div class="label">Phone:</div>
            <div class="value">{{ $inquiry->phone }}</div>
        </div>

        @if($inquiry->company)
        <div class="field">
            <div class="label">Company:</div>
            <div class="value">{{ $inquiry->company }}</div>
        </div>
        @endif

        <div class="field">
            <div class="label">Event Type:</div>
            <div class="value">{{ $inquiry->event_type }}</div>
        </div>

        <div class="field">
            <div class="label">Guest Count:</div>
            <div class="value">{{ $inquiry->guest_count }}</div>
        </div>

        <div class="field">
            <div class="label">Event Date:</div>
            <div class="value">{{ $inquiry->event_date->format('F j, Y') }}</div>
        </div>

        <div class="field">
            <div class="label">Event Time:</div>
            <div class="value">{{ $inquiry->event_time }}</div>
        </div>

        @if($inquiry->details)
        <div class="field">
            <div class="label">Additional Details:</div>
            <div class="value">{{ $inquiry->details }}</div>
        </div>
        @endif
    </div>

    <div class="footer">
        <p>This is an automated message from your website's event inquiry form.</p>
    </div>
</body>
</html> 