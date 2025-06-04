# Boy Projects - Laravel Admin System with Email Management

## **🎯 Overview**
A comprehensive Laravel-based application featuring:
1. **Customizable Landing Page** – Dynamic content management with multiple template layouts
2. **Advanced Admin Dashboard** – Complete admin management with email system integration
3. **Email Management System** – Automated notifications, verification, and password reset
4. **Enhanced Security** – Session management with back-button prevention and authentication checks

---

## **📋 Table of Contents**
- [Features](#features)
- [Installation](#installation)
- [Email Configuration](#email-configuration)
- [Admin System](#admin-system)
- [Security Features](#security-features)
- [File Structure](#file-structure)
- [Usage Guide](#usage-guide)
- [Testing](#testing)

---

## **✨ Features**

### **🎨 Landing Page Management**
- Dynamic section management (enable/disable)
- Multiple template layouts per section
- Real-time content editing
- Order management for sections
- Responsive design with modern UI

### **👥 Admin Management System**
- Secure admin authentication
- Role-based access control
- Admin account verification
- Bulk email operations
- Contact message management

### **📧 Email System**
- **Account Reactivation**: Email notifications with WhatsApp integration
- **Security Codes**: Password reset with time-limited security codes
- **Email Verification**: Secure token-based verification system
- **Bulk Emails**: Send notifications to multiple admins
- **Template System**: Blade-based email templates

### **🔒 Security Features**
- Enhanced logout with session invalidation
- Back-button prevention after logout
- Real-time session validation
- Cache control headers
- CSRF protection
- Password visibility toggles

### **💬 Contact System**
- Contact form submissions
- Admin response management
- Message status tracking
- Bulk operations

---

## **🚀 Installation**

### **Prerequisites**
- PHP 8.1+
- Composer
- MySQL 8.0+
- Node.js & NPM (for assets)

### **Setup Steps**

1. **Clone Repository**
   ```bash
   git clone https://github.com/danaardana/boyzproject
   cd boyzproject
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run dev
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

   # Email Configuration (Required for admin features)
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME="${APP_NAME}"
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

6. **Start Development Server**
   ```bash
   php artisan serve
   ```

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

### **Default Admin Access**
- URL: `/admin/login`
- Default credentials are created during seeding

### **Admin Features**
- **Dashboard**: Overview with statistics
- **Content Management**: Edit landing page sections
- **Email Operations**: Send verification, reactivation, security codes
- **User Management**: Admin account management
- **Contact Management**: Handle customer inquiries
- **Security**: Password changes, session management

### **Email Operations**
```php
// Individual email sending
POST /admin/emails/reactivation
POST /admin/emails/security-code
POST /admin/emails/verification

// Bulk email operations
POST /admin/emails/bulk
```

---

## **🛡️ Security Features**

### **Authentication Security**
- Password requirements (8+ chars, mixed case, numbers, symbols)
- Security code expiration (1 hour)
- Session invalidation on logout
- CSRF token validation

### **Back-Button Prevention**
- Cache control headers on all admin pages
- JavaScript session validation
- Real-time authentication checks
- Automatic redirect to login when session expires

### **Session Management**
- Periodic session validation (every 5 minutes)
- Page focus session checks
- Complete session cleanup on logout

---

## **📁 File Structure**

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── AuthController.php          # Admin authentication
│   │   │   └── EmailController.php         # Email management
│   │   ├── AdminController.php             # Admin dashboard
│   │   ├── ContactController.php           # Contact management
│   │   ├── LandingPageController.php       # Landing page
│   │   └── TableController.php             # Data tables
│   └── Middleware/
│       └── PreventBackHistory.php          # Security middleware
├── Mail/
│   ├── AdminReactivationNotification.php  # Reactivation emails
│   ├── AdminSecurityCode.php              # Security code emails
│   └── AdminVerification.php              # Verification emails
└── Models/
    ├── Admin.php                           # Admin model with security methods
    ├── Section.php                         # Landing page sections
    └── SectionContent.php                  # Section content

resources/views/
├── admin/
│   ├── auth/                               # Authentication pages
│   │   ├── login.blade.php                # Login with password toggle
│   │   ├── reset-password.blade.php       # Password reset
│   │   └── change-password.blade.php      # Password change
│   ├── email/                              # Email templates
│   │   ├── reactivate.blade.php           # Reactivation email
│   │   ├── security_code.blade.php        # Security code email
│   │   └── verification.blade.php         # Verification email
│   ├── layouts/
│   │   ├── master.blade.php               # Main admin layout
│   │   └── auth.blade.php                 # Auth layout
│   └── admin.blade.php                    # Admin management page
└── landing/                                # Landing page templates
    ├── sections/                           # Template sections
    └── index.blade.php                     # Main landing page

routes/
└── web.php                                 # All application routes
```

---

## **📖 Usage Guide**

### **Landing Page Customization**
1. Login to admin panel: `/admin/login`
2. Navigate to "Landing Page Tables"
3. Select section to edit
4. Modify content, enable/disable sections
5. Changes reflect immediately on landing page

### **Email Management**
1. Go to "Admin Management" page
2. Use dropdown menu for individual emails:
   - Send Verification
   - Send Reactivation  
   - Reset Password
3. Use checkboxes + "Send Bulk Emails" for multiple recipients

### **Password Reset Flow**
1. User clicks "Forgot Password"
2. Enters email address
3. Receives security code via email
4. Enters code + new password
5. Password updated successfully

### **Admin Verification**
1. Send verification email from admin panel
2. Admin receives email with secure link
3. Click link to verify account
4. Account marked as verified

---

## **🧪 Testing**

### **Email Testing**
Test route available: `/test-email/{adminId}`
```bash
# Test email functionality
curl http://localhost:8000/test-email/1
```

### **Security Testing**
1. Login to admin panel
2. Logout
3. Try browser back button → Should redirect to login
4. Try accessing admin URLs directly → Should redirect to login

### **Feature Testing**
- Contact form submissions
- Admin email operations
- Password reset flow
- Session expiration handling

---

## **🔧 Configuration**

### **WhatsApp Integration**
Update phone number in reactivation email template:
```blade
<!-- resources/views/admin/email/reactivate.blade.php -->
<a href="https://wa.me/082216649329?text=reactivate%20account%20{{ urlencode($admin->name) }}" 
   style="background-color: #25D366; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px;">
    Contact via WhatsApp
</a>
```

### **Session Configuration**
Adjust session timeout in `config/session.php`:
```php
'lifetime' => 120, // minutes
```

### **Email Rate Limiting**
Configure in `config/mail.php` if needed for production.

---

## **🚀 Deployment**

### **Production Checklist**
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up proper email credentials
- [ ] Configure web server (Apache/Nginx)
- [ ] Set proper file permissions
- [ ] Enable HTTPS
- [ ] Configure caching (`php artisan config:cache`)

---

## **🤝 Contributing**
1. Fork the repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## **📝 License**
This project is open source and available under the [MIT License](LICENSE).

---

## **👨‍💻 Author**
**Boy Projects Team**
- Email: your-email@gmail.com
- WhatsApp: +62 822-1664-9329

---

## **📞 Support**
For support and questions:
- Create an issue on GitHub
- Contact via WhatsApp: +62 822-1664-9329
- Email: your-email@gmail.com