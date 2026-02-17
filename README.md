# 🎬 Aplikasi Film (Movie App)

Aplikasi katalog film modern berbasis Laravel yang memungkinkan pengguna untuk menjelajahi film, mencari judul favorit, dan mengelola daftar tontonan mereka dengan antarmuka yang elegan dan responsif.

## ✨ Fitur Baru (Update UI)

Kami telah melakukan perombakan besar-besaran pada tampilan antarmuka (UI) untuk memberikan pengalaman pengguna terbaik:

- **Modern Light Theme**: Tampilan bersih dan cerah dengan warna primer Indigo yang modern.
- **Desain Responsif**: Tampilan yang optimal di semua perangkat (Desktop, Tablet, Mobile).
- **Interaktif**: Efek hover yang halus, animasi transisi, dan feedback visual yang menarik.
- **Notifikasi Cantik**: Integrasi **SweetAlert2** untuk pesan sukses dan error yang lebih informatif.
- **Font Modern**: Menggunakan Google Font **Poppins** untuk keterbacaan yang lebih baik.

## 🛠 Stack Teknologi

### Backend

- **Framework:** [Laravel 12](https://laravel.com)
- **Bahasa:** PHP 8.2+
- **Database:** MySQL / MariaDB

### Frontend

- **CSS Framework:** [Tailwind CSS](https://tailwindcss.com) (via CDN untuk fleksibilitas)
- **Ikon:** Font Awesome 6
- **Font:** Poppins (Google Fonts)
- **Notifikasi:** SweetAlert2
- **Scripting:** JavaScript (Vanilla + jQuery)

## 🏗 Struktur Proyek

Aplikasi ini mengikuti pola arsitektur **MVC (Model-View-Controller)**:

- **Controllers** (`app/Http/Controllers`): Menangani logika bisnis.
- **Models** (`app/Models`): Representasi data database.
- **Views** (`resources/views`): Antarmuka pengguna (Blade Templates).
- **Routes** (`routes/web.php`): Definisi jalur URL aplikasi.

## 🚀 Cara Menjalankan (Getting Started)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal Anda:

1.  **Clone Repositori**

    ```bash
    git clone <repository-url>
    cd movie-app
    ```

2.  **Instal Dependensi**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database Anda.

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi Database**

    ```bash
    php artisan migrate
    ```

5.  **Jalankan Aplikasi**
    ```bash
    php artisan serve
    ```
    Buka browser dan akses: `http://localhost:8000`

## 📝 Dokumentasi Kode

Sesuai permintaan, seluruh kode baru telah dilengkapi dengan komentar dan dokumentasi dalam **Bahasa Indonesia** untuk memudahkan pengembangan dan pemeliharaan selanjutnya.

## 📄 Lisensi

Aplikasi ini bersifat open-source dan dilisensikan di bawah [MIT license](https://opensource.org/licenses/MIT).

---

Dibuat dengan ❤️ oleh Kevin.
