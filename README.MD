# 🏠 NusantaraSmart

> Aplikasi E-Commerce Smart Home berbasis web dengan integrasi Xendit Payment Gateway

![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=flat&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=flat&logo=mysql&logoColor=white)

---

#Deskripsi

NusantaraSmart ialah aplikasi/website onlineshop dengan tema SmartHome yang dibangun sebagai proyek Uji Kompetensi SMK 2026. Aplikasi ini memungkinkan customer untuk membeli produk smarthome secara online dengan pembayaran terintegrasi melalui Xendit Payment Gateway.

---

## ✨ Fitur Utama

### 👤 Customer
- Register & Login akun
- Katalog produk dengan filter kategori & pencarian
- Shopping cart berbasis session
- Checkout & pembuatan pesanan
- Pembayaran via Xendit (Transfer Bank, E-Wallet, QRIS, dll)
- Riwayat & tracking status pesanan

### 🛠️ Admin
- Dashboard statistik (total pesanan, pendapatan, stok menipis)
- CRUD Kategori produk
- CRUD Produk dengan upload gambar
- Manajemen & update status pesanan
- Auto-update status pembayaran via Xendit Webhook

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Framework | Laravel 12 |
| Language | PHP 8.2 |
| Frontend | Blade Template Engine |
| CSS Framework | Tailwind CSS |
| UI Components | Flowbite 2.2.1 |
| Database | MySQL |
| Authentication | Laravel Breeze |
| Payment Gateway | Xendit |
| Build Tool | Vite |
| Version Control | Git & GitHub |

---

## 🗄️ Struktur Database
users           → Data pengguna (admin & customer)
categories      → Kategori produk
products        → Data produk smart home
orders          → Data pesanan customer
order_items     → Detail item dalam pesanan
payments        → Data pembayaran via Xendit

### Relasi Antar Tabel
users ──hasMany──► orders ──hasMany──► order_items ──belongsTo──► products
│                                                │
hasOne                                         belongsTo
│                                                │
payments                                       categories

---

## 🔄 Alur Sistem (End-to-End)

### Alur Customer
Register / Login
│
▼
Katalog Produk (filter, search)
│
▼
Tambah ke Keranjang
│
▼
Checkout (isi alamat pengiriman)
│
▼
Buat Pesanan → Generate Invoice Xendit
│
▼
Halaman Pembayaran Xendit
│
▼
Bayar (Transfer / E-Wallet / QRIS)
│
▼
Xendit kirim Webhook → Status otomatis update ke "Paid"
│
▼
Lihat Riwayat Pesanan

### Alur Admin
Login sebagai Admin
│
▼
Dashboard (statistik & pesanan terbaru)
│
├──► Kelola Kategori (CRUD)
├──► Kelola Produk (CRUD + Upload Gambar)
└──► Kelola Pesanan (lihat detail & update status)

---

## 🚀 Cara Setup Project

### Prasyarat
Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL (via Laragon/XAMPP)
- Git

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/raihanvst/NusantaraSmart.git
cd NusantaraSmart
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Install dependencies JavaScript**
```bash
npm install
```

**4. Salin file environment**
```bash
cp .env.example .env
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Konfigurasi database di `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nusantarasmart
DB_USERNAME=root
DB_PASSWORD=
```

**7. Buat database `nusantarasmart` di MySQL, lalu jalankan migrasi**
```bash
php artisan migrate
```

**8. Jalankan seeder (data awal)**
```bash
php artisan db:seed
```

**9. Buat symlink untuk storage gambar**
```bash
php artisan storage:link
```

**10. Compile asset CSS/JS**
```bash
npm run build
```

**11. Jalankan aplikasi**
```bash
php artisan serve
```

Akses di browser: `http://127.0.0.1:8000`

---

## 🚀 Cara Setup Project

### Prasyarat
Pastikan sudah terinstall:
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL (via Laragon/XAMPP)
- Git

### Langkah Instalasi

**1. Clone repository**
```bash
git clone https://github.com/raihanvst/NusantaraSmart.git
cd NusantaraSmart
```

**2. Install dependencies PHP**
```bash
composer install
```

**3. Install dependencies JavaScript**
```bash
npm install
```

**4. Salin file environment**
```bash
cp .env.example .env
```

**5. Generate application key**
```bash
php artisan key:generate
```

**6. Konfigurasi database di `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nusantarasmart
DB_USERNAME=root
DB_PASSWORD=
```

**7. Buat database `nusantarasmart` di MySQL, lalu jalankan migrasi**
```bash
php artisan migrate
```

**8. Jalankan seeder (data awal)**
```bash
php artisan db:seed
```

**9. Buat symlink untuk storage gambar**
```bash
php artisan storage:link
```

**10. Compile asset CSS/JS**
```bash
npm run build
```

**11. Jalankan aplikasi**
```bash
php artisan serve
```

Akses di browser: `http://127.0.0.1:8000`

---

## 💳 Konfigurasi Xendit

**1. Daftar akun di** https://dashboard.xendit.co

**2. Tambahkan konfigurasi di `.env`**
```env
XENDIT_SECRET_KEY=xnd_development_xxxxxxxxxxxxxx
XENDIT_WEBHOOK_TOKEN=xxxxxxxxxxxxxx
APP_URL=https://your-ngrok-url.ngrok-free.dev
```

**3. Install package Xendit**
```bash
composer require xendit/xendit-php
```

**4. Setup webhook untuk testing lokal**

Install ngrok: https://ngrok.com/download

```bash
ngrok http 8000
```

**5. Daftarkan webhook URL di dashboard Xendit**
Settings → Webhooks → Invoices paid
URL: https://your-ngrok-url.ngrok-free.dev/webhook/xendit

---

## 👤 Akun Default

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@nusantarasmart.com | admin123456 |

> Customer bisa register mandiri melalui halaman `/register`

---

## 📁 Struktur Folder Penting
NusantaraSmart/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          → Controller admin panel
│   │   │   ├── Auth/           → Controller autentikasi
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── CustomerOrderController.php
│   │   │   ├── ShopController.php
│   │   │   └── WebhookController.php
│   │   └── Middleware/
│   │       ├── IsAdmin.php
│   │       └── IsCustomer.php
│   ├── Models/                 → Eloquent Models
│   └── Services/
│       └── XenditService.php   → Logika Xendit
├── database/
│   ├── migrations/             → Skema database
│   └── seeders/                → Data awal
├── resources/
│   ├── css/app.css             → Tailwind + custom styles
│   └── views/
│       ├── admin/              → Tampilan admin panel
│       ├── auth/               → Halaman login & register
│       ├── layouts/            → Layout utama
│       └── shop/               → Halaman customer
└── routes/
└── web.php                 → Semua route aplikasi

---

## 🌿 Git Branch Strategy

| Branch | Kegunaan |
|--------|----------|
| `main` | Branch utama sebagai Final dari branch Dev |
| `dev-backend` | Branch untuk tahap Development |

---

## 👨‍💻 Developer

**Raihan Vista**
SMK BPI — Rekayasa Perangkat Lunak
Tahun Ajaran 2025/2026

---
