# Admin Email System Documentation

This documentation explains how to use the Laravel email system for sending admin notifications.

## Overview

The email system includes three types of emails:
1. **Reactivation Notification** - Notifies admins about account deactivation and provides WhatsApp link for reactivation
2. **Security Code** - Sends security codes for password reset
3. **Verification Email** - Sends email verification links for admin accounts

## Email Templates

All email templates are located in `resources/views/admin/email/`:
- `reactivate.blade.php` - Account deactivation notification
- `security_code.blade.php` - Password reset security code
- `verification.blade.php` - Email verification

## Mailable Classes

Located in `app/Mail/`:
- `AdminReactivationNotification.php`
- `AdminSecurityCode.php`
- `AdminVerification.php`

## Usage

### 1. Individual Email Sending

From the admin management page (`/admin/admin`), you can send emails to individual admins:

1. Click the dropdown menu (three dots) next to any admin
2. Select the desired email type:
   - **Reset Password** - Sends security code email
   - **Send Verification** - Sends verification email
   - **Send Reactivation** - Sends reactivation notification

### 2. Bulk Email Sending

1. Select multiple admins using checkboxes
2. Click "Send Bulk Emails" button
3. Enter email type when prompted:
   - `reactivation`
   - `security_code`
   - `verification`

### 3. Programmatic Usage

You can also send emails programmatically:

```php
use App\Models\Admin;
use App\Mail\AdminSecurityCode;
use Illuminate\Support\Facades\Mail;

// Send security code
$admin = Admin::find(1);
$securityCode = $admin->generateSecurityCode();
Mail::to($admin->email)->send(new AdminSecurityCode($admin, $securityCode));

// Send reactivation notification
Mail::to($admin->email)->send(new AdminReactivationNotification($admin));

// Send verification email
Mail::to($admin->email)->send(new AdminVerification($admin));
```

## API Endpoints

### POST `/admin/emails/reactivation`
Sends reactivation notification to an admin.

**Parameters:**
- `admin_id` (required) - ID of the admin

### POST `/admin/emails/security-code`
Sends security code for password reset.

**Parameters:**
- `admin_id` (required) - ID of the admin

### POST `/admin/emails/verification`
Sends verification email to an admin.

**Parameters:**
- `admin_id` (required) - ID of the admin

### POST `/admin/emails/bulk`
Sends bulk emails to multiple admins.

**Parameters:**
- `email_type` (required) - Type of email: `reactivation`, `security_code`, or `verification`
- `admin_ids` (required) - Array of admin IDs

## Email Features

### Reactivation Email
- Displays admin name dynamically
- Includes WhatsApp link with pre-filled message: "reactivate account [admin_name]"
- WhatsApp number: 082216649329

### Security Code Email
- Displays admin name and security code
- Shows expiration time
- Includes "Reset Password" button linking to password reset form

### Verification Email
- Displays admin name
- Includes verification button with secure token
- Automatically verifies admin account when clicked

## Email Verification Process

1. When verification email is sent, a secure token is generated
2. Admin clicks verification link: `/admin/verify/{id}/{token}`
3. System validates token and marks admin as verified
4. Admin is redirected to login page with success message

## Configuration

Ensure your `.env` file has proper email configuration:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Boy Projects"
```

## Assets

The email logo is located at `public/admin/email/logo.png` and is automatically included in all email templates.

## Error Handling

All email operations include proper error handling:
- Success/failure notifications
- Detailed error messages
- Bulk operation statistics

## Security

- Email verification uses secure SHA-256 tokens
- Security codes expire after 1 hour
- All routes are protected with CSRF tokens
- Admin verification route is public but requires valid token 