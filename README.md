# Laravel Customizable Landing Page & Admin Dashboard

## **1. Overview**
Proyek ini adalah aplikasi berbasis Laravel yang memiliki dua bagian:
1. **Landing Page** – Dapat dikustomisasi oleh admin sehingga setiap bagian bisa memilih template yang digunakan, diaktifkan/nonaktifkan, dan diubah kontennya.
2. **Admin Dashboard** – Digunakan untuk mengelola tampilan landing page dan isi kontennya secara dinamis.

## **2. Installation**
### **Prerequisites**
- PHP 8+
- Composer
- MySQL 

### **Setup Steps**
1. **Clone Repository**
   ```bash
   git clone https://github.com/danaardana/boyzproject
   cd your-repo
   ```
2. **Install Dependencies**
   ```bash
   composer install
   npm install  # Jika menggunakan Laravel Mix
   ```
3. **Setup Environment**
   Salin file `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   ```
   Lalu edit `.env` untuk konfigurasi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_database_user
   DB_PASSWORD=your_database_password
   ```
4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```
5. **Run Migrations**
   ```bash
   php artisan migrate
   ```
6. **Seed Default Sections & Content (Opsional)**
   ```bash
   php artisan db:seed
   ```
7. **Run Application**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di: `http://127.0.0.1:8000/`

## **3. Folder Structure**
```
app/
│── Http/Controllers/
│   ├── Admin Controller
│   ├── Contact Controller
│   ├── Controller
│   ├── Email Verification Controller
│   ├── Landing Page Controller
│   ├── Table Controller
│
│── Models/
│   ├── admin
│   ├── Section  
│   ├── Section Content

public/
│   ├── admin
│   │   ├── lang
│   │   ├── CSS, fonts, images, js, libs
│   ├── landing  
│   │   ├── CSS, fonts, images, js, libs, php

resources/views/
│── admin/
│   ├── partials/
│   │   ├── footer
│   │   ├── horizontal menu
│   │   ├── navbar
│   │   ├── sidebar
│   ├── admin
│   ├── chat
│   ├── dashboard
│   ├── data
│   ├── email confirmation
│   ├── email verification
│   ├── faq
│   ├── history
│   ├── landing page tables
│   ├── lockscreen
│   ├── subsection tables
│
│── landing/
│   ├── error/
│   │   ├── 404
│   │   ├── comingsoon
│   ├── partials/
│   │   ├── footer
│   │   ├── navbar
│   ├── sections/
│   │   ├── about - 2 layouts
│   │   ├── activities - 4 layouts
│   │   ├── categories - 2 layouts
│   │   ├── contact
│   │   ├── counter
│   │   ├── cta - 3 layouts
│   │   ├── home - 4 layouts
│   │   ├── instagram
│   │   ├── portofolio - 3 layouts
│   │   ├── pricing
│   │   ├── promotion - 3 layouts
│   │   ├── services - 2 layouts
│   │   ├── testimonials - 2 layouts
│   │   ├── tiktok
│   ├── index
│   ├── login
│
│── layouts/
│   ├── admin
│   ├── landing
```

## **4. Routing**
Tambahkan dalam `routes/web`:
```php
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TableController;

```

## **5. Customizing Landing Page**
- **Admin bisa mengedit bagian-bagian landing page** melalui `/admin/sections`
- **Data tersimpan dalam database** (`sections` & `section_contents`)
- **Bagian yang tidak aktif tidak akan ditampilkan di landing page**
- **Setiap section memiliki isi yang dapat diubah, termasuk teks, gambar, dan tombol**
- **Admin dapat mengatur urutan section dengan `show_order`**

## **6. Future Improvements**
- Sistem preview sebelum perubahan diterapkan template
- Integrasi dengan API untuk manajemen konten SHOPEE dinamis
- Integrasi ChatBot