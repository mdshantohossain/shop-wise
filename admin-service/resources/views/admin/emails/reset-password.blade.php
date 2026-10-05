<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            font-family: Arial, Helvetica, sans-serif;
        }

        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .email-header h2 {
            margin: 0;
            font-size: 24px;
        }

        .email-body {
            padding: 30px;
            color: #333;
        }

        .email-body h3 {
            color: #0d6efd;
            margin-top: 0;
            text-align: center;
        }

        .email-body p {
            font-size: 15px;
            line-height: 1.7;
            margin: 10px 0;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: rgb(255, 43, 53);
        }

        .action-button {
            display: inline-block;
            background: #ff2f0a;
            color: #ffffff !important;
            text-decoration: none;
            padding: 10px 22px; /* smaller & cleaner */
            border-radius: 32px; /* pill shape */
            font-weight: 600;
            font-size: 14px;
            border: none;
            cursor: pointer;
            transition: all 0.25s ease;
            letter-spacing: 0.4px;
            box-shadow: 0 4px 12px rgba(255, 43, 53, 0.25);
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(255, 43, 53, 0.35);
            background: #e01f2b;
        }

        .btn-container {
            text-align: center;
            margin: 30px 0;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 20px;
            }

            .email-header h2 {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">

    <!-- Body -->
    <div class="email-body">
        <p class="greeting">{{ __('Hello') }} {{ $user['name'] ?? 'User' }},</p>
        <p>We received a request to reset your password for your <strong>{{ config('app.name') }}</strong> account.</p>
        <p>Please click the button below to set a new password:</p>

        <div class="btn-container">
            <a href="{{ $url }}" class="action-button">Reset Password</a>
        </div>

        <p>If you did not request a password reset, no further action is required.</p>
        <p style="color: #888;">This link will expire in 60 minutes.</p>
    </div>


    <!-- Footer -->
    <div style="background-color:#2b2b2b; padding:20px; text-align:center; color:#ccc; font-size:13px;">
        <p style="margin: 0;">© {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
    </div>

</div>
</body>
</html>
