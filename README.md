# Laravel Customizable Landing Page & Admin Dashboard

## **1. Overview**
Proyek ini adalah aplikasi berbasis Laravel yang memiliki dua bagian:
1. **Landing Page** – Dapat dikustomisasi oleh admin sehingga setiap bagian bisa diatur dan diaktifkan/nonaktifkan.
2. **Admin Dashboard** – Digunakan untuk mengelola tampilan landing page.

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
6. **Seed Default Sections (Opsional)**
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
│   ├── LandingSection.php  # Model untuk landing page
│── Http/Controllers/
│   ├── LandingPageController.php  # Controller utama
resources/views/
│── layouts/
│   ├── landing.blade.php  # Layout utama landing page
│   ├── admin.blade.php  # Layout admin
│── landing/
│   ├── sections/  # Folder untuk bagian landing page
│   │   ├── hero.blade.php
│   │   ├── about.blade.php
│   │   ├── services.blade.php
│   ├── index.blade.php  # Halaman utama landing page
│── admin/
│   ├── dashboard.blade.php
│   ├── manage-landing.blade.php  # Halaman pengelolaan landing page
```

## **4. Routing**
Tambahkan dalam `routes/web.php`:
```php
use App\Http\Controllers\LandingPageController;

Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');
Route::get('/admin/landing', [LandingPageController::class, 'edit'])->name('admin.manage-landing');
Route::post('/admin/landing', [LandingPageController::class, 'update']);
```

## **5. Customizing Landing Page**
- **Admin bisa mengedit bagian-bagian landing page** melalui `admin/landing`
- **Data tersimpan dalam database** (`landing_sections`)
- **Bagian yang tidak aktif tidak akan ditampilkan di landing page**

## **6. Future Improvements**
- Integrasi dengan API untuk manajemen dinamis
- Opsi multi-template untuk landing page




