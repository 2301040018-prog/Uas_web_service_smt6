

<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

# 🏨 API Sistem Manajemen Hotel dan Reservasi Kamar

RESTful API untuk pengelolaan sistem reservasi hotel yang mencakup manajemen data hotel, data kamar, pencarian ketersediaan kamar, transaksi booking, dan riwayat pemesanan pengguna.

---

## 📖 Deskripsi Singkat

API Sistem Manajemen Hotel dan Reservasi Kamar adalah layanan Web Service berbasis RESTful API yang dibangun menggunakan Laravel dan JWT Authentication. Sistem ini dirancang untuk memudahkan proses operasional hotel dan pemesanan kamar secara digital dan terintegrasi.

### ✨ Fitur Utama

* 🔐 Autentikasi pengguna menggunakan JWT (Register, Login, Logout, Me)
* 🏨 Manajemen data hotel (CRUD)
* 🛏️ Manajemen data kamar (CRUD)
* 🔍 Pencarian dan validasi ketersediaan kamar secara real-time
* 🛒 Transaksi booking dan pembatalan reservasi
* 📅 Perhitungan tarif otomatis menggunakan Carbon
* 📝 Log aktivitas otomatis menggunakan Middleware

---

## ⚙️ Cara Menjalankan Sistem

### Persyaratan

* PHP >= 8.2
* Composer
* MySQL
* Laravel Herd / XAMPP / Laragon

### 1. Clone Repository

```bash
git clone https://github.com/username/Uas_Web_Service.git
cd Uas_Web_Service
```

### 2. Install Dependency

```bash
composer install
```

### 3. Salin File Environment

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_manajemen_hotel
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
http://127.0.0.1:8000
```

---

## 👤 Akun Uji Coba

Setelah menjalankan seeder, akun berikut tersedia untuk pengujian:

| Role       | Email                                 | Password    |
| ---------- | ------------------------------------- | ----------- |
| Admin/User | [eka@gmail.com](mailto:eka@gmail.com) | password123 |

### Cara Login

Kirim request:

```http
POST /api/auth/login
```

Gunakan email dan password di atas, kemudian simpan token JWT yang diperoleh dan gunakan sebagai Bearer Token pada endpoint yang memerlukan autentikasi.

---

# 📡 Daftar Endpoint API

## 🔐 Authentication

| Method | Endpoint           | Keterangan                  |
| ------ | ------------------ | --------------------------- |
| POST   | /api/auth/register | Registrasi user baru        |
| POST   | /api/auth/login    | Login dan mendapatkan JWT   |
| POST   | /api/auth/logout   | Logout user                 |
| GET    | /api/auth/me       | Menampilkan data user login |

---

## 🏨 Hotels

| Method | Endpoint         | Keterangan                |
| ------ | ---------------- | ------------------------- |
| GET    | /api/hotels      | Menampilkan seluruh hotel |
| POST   | /api/hotels      | Menambahkan hotel baru    |
| GET    | /api/hotels/{id} | Detail hotel              |
| PUT    | /api/hotels/{id} | Update data hotel         |
| DELETE | /api/hotels/{id} | Hapus data hotel          |

---

## 🛏️ Rooms

| Method | Endpoint        | Keterangan                |
| ------ | --------------- | ------------------------- |
| GET    | /api/rooms      | Menampilkan seluruh kamar |
| POST   | /api/rooms      | Menambahkan kamar         |
| GET    | /api/rooms/{id} | Detail kamar              |
| PUT    | /api/rooms/{id} | Update data kamar         |
| DELETE | /api/rooms/{id} | Hapus data kamar          |

---

## 📋 Bookings

> Endpoint berikut memerlukan Bearer Token.

| Method | Endpoint                | Keterangan                  |
| ------ | ----------------------- | --------------------------- |
| GET    | /api/auth/bookings      | Menampilkan seluruh booking |
| POST   | /api/auth/bookings      | Membuat booking baru        |
| GET    | /api/auth/bookings/{id} | Detail booking              |
| PUT    | /api/auth/bookings/{id} | Update status booking       |
| DELETE | /api/auth/bookings/{id} | Hapus booking               |
| GET    | /api/auth/my-bookings   | Riwayat booking user login  |

---

## 📄 Dokumentasi API

Dokumentasi lengkap endpoint dan Postman Collection dapat diakses melalui:

🔗 **Tambahkan Link Postman Collection di sini**

Contoh:

```text
https://documenter.getpostman.com/view/xxxxxx
```

---

# 🛠️ Teknologi yang Digunakan

| Teknologi | Keterangan                             |
| --------- | -------------------------------------- |
| Laravel   | Framework PHP untuk REST API           |
| MySQL     | Database Management System             |
| JWT Auth  | Autentikasi menggunakan JSON Web Token |
| Postman   | Pengujian API                          |
| GitHub    | Version Control dan Kolaborasi Tim     |

---

# 👨‍💻 Tim Pengembang

| Nama           | NIM        | Tugas                                                                        |
| -------------- | ---------- | ---------------------------------------------------------------------------- |
| Eka Putra      | 230104XXXX | Pengembangan Arsitektur Sistem, Endpoint Auth, Booking Logic, Optimasi Query |
| Rekan Kelompok | 230104XXXX | CRUD Hotel & Kamar, Relasi Database, Middleware Log Aktivitas                |

---

## 📜 Lisensi

Project ini dibuat untuk memenuhi tugas mata kuliah **Web Service** Program Studi Rekayasa Perangkat Lunak.

© 2026 Kelompok API Sistem Manajemen Hotel dan Reservasi Kamar
