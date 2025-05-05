# 🌐 SilangProject

**SilangProject** adalah aplikasi manajemen proyek dan tugas berbasis web yang dibangun dengan stack modern — **React.js + ShadCN UI** di frontend, dan **Laravel** sebagai backend lengkap dengan autentikasi dan fitur CRUD. Fokus utamanya adalah kesederhanaan, efisiensi, dan keindahan antarmuka.

## 🚀 Tech Stack

- **Frontend:** React.js (Vite), ShadCN UI, TailwindCSS
- **Backend:** Laravel 10+, Sanctum untuk autentikasi API
- **Database:** MySQL / PostgreSQL (sesuai konfigurasi Laravel)

## 🔐 Fitur Utama

- **Autentikasi Aman:** Menggunakan Laravel Sanctum (login, register, logout)
- **CRUD Pengguna:** Tambah, ubah, hapus, dan lihat data pengguna
- **CRUD Proyek:** Kelola proyek dengan deskripsi, status, dan waktu mulai
- **CRUD Tugas:** Hubungkan tugas ke proyek, tetapkan ke pengguna, dan atur deadline
- **Responsive Design:** Antarmuka bersih dan ringan untuk desktop maupun mobile

## 🧩 Struktur Proyek

### Frontend (`/frontend`)

- Dibuat dengan React + Vite
- Komponen UI menggunakan ShadCN (berbasis Radix UI + Tailwind)
- Mengakses backend melalui `fetch` / `axios` dengan autentikasi token

### Backend (`/backend`)

- Laravel REST API
- Resource routes untuk `User`, `Project`, dan `Task`
- Validasi otomatis dan respons JSON yang konsisten
- Middleware autentikasi via Sanctum

## 🛠️ Instalasi

### Backend

```bash
cd backend
composer install
php artisan migrate
php artisan serve
