BOY PROJECTS - ADMIN PANEL
==============================

Hello {{ $admin->name }},

Welcome to the Admin Panel! Your administrator account has been successfully created.

LOGIN CREDENTIALS:
------------------
Email: {{ $admin->email }}
Password: {{ $password }}
Status: {{ $admin->is_active ? 'Active' : 'Inactive' }} | {{ $admin->verified ? 'Verified' : 'Pending Verification' }}

LOGIN URL: {{ $loginUrl }}

IMPORTANT SECURITY NOTICE:
--------------------------
For your security, we strongly recommend that you change your password immediately after your first login. You can do this from the admin panel settings.

AS AN ADMINISTRATOR, YOU HAVE ACCESS TO:
----------------------------------------
• Dashboard and Analytics
• User Management  
• Content Management
• Message and Communication Tools
• System Configuration

If you have any questions or need assistance, please don't hesitate to contact the system administrator.

Best regards,
The Boy Projects Team

---
This is an automated message. Please do not reply to this email.
© {{ date('Y') }} Boy Projects. All rights reserved. 