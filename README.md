# Aplikasi Film (Movie App)

Aplikasi film berbasis Laravel yang memungkinkan pengguna untuk menjelajahi film, mencari, dan mengelola daftar favorit mereka.

## 🛠 Stack Teknologi

### Backend

- **Framework:** [Laravel 12](https://laravel.com)
- **Bahasa:** PHP 8.2+
- **HTTP Client:** GuzzleHTTP
- **Testing:** Pest / PHPUnit

### Frontend

- **Build Tool:** [Vite 6.0](https://vitejs.dev)
- **CSS Framework:** [TailwindCSS 4.0](https://tailwindcss.com)
- **Templating:** Blade
- **HTTP Client:** Axios

## 🏗 Arsitektur

Aplikasi ini mengikuti pola arsitektur standar **MVC (Model-View-Controller)** yang disediakan oleh Laravel.

### Komponen Utama

- **Controllers:** Menangani logika aplikasi dan mengembalikan tampilan (view).
    - `AuthController`: Mengelola autentikasi pengguna (Login/Logout).
    - `MovieController`: Menangani daftar film, pencarian, dan pengambilan detail film.
    - `FavoriteController`: Mengelola daftar film favorit pengguna.
- **Models:** Merepresentasikan struktur data dan berinteraksi dengan database.
    - `User`: Merepresentasikan pengguna aplikasi.
    - `Favorite`: Merepresentasikan hubungan antara pengguna dan film favorit mereka.
- **Views:** Template Blade yang terletak di `resources/views`.
    - Menggunakan tata letak utama (`layouts/app.blade.php`) untuk desain yang konsisten.
    - Komponen untuk elemen UI yang dapat digunakan kembali.
- **Middleware:**
    - `auth.custom`: Middleware kustom untuk melindungi rute yang memerlukan autentikasi.
- **Lokalisasi (Localization):**
    - Mendukung bahasa Inggris (`en`) dan Indonesia (`id`).
    - Logika penggantian bahasa diimplementasikan melalui rute dan session.

## 🚀 Memulai (Getting Started)

1.  **Clone repositori**

    ```bash
    git clone <repository-url>
    cd movie-app
    ```

2.  **Instal dependensi PHP**

    ```bash
    composer install
    ```

3.  **Instal dependensi Node.js**

    ```bash
    npm install
    ```

4.  **Pengaturan Lingkungan (Environment)**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    _Konfigurasikan kredensial database Anda di file `.env`._

5.  **Jalankan Migrasi**

    ```bash
    php artisan migrate
    ```

6.  **Jalankan Aplikasi**
    - Mulai server Laravel:
        ```bash
        php artisan serve
        ```
    - Mulai server pengembangan Vite (di terminal terpisah):
        ```bash
        npm run dev
        ```

## 📝 Fitur

- **Autentikasi Pengguna:** Fungsionalitas login dan logout yang aman.
- **Penjelajahan Film:** Melihat daftar film populer atau yang sedang tren.
- **Pencarian:** Mencari film berdasarkan judul.
- **Favorit:** Menambahkan atau menghapus film dari daftar favorit pribadi.
- **Dukungan Multi-bahasa:** Beralih antara antarmuka bahasa Inggris dan Indonesia.
