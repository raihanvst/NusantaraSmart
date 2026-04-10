# 📖 User Guide — NusantaraSmart

Panduan penggunaan aplikasi NusantaraSmart untuk Admin dan Customer.

---

## 🔐 1. Register & Login

### Register (Daftar Akun Baru)
1. Buka aplikasi di browser
2. Klik tombol **"Daftar"** di pojok kanan atas navbar
3. Isi form:
   - **Nama Lengkap** → nama kamu
   - **Email** → alamat email aktif
   - **Password** → minimal 8 karakter
   - **Konfirmasi Password** → ulangi password
4. Klik **"Buat Akun Sekarang"**
5. Setelah berhasil, kamu akan diarahkan ke halaman Login

### Login (Masuk ke Akun)
1. Buka halaman `/login`
2. Isi **Email** dan **Password**
3. Centang **"Ingat Saya"** jika ingin tetap login
4. Klik **"Masuk ke Akun"**
5. Kamu akan diarahkan ke halaman Katalog Produk

### Akun Default Admin
| Email | Password |
|-------|----------|
| admin@nusantarasmart.com | admin123456 |

---

## 🛍️ 2. Panduan Customer

### 2.1 Melihat Katalog Produk
1. Setelah login, kamu otomatis diarahkan ke halaman **Katalog**
2. Produk ditampilkan dalam grid 3 kolom
3. Gunakan **filter kategori** (pills di atas) untuk menyaring produk
4. Gunakan **search bar** di navbar untuk mencari produk tertentu
5. Gunakan **filter harga** di sidebar untuk menyaring berdasarkan harga

### 2.2 Melihat Detail Produk
1. Klik nama atau gambar produk di katalog
2. Halaman detail menampilkan:
   - Gambar produk
   - Nama & deskripsi
   - Harga & stok tersedia
   - Produk terkait di bagian bawah
3. Atur jumlah dengan tombol **+** dan **−**
4. Klik **"Tambah ke Keranjang"**

### 2.3 Keranjang Belanja
1. Klik **"Keranjang"** di navbar
2. Halaman keranjang menampilkan semua produk yang dipilih
3. Kamu bisa:
   - Ubah jumlah produk dengan tombol +/−
   - Hapus produk tertentu dengan klik **"Hapus"**
   - Kosongkan semua dengan **"Kosongkan keranjang"**
4. Bagian kanan menampilkan **Ringkasan Pesanan**
5. Klik **"Lanjut ke Checkout"** jika sudah siap

### 2.4 Checkout & Pembayaran
1. Di halaman Checkout, isi:
   - **Alamat Lengkap** → alamat pengiriman lengkap (wajib)
   - **Catatan** → pesan untuk penjual (opsional)
2. Periksa daftar produk dan total pembayaran
3. Klik **"Buat Pesanan & Bayar"**
4. Kamu akan diarahkan ke **halaman pembayaran Xendit**
5. Pilih metode pembayaran:
   - Transfer Bank (BCA, Mandiri, BRI, dll)
   - E-Wallet (OVO, GoPay, DANA, dll)
   - QRIS
   - Kartu Kredit/Debit
6. Selesaikan pembayaran sesuai instruksi
7. Setelah bayar, status pesanan otomatis berubah menjadi **"Dibayar"**

### 2.5 Riwayat Pesanan
1. Klik nama akun di navbar → pilih **"Pesanan Saya"**
2. Halaman menampilkan semua riwayat pesanan
3. Status pesanan:
   | Status | Keterangan |
   |--------|-----------|
   | Menunggu Pembayaran | Pesanan dibuat, belum dibayar |
   | Sudah Dibayar | Pembayaran berhasil dikonfirmasi |
   | Sedang Diproses | Admin sedang memproses pesanan |
   | Sedang Dikirim | Pesanan dalam perjalanan |
   | Selesai | Pesanan telah diterima |
   | Dibatalkan | Pesanan dibatalkan |
4. Klik **"Lihat Detail"** untuk melihat detail pesanan
5. Jika status masih "Menunggu Pembayaran", klik **"Bayar Sekarang"** untuk melanjutkan pembayaran

---

## 🛠️ 3. Panduan Admin

### 3.1 Akses Admin Panel
1. Login dengan akun admin
2. Klik nama akun di navbar → pilih **"Admin Panel"**
3. Atau langsung akses `/admin/dashboard`

### 3.2 Dashboard
Dashboard menampilkan ringkasan:
- **Total Pesanan** → jumlah semua pesanan masuk
- **Menunggu Bayar** → pesanan yang belum dibayar
- **Total Pendapatan** → total dari pesanan yang sudah dibayar
- **Produk Aktif** → jumlah produk yang tampil di katalog
- **Pesanan Terbaru** → 5 pesanan terakhir
- **Stok Menipis** → produk dengan stok ≤ 10

### 3.3 Manajemen Kategori
1. Klik **"Kategori"** di sidebar
2. Halaman menampilkan daftar semua kategori

**Tambah Kategori:**
1. Klik **"+ Tambah Kategori"**
2. Isi Nama dan Deskripsi (opsional)
3. Klik **"Simpan Kategori"**

**Edit Kategori:**
1. Klik **"Edit"** pada baris kategori
2. Ubah data yang diperlukan
3. Klik **"Perbarui Kategori"**

**Hapus Kategori:**
1. Klik **"Hapus"** pada baris kategori
2. Konfirmasi di modal yang muncul
3. Klik **"Ya, Hapus"**

> ⚠️ Kategori yang masih memiliki produk tidak bisa dihapus

### 3.4 Manajemen Produk
1. Klik **"Produk"** di sidebar
2. Halaman menampilkan daftar semua produk

**Tambah Produk:**
1. Klik **"+ Tambah Produk"**
2. Isi semua field:
   - Kategori (wajib)
   - Nama Produk (wajib)
   - Deskripsi (opsional)
   - Harga dalam Rupiah (wajib)
   - Stok (wajib)
   - Gambar (opsional, maks 2MB, format jpg/png/webp)
   - Centang **"Produk aktif"** agar tampil di katalog
3. Klik **"Simpan Produk"**

**Edit Produk:**
1. Klik **"Edit"** pada baris produk
2. Ubah data yang diperlukan
3. Untuk ganti gambar, pilih file baru (kosongkan jika tidak ingin mengubah)
4. Klik **"Perbarui Produk"**

**Hapus Produk:**
1. Klik **"Hapus"** pada baris produk
2. Konfirmasi di modal
3. Gambar produk akan ikut terhapus otomatis

### 3.5 Manajemen Pesanan
1. Klik **"Pesanan"** di sidebar
2. Halaman menampilkan semua pesanan yang masuk
3. Klik **"Detail"** untuk melihat detail pesanan

**Update Status Pesanan:**
1. Di halaman detail pesanan, lihat bagian **"Update Status"**
2. Pilih status baru dari dropdown
3. Klik **"Simpan Perubahan"**

> Status pembayaran (paid/expired) diupdate **otomatis** oleh sistem via Xendit Webhook — admin tidak perlu mengubah secara manual.

---

## 📞 Bantuan

Jika mengalami kendala, hubungi:
- Email: hello@nusantarasmart.com
- Jam operasional: Senin–Jumat, 09.00–17.00 WIB