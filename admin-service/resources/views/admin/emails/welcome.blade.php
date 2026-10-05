<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
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

    </style>
</head>


<body style="margin:0; padding:0; font-family:'Segoe UI', Arial, Helvetica, sans-serif;">
<div style="max-width:650px; margin:40px auto; background:#ffffff; border-radius:10px; box-shadow:0 4px 18px rgba(0,0,0,0.08); overflow:hidden;">

    <!-- Body -->
    <div style="padding:35px 30px 40px 30px; color:#333;">
        <h2 style="color:rgb(255, 43, 53); margin-bottom:10px;">
            Hello {{ $userName }},
        </h2>

        <p style="font-size:16px; line-height:1.7; margin-top:0;">
            Welcome to <strong>{{ config('app.name') }}</strong>! Your account has been successfully created.
        </p>

        <p style="font-size:15px; line-height:1.7;">
            You can now explore products, manage your orders, and enjoy a personalized shopping experience.
        </p>

        <div style="background-color:#fef2f2; border-left:4px solid rgb(255, 43, 53); padding:15px 20px; margin:25px 0; border-radius:6px;">
            <p style="margin:0; font-size:14px; color:#444;">
                💡 <strong>Tip:</strong> Complete your profile to get better recommendations and faster checkout.
            </p>
        </div>

        <h3 style="margin-bottom:10px; color:#222;">Get started:</h3>

        <ul style="font-size:15px; color:#555; line-height:1.8; padding-left:20px; margin-top:0;">
            <li>Browse products and discover deals</li>
            <li>Update your profile information</li>
            <li>Track your orders easily</li>
        </ul>

        <div style="text-align:center; margin-top:35px;">
            <a href="{{ config('app.frontend_url') . '/dashboard' }}" class="action-button">
                Go to Dashboard
            </a>
        </div>
    </div>

    <!-- Footer -->
    <div style="background-color:#2b2b2b; padding:20px; text-align:center; color:#ccc; font-size:13px;">
        <p style="margin:0;">
            Need help? <a href="{{ config('services.frontend.url') . '/contact' }}" style="color:#ff7373; text-decoration:none;">Contact our support team</a>.
        </p>
        <p style="margin-top:8px;">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</div>
</body>
</html>
