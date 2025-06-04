# Boy Projects - Laravel Admin System with Real-Time Notifications

## **🎯 Overview**
A comprehensive Laravel-based application featuring:
1. **Customizable Landing Page** – Dynamic content management with multiple template layouts
2. **Advanced Admin Dashboard** – Complete admin management with real-time notifications
3. **Real-Time Notification System** – Live updates using Pusher for instant notifications
4. **Email Management System** – Automated notifications, verification, and contact management
5. **Enhanced Security** – Session management with back-button prevention and authentication checks

---

## **📋 Table of Contents**
- [Features](#features)
- [Installation](#installation)
- [Real-Time Configuration](#real-time-configuration)
- [Email Configuration](#email-configuration)
- [Admin System](#admin-system)
- [Security Features](#security-features)
- [File Structure](#file-structure)
- [Usage Guide](#usage-guide)
- [Technologies Used](#technologies-used)

---

## **✨ Features**

### **🎨 Landing Page Management**
- Dynamic section management (enable/disable)
- Multiple template layouts per section
- Real-time content editing
- Order management for sections
- Responsive design with modern UI

### **📡 Real-Time Notification System**
- **Live Dashboard Updates**: Instant notification updates without page refresh
- **Contact Form Alerts**: Real-time notifications when new contact messages arrive
- **Pusher Integration**: WebSocket-based real-time communication
- **Badge Counters**: Dynamic notification counters that update instantly
- **Multi-Page Support**: Real-time updates work across all admin pages
- **Browser Notifications**: Desktop notifications for new messages
- **Unread Message Tracking**: Real-time unread message counts

### **👥 Admin Management System**
- Secure admin authentication
- Role-based access control
- Admin account verification
- Real-time notification preferences
- Contact message management with live updates

### **📧 Enhanced Contact System**
- **Contact Form Submissions**: Secure CSRF-protected contact forms
- **Real-Time Notifications**: Instant alerts when new messages arrive
- **Message Status Tracking**: New, In Progress, Resolved, Closed statuses
- **Admin Responses**: Reply to customer messages with status updates
- **Assignment System**: Assign messages to specific admins
- **Filtering & Search**: Filter by category, status, and read/unread
- **Bulk Operations**: Mark all as read, delete multiple messages

### **🔒 Security Features**
- Enhanced logout with session invalidation
- Back-button prevention after logout
- Real-time session validation
- Cache control headers
- CSRF protection with token validation
- Password visibility toggles
- Database injection protection

---

## **🚀 Installation**

### **Prerequisites**
- PHP 8.1+
- Composer
- MySQL 8.0+
- Node.js 14.17.3+ & NPM
- Pusher account (for real-time features)

### **Setup Steps**

1. **Clone Repository**
   ```bash
   git clone https://github.com/danaardana/boyzproject
   cd boyzproject
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update your `.env` file:
   ```env
   APP_NAME="Boy Projects"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=boyzproject
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   # Email Configuration
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME="${APP_NAME}"

   # Pusher Configuration (Required for real-time features)
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=your_app_id
   PUSHER_APP_KEY=your_app_key
   PUSHER_APP_SECRET=your_app_secret
   PUSHER_HOST=
   PUSHER_PORT=443
   PUSHER_SCHEME=https
   PUSHER_APP_CLUSTER=ap1
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Database Setup**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Compile Assets**
   ```bash
   npm run dev
   # or for production
   npm run build
   ```

7. **Start Development Server**
   ```bash
   php artisan serve
   ```

---

## **📡 Real-Time Configuration**

### **Pusher Setup**
1. **Create Pusher Account**
   - Visit [pusher.com](https://pusher.com)
   - Create a new app
   - Get your app credentials

2. **Configure Environment**
   ```env
   BROADCAST_DRIVER=pusher
   PUSHER_APP_ID=2003476
   PUSHER_APP_KEY=826b21ec656c73be408d
   PUSHER_APP_SECRET=2c3e417407e10ea3cd24
   PUSHER_APP_CLUSTER=ap1
   ```

3. **Broadcasting Routes**
   - Channel: `admin.notifications`
   - Event: `ContactMessageEvent`
   - Authentication: Admin only

### **Real-Time Features**
- **Dashboard Notifications**: Live updates in admin navbar
- **Message Counters**: Real-time unread message counts
- **Instant Alerts**: New contact form submissions
- **Cross-Page Updates**: Updates work on all admin pages
- **WebSocket Connection**: Persistent connection for instant updates

---

## **📧 Email Configuration**

### **Gmail Setup (Recommended)**
1. Enable 2-Factor Authentication on your Gmail account
2. Generate an App Password:
   - Go to Google Account settings
   - Security → 2-Step Verification → App passwords
   - Generate password for "Mail"
3. Use the generated password in `MAIL_PASSWORD`

### **Email Templates**
Located in `resources/views/admin/email/`:
- `reactivate.blade.php` - Account reactivation with WhatsApp integration
- `security_code.blade.php` - Password reset security codes
- `verification.blade.php` - Email verification links

---

## **🎛️ Admin System**

### **Admin Access**
- URL: `/admin/login`
- Real-time dashboard with live notifications
- Contact message management with instant updates

### **Admin Features**
- **Real-Time Dashboard**: Live notification updates and statistics
- **Contact Management**: 
  - View all messages with real-time updates
  - Reply to customers with status tracking
  - Assign messages to team members
  - Filter by category, status, read/unread
  - Bulk operations (mark all as read, delete)
- **Content Management**: Edit landing page sections
- **Email Operations**: Send verification, reactivation, security codes
- **User Management**: Admin account management

### **Contact System Endpoints**
```php
// Contact form submission (public)
POST /contact/submit

// Admin message management
GET /admin/messages              // List all messages
GET /admin/messages/{id}         // View single message
POST /admin/messages/{id}/read   // Mark as read
POST /admin/messages/read-all    // Mark all as read
POST /admin/messages/{id}/respond // Reply to message
POST /admin/messages/{id}/assign  // Assign to admin
DELETE /admin/messages/{id}      // Delete message
```

---

## **🛡️ Security Features**

### **Enhanced Security**
- **CSRF Protection**: All forms protected with CSRF tokens
- **Database Security**: Prepared statements prevent SQL injection
- **Input Validation**: Server-side validation for all inputs
- **Session Security**: Secure session management
- **Password Security**: Strong password requirements

### **Contact Form Security**
- CSRF token validation
- Input sanitization
- Rate limiting protection
- Validation for all fields:
  - Name: Required, max 255 characters
  - Email: Required, valid email format
  - Phone: Optional, max 20 characters
  - Subject: Required, max 255 characters
  - Message: Required content

### **Authentication Security**
- Password requirements (8+ chars, mixed case, numbers, symbols)
- Security code expiration (1 hour)
- Session invalidation on logout
- CSRF token validation
- Back-button prevention after logout

---

## **📁 File Structure**
```
boyzproject/
├── app/
│   ├── Events/
│   │   └── ContactMessageEvent.php      # Real-time event broadcasting
│   ├── Http/Controllers/
│   │   ├── AdminController.php          # Admin dashboard with real-time data
│   │   └── ContactController.php        # Contact management with broadcasting
│   ├── Models/
│   │   ├── ContactMessage.php           # Contact message model
│   │   ├── Customer.php                 # Customer model
│   │   └── MessageResponse.php          # Admin response model
│   └── Providers/
│       └── ViewComposerServiceProvider.php # Navbar notifications
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── messages.blade.php       # Message list with real-time updates
│   │   │   ├── messages-single.blade.php # Single message view
│   │   │   └── partials/
│   │   │       └── navbar.blade.php     # Real-time notification navbar
│   │   └── layouts/
│   │       ├── admin.blade.php          # Admin layout
│   │       └── landing.blade.php        # Landing page with contact form
│   └── js/
│       └── notifications.js             # Real-time notification handling
├── routes/
│   ├── web.php                          # Web routes
│   └── channels.php                     # Broadcasting channels
├── config/
│   └── broadcasting.php                 # Broadcasting configuration
├── database/
│   └── migrations/                      # Database schema
├── webpack.mix.js                       # Laravel Mix configuration
└── package.json                         # NPM dependencies with Pusher
```

---

## **🔧 Technologies Used**

### **Backend**
- **Laravel 10** - PHP framework
- **MySQL** - Database
- **Pusher** - Real-time WebSocket service
- **Laravel Echo** - Broadcasting client
- **Laravel Mix** - Asset compilation

### **Frontend**
- **Bootstrap 5** - UI framework
- **jQuery** - JavaScript library
- **Pusher JS** - Real-time client library
- **Font Awesome** - Icons

### **Real-Time Stack**
- **Pusher Channels** - WebSocket service
- **Laravel Broadcasting** - Server-side broadcasting
- **Laravel Echo** - Client-side listener
- **pusher-js** - JavaScript WebSocket client

---

## **📱 Usage Guide**

### **Customer Experience**
1. Fill out contact form on landing page
2. Receive confirmation message
3. Admin receives real-time notification

### **Admin Experience**
1. Log into admin dashboard
2. See real-time notifications in navbar
3. View all messages with live updates
4. Respond to customers with status tracking
5. Assign messages to team members
6. Filter and manage messages efficiently

### **Real-Time Features**
- **Instant Notifications**: New messages appear immediately
- **Live Counters**: Unread message counts update in real-time
- **Cross-Page Updates**: Works on dashboard, message list, and single message pages
- **Desktop Notifications**: Browser notifications for new messages

---

## **🧪 Testing**

### **Test Real-Time Features**
1. Open admin dashboard in one browser
2. Submit contact form in another browser/tab
3. Watch admin dashboard update instantly
4. Verify notification counters update
5. Check message appears in inbox immediately

### **Test Contact System**
1. Submit contact form with various data
2. Verify admin receives notification
3. Test admin response functionality
4. Check message status updates
5. Test assignment features

---

## **📈 Performance Notes**

- **Real-time updates** use minimal bandwidth (WebSocket)
- **Database queries** optimized with proper indexing
- **Asset compilation** uses Laravel Mix for optimization
- **Broadcasting** only to authenticated admin users
- **Memory efficient** event handling

---

## **🤝 Contributing**

1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## **📄 License**

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details.

---

## **📞 Support**

For support and questions:
- 📧 Email: support@boyprojects.com
- 📱 WhatsApp: [Contact via WhatsApp](https://wa.me/your_number)
- 🐛 Issues: [GitHub Issues](https://github.com/danaardana/boyzproject/issues)

---

**Made with ❤️ by the Boy Projects Team**