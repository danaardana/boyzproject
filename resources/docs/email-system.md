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

#### 5. Contact Message Reply System (NEW)
- **Purpose**: Admin responses to customer contact messages
- **Template**: `reply.blade.php`
- **Features**:
  - Professional Indonesian language formatting
  - Boy Projects branding
  - Original message context
  - Response tracking
  - Custom subject formatting

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

### MessageReplyMail (NEW)

```php
class MessageReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $adminResponse;
    public $originalMessage;
    public $messageStatus;
    public $adminName;

    public function __construct(
        Customer $customer,
        string $adminResponse,
        ContactMessage $originalMessage,
        string $messageStatus,
        string $adminName
    ) {
        $this->customer = $customer;
        $this->adminResponse = $adminResponse;
        $this->originalMessage = $originalMessage;
        $this->messageStatus = $messageStatus;
        $this->adminName = $adminName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Balasan Pesan: ' . ($this->originalMessage->content_key ?? 'Pesan Anda') . ' - ' . config('app.name', 'Boy Projects'),
            from: new Address(
                config('mail.from.address', 'support@boyprojects.com'),
                config('mail.from.name', 'Boy Projects')
            ),
            replyTo: [
                new Address(
                    config('mail.from.address', 'support@boyprojects.com'),
                    config('mail.from.name', 'Boy Projects')
                )
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.email.reply',
            with: [
                'customer' => $this->customer,
                'adminResponse' => $this->adminResponse,
                'originalMessage' => $this->originalMessage,
                'messageStatus' => $this->messageStatus,
                'adminName' => $this->adminName,
            ]
        );
    }
}
```

### AdminMessageMail (NEW)

```php
class AdminMessageMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $customer;
    public $subject;
    public $messageBody;
    public $adminName;

    public function __construct(Customer $customer, string $subject, string $messageBody, string $adminName)
    {
        $this->customer = $customer;
        $this->subject = $subject;
        $this->messageBody = $messageBody;
        $this->adminName = $adminName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
            from: new Address(
                config('mail.from.address', 'support@boyprojects.com'),
                config('mail.from.name', 'Boy Projects')
            ),
            replyTo: [
                new Address(
                    config('mail.from.address', 'support@boyprojects.com'),
                    config('mail.from.name', 'Boy Projects')
                )
            ]
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'admin.email.admin_message',
            with: [
                'customer' => $this->customer,
                'subject' => $this->subject,
                'messageBody' => $this->messageBody,
                'adminName' => $this->adminName,
            ]
        );
    }
}
```

## Contact Message Reply System (NEW)

### Features Overview

The Contact Message Reply System allows administrators to professionally respond to customer inquiries submitted through the landing page contact form. All email replies are formatted with proper Indonesian localization and Boy Projects branding.

### Key Features

#### Professional Email Formatting
- **Subject Format**: `Balasan Pesan: [Original Subject] - Boy Projects`
- **Sender Name**: `Boy Projects` (not individual admin names)
- **From Address**: `support@boyprojects.com` (configurable)
- **Reply-To**: Same as from address for consistency

#### Indonesian Localization
- All email content in professional Indonesian language
- Localized date formatting (d M Y H:i)
- Indonesian button text: "Hubungi Kami Lagi"
- Indonesian field labels: "Pesan Asli", "Dibalas oleh", "Tanggal"

#### Email Template Features
- Responsive HTML design
- Mobile-friendly layout
- Professional Boy Projects branding
- Original message context display
- Admin response highlighting
- Clear call-to-action button

### Implementation Details

#### Email Subject Format
```php
// Old format (FIXED)
'subject' => 'Re: installation - Response from Laravel'

// New format (CURRENT)
'subject' => 'Balasan Pesan: installation - Boy Projects'
```

#### Sender Configuration
```php
// Using Address class for proper envelope formatting
from: new Address(
    config('mail.from.address', 'support@boyprojects.com'),
    config('mail.from.name', 'Boy Projects')
)
```

#### Template Variables
```php
// Available in reply.blade.php template
$customer           // Customer object with encrypted data
$adminResponse      // Admin's response message
$originalMessage    // Original contact message
$messageStatus      // Message status (resolved, in_progress, etc.)
$adminName          // Name of responding admin
```

### Email Content Structure

#### Header Section
- Boy Projects logo
- Professional greeting in Indonesian
- Customer name personalization

#### Main Content
- Clear title: "Balasan Pesan dari Boy Projects"
- Admin response in highlighted box
- Original message context
- Response metadata (status, admin, date)

#### Footer Section
- Contact button linking to landing page
- Boy Projects branding
- Indonesian copyright notice

### Integration Points

#### From Admin Panel
```javascript
// Modal form for replying to messages
$('#replyForm').on('submit', function(e) {
    e.preventDefault();
    // AJAX submission with proper error handling
    // Automatic email sending after successful response
});
```

#### From ContactController
```php
public function respond(Request $request, ContactMessage $message)
{
    // Validate response
    // Update message status
    // Send email to customer
    \Mail::to($message->customer->email)->send(
        new MessageReplyMail(
            $message->customer,
            $request->response,
            $message,
            $newStatus,
            $admin->name
        )
    );
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

#### POST `/admin/messages/{message}/respond` (NEW)
**Send reply email to customer**

**Request Body:**
```json
{
    "response": "Thank you for your inquiry. We will process your request within 24 hours."
}
```

**Response:**
```json
{
    "status": "success",
    "message": "Response sent successfully and email notification sent to customer"
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

### Email Configuration (UPDATED)

#### SMTP Settings
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=support@boyprojects.com
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
        'welcome' => 'admin.email.welcome_admin',
        'reply' => 'admin.email.reply',                    // NEW
        'admin_message' => 'admin.email.admin_message'     // NEW
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

// NEW: Test for message reply emails
public function test_message_reply_email_can_be_sent()
{
    Mail::fake();
    
    $customer = Customer::factory()->create();
    $message = ContactMessage::factory()->create(['customer_id' => $customer->id]);
    $admin = Admin::factory()->create();
    
    Mail::to($customer->email)->send(
        new MessageReplyMail(
            $customer,
            'Thank you for your inquiry',
            $message,
            'resolved',
            $admin->name
        )
    );
    
    Mail::assertSent(MessageReplyMail::class);
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

## Recent Updates (January 2024)

### Contact Message Reply System Enhancement
- **Subject Format**: Changed from "Re: [subject] - Response from Laravel" to "Balasan Pesan: [subject] - Boy Projects"
- **Sender Name**: Fixed from "vixen19.fox" to "Boy Projects"
- **Indonesian Localization**: Complete translation of email templates
- **Address Class**: Proper implementation of Laravel's Address class for envelope formatting
- **Template Improvements**: Enhanced mobile responsiveness and professional styling

### Configuration Updates
- Updated default mail configuration to use Boy Projects branding
- Added proper Address class imports for Mailable classes
- Enhanced error handling for email sending operations

### Bug Fixes
- Fixed Envelope constructor parameter format issue
- Corrected array-to-Address class conversion
- Improved email template rendering consistency

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

#### Envelope Constructor Errors (NEW)
1. Ensure proper Address class usage
2. Check parameter format in envelope() method
3. Verify import statements for Mailables classes
4. Test with simple string addresses first

### Debug Tools

#### Email Testing Commands
```bash
# Test email configuration
php artisan mail:test

# Clear email cache
php artisan cache:clear

# View email logs
php artisan log:show

# Test specific mailable
php artisan tinker
Mail::to('test@example.com')->send(new App\Mail\MessageReplyMail(...));
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
5. **Address Classes**: Always use proper Address class for envelope formatting
6. **Localization**: Use appropriate language for target audience 