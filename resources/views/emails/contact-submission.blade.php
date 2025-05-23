<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Contact Form Submission</title>
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
        <h2>New Contact Form Submission</h2>
        <p>Received on {{ $submission->created_at->format('F j, Y \a\t g:i A') }}</p>
    </div>

    <div class="content">
        <div class="field">
            <div class="label">Name:</div>
            <div class="value">{{ $submission->first_name }} {{ $submission->last_name }}</div>
        </div>

        <div class="field">
            <div class="label">Email:</div>
            <div class="value">{{ $submission->email }}</div>
        </div>

        <div class="field">
            <div class="label">Phone:</div>
            <div class="value">{{ $submission->phone }}</div>
        </div>

        @if($submission->subject)
        <div class="field">
            <div class="label">Subject:</div>
            <div class="value">{{ $submission->subject }}</div>
        </div>
        @endif

        <div class="field">
            <div class="label">Message:</div>
            <div class="value">{{ $submission->message }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This is an automated message from your website's contact form.</p>
    </div>
</body>
</html> 