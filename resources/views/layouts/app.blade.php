<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Movie App')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Konfigurasi Tailwind Kustom (Custom Tailwind Configuration) -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            500: '#6366f1', // Indigo Themed
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* CSS Kustom Tambahan (Additional Custom CSS) */
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Animasi Fade In (Fade In Animation) */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Styling Scrollbar Kustom (Custom Scrollbar Styling) */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #c7c7c7;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">
    <!-- Navigasi (Navigation) -->
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-gray-100 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo & Menu Kiri -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('movies.index') }}" class="flex items-center space-x-2 group">
                        <div class="w-10 h-10 bg-primary-600 rounded-xl flex items-center justify-center text-white text-xl shadow-lg shadow-primary-500/30 group-hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-play"></i>
                        </div>
                        <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-primary-600 to-primary-700">
                            {{ __('messages.app_name') }}
                        </span>
                    </a>

                    <div class="hidden md:flex space-x-1">
                        <a href="{{ route('movies.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200 font-medium {{ request()->routeIs('movies.*') ? 'text-primary-600 bg-primary-50' : '' }}">
                            {{ __('messages.movies') }}
                        </a>
                        <a href="{{ route('favorites.index') }}" class="px-4 py-2 rounded-lg text-gray-600 hover:text-primary-600 hover:bg-primary-50 transition-all duration-200 font-medium {{ request()->routeIs('favorites.*') ? 'text-primary-600 bg-primary-50' : '' }}">
                            {{ __('messages.favorites') }}
                        </a>
                    </div>
                </div>

                <!-- Menu Kanan (Right Menu) -->
                <div class="flex items-center space-x-4">
                    <!-- Pengalih Bahasa (Language Switcher) -->
                    <div class="flex bg-gray-100 p-1 rounded-lg">
                        <a href="{{ route('language.switch', 'en') }}" class="px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 {{ app()->getLocale() == 'en' ? 'bg-white text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">EN</a>
                        <a href="{{ route('language.switch', 'id') }}" class="px-3 py-1 text-xs font-medium rounded-md transition-all duration-200 {{ app()->getLocale() == 'id' ? 'bg-white text-primary-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">ID</a>
                    </div>

                    @if(session('authenticated'))
                    <form method="POST" action="{{ route('logout') }}" class="inline-flex items-center m-0">
                        @csrf
                        <button type="submit" class="flex items-center space-x-2 px-4 py-1.5 rounded-lg text-red-500 hover:bg-red-50 hover:text-red-600 transition-colors duration-200 font-medium text-sm leading-none">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>{{ __('messages.logout') }}</span>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Konten Utama (Main Content) -->
    <main class="flex-grow py-10 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto w-full fade-in">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-100 py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-500 text-sm">
                &copy; {{ date('Y') }} {{ __('messages.app_name') }}. {{ __('messages.footer_made_with') }} <i class="fas fa-heart text-red-400 mx-1"></i> {{ __('messages.footer_by') }} Kevin.
            </p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Skrip Notifikasi SweetAlert2 (SweetAlert2 Notification Scripts) -->
    <div id="flash-messages"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-title-success="{{ __('messages.success') }}"
        data-title-error="{{ __('messages.oops') }}"
        style="display: none;"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil data dari elemen HTML untuk menghindari error linter JS
            // (Get data from HTML element to avoid JS linter errors)
            const flashElement = document.getElementById('flash-messages');
            const flashSuccess = flashElement.dataset.success;
            const flashError = flashElement.dataset.error;
            const titleSuccess = flashElement.dataset.titleSuccess;
            const titleError = flashElement.dataset.titleError;

            // Notifikasi Sukses
            if (flashSuccess) {
                Swal.fire({
                    icon: 'success',
                    title: titleSuccess,
                    text: flashSuccess,
                    confirmButtonColor: '#4f46e5',
                    timer: 3000,
                    timerProgressBar: true,
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-2.5'
                    }
                });
            }

            // Notifikasi Error
            if (flashError) {
                Swal.fire({
                    icon: 'error',
                    title: titleError,
                    text: flashError,
                    confirmButtonColor: '#ef4444',
                    customClass: {
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-2.5'
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>