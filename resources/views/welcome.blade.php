<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Movie App') }}</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                            200: '#c7d2fe',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                        }
                    },
                    animation: {
                        'blob': 'blob 7s infinite',
                        'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                    },
                    keyframes: {
                        blob: {
                            '0%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                            '33%': {
                                transform: 'translate(30px, -50px) scale(1.1)'
                            },
                            '66%': {
                                transform: 'translate(-20px, 20px) scale(0.9)'
                            },
                            '100%': {
                                transform: 'translate(0px, 0px) scale(1)'
                            },
                        },
                        fadeInUp: {
                            '0%': {
                                opacity: '0',
                                transform: 'translateY(20px)'
                            },
                            '100%': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        }
                    }
                }
            }
        }
    </script>

    <style>
        .hero-pattern {
            background-color: #f9fafb;
            background-image: radial-gradient(#e5e7eb 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>

<body class="antialiased text-gray-800 hero-pattern min-h-screen flex items-center justify-center overflow-hidden">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex flex-col md:flex-row items-center gap-12 relative z-10">
        <!-- Text Content -->
        <div class="md:w-1/2 text-center md:text-left space-y-8 animate-fade-in-up">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary-50 text-primary-600 text-sm font-medium mb-4 ring-1 ring-primary-100">
                <span class="flex h-2 w-2 rounded-full bg-primary-600 mr-2 animate-pulse"></span>
                {{ __('messages.hero_badge') }}
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight text-gray-900 leading-tight">
                {{ __('messages.hero_title_1') }} <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary-600 to-primary-500">
                    {{ __('messages.hero_title_2') }}
                </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-600 max-w-lg mx-auto md:mx-0 leading-relaxed">
                {{ __('messages.hero_description') }}
            </p>

            <div class="flex flex-col sm:flex-row items-center gap-4 justify-center md:justify-start">
                <a href="{{ route('movies.index') }}" class="px-8 py-4 bg-primary-600 text-white rounded-xl font-semibold shadow-lg shadow-primary-500/30 hover:bg-primary-700 hover:-translate-y-1 transition-all duration-300 w-full sm:w-auto text-center flex items-center justify-center group">
                    <i class="fas fa-play-circle mr-2 group-hover:scale-110 transition-transform"></i> {{ __('messages.start_browsing') }}
                </a>

                @if (Route::has('login'))
                @auth
                <a href="{{ url('/home') }}" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 w-full sm:w-auto text-center shadow-sm">
                    {{ __('messages.dashboard') }}
                </a>
                @else
                <a href="{{ route('login') }}" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-semibold hover:bg-gray-50 hover:border-gray-300 transition-all duration-300 w-full sm:w-auto text-center shadow-sm">
                    {{ __('messages.login') }}
                </a>
                @endauth
                @endif
            </div>

            <div class="pt-8 flex items-center justify-center md:justify-start gap-8 text-gray-400 border-t border-gray-200 mt-8">
                <div class="flex flex-col items-center md:items-start group cursor-default">
                    <span class="text-3xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">10k+</span>
                    <span class="text-sm font-medium">{{ __('messages.stats_movies') }}</span>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="flex flex-col items-center md:items-start group cursor-default">
                    <span class="text-3xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">5k+</span>
                    <span class="text-sm font-medium">{{ __('messages.stats_series') }}</span>
                </div>
                <div class="h-8 w-px bg-gray-200"></div>
                <div class="flex flex-col items-center md:items-start group cursor-default">
                    <span class="text-3xl font-bold text-gray-900 group-hover:text-primary-600 transition-colors">Fast</span>
                    <span class="text-sm font-medium">{{ __('messages.stats_search') }}</span>
                </div>
            </div>
        </div>

        <!-- Image/Illustration -->
        <div class="md:w-1/2 relative hidden md:block">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-72 h-72 bg-purple-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-primary-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-72 h-72 bg-pink-100 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>

            <div class="relative transform rotate-3 hover:rotate-0 transition-all duration-700 ease-out">
                <div class="bg-white p-2 rounded-3xl shadow-2xl">
                    <div class="rounded-2xl overflow-hidden bg-gray-900 aspect-[4/3] flex items-center justify-center group relative shadow-inner">
                        <div class="absolute inset-0 bg-gradient-to-br from-gray-800 to-black opacity-90"></div>

                        <!-- Floating Items -->
                        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 text-center text-white z-10">
                            <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-full flex items-center justify-center mx-auto mb-6 border border-white/20 group-hover:scale-110 transition-transform duration-500 shadow-xl shadow-primary-500/20">
                                <i class="fas fa-search text-4xl text-white"></i>
                            </div>
                            <h3 class="text-3xl font-bold mb-2">{{ __('messages.find_movie') }}</h3>
                            <p class="text-white/60">{{ __('messages.find_movie_desc') }}</p>
                        </div>

                        <!-- Decorative Elements -->
                        <i class="fas fa-film absolute text-8xl text-white/5 bottom-[-20px] left-[-20px] rotate-[-15deg]"></i>
                        <i class="fas fa-video absolute text-6xl text-white/5 top-[20px] right-[20px] rotate-[15deg]"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</body>

</html>