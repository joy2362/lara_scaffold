{{-- resources/views/emails/forgot-password-code.blade.php --}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f6f6f6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            background-color: #ffffff;
            margin: 30px auto;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            color: #333333;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .code {
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 6px;
            background-color: #e9ecef;
            padding: 10px 20px;
            display: inline-block;
            border-radius: 4px;
            margin: 20px 0;
            color: #212529;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            font-size: 12px;
            color: #888888;
            margin-top: 30px;
            border-top: 1px solid #dddddd;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset Code</h1>
        <p>Hello {{ $user->name ?? 'User' }},</p>
        <p>We received a request to reset your password. Use the following verification code to proceed:</p>

        <div class="code">{{ $code }}</div>

        <p>If you did not request a password reset, please ignore this email.</p>

        <p>Thank you,<br />{{ config('app.name') }} Team</p>

        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </div>
    </div>
</body>
</html>
