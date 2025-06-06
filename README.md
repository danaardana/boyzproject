# Boy Projects - E-Commerce Motorcycle Spare Parts Admin Dashboard

## **🏍️ Overview**
A comprehensive Laravel-based e-commerce admin dashboard specifically designed for motorcycle spare parts business with Shopee integration. Features a complete transformation from crypto trading to automotive parts management with advanced admin tools, real-time notifications, and customer engagement systems.

## **🎯 Core Business Features**
- **E-Commerce Motorcycle Parts Dashboard** – Complete sales analytics with Indonesian currency formatting
- **Multi-Platform Integration** – Shopee, Tokopedia platform support with filtering
- **Advanced Analytics** – Revenue tracking, top-selling categories, product performance
- **Customer Reviews System** – Star ratings and platform-specific feedback management
- **Enhanced Chat Interface** – Filter/sort functionality with 19 realistic conversations
- **Email Reply System** – Dynamic customer response with database integration
- **Professional Email System** – Anti-spam measures with automated admin workflows

---

## **📊 Dashboard Features**

### **🚀 E-Commerce Analytics**
- **Total Sales**: Rp 12.8M+ with trend indicators
- **Order Management**: 847+ orders with status tracking  
- **Product Performance**: 1,247+ products sold with category breakdown
- **Customer Satisfaction**: 4.8/5 average rating display
- **Revenue Charts**: Interactive donut charts with ApexCharts integration
- **Transaction Distribution**: Platform-wise sales breakdown with percentages

### **🏷️ Motorcycle Categories**
- **Mounting & Body Parts**: Brackets, fairings, body panels
- **Lighting Systems**: LED lights, indicators, headlamps  
- **Installation Services**: Professional installation and maintenance
- **Accessories**: Custom parts and performance upgrades

### **📈 Advanced Charts & Analytics**
- **Revenue by Platform**: Donut chart with Shopee/Tokopedia breakdown
- **Transaction Distribution**: Pie chart with percentage breakdowns
- **Responsive Design**: Mobile-optimized charts with proper aspect ratios
- **Indonesian Currency**: Proper Rupiah formatting throughout dashboard
- **Real-Time Updates**: Dynamic data updates without page refresh

---

## **🔐 Enhanced Authentication System**

### **👨‍💼 Admin Management**
- **Secure Login System**: Enhanced with remember me functionality (7-day sessions)
- **Real-Time Validation**: Live form validation with loading states
- **Account Verification**: Email-based verification with secure tokens
- **Password Management**: Secure reset with email verification codes
- **Session Management**: Extended sessions with localStorage email persistence
- **Admin Reactivation**: Automated reactivation system via email links

### **🛡️ Security Features**
- **Middleware Protection**: AdminVerificationMiddleware with proper resolution
- **Anti-Spam Email System**: Professional templates with proper headers
- **Remember Me Implementation**: Database token storage with 7-day expiration
- **Forced Logout Routes**: Edge case handling for authentication conflicts
- **Session Invalidation**: Proper cleanup on logout with cache clearing

---

## **📧 Professional Email System**

### **✉️ Admin Email Templates**
- **Welcome Emails**: Professional onboarding with secure verification links
- **Security Codes**: Time-limited codes for password resets (15-minute expiry)
- **Account Verification**: SHA256 token-based email verification
- **Reactivation Notifications**: Automated account reactivation with instant database updates
- **Anti-Spam Measures**: Proper email headers, HTML text logos, professional styling

### **🔧 Email Technical Features**
- **Laravel Mailables**: Modern mail system with Address objects and proper envelopes
- **SMTP Configuration**: Gmail integration with app passwords
- **Template Responsiveness**: Mobile-friendly email templates
- **Security Tokens**: Cryptographically secure verification tokens
- **Audit Logging**: Complete email activity tracking

---

## **💬 Smart Chat System**

### **🤖 Auto-Response Configuration**
Location: `public/landing/js/chat-bubble.js`

```javascript
autoResponses: {
    'hello': 'Hello! Welcome to Boys Project! How can I assist you today?',
    'hi': 'Hi there! Thanks for visiting Boys Project. What can I do for you?',
    'help': 'I\'m here to help! What do you need assistance with regarding our services?',
    'contact': 'You can reach us at info@boysproject.com or through our contact form.',
    'hours': 'We\'re available Monday-Friday 9AM-6PM.',
    'pricing': 'For detailed pricing information, please check our services page!',
    'services': 'We offer a wide range of digital services.',
    'thanks': 'You\'re very welcome! Is there anything else I can help you with?',
    'bye': 'Goodbye! Thank you for your interest in Boys Project!',
    'default': 'Thanks for your message: "{{message}}". Let me connect you with our team!'
}
```

### **💬 Chat Features**
- **Smart Keyword Detection**: Automatic response matching for common queries
- **Professional UI**: Modern chat bubble with gradient design
- **Quick Actions**: Pre-configured response buttons
- **Typing Indicators**: Visual feedback during bot responses
- **Mobile Responsive**: Optimized for all device sizes
- **Message History**: Conversation persistence and tracking

---

## **📨 Advanced Message Management System**

### **📥 Admin Message Center**
- **Inbox Management**: Complete message categorization system
- **Category Badges**: Color-coded labels (Warranty, Installation, Support, General)
- **Status Tracking**: New, In Progress, Resolved, Closed workflow
- **Assignment System**: Assign messages to specific admin members
- **Response Management**: Reply system with conversation threading
- **Bulk Operations**: Mark all as read, delete multiple messages

### **✉️ Email Reply System**
- **MessageReplyMail Class**: Laravel Mailable for automated email responses
- **Dynamic Blade Templates**: Customer-specific email content with variables
- **Database Integration**: Reply storage in message_responses table
- **Email Variables**: $customer, $adminResponse, $originalMessage, $messageStatus, $adminName
- **Error Handling**: Comprehensive logging and fallback mechanisms
- **Success Notifications**: Real-time feedback on email send status

### **💬 Enhanced Chat Interface**
- **Filter & Sort Controls**: Dropdown beside "Recent" with advanced options
- **Filter Options**: 
  - All Messages (shows complete conversation list)
  - Unread Only (displays unread conversations with indicators)
- **Sort Functions**:
  - Newest First (most recent activity at top)
  - Oldest First (chronological order from oldest)
- **Visual Enhancements**:
  - Larger chat previews with improved readability
  - Removed avatar images for cleaner interface
  - 19 realistic motorcycle parts conversations
  - Custom scrollbar styling with smooth scrolling
  - 350px sidebar width with proper viewport calculations

### **🔔 Real-Time Notifications**
- **Navbar Notifications**: Live message counts with dropdown preview
- **Pusher Integration**: WebSocket-based real-time updates
- **Unread Counters**: Dynamic badge updates without page refresh
- **Message Previews**: Quick message content preview in notifications

---

## **🚀 Installation & Setup**

### **Prerequisites**
- PHP 8.1+
- Composer 2.0+
- MySQL 8.0+
- Node.js 16+ & NPM
- Pusher account (for real-time features)

### **Quick Setup**

1. **Clone & Install**
   ```bash
   git clone <repository-url>
   cd boyzproject
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

4. **Email Configuration**
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

5. **Real-Time Features (Pusher)**
   ```env
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your_app_id
   PUSHER_APP_KEY=your_app_key
   PUSHER_APP_SECRET=your_app_secret
   PUSHER_APP_CLUSTER=ap1
   ```

6. **Compile & Run**
   ```bash
   npm run dev
   php artisan serve
   ```

---

## **🏗️ Project Structure**

### **Key Files & Directories**
```
boyzproject/
├── 📁app/
│   ├── 📁Http/Controllers/
│   │   ├── 📄 Admin Controller.php            
│   │   ├── 📄 Contact Controller.php         
│   │   └── 📁 Models/
│   │       ├── 📄 📄 Auth Controller.php      
│   │       └── 📄 📄 Email Controller.php     
│   ├── 📁 Mail/
│   │   ├── 📄 Admin Welcome Email.php          
│   │   ├── 📄 Admin Security Code.php        
│   │   ├── 📄 Admin Verification.php          
│   │   ├── 📄 Admin Reactivation Notification.php 
│   │   └── 📄 Message ReplyMail.php           
│   └── 📁 Models/
│       ├── 📄 Admin.php                        
│       ├── 📄 Contact Message.php             
│       └── 📄 Session.php                      
├── 📁 resources/views/
│   ├── 📁 admin/
│   │   ├── 📄 dashboard.blade.php              
│   │   ├── 📄 messages.blade.php             
│   │   ├── 📄 messages-single.blade.php       
│   │   ├── 📄 chat.blade.php                   
│   │   └── 📁 auth/
│   │       ├── 📄 Change Password.blade.php   
│   │       ├── 📄 Forgot Password.blade.php   
│   │       ├── 📄 Reset Password.blade.php   
│   │       ├── 📄 Lockscreen.blade.php    
│   │       └── 📄 login.blade.php              
│   └── 📁 models
│       ├── 📄 Admin.blade.php              
│       ├── 📄 Contact Message.blade.php                 
│       ├── 📄 Custumer.blade.php                 
│       ├── 📄 Message Response.blade.php                 
│       ├── 📄 Section.blade.php                 
│       ├── 📄 Section Content.blade.php       
│       └── 📄 Session.blade.php                  
└── 📁 routes
    └── 📄 web.php                              
```

### **Database Schema**
- **admins**: Enhanced with remember_token, verification, security codes
- **contact_messages**: Message system with categories and status tracking
- **customers**: Customer information for message system
- **message_responses**: Admin responses to customer messages
- **predefined_messages**: Chat auto-response configuration
- **sessions**: Admin login history and session tracking

*Note: Unused e-commerce tables (products, transactions, reviews, categories, platforms) have been removed for optimization.*

---

## **🎯 Usage Guide**

### **Admin Access**
1. Navigate to `/admin/login`
2. Use admin credentials (create via seeder)
3. Access dashboard at `/admin/dashboard`

### **Dashboard Navigation**
- **📊 Dashboard**: E-commerce analytics and charts
- **📨 Messages**: Customer message management
- **👥 Admin**: Admin user management
- **📈 History**: Login session tracking
- **💬 Chat**: Real-time message interface

### **Email System**
- **Send Welcome**: Create new admin → auto-sends welcome email
- **Verification**: Email verification links with secure tokens
- **Reactivation**: Deactivated accounts can self-reactivate via email
- **Security Codes**: Password reset with time-limited codes

### **Chat Configuration**
Edit `public/landing/js/chat-bubble.js`:
```javascript
// Add new auto-response
'new_keyword': 'Your custom response here',
```

---

## **🛠️ Technologies Used**

### **Backend**
- **Laravel 10**: PHP framework with modern features
- **MySQL 8**: Database with proper indexing and relationships
- **Pusher**: Real-time WebSocket communication
- **Laravel Mail**: Professional email system with templates

### **Frontend**
- **Bootstrap 5**: Responsive UI framework
- **ApexCharts**: Interactive charts and analytics
- **Vanilla JavaScript**: Custom chat and dashboard functionality
- **CSS3**: Modern styling with gradients and animations

### **Development Tools**
- **Composer**: PHP dependency management
- **NPM**: Frontend asset compilation
- **Laravel Mix**: Asset bundling and optimization
- **Git**: Version control with comprehensive history

---

## **🔧 Configuration Notes**

### **Chart Integration**
- **ApexCharts**: Properly integrated with vanilla JavaScript
- **Responsive Design**: Charts adapt to screen sizes
- **Indonesian Currency**: Rupiah formatting throughout
- **Data Binding**: Dynamic data from Laravel backend

### **Email Anti-Spam**
- **Proper Headers**: From, Reply-To, Message-ID
- **HTML Text Logos**: No image dependencies
- **Professional Templates**: GDPR-compliant and mobile-friendly
- **SPF/DKIM**: Email authentication setup required

### **Security Considerations**
- **Token Validation**: Cryptographically secure tokens
- **Session Management**: Proper cleanup and invalidation
- **CSRF Protection**: All forms protected
- **Input Validation**: Server-side validation on all inputs

---

## **📝 Updates History**

<details>
<summary>Latest Version 1.1.2 (June 2025)</summary>
- ✅ **Database Cleanup**: Removed unused e-commerce tables (products, transactions, reviews, categories, platforms)
- ✅ **Project Optimization**: Removed unnecessary tests folder and phpunit configuration
- ✅ **Dependency Cleanup**: Cleaned up composer.json by removing test-related packages
- ✅ **Streamlined Codebase**: Focused on core message management and chat functionality
</details>

<details>
<summary>Version 1.1 (June 2025)</summary>

- ✅ **Email Reply System**: Complete email response functionality with MessageReplyMail class
- ✅ **Dynamic Email Templates**: Blade-based email templates with customer data integration
- ✅ **Enhanced Chat Interface**: Filter and sort functionality with dropdown controls
- ✅ **Chat Navigation Fix**: Proper routing to chat interface from admin navbar
- ✅ **Improved Chat UI**: Larger previews, no avatars, 19 realistic conversations
- ✅ **Filter Options**: All Messages, Unread Only with visual indicators
- ✅ **Sort Functions**: Newest First, Oldest First with time-based sorting
- ✅ **Scrollable Design**: Enhanced sidebar with custom scrollbar styling
</details>

<details>
<summary>Version 1.0 (May 2025)</summary>
- ✅ **E-Commerce Dashboard**: Complete transformation from crypto to motorcycle parts
- ✅ **Enhanced Login**: Remember me functionality with 7-day sessions
- ✅ **Email System Overhaul**: Anti-spam measures and professional templates
- ✅ **Chart Integration**: Working ApexCharts with Indonesian currency
- ✅ **Automated Reactivation**: Email-based account reactivation system
- ✅ **Middleware Fixes**: Proper middleware resolution and routing
- ✅ **Message Management**: Complete inbox system with categorization

### **Technical Improvements**
- ✅ **JavaScript Optimization**: Converted jQuery dependencies to vanilla JS
- ✅ **Database Optimization**: Proper migrations and relationships
- ✅ **Asset Management**: Corrected asset paths and dependencies
- ✅ **Cache Management**: Proper cache clearing procedures
- ✅ **Mobile Responsiveness**: Optimized for all device sizes
</details>
---

## **📄 License**

This project is proprietary software developed for Boy Projects. All rights reserved.

---

*Last Updated: June 2025*
*Version: 1.1.2 - Optimized & Streamlined Edition*