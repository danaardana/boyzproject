<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Admin Panel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #5156be;
            margin-bottom: 10px;
        }
        .welcome-text {
            font-size: 18px;
            color: #6c757d;
        }
        .credentials-box {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .credential-item {
            margin: 10px 0;
            padding: 8px 0;
        }
        .credential-label {
            font-weight: bold;
            color: #495057;
            display: inline-block;
            width: 80px;
        }
        .credential-value {
            color: #212529;
            background-color: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: monospace;
        }
        .login-button {
            display: inline-block;
            background-color: #5156be;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }
        .login-button:hover {
            background-color: #4145a7;
        }
        .security-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        .security-notice h4 {
            color: #856404;
            margin: 0 0 10px 0;
        }
        .security-notice p {
            color: #856404;
            margin: 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            margin-top: 30px;
            border-top: 1px solid #e9ecef;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="logo">Boy Projects</div>
            <div class="welcome-text">Welcome to the Admin Panel</div>
        </div>

        <h2>Hello {{ $admin->name }},</h2>
        
        <p>Welcome to the Admin Panel! Your administrator account has been successfully created. You now have access to manage the system with the following credentials:</p>

        <div class="credentials-box">
            <h3 style="margin-top: 0; color: #495057;">Your Login Credentials</h3>
            
            <div class="credential-item">
                <span class="credential-label">Email:</span>
                <span class="credential-value">{{ $admin->email }}</span>
            </div>
            
            <div class="credential-item">
                <span class="credential-label">Password:</span>
                <span class="credential-value">{{ $password }}</span>
            </div>
            
            <div class="credential-item">
                <span class="credential-label">Status:</span>
                <span class="credential-value">
                    {{ $admin->is_active ? 'Active' : 'Inactive' }} | 
                    {{ $admin->verified ? 'Verified' : 'Pending Verification' }}
                </span>
            </div>
        </div>

        <div style="text-align: center;">
            <a href="{{ $loginUrl }}" class="login-button">Login to Admin Panel</a>
        </div>

        <div class="security-notice">
            <h4>🔒 Important Security Information</h4>
            <p>For your security, we strongly recommend that you change your password immediately after your first login. You can do this from the admin panel settings.</p>
        </div>

        <p>As an administrator, you will have access to:</p>
        <ul>
            <li>Dashboard and Analytics</li>
            <li>User Management</li>
            <li>Content Management</li>
            <li>Message and Communication Tools</li>
            <li>System Configuration</li>
        </ul>

        <p>If you have any questions or need assistance, please don't hesitate to contact the system administrator.</p>

        <p>Best regards,<br>
        <strong>The Boy Projects Team</strong></p>

        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} Boy Projects. All rights reserved.</p>
        </div>
    </div>
</body>
</html> 