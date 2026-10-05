<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Verify Email Address') }} - {{ config('app.name') }}</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .email-wrapper {
            background-color: #f5f5f5;
            padding: 20px;
            min-height: 100vh;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .email-body {
            padding: 40px 30px;
            color: #333333;
        }

        .email-body > p:first-child {
            margin-top: 0;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: rgb(255, 43, 53);
        }

        .content {
            font-size: 15px;
            line-height: 1.6;
            color: #555555;
            margin: 15px 0;
        }

        .action-container {
            text-align: center;
            margin: 40px 0;
        }

        .action-button {
            display: inline-block;
            background: #ff2b35;
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

        .footer-note {
            font-size: 13px;
            color: #888888;
            line-height: 1.6;
            margin: 30px 0 0 0;
            border-top: 1px solid #eeeeee;
            padding-top: 20px;
        }

        .footer-note strong {
            color: #555555;
        }

        @media only screen and (max-width: 600px) {
            .email-wrapper {
                padding: 10px;
            }

            .email-body {
                padding: 25px 20px;
            }

            .action-button {
                padding: 12px 28px;
                font-size: 15px;
                width: 100%;
                box-sizing: border-box;
            }

            .greeting {
                font-size: 16px;
            }

            .content {
                font-size: 14px;
            }
        }

        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a1a1a;
            }

            .email-wrapper {
                background-color: #1a1a1a;
            }

            .email-container {
                background-color: #2a2a2a;
            }

            .email-body {
                color: #e0e0e0;
            }

            .greeting {
                color: #ffffff;
            }

            .content {
                color: #cccccc;
            }

            .footer-note {
                color: #999999;
                border-top-color: #444444;
            }

            .footer-note strong {
                color: #dddddd;
            }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-container">

        <div class="email-body">
            <p class="greeting">{{ __('Hello') }} {{ $user['name'] ?? 'User' }},</p>

            <p class="content">
                {{ __('Thank you for signing up for :app! We\'re excited to have you.', ['app' => config('app.name')]) }}
            </p>

            <p class="content">
                {{ __('To complete your registration and secure your account, please verify your email address by clicking the button below:') }}
            </p>

            <div class="action-container">
                <a href="{{ $verificationUrl }}" class="action-button">{{ __('Verify Email') }}</a>
            </div>

            <p class="footer-note">
                <strong>{{ __('Didn\'t create this account?') }}</strong><br>
                {{ __('If you didn\'t sign up for a :app account, please ignore this email or contact our support team immediately.', ['app' => config('app.name')]) }}
            </p>
        </div>


        <!-- Footer -->
        <div style="background-color:#2b2b2b; padding:20px; text-align:center; color:#ccc; font-size:13px;">
            <p style="margin: 0;">© {{ now()->year }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</div>
</body>
</html>
