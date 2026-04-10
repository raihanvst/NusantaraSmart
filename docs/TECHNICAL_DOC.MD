# 🔧 Technical Documentation — NusantaraSmart

Dokumentasi teknis untuk developer dan penguji.

---

## 🗄️ ERD (Entity Relationship Diagram)

```
┌─────────────┐       ┌─────────────┐       ┌──────────────┐
│    USERS    │       │   ORDERS    │       │ ORDER_ITEMS  │
│─────────────│       │─────────────│       │──────────────│
│ id (PK)     │──┐    │ id (PK)     │──┐    │ id (PK)      │
│ name        │  │    │ user_id (FK)│←─┘    │ order_id (FK)│←─┐
│ email       │  └───►│ order_number│  ┌───►│ product_id   │  │
│ password    │       │ status      │  │    │ quantity     │  │
│ role        │       │ total_amount│  │    │ price        │  │
│ created_at  │       │ shipping_   │  │    │ created_at   │  │
│ updated_at  │       │   address   │  │    │ updated_at   │  │
└─────────────┘       │ notes       │  │    └──────────────┘  │
                      │ created_at  │  │                      │
                      │ updated_at  │  │    ┌──────────────┐  │
                      └─────────────┘  │    │   PRODUCTS   │  │
                             │         └────│──────────────│  │
                             │              │ id (PK)      │──┘
                      ┌──────▼──────┐       │ category_id  │──┐
                      │  PAYMENTS   │       │ name         │  │
                      │─────────────│       │ slug         │  │
                      │ id (PK)     │       │ description  │  │
                      │ order_id(FK)│       │ price        │  │
                      │ xendit_     │       │ stock        │  │
                      │  invoice_id │       │ image        │  │
                      │ xendit_     │       │ is_active    │  │
                      │  invoice_url│       │ created_at   │  │
                      │ amount      │       │ updated_at   │  │
                      │ status      │       └──────────────┘  │
                      │ payment_    │                          │
                      │   method    │       ┌──────────────┐  │
                      │ paid_at     │       │  CATEGORIES  │  │
                      │ created_at  │       │──────────────│  │
                      │ updated_at  │       │ id (PK)      │←─┘
                      └─────────────┘       │ name         │
                                            │ slug         │
                                            │ description  │
                                            │ created_at   │
                                            │ updated_at   │
                                            └──────────────┘
```

### Relasi Antar Tabel

| Tabel Asal | Relasi | Tabel Tujuan | Keterangan |
|-----------|--------|-------------|-----------|
| users | hasMany | orders | 1 user bisa punya banyak order |
| orders | belongsTo | users | 1 order dimiliki 1 user |
| orders | hasMany | order_items | 1 order berisi banyak item |
| orders | hasOne | payments | 1 order punya 1 data pembayaran |
| order_items | belongsTo | orders | Item merujuk ke 1 order |
| order_items | belongsTo | products | Item merujuk ke 1 produk |
| products | belongsTo | categories | 1 produk punya 1 kategori |
| categories | hasMany | products | 1 kategori punya banyak produk |

---

## 🔄 Flow Sistem

### Flow Checkout & Payment

```
[Customer]
    │
    ├─ Tambah produk ke cart (session)
    │
    ├─ Buka halaman Checkout
    │     └─ Validasi: cart tidak boleh kosong
    │
    ├─ Submit form (alamat pengiriman)
    │     ├─ Validasi input
    │     ├─ Cek stok semua produk
    │     ├─ Buat record di tabel orders
    │     ├─ Buat record di tabel order_items
    │     ├─ Kurangi stok produk (decrement)
    │     └─ Kosongkan cart (session)
    │
    ├─ Generate Invoice Xendit
    │     ├─ XenditService::createInvoice()
    │     ├─ Simpan xendit_invoice_id & xendit_invoice_url
    │     └─ Buat record di tabel payments (status: pending)
    │
    ├─ Redirect ke halaman pembayaran Xendit
    │
    └─ Customer memilih metode & menyelesaikan pembayaran

[Xendit]
    │
    └─ POST /webhook/xendit
          ├─ Verifikasi x-callback-token
          ├─ Cari order berdasarkan external_id
          ├─ Jika status PAID:
          │     ├─ Update orders.status → 'paid'
          │     └─ Update payments.status → 'paid'
          └─ Jika status EXPIRED:
                ├─ Update orders.status → 'cancelled'
                └─ Update payments.status → 'expired'
```

### Flow Auth & Role

```
Request masuk
    │
    ├─ Middleware auth → cek sudah login?
    │     └─ Belum login → redirect ke /login
    │
    └─ Sudah login → cek role
          ├─ isAdmin → akses /admin/*
          └─ isCustomer → akses /cart, /orders, /checkout
```

---

## ⚙️ Cara Setup Project

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL
- Git

### Instalasi

```bash
# 1. Clone repo
git clone https://github.com/raihanvst/NusantaraSmart.git
cd NusantaraSmart

# 2. Install dependencies
composer install
npm install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Konfigurasi .env (sesuaikan dengan lokal)
DB_DATABASE=nusantarasmart
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrasi & seeder
php artisan migrate
php artisan db:seed

# 6. Storage symlink
php artisan storage:link

# 7. Build asset
npm run build

# 8. Jalankan
php artisan serve
```

---

## 💳 Konfigurasi Xendit & Webhook

### 1. Setup Akun Xendit
1. Daftar di https://dashboard.xendit.co
2. Masuk ke **Settings → API Keys**
3. Generate Secret Key dengan permission **Money-in Write**
4. Catat **Webhook Verification Token** di Settings → Webhooks

### 2. Konfigurasi `.env`
```env
XENDIT_SECRET_KEY=xnd_development_xxxxxx
XENDIT_WEBHOOK_TOKEN=xxxxxxxxxxxxxx
APP_URL=https://your-ngrok-url.ngrok-free.dev
```

### 3. Setup Ngrok (Testing Lokal)
```bash
# Install ngrok dari https://ngrok.com/download
ngrok http 8000
```

### 4. Daftarkan Webhook di Xendit
1. Buka **Settings → Webhooks**
2. Di bagian **Invoices paid**, masukkan:
```
https://your-ngrok-url.ngrok-free.dev/webhook/xendit
```
3. Klik **Test and Save**
4. Pastikan response status **200**

### 5. Verifikasi Konfigurasi
```bash
php artisan tinker
config('services.xendit.secret_key')
# Harus menampilkan secret key, bukan null
```

---

## 🗂️ Struktur Folder

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── CategoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── OrderController.php
│   │   │   └── ProductController.php
│   │   ├── Auth/               → Breeze auth controllers
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── CustomerOrderController.php
│   │   ├── ShopController.php
│   │   └── WebhookController.php
│   └── Middleware/
│       ├── IsAdmin.php
│       └── IsCustomer.php
├── Models/
│   ├── Category.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Payment.php
│   ├── Product.php
│   └── User.php
└── Services/
    └── XenditService.php
```

---

## 🌿 Git Branch

| Branch | Keterangan |
|--------|-----------|
| `main` | Production-ready code |
| `dev-backend` | Branch pengembangan aktif |

---

## 👨‍💻 Developer

**Raihan Vista**
SMK BPI — Rekayasa Perangkat Lunak
Tahun Ajaran 2025/2026