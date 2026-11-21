# SIGAP Banjir — Prototipe Web GIS Kota Lhokseumawe

## Cara Menjalankan (Laragon)

### 1. Nyalakan Laragon
Buka Laragon → klik **Start All** (pastikan Apache & MySQL hijau).

### 2. Buat Database
Buka **HeidiSQL** atau **phpMyAdmin** dari Laragon, lalu jalankan:
```sql
CREATE DATABASE sigap_banjir CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Install dependencies
```bash
composer install
npm install
npm run build
```

### 4. Jalankan migrasi + seeder
```bash
php artisan migrate --seed
```

`migrate:fresh` menghapus semua tabel dan data. Gunakan hanya untuk database pengembangan yang memang boleh di-reset.

### 5. Jalankan server
```bash
php artisan serve
```
Buka browser → **http://localhost:8000**

---

## Akun Login

| Peran              | Email                        | Kata Sandi        |
|--------------------|------------------------------|-------------------|
| Admin Sistem       | admin@sigapbanjir.demo       | **admin123**      |
| Petugas BPBD       | petugas@sigapbanjir.demo     | **petugas123**    |
| Koordinator Relawan| koordinator@sigapbanjir.demo | **koordinator123**|
| Masyarakat (demo)  | warga@sigapbanjir.demo       | **sigap123**      |

> Pendaftaran publik di `/daftar` membuat akun **Masyarakat** baru dengan kata sandi yang diisi sendiri.

Halaman dashboard dibatasi menggunakan session guard Laravel, status akun aktif, dan peran pengguna.

## Reset Kata Sandi

Di lingkungan lokal, gunakan `MAIL_MAILER=log` pada `.env`. Setelah meminta tautan di `/lupa-sandi`, buka `storage/logs/laravel.log` untuk menyalin URL reset. Pastikan `APP_URL` sesuai alamat aplikasi yang dibuka di browser. Untuk pengiriman email sebenarnya, isi konfigurasi SMTP pada `.env` dan bersihkan cache konfigurasi dengan `php artisan config:clear`.

## Struktur Data Operasional

Migration Laravel menjadi sumber skema database. Migration tambahan membentuk tabel untuk:

- laporan banjir, foto laporan, dan dampak;
- lokasi pengungsian, fasilitas, dan permintaan evakuasi;
- kondisi jalan dan rute evakuasi;
- relawan, keahlian, kebutuhan relawan, dan penugasan;
- stok bantuan, kebutuhan logistik, alokasi, penyaluran, dan pergerakan stok;
- notifikasi, log aktivitas, pengaturan sistem, dan hak akses.

Jika database dibuat dari dump SQL lama, atur koneksi MySQL di `.env`, lalu jalankan `php artisan migrate` untuk membuat tabel dari migration yang belum tercatat. Jangan menjalankan `migrate:fresh` pada database yang datanya ingin dipertahankan.

## Pelaporan Warga Tanpa Login

Warga dapat mengirim laporan banjir di `/lapor-banjir` atau permintaan evakuasi di `/permintaan-evakuasi` tanpa masuk atau membuat akun. Nomor HP dipakai petugas untuk tindak lanjut dan untuk mengecek status di `/cek-status` bersama nomor referensi yang ditampilkan setelah pengiriman.

Laporan banjir dan permintaan evakuasi masuk ke antrean **Menunggu**. Petugas BPBD tetap harus masuk untuk meninjau laporan di `/petugas/verifikasi-laporan` atau memperbarui permintaan di `/petugas/permintaan-evakuasi`. Foto laporan disimpan di disk privat dan hanya dapat diakses melalui halaman petugas.

Form laporan meminta warga memilih titik dengan mengeklik peta atau menggunakan lokasi perangkat; koordinat tidak perlu diisi manual. Tinggi air diisi dalam meter. Setiap laporan publik wajib menyertakan satu foto JPG/PNG/WEBP (maks. 5 MB) dan satu video MP4 (maks. 50 MB). Kedua form membatasi frekuensi pengiriman; peta membutuhkan koneksi internet untuk memuat peta dasar OpenStreetMap.

Setelah menarik perubahan yang menambahkan kolom informasi pelapor laporan banjir, jalankan `php artisan migrate`. Perintah ini hanya menjalankan migration yang belum diterapkan dan tidak menghapus data.

---

## Alur Login → Dashboard

```
Admin Sistem        → /admin
Petugas BPBD        → /petugas
Koordinator Relawan → /koordinator
Masyarakat          → / (beranda publik)
```

> Masyarakat tidak memiliki dashboard khusus. Setelah login, mereka diarahkan ke halaman beranda. Pelaporan banjir dan permintaan evakuasi tersedia tanpa akun di `/lapor-banjir` dan `/permintaan-evakuasi`.

