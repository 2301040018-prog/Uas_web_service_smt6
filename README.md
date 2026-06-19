

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## 🏨 API Sistem Manajemen Hotel dan Reservasi Kamar

RESTful API untuk pengelolaan sistem reservasi hotel mencakup manajemen data hotel, data kamar, pencarian ketersediaan kamar, transaksi booking, dan riwayat pemesanan pengguna.

## 📖 Deskripsi Singkat

API Sistem Manajemen Hotel dan Reservasi Kamar adalah layanan Web Service berbasis RESTful API yang dibangun menggunakan Laravel dan JWT Authentication. Sistem ini dirancang untuk memudahkan proses operasional hotel dan pemesanan kamar secara digital dan terintegrasi.

### Fitur Utama

* 🔐 Autentikasi pengguna menggunakan JWT (Register, Login, Logout, Me)
* 🏨 Manajemen data hotel (CRUD)
* 🛏️ Manajemen data kamar (CRUD)
* 🔍 Pencarian dan validasi ketersediaan kamar secara real-time
* 🛒 Transaksi booking dan pembatalan reservasi
* 📅 Perhitungan tarif otomatis menggunakan Carbon
* 📝 Log aktivitas otomatis setiap request tercatat ke database melalui Middleware

---

## ⚙️ Cara Menjalankan Sistem

### Persyaratan

* PHP >= 8.2
* Composer
* MySQL
* Laravel Herd / XAMPP / Laragon

### Langkah-langkah

### 1. Clone Repository

```bash
git clone https://github.com/2301040018-prog/Uas_web_service_smt6.git
cd uas_web_service
```

### 2. Install Dependency

```bash
composer install
```

### 3. Salin File Konfigurasi

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi File .env

Buka file `.env` dan sesuaikan bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_service_uas
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 7. Jalankan Migrasi dan Seeder

```bash
php artisan migrate --seed
```

### 8. Jalankan Server

```bash
php artisan serve
```

Server akan berjalan pada:

```text
http://uas_ws_smt6.test
```

---

## 👤 Informasi Pengujian

Sistem tidak menyediakan akun bawaan untuk pengujian. Pengguna harus melakukan registrasi terlebih dahulu sebelum dapat mengakses fitur yang memerlukan autentikasi.

### Registrasi Akun

| Method | Endpoint           |
| ------ | ------------------ |
| POST   | /api/auth/register |

Setelah registrasi berhasil, lakukan login menggunakan email dan password yang telah didaftarkan.

### Login

| Method | Endpoint        |
| ------ | --------------- |
| POST   | /api/auth/login |

Login yang berhasil akan menghasilkan JWT Token yang digunakan sebagai **Bearer Token** pada header Authorization untuk mengakses endpoint yang memerlukan autentikasi.

Contoh:

```text
Authorization: Bearer <token>
```

---

## 📡 Daftar Endpoint

### 🔐 Authentication

| Method | Endpoint           | Keterangan                        |
| ------ | ------------------ | --------------------------------- |
| POST   | /api/auth/register | Registrasi user baru              |
| POST   | /api/auth/login    | Login dan mendapatkan token JWT   |
| POST   | /api/auth/logout   | Logout dan invalidasi token       |
| GET    | /api/auth/me       | Ambil data user yang sedang login |

---

### 🏨 Hotels

| Method | Endpoint         | Keterangan         |
| ------ | ---------------- | ------------------ |
| GET    | /api/hotels      | Daftar semua hotel |
| POST   | /api/hotels      | Tambah hotel baru  |
| GET    | /api/hotels/{id} | Detail hotel       |
| PUT    | /api/hotels/{id} | Update data hotel  |
| DELETE | /api/hotels/{id} | Hapus hotel        |

---

### 🛏️ Rooms

| Method | Endpoint        | Keterangan         |
| ------ | --------------- | ------------------ |
| GET    | /api/rooms      | Daftar semua kamar |
| POST   | /api/rooms      | Tambah kamar baru  |
| GET    | /api/rooms/{id} | Detail kamar       |
| PUT    | /api/rooms/{id} | Update data kamar  |
| DELETE | /api/rooms/{id} | Hapus kamar        |

---

### 📋 Bookings

| Method | Endpoint                | Keterangan                       |
| ------ | ----------------------- | -------------------------------- |
| GET    | /api/auth/bookings      | Daftar seluruh booking           |
| POST   | /api/auth/bookings      | Membuat booking baru             |
| GET    | /api/auth/bookings/{id} | Detail booking                   |
| PUT    | /api/auth/bookings/{id} | Update status booking            |
| DELETE | /api/auth/bookings/{id} | Hapus booking                    |
| GET    | /api/auth/my-bookings   | Riwayat booking milik user login |

---

## 📄 Dokumentasi API

Dokumentasi lengkap endpoint tersedia secara online melalui tautan berikut:

🔗 **Tambahkan Link Postman Collection di sini**

Dokumentasi mencakup detail endpoint, method, parameter, contoh request, dan contoh response untuk seluruh fitur sistem.

---

## 🛠️ Teknologi yang Digunakan

| Teknologi | Keterangan                                           |
| --------- | ---------------------------------------------------- |
| Laravel   | Framework PHP untuk membangun RESTful API            |
| MySQL     | Database untuk menyimpan data sistem                 |
| JWT Auth  | Autentikasi berbasis JSON Web Token (tymon/jwt-auth) |
| Postman   | Tools untuk testing dan dokumentasi API              |
| GitHub    | Version control dan kolaborasi tim                   |

---

## 👨‍💻 Tim Pengembang

| Nama                 | NIM        | Tugas                                                                                                                    |
| -------------------- | ---------- | ------------------------------------------------------------------------------------------------------------------------ |
| Duwik                | 2301040018 | Arsitektur sistem, JWT Authentication, Endpoint Auth, Endpoint Booking, validasi booking dan perhitungan tarif otomatis. |
| Baiq Alia Zulifianti | 2301040032 | Endpoint Hotel, Endpoint Room, relasi database, Middleware Activity Log, dan pengujian API.                              |

---

### Proyek UAS Mata Kuliah Web Service Genap 2025/2026 | Universitas Bumigora
