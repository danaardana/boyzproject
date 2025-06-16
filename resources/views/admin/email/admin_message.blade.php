<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from Boy Projects</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }
        .header p {
            margin: 5px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #495057;
            margin-bottom: 20px;
        }
        .message-content {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .message-content p {
            margin: 0;
            line-height: 1.7;
        }
        .admin-signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-style: italic;
        }
        .footer {
            background-color: #495057;
            color: white;
            padding: 25px 30px;
            text-align: center;
            font-size: 14px;
        }
        .footer p {
            margin: 5px 0;
        }
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #6c757d;
            opacity: 0.8;
        }
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: 500;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            color: white;
            text-decoration: none;
        }
        .important-note {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .logo {
            width: 60px;
            height: 60px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            margin: 0 auto 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 5px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                📧
            </div>
            <h1>Boy Projects</h1>
            <p>Professional Customer Support</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Hello <strong>{{ $customer->name }}</strong>,
            </div>

            <p>We hope this email finds you well. Our team has sent you the following message:</p>

            <div class="message-content">
                {!! nl2br(e($messageBody)) !!}
            </div>

            <div class="important-note">
                <strong>📋 Note:</strong> This message was sent directly from our customer support team. 
                If you have any questions or need further assistance, please don't hesitate to contact us.
            </div>

            <div style="text-align: center; margin: 30px 0;">
                <a href="mailto:{{ config('mail.from.address') }}" class="btn">
                    Reply to this Message
                </a>
            </div>

            <div class="admin-signature">
                <p><strong>Best regards,</strong></p>
                <p>{{ $adminName }}</p>
                <p>Customer Support Team</p>
                <p>Boy Projects</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Boy Projects</strong></p>
            <p>Partner terpercaya untuk suku cadang dan aksesoris motor Anda</p>
            
            <div class="contact-info">
                <p>📧 Email: {{ config('mail.from.address') }}</p>
                <p>🌐 Website: {{ config('app.url') }}</p>
                <p>📞 Support: Available 24/7</p>
            </div>
            
            <p style="margin-top: 20px; font-size: 12px; opacity: 0.7;">
                Email ini dikirim ke {{ $customer->email }} karena Anda adalah pelanggan berharga Boy Projects.
                <br>Customer ID: #{{ $customer->id }}
            </p>
        </div>
    </div>
</body>
</html> 