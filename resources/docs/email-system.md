# Email System Documentation

## Overview

The Email System provides comprehensive email functionality for admin notifications, customer communications, and automated messaging. It features professional email templates, secure token authentication, and advanced delivery tracking capabilities.

## Architecture

### Email Types

The system supports multiple email types for different purposes:

#### 1. Admin Reactivation Notification
- **Purpose**: Notifies admins about account deactivation
- **Template**: `reactivate.blade.php`
- **Features**: 
  - WhatsApp integration for quick reactivation
  - Professional email design
  - Dynamic admin information

#### 2. Security Code Email
- **Purpose**: Password reset functionality
- **Template**: `security_code.blade.php`
- **Features**:
  - Time-limited security codes
  - Secure token generation
  - Expiration tracking

#### 3. Email Verification
- **Purpose**: Admin account verification
- **Template**: `verification.blade.php`
- **Features**:
  - Secure verification links
  - Token-based authentication
  - Automatic account activation

#### 4. Welcome Email
- **Purpose**: New admin onboarding
- **Template**: `welcome_admin.blade.php`
- **Features**:
  - Login credentials delivery
  - Getting started information
  - Professional branding

## Email Templates

### Template Structure

All email templates are located in `resources/views/admin/email/` and follow a consistent structure with:

- Responsive HTML layout
- Email-safe CSS styling
- Dynamic subject lines
- Professional branding elements
- Cross-client compatibility

### Template Features

#### Responsive Design
- Mobile-friendly layouts
- Email client compatibility
- Consistent rendering across platforms

#### Professional Branding
- Company logo integration
- Consistent color scheme
- Professional typography

#### Dynamic Content
- Personalized messaging
- Variable data insertion
- Conditional content display

## Mailable Classes

### AdminReactivationNotification

```php
class AdminReactivationNotification extends Mailable
{
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('Account Deactivation Notification')
                    ->view('admin.email.reactivate');
    }
}
```

### AdminSecurityCode

```php
class AdminSecurityCode extends Mailable
{
    public function __construct($admin, $securityCode)
    {
        $this->admin = $admin;
        $this->securityCode = $securityCode;
    }

    public function build()
    {
        return $this->subject('Security Code for Password Reset')
                    ->view('admin.email.security_code');
    }
}
```

### AdminVerification

```php
class AdminVerification extends Mailable
{
    public function __construct($admin)
    {
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('Verify Your Admin Account')
                    ->view('admin.email.verification');
    }
}
```

## Email Sending Methods

### Individual Email Sending

#### From Admin Management Interface
```javascript
// Send security code
function sendSecurityCode(adminId) {
    if (confirm('Send security code for password reset to this admin?')) {
        $.ajax({
            url: '/admin/emails/security-code',
            method: 'POST',
            data: { admin_id: adminId },
            success: function(response) {
                alert('Security code sent successfully!');
            }
        });
    }
}
```

#### Programmatic Sending
```php
use App\Mail\AdminSecurityCode;
use Illuminate\Support\Facades\Mail;

$admin = Admin::find(1);
$securityCode = $admin->generateSecurityCode();
Mail::to($admin->email)->send(new AdminSecurityCode($admin, $securityCode));
```

### Bulk Email Operations

#### Bulk Email Interface
```javascript
function sendBulkEmails() {
    const selectedAdmins = getSelectedAdminIds();
    const emailType = prompt('Enter email type (reactivation, security_code, verification):');
    
    $.ajax({
        url: '/admin/emails/bulk',
        method: 'POST',
        data: {
            email_type: emailType,
            admin_ids: selectedAdmins
        },
        success: function(response) {
            alert(response.message);
        }
    });
}
```

## API Endpoints

### Individual Email Endpoints

#### POST `/admin/emails/reactivation`
**Send reactivation notification**

**Request Body:**
```json
{
    "admin_id": 1
}
```

**Response:**
```json
{
    "success": true,
    "message": "Reactivation email sent successfully",
    "email_sent": true
}
```

#### POST `/admin/emails/security-code`
**Send security code for password reset**

**Request Body:**
```json
{
    "admin_id": 1
}
```

**Response:**
```json
{
    "success": true,
    "message": "Security code sent successfully",
    "expires_at": "2024-01-15 15:30:00"
}
```

#### POST `/admin/emails/verification`
**Send verification email**

**Request Body:**
```json
{
    "admin_id": 1
}
```

**Response:**
```json
{
    "success": true,
    "message": "Verification email sent successfully",
    "verification_url": "https://example.com/admin/verify/1/token"
}
```

### Bulk Email Endpoint

#### POST `/admin/emails/bulk`
**Send bulk emails to multiple admins**

**Request Body:**
```json
{
    "email_type": "security_code",
    "admin_ids": [1, 2, 3, 4]
}
```

**Response:**
```json
{
    "success": true,
    "message": "Bulk emails sent: 4 successful, 0 failed",
    "successful": 4,
    "failed": 0,
    "errors": []
}
```

## Email Verification Process

### Verification Flow

1. **Email Generation**: System generates secure verification token
2. **Email Sending**: Verification email sent to admin
3. **Link Clicking**: Admin clicks verification link
4. **Token Validation**: System validates token and timeframe
5. **Account Activation**: Admin account marked as verified

### Security Features

#### Token Generation
```php
public function generateVerificationToken()
{
    return hash('sha256', $this->id . $this->email . now()->timestamp . config('app.key'));
}
```

#### Token Validation
```php
public function verifyToken($token)
{
    $expectedToken = $this->generateVerificationToken();
    return hash_equals($expectedToken, $token);
}
```

## Configuration

### Email Configuration

#### SMTP Settings
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

#### Email Queue Configuration
```env
QUEUE_CONNECTION=database
MAIL_QUEUE_ENABLED=true
```

### Template Configuration

#### Logo Path
```php
// Email templates use this path for logo
$logoPath = public_path('admin/email/logo.png');
```

#### Color Scheme
```css
:root {
    --primary-color: #007bff;
    --secondary-color: #6c757d;
    --success-color: #28a745;
    --danger-color: #dc3545;
    --warning-color: #ffc107;
}
```

## Advanced Features

### Email Tracking

#### Delivery Tracking
```php
public function trackEmailDelivery($messageId, $status)
{
    EmailLog::create([
        'message_id' => $messageId,
        'status' => $status,
        'delivered_at' => now()
    ]);
}
```

#### Open Rate Tracking
Email open tracking is implemented using tracking pixels that are embedded in email templates. The tracking system records when emails are opened and provides analytics on engagement rates.

### Email Templates Management

#### Dynamic Template Loading
```php
public function getEmailTemplate($type)
{
    $templates = [
        'reactivation' => 'admin.email.reactivate',
        'security_code' => 'admin.email.security_code',
        'verification' => 'admin.email.verification',
        'welcome' => 'admin.email.welcome_admin'
    ];
    
    return $templates[$type] ?? 'admin.email.default';
}
```

### Anti-Spam Measures

#### Rate Limiting
```php
// Limit emails per admin per hour
public function canSendEmail($adminId)
{
    $recentEmails = EmailLog::where('admin_id', $adminId)
        ->where('created_at', '>=', now()->subHour())
        ->count();
        
    return $recentEmails < 5; // Max 5 emails per hour
}
```

#### Content Filtering
```php
public function validateEmailContent($content)
{
    $spamKeywords = ['free', 'urgent', 'limited time'];
    
    foreach ($spamKeywords as $keyword) {
        if (stripos($content, $keyword) !== false) {
            return false;
        }
    }
    
    return true;
}
```

## Testing

### Email Testing in Development

#### Mail Testing with Mailtrap
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_ENCRYPTION=tls
```

#### Log Driver for Testing
```env
MAIL_MAILER=log
```

### Unit Testing

#### Email Sending Tests
```php
public function test_security_code_email_can_be_sent()
{
    Mail::fake();
    
    $admin = Admin::factory()->create();
    $securityCode = $admin->generateSecurityCode();
    
    Mail::to($admin->email)->send(new AdminSecurityCode($admin, $securityCode));
    
    Mail::assertSent(AdminSecurityCode::class);
}
```

## Performance Optimization

### Email Queuing

#### Queue Configuration
```php
// In AppServiceProvider
public function boot()
{
    Mail::queue(function($message) {
        $message->onQueue('emails');
    });
}
```

#### Background Processing
```bash
php artisan queue:work --queue=emails
```

### Template Optimization

#### Caching Compiled Templates
```php
public function getCachedTemplate($template, $data)
{
    $cacheKey = "email_template_{$template}_" . md5(serialize($data));
    
    return Cache::remember($cacheKey, 3600, function() use ($template, $data) {
        return view($template, $data)->render();
    });
}
```

## Security Best Practices

### Token Security
- Use cryptographically secure random tokens
- Implement token expiration
- Hash sensitive data
- Validate all inputs

### Email Security
- Use SPF, DKIM, and DMARC records
- Implement rate limiting
- Validate email addresses
- Use secure SMTP connections

### Data Protection
- Encrypt sensitive email content
- Log email activities
- Implement access controls
- Regular security audits

## Troubleshooting

### Common Issues

#### Email Not Sending
1. Check SMTP configuration
2. Verify email credentials
3. Check firewall settings
4. Review email logs

#### Template Rendering Issues
1. Check template syntax
2. Verify data variables
3. Test with simple content
4. Review error logs

#### Token Validation Failures
1. Check token generation logic
2. Verify token expiration
3. Test token comparison
4. Review security headers

### Debug Tools

#### Email Testing Commands
```bash
# Test email configuration
php artisan mail:test

# Clear email cache
php artisan cache:clear

# View email logs
php artisan log:show
```

## Best Practices

### Email Design
1. **Mobile First**: Design for mobile devices
2. **Simple Layout**: Keep designs clean and simple
3. **Clear CTAs**: Use prominent call-to-action buttons
4. **Consistent Branding**: Maintain brand consistency

### Content Strategy
1. **Personalization**: Use recipient names and relevant data
2. **Clear Subject Lines**: Write descriptive subject lines
3. **Concise Content**: Keep messages brief and focused
4. **Professional Tone**: Maintain professional communication

### Technical Implementation
1. **Error Handling**: Implement comprehensive error handling
2. **Logging**: Log all email activities
3. **Testing**: Thoroughly test all email functionality
4. **Monitoring**: Monitor email delivery rates and performance 