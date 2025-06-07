# Message System Documentation

## Overview

The Message System handles customer inquiries through contact forms with comprehensive tracking, response management, and integration capabilities. It provides a structured approach to customer support with priority management, automated notifications, and detailed analytics.

## Architecture

### Database Structure

#### 1. Contact Messages Table (`contact_messages`)
**Main message storage table**

**Fields:**
- `id` - Primary key
- `customer_id` - Foreign key to customers table (nullable for anonymous)
- `name` - Sender's name
- `email` - Sender's email address
- `phone` - Contact phone number (optional)
- `subject` - Message subject line
- `content` - Full message content
- `category` - Message category (sales, support, complaint, etc.)
- `priority` - Message priority (low, normal, high, urgent)
- `status` - Current status (new, read, in_progress, resolved, closed)
- `assigned_admin_id` - Admin assigned to handle message
- `source` - Source of message (website, email, mobile_app)
- `is_read` - Read status flag
- `read_at` - Timestamp when first read
- `responded_at` - Timestamp of first response
- `resolved_at` - Timestamp when resolved
- `customer_ip` - IP address of sender (for tracking)
- `user_agent` - Browser/device information
- `attachments` - JSON array of file attachments
- `tags` - JSON array for categorization tags
- `metadata` - JSON field for additional data
- `created_at`, `updated_at` - Timestamp fields

#### 2. Message Responses Table (`message_responses`)
**Admin responses to customer messages**

**Fields:**
- `id` - Primary key
- `contact_message_id` - Foreign key to contact_messages table
- `admin_id` - Foreign key to admins table
- `response_content` - Response text content
- `response_type` - Type (reply, internal_note, auto_response)
- `is_internal` - Whether response is internal note only
- `attachments` - JSON array of file attachments
- `cc_emails` - JSON array of additional recipients
- `scheduled_at` - For scheduled responses (nullable)
- `template_used` - Template ID if using template
- `delivery_status` - Email delivery status
- `read_receipt` - Customer read confirmation
- `created_at`, `updated_at` - Timestamp fields

#### 3. Message Categories Table (`message_categories`)
**Category management for organization**

**Fields:**
- `id` - Primary key
- `name` - Category name
- `description` - Category description
- `color_code` - Color for visual identification
- `auto_assign_admin_id` - Default admin for category
- `response_template_id` - Default response template
- `priority_level` - Default priority for category
- `is_active` - Active status
- `sort_order` - Display order
- `created_at`, `updated_at` - Timestamp fields

### Model Relationships

```php
// ContactMessage Model
class ContactMessage extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    
    public function assignedAdmin()
    {
        return $this->belongsTo(Admin::class, 'assigned_admin_id');
    }
    
    public function responses()
    {
        return $this->hasMany(MessageResponse::class);
    }
    
    public function category()
    {
        return $this->belongsTo(MessageCategory::class, 'category');
    }
    
    public function latestResponse()
    {
        return $this->hasOne(MessageResponse::class)->latest();
    }
}

// MessageResponse Model
class MessageResponse extends Model
{
    public function message()
    {
        return $this->belongsTo(ContactMessage::class, 'contact_message_id');
    }
    
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
```

## Message Management Interface

### Admin Dashboard (`/admin/messages`)

**Features:**
- **Unified Inbox**: All messages in one location
- **Filtering & Search**: Advanced filtering options
- **Priority Management**: Visual priority indicators
- **Bulk Operations**: Mass actions for efficiency
- **Assignment System**: Delegate messages to team members
- **Response Templates**: Quick response options
- **Attachment Handling**: File upload and download
- **Status Tracking**: Comprehensive status management

### Quick Response System

**Template Management:**
```php
class ResponseTemplateService
{
    public function getTemplatesForCategory($category)
    {
        return ResponseTemplate::where('category', $category)
            ->where('is_active', true)
            ->orderBy('usage_count', 'desc')
            ->get();
    }
    
    public function personalizeTemplate($template, $customerData)
    {
        $content = $template->content;
        
        // Replace placeholders
        $content = str_replace('{{customer_name}}', $customerData['name'], $content);
        $content = str_replace('{{inquiry_subject}}', $customerData['subject'], $content);
        $content = str_replace('{{current_date}}', now()->format('F j, Y'), $content);
        
        return $content;
    }
}
```

## Email Integration

### Automatic Notifications

**Customer Notifications:**
- **Receipt Confirmation**: Immediate acknowledgment
- **Status Updates**: Progress notifications
- **Response Alerts**: New admin responses
- **Resolution Notice**: Issue closure confirmation

**Admin Notifications:**
- **New Message Alerts**: Instant notifications
- **Assignment Notifications**: Task delegation alerts
- **Escalation Warnings**: Priority/time-based alerts
- **Summary Reports**: Daily/weekly digests

### Email Templates

**Template Structure:**
```php
class EmailTemplateService
{
    public function sendReceiptConfirmation($message)
    {
        $template = EmailTemplate::where('type', 'message_receipt')->first();
        
        $variables = [
            'customer_name' => $message->name,
            'ticket_id' => $message->id,
            'subject' => $message->subject,
            'category' => $message->category,
            'expected_response_time' => $this->calculateResponseTime($message)
        ];
        
        return Mail::to($message->email)->send(
            new MessageReceiptEmail($template, $variables)
        );
    }
}
```

### SMTP Configuration

**Multiple Provider Support:**
```php
// config/mail.php configurations
'mailers' => [
    'smtp' => [
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.gmail.com'),
        'port' => env('MAIL_PORT', 587),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    ],
    'ses' => [
        'transport' => 'ses',
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'sendgrid' => [
        'transport' => 'sendgrid',
        'api_key' => env('SENDGRID_API_KEY'),
    ]
]
```

## Advanced Features

### Priority System

**Auto-Priority Assignment:**
```php
class MessagePriorityService
{
    public function calculatePriority($message)
    {
        $priority = 'normal';
        
        // Check for urgent keywords
        $urgentKeywords = ['urgent', 'emergency', 'asap', 'immediately'];
        if ($this->containsKeywords($message->content, $urgentKeywords)) {
            $priority = 'urgent';
        }
        
        // Check customer tier
        if ($message->customer && $message->customer->tier === 'premium') {
            $priority = $this->increasePriority($priority);
        }
        
        // Check message complexity
        if (str_word_count($message->content) > 500) {
            $priority = $this->increasePriority($priority);
        }
        
        return $priority;
    }
}
```

### Automated Responses

**Rule-based Auto-Response:**
```php
class AutoResponseEngine
{
    public function processNewMessage($message)
    {
        $rules = AutoResponseRule::where('is_active', true)
            ->orderBy('priority', 'desc')
            ->get();
        
        foreach ($rules as $rule) {
            if ($this->messageMatchesRule($message, $rule)) {
                $this->sendAutoResponse($message, $rule);
                break;
            }
        }
    }
    
    private function messageMatchesRule($message, $rule)
    {
        $conditions = json_decode($rule->conditions, true);
        
        foreach ($conditions as $condition) {
            if (!$this->evaluateCondition($message, $condition)) {
                return false;
            }
        }
        
        return true;
    }
}
```

### Analytics & Reporting

**Performance Metrics:**
```php
class MessageAnalyticsService
{
    public function getResponseTimeMetrics($period = '30 days')
    {
        return [
            'average_response_time' => ContactMessage::where('created_at', '>=', now()->subDays(30))
                ->whereNotNull('responded_at')
                ->avg(DB::raw('TIMESTAMPDIFF(MINUTE, created_at, responded_at)')),
            'first_response_rate' => $this->calculateFirstResponseRate($period),
            'resolution_rate' => $this->calculateResolutionRate($period),
            'customer_satisfaction' => $this->getAverageSatisfactionScore($period)
        ];
    }
    
    public function getCategoryDistribution()
    {
        return ContactMessage::select('category', DB::raw('count(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
    }
}
```

## Mobile API Integration

### RESTful Endpoints

**Message API:**
```php
// routes/api.php
Route::prefix('messages')->group(function () {
    Route::post('/', [MessageController::class, 'store']);
    Route::get('/categories', [MessageController::class, 'getCategories']);
    Route::post('/{id}/attachments', [MessageController::class, 'uploadAttachment']);
    Route::get('/{id}/status', [MessageController::class, 'getStatus']);
});
```

**API Response Format:**
```php
public function store(Request $request)
{
    $message = ContactMessage::create($request->validated());
    
    // Send confirmation email
    $this->emailService->sendReceiptConfirmation($message);
    
    return response()->json([
        'success' => true,
        'message' => 'Message received successfully',
        'data' => [
            'ticket_id' => $message->id,
            'status' => $message->status,
            'expected_response_time' => $this->calculateResponseTime($message)
        ]
    ], 201);
}
```

## Integration Capabilities

### CRM Integration

**Customer Data Sync:**
```php
class CRMIntegrationService
{
    public function syncCustomerData($message)
    {
        $customer = $this->findOrCreateCustomer($message);
        
        // Update customer interaction history
        $customer->interactions()->create([
            'type' => 'message',
            'reference_id' => $message->id,
            'summary' => $message->subject,
            'date' => $message->created_at
        ]);
        
        // Update customer preferences
        $this->updateCustomerPreferences($customer, $message);
        
        return $customer;
    }
}
```

### Helpdesk Integration

**Ticket System Bridge:**
```php
public function convertToTicket($messageId)
{
    $message = ContactMessage::find($messageId);
    
    // Create helpdesk ticket
    $ticket = HelpdeskTicket::create([
        'title' => $message->subject,
        'description' => $message->content,
        'customer_email' => $message->email,
        'priority' => $message->priority,
        'category' => $message->category,
        'source' => 'contact_message',
        'reference_id' => $message->id
    ]);
    
    // Update message status
    $message->update(['status' => 'converted_to_ticket']);
    
    return $ticket;
}
```

## Security Features

### Spam Protection

**Multi-layer Filtering:**
```php
class SpamDetectionService
{
    public function analyzeMessage($message)
    {
        $score = 0;
        
        // Check sender reputation
        $score += $this->checkSenderReputation($message->email);
        
        // Content analysis
        $score += $this->analyzeContent($message->content);
        
        // Rate limiting
        $score += $this->checkSubmissionRate($message->customer_ip);
        
        // Keyword filtering
        $score += $this->checkSpamKeywords($message->content);
        
        return $score;
    }
    
    public function isSpam($score)
    {
        return $score >= config('message.spam_threshold', 50);
    }
}
```

### Data Protection

**GDPR Compliance:**
```php
class DataProtectionService
{
    public function anonymizeMessage($messageId)
    {
        $message = ContactMessage::find($messageId);
        
        $message->update([
            'name' => 'Anonymous User',
            'email' => 'redacted@privacy.com',
            'phone' => null,
            'customer_ip' => null,
            'user_agent' => null,
            'content' => 'Content removed for privacy protection'
        ]);
        
        // Log anonymization
        ActivityLog::create([
            'action' => 'data_anonymized',
            'model_type' => ContactMessage::class,
            'model_id' => $messageId,
            'admin_id' => auth()->id()
        ]);
    }
}
```

## Best Practices

### Response Guidelines
1. **Timely Responses**: Acknowledge within 1 hour, respond within 24 hours
2. **Professional Tone**: Maintain consistent, helpful communication style
3. **Complete Information**: Address all points in customer inquiry
4. **Follow-up Protocol**: Ensure customer satisfaction before closing

### Performance Optimization
1. **Database Indexing**: Optimize queries for large message volumes
2. **Email Queue**: Use queue system for bulk email processing
3. **File Storage**: Efficient attachment handling and storage
4. **Caching Strategy**: Cache frequently accessed data

### Monitoring & Alerts
1. **Response Time Monitoring**: Track and alert on delayed responses
2. **Volume Alerts**: Monitor for unusual message spikes
3. **Error Tracking**: Log and alert on system errors
4. **Performance Metrics**: Regular analysis of key indicators

## Troubleshooting

### Common Issues

#### Email Delivery Problems
- Verify SMTP configuration
- Check sender reputation
- Review spam folder placement
- Monitor bounce rates

#### Attachment Upload Failures
- Check file size limits
- Verify file type restrictions
- Review storage permissions
- Monitor disk space usage

#### Performance Degradation
- Analyze database query performance
- Review message processing queue
- Check server resource usage
- Optimize email sending rates

### Debug Tools
- Email delivery tracking
- Message processing logs
- Performance monitoring dashboard
- Error reporting system 