<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - {{ config('app.name') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', 'Helvetica', 'Arial', sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
        }

        .email-wrapper {
            background: #f5f7fa;
            padding: 40px 20px;
        }

        .email-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .email-header {
            background: #ff2f0a;
            padding: 40px 30px;
            text-align: center;
            color: #ffffff;
        }

        .email-header h1 {
            font-size: 28px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .email-header p {
            font-size: 16px;
            opacity: 0.95;
        }

        .email-content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 16px;
            margin-bottom: 20px;
            color: #333;
        }

        .greeting strong {
            color: #ff2f0a;
        }

        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #f0f0f0;
        }

        .info-box {
            background: #f9fafb;
            border-left: 4px solid #ff2f0a;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #ff2f0a;
        }

        .info-value {
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-processing {
            background: #dbeafe;
            color: #1e40af;
        }

        .status-delivered {
            background: #dcfce7;
            color: #166534;
        }

        .status-paid {
            background: #dcfce7;
            color: #166534;
        }

        .status-unpaid {
            background: #fee2e2;
            color: #991b1b;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            background: #f3f4f6;
            padding: 12px;
            text-align: left;
            font-weight: 600;
            font-size: 13px;
            color: #667eea;
            border-bottom: 2px solid #e5e7eb;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }

        .items-table tbody tr:hover {
            background: #fafbfc;
        }

        .items-table .text-right {
            text-align: right;
        }

        .items-table .text-muted {
            color: #999;
        }

        .pricing-summary {
            background: #f9fafb;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .price-row.total {
            font-size: 18px;
            font-weight: 700;
            color: #ff2f0a;
            border-top: 2px solid #e5e7eb;
            padding-top: 10px;
            margin-bottom: 0;
        }

        .cta-button {
            display: inline-block;
            background: #ff2f0a;
            color: #ffffff !important;
            padding: 14px 32px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }

        .cta-wrapper {
            text-align: center;
            margin-top: 30px;
        }

        .delivery-box {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 16px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .delivery-box strong {
            color: #f59e0b;
        }

        .delivery-info {
            font-size: 14px;
            line-height: 1.8;
            color: #666;
        }

        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 30px 0;
        }

        .email-footer {
            background: #1f2937;
            color: #d1d5db;
            text-align: center;
            padding: 30px 20px;
            font-size: 13px;
        }

        .footer-links {
            margin-bottom: 15px;
        }

        .footer-links a {
            color: #60a5fa;
            text-decoration: none;
            margin: 0 10px;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .email-header {
                padding: 30px 20px;
            }

            .email-header h1 {
                font-size: 24px;
            }

            .email-content {
                padding: 20px;
            }

            .info-row {
                flex-direction: column;
            }

            .info-label {
                display: block;
                margin-bottom: 4px;
            }

            .info-value {
                display: block;
            }

            .items-table th,
            .items-table td {
                padding: 8px;
                font-size: 13px;
            }

            .price-row {
                font-size: 13px;
            }

            .price-row.total {
                font-size: 16px;
            }

            .cta-button {
                display: block;
                width: 100%;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-wrapper">
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>✓ Order Confirmed</h1>
            <p>Thank you for your purchase!</p>
        </div>

        <!-- Content -->
        <div class="email-content">
            <div class="greeting">
                Hello <strong>{{ $order->user->name }}</strong>,
            </div>

            <p style="margin-bottom: 20px; color: #666;">
                We're excited to let you know that your order has been placed successfully.
                Below you'll find all the details of your purchase.
            </p>

            <!-- Order Status Section -->
            <div class="section">
                <div class="section-title">Order Details</div>

                <div class="info-box">
                    <div class="info-row">
                        <span class="info-label">Order ID:</span>
                        <span class="info-value">#{{ $order->order_number }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Order Date:</span>
                        <span class="info-value">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Order Status:</span>
                        <span class="info-value">
                                @php
                                    $statuses = ['Pending', 'Processing', 'Delivered', 'Canceled'];
                                    $statusClasses = ['status-pending', 'status-processing', 'status-delivered', 'status-pending'];
                                    $status = $statuses[$order->order_status] ?? 'Unknown';
                                    $statusClass = $statusClasses[$order->order_status] ?? 'status-pending';
                                @endphp
                                <span class="status-badge {{ $statusClass }}">{{ $status }}</span>
                            </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Payment Status:</span>
                        <span class="info-value">
                                @php
                                    $paymentStatuses = ['Unpaid', 'Paid', 'Refunded'];
                                    $paymentStatusClasses = ['status-unpaid', 'status-paid', 'status-pending'];
                                    $paymentStatus = $paymentStatuses[$order->payment_status] ?? 'Unknown';
                                    $paymentStatusClass = $paymentStatusClasses[$order->payment_status] ?? 'status-unpaid';
                                @endphp
                                <span class="status-badge {{ $paymentStatusClass }}">{{ $paymentStatus }}</span>
                            </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Payment Method:</span>
                        <span class="info-value">
                                {{ $order->payment_type == 0 ? 'Cash On Delivery' : 'Online Payment' }}
                            </span>
                    </div>
                </div>
            </div>

            <!-- Items Section -->
            <div class="section">
                <div class="section-title">Order Items</div>

                <table class="items-table">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th style="text-align: center;">Qty</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($order->orderDetails as $item)
                        <tr>
                            <td>
                                <span style="width: 120px; height: 120px; border-radius: 50%">
                                   <img src="{{ $item->product->image_thumbnail }}" alt="{{ $item->product->name }}" />
                                </span>
                                {{ $item->product->name }}</td>
                            <td style="text-align: center;">{{ $item->quantity }}</td>
                            <td class="text-right">৳{{ number_format($item->price, 2) }}</td>
                            <td class="text-right">
                                <strong>৳{{ number_format($item->price * $item->quantity, 2) }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: #999;">
                                No items to display
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Pricing Summary -->
                <div class="pricing-summary">
                    <div class="price-row">
                        <span>Subtotal:</span>
                        <span>৳{{ number_format($order->order_total, 2) }}</span>
                    </div>
                    <div class="price-row">
                        <span>Delivery Charge:</span>
                        <span>৳{{ number_format($order->delivery_charge, 2) }}</span>
                    </div>
                    <div class="price-row total">
                        <span>Total Amount:</span>
                        <span>৳{{ number_format($order->order_total + $order->delivery_charge, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Section -->
            <div class="section">
                <div class="section-title">Delivery Information</div>

                <div class="delivery-box">
                    <div class="delivery-info">
                        <div style="margin-bottom: 12px;">
                            <strong>📍 Delivery Address:</strong><br>
                            {{ $order->delivery_address }}
                        </div>
                        <div>
                            <strong>📞 Contact Number:</strong><br>
                            {{ $order->phone }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Info (if online payment) -->
            @if(isset($order->payment))
                <div class="section">
                    <div class="section-title">Payment Information</div>

                    <div class="info-box">
                        <div class="info-row">
                            <span class="info-label">Transaction ID:</span>
                            <span class="info-value">{{ $order->payment->transaction_id }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Payment Gateway:</span>
                            <span class="info-value">{{ $order->payment->bank_type }}</span>
                        </div>

                        @if(!empty($order->payment->sender_number))
                            <div class="info-row">
                                <span class="info-label">Sender Number:</span>
                                <span class="info-value">{{ $order->payment->sender_number }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="divider"></div>

            <!-- CTA -->
            <div class="cta-wrapper">
                <a href="{{ config('app.frontend_url') }}/dashboard" class="cta-button">
                    View Your Orders
                </a>
            </div>

            <p style="text-align: center; margin-top: 20px; font-size: 14px; color: #999;">
                You can track your order status anytime in your account dashboard.
            </p>
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
</div>
</body>
</html>
