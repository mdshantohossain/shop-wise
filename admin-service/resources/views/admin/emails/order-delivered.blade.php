<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Confirmation</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Oxygen', 'Ubuntu', 'Cantarell', sans-serif;
            line-height: 1.6;
            color: #2d3748;
            background-color: #f7fafc;
        }

        .email-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        }

        /* Content */
        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 24px;
            line-height: 1.7;
        }

        .greeting strong {
            color: #1a202c;
            font-weight: 600;
        }

        /* Status Section */
        .status-section {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.05) 0%, rgba(5, 150, 105, 0.05) 100%);
            border-left: 4px solid #10b981;
            padding: 20px;
            border-radius: 8px;
            margin: 24px 0;
        }

        .status-badge {
            display: inline-block;
            background-color: #10b981;
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
        }

        .status-title {
            font-size: 16px;
            color: #1a202c;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .status-date {
            font-size: 14px;
            color: #4a5568;
        }

        /* Order Summary */
        .section {
            margin: 32px 0;
        }

        .section-title {
            font-size: 16px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid #edf2f7;
        }

        .order-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .detail-item {
            padding: 12px;
            background-color: #f7fafc;
            border-radius: 6px;
        }

        .detail-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .detail-value {
            font-size: 15px;
            color: #2d3748;
            font-weight: 500;
        }

        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .items-table th {
            background-color: #edf2f7;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #4a5568;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #cbd5e0;
        }

        .items-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #edf2f7;
            font-size: 14px;
        }

        .items-table tr:last-child td {
            border-bottom: none;
        }

        .item-name {
            font-weight: 500;
            color: #1a202c;
        }

        .item-qty {
            text-align: center;
            color: #718096;
        }

        .item-price {
            text-align: right;
            color: #1a202c;
            font-weight: 500;
        }

        /* Delivery Address */
        .address-box {
            background-color: #f7fafc;
            padding: 16px;
            border-radius: 8px;
            border-left: 3px solid #10b981;
        }

        .address-label {
            font-size: 12px;
            color: #718096;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .address-content {
            font-size: 14px;
            color: #2d3748;
            line-height: 1.8;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.08) 0%, rgba(5, 150, 105, 0.08) 100%);
            padding: 24px;
            border-radius: 8px;
            text-align: center;
            margin: 24px 0;
        }

        .cta-button {
            display: inline-block;
            background: #ff2f0a;
            color: white;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .cta-button:hover {
            opacity: 0.95;
        }

        /* Info Box */
        .info-box {
            background-color: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 16px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .info-box-title {
            color: #1e40af;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .info-box-text {
            color: #1e40af;
            font-size: 13px;
            line-height: 1.6;
        }

        /* Footer */
        .email-footer {
            background: #1f2937;
            color: #d1d5db;
            text-align: center;
            padding: 30px 20px;
            font-size: 13px;
        }

        .footer-links {
            margin: 12px 0;
        }

        .footer-links a {
            color: #3182ce;
            text-decoration: none;
            font-size: 12px;
            margin: 0 8px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .email-container {
                border-radius: 0;
            }

            .content {
                padding: 24px 16px;
            }

            .order-details {
                grid-template-columns: 1fr;
            }

            .header {
                padding: 30px 16px;
            }


            .email-footer {
                background: #1f2937;
                color: #d1d5db;
                text-align: center;
                padding: 30px 20px;
                font-size: 13px;
            }

            .items-table {
                font-size: 13px;
            }

            .items-table th,
            .items-table td {
                padding: 10px 6px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">

    <!-- Content -->
    <div class="content">
        <!-- Greeting -->
        <div class="greeting">
            Hi <strong>{{ $order->user->name }}</strong>,
            <br><br>
            Great news! Your order has been successfully delivered. We hope you're excited to receive your items. Thank you for shopping with us!
        </div>

        <!-- Status Section -->
{{--        <div class="status-section">--}}
{{--            <div class="status-badge">Delivered</div>--}}
{{--            <div class="status-title">Delivery Complete</div>--}}
{{--            <div class="status-date">--}}
{{--                Delivered on {{ $order->delivery_at->format('l, F j, Y \a\t g:i A') }}--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Order Information -->
        <div class="section">
            <div class="section-title">Order Information</div>
            <div class="order-details">
                <div class="detail-item">
                    <div class="detail-label">Order Number</div>
                    <div class="detail-value">#{{ $order->order_number }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Total Amount</div>
                    <div class="detail-value">৳{{ number_format($order->order_total, 2) }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Order Date</div>
                    <div class="detail-value">{{ $order->created_at?->format('M d, Y') ?? 'N/A' }}</div>
                </div>
            </div>
        </div>

        <!-- Ordered Items -->
        <div class="section">
            <div class="section-title">Items Delivered</div>
            <table class="items-table">
                <thead>
                <tr>
                    <th style="text-align: left;">Product</th>
                    <th class="item-qty">Qty</th>
                    <th class="item-price">Price</th>
                </tr>
                </thead>
                <tbody>
                @forelse($order->orderDetails as $item)
                    <tr>
                        <td class="item-name">
                            <span style="width: 120px; height: 120px; border-radius: 50%">
                                <img src="{{ $item->product->image_thumbnail }}" alt="{{ $item->product->name }}" />
                            </span>
                            {{ $item->product->name }}
                        </td>
                        <td class="item-qty">{{ $item->quantity }}</td>
                        <td class="item-price">৳{{ number_format($item->price) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #718096;">No items to display</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Delivery Address -->
        <div class="section">
            <div class="section-title">Delivery Address</div>
            <div class="address-box">
                <div class="address-label">Delivered To</div>
                <div class="address-content">
                    {{ $order->user->name }}<br>
                    {{ $order->delivery_address }}<br>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="info-box">
            <div class="info-box-title">What's Next?</div>
            <div class="info-box-text">
                Please inspect your package upon receipt. If you notice any damage or missing items, contact us immediately. We're here to help!
            </div>
        </div>

        <!-- Review CTA -->
        <div class="cta-section">
            <p style="margin-bottom: 16px; font-size: 14px; color: #2d3748;">
                We'd love to hear about your experience!
            </p>
            <a href="{{ $review_url ?? '#' }}" class="cta-button">Share Your Review</a>
        </div>

        <!-- Support Info -->
        <div class="info-box" style="background-color: #fef3c7; border-left-color: #f59e0b;">
            <div class="info-box-title" style="color: #92400e;">Need Help?</div>
            <div class="info-box-text" style="color: #92400e;">
                If you have any questions about your delivery, please reach out to our customer support team. We're ready to assist!
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <div class="footer-links">
            <a href="{{ config('app.url') }}">Home</a>
            <a href="{{ config('app.frontend_url') }}/contact">Contact</a>
            <a href="{{ config('app.frontend_url') }}/faq">FAQ</a>
        </div>

        <p style="margin-bottom: 10px;">
            © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
        </p>

        <p style="font-size: 12px; opacity: 0.8;">
            This is an automated message, please do not reply to this email.
        </p>
    </div>
</div>
</body>
</html>
