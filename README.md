# Laravel Customizable Landing Page & Admin Dashboard

## **1. Overview**
Proyek ini adalah aplikasi berbasis Laravel yang memiliki dua bagian:
1. **Landing Page** – Dapat dikustomisasi oleh admin sehingga setiap bagian bisa diatur, diaktifkan/nonaktifkan, dan diubah kontennya.
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
│── Models/
│   ├── Section.php  # Model utama untuk setiap section
│   ├── SectionContent.php  # Model untuk konten dalam section
│── Http/Controllers/
│   ├── LandingPageController.php  # Controller utama untuk landing page
│   ├── AdminController.php  # Controller untuk manajemen admin
resources/views/
│── admin/
│   ├── dashboard.blade.php
│   ├── manage-sections.blade.php  # Halaman pengelolaan landing page
│── landing/
│   ├── error/
│   │   ├── 404.blade.php  # Halaman error 404
│   │   ├── comingsoon.blade.php  # Halaman coming soon
│   ├── sections/
│   │   ├── about.blade.php
│   │   ├── activities.blade.php
│   │   ├── counter.blade.php
│   │   ├── cta.blade.php
│   │   ├── home.blade.php
│   │   ├── instagram.blade.php
│   │   ├── portofolio.blade.php
│   │   ├── pricing.blade.php
│   │   ├── services.blade.php
│   │   ├── team.blade.php
│   │   ├── testimonials.blade.php
│   │   ├── tiktok.blade.php
│── layouts/
│   ├── landing.blade.php  # Layout utama landing page
│   ├── admin.blade.php  # Layout admin
│── partials/
│   ├── footer.blade.php
│   ├── navabr.blade.php  
```

## **4. Routing**
Tambahkan dalam `routes/web.php`:
```php
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\AdminController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/admin/sections', [AdminController::class, 'index'])->name('admin.sections');
Route::post('/admin/sections', [AdminController::class, 'update']);
Route::get('/admin/sections/{id}/edit', [AdminController::class, 'edit'])->name('admin.sections.edit');
Route::post('/admin/sections/{id}', [AdminController::class, 'save']);
```

## **5. Customizing Landing Page**
- **Admin bisa mengedit bagian-bagian landing page** melalui `/admin/sections`
- **Data tersimpan dalam database** (`sections` & `section_contents`)
- **Bagian yang tidak aktif tidak akan ditampilkan di landing page**
- **Setiap section memiliki isi yang dapat diubah, termasuk teks, gambar, dan tombol**
- **Admin dapat mengatur urutan section dengan `show_order`**

## **6. Future Improvements**
- Integrasi dengan API untuk manajemen konten dinamis
- Opsi multi-template untuk landing page
- Drag & Drop editor untuk mengatur urutan section
- Sistem preview sebelum perubahan diterapkan