@extends('layouts.app')

@section('title', 'Movies - Movie App')

@section('content')
<div class="space-y-8">
    <!-- Header Bagian (Section Header) -->
    <div class="text-center space-y-4">
        <h1 class="text-4xl font-bold text-gray-900 tracking-tight">{{ __('messages.search_catalog') }}</h1>
        <p class="text-gray-500 max-w-2xl mx-auto">
            {{ __('messages.search_catalog_desc') }}
        </p>
    </div>

    <!-- Formulir Pencarian (Search Form) -->
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/50 p-6 md:p-8 transform transition-all hover:scale-[1.01] duration-300 border border-gray-100">
        <h2 class="text-xl font-bold mb-6 flex items-center text-gray-800">
            <i class="fas fa-search mr-3 text-primary-500"></i>
            {{ __('messages.search_movies') }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            <!-- Input Judul -->
            <div class="md:col-span-6 space-y-2">
                <label class="block text-gray-700 text-sm font-semibold tracking-wide">
                    {{ __('messages.search_placeholder') }}
                </label>
                <div class="relative">
                    <input type="text"
                        id="search-title"
                        placeholder="Contoh: Avengers, Batman..."
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 text-gray-700 placeholder-gray-400">
                    <i class="fas fa-film absolute left-4 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Input Tahun -->
            <div class="md:col-span-3 space-y-2">
                <label class="block text-gray-700 text-sm font-semibold tracking-wide">
                    {{ __('messages.year') }}
                </label>
                <div class="relative">
                    <input type="number"
                        id="search-year"
                        placeholder="YYYY"
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 text-gray-700 placeholder-gray-400">
                    <i class="fas fa-calendar absolute left-4 top-3.5 text-gray-400"></i>
                </div>
            </div>

            <!-- Input Tipe -->
            <div class="md:col-span-3 space-y-2">
                <label class="block text-gray-700 text-sm font-semibold tracking-wide">
                    {{ __('messages.type') }}
                </label>
                <div class="relative">
                    <select id="search-type" class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 text-gray-700 appearance-none cursor-pointer">
                        <option value="">{{ __('messages.all_types') }}</option>
                        <option value="movie">{{ __('messages.movie') }}</option>
                        <option value="series">{{ __('messages.series') }}</option>
                        <option value="episode">{{ __('messages.episode') }}</option>
                    </select>
                    <i class="fas fa-filter absolute left-4 top-3.5 text-gray-400"></i>
                    <i class="fas fa-chevron-down absolute right-4 top-3.5 text-gray-400 pointer-events-none text-xs"></i>
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <button id="search-button"
                class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-8 rounded-xl shadow-lg shadow-primary-500/30 transition-all duration-300 transform hover:-translate-y-0.5 active:translate-y-0 flex items-center">
                <i class="fas fa-search mr-2"></i>{{ __('messages.search_button') }}
            </button>
        </div>
    </div>

    <!-- Grid Film (Movies Grid) -->
    <div id="movies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <!-- Film akan dimuat di sini oleh JavaScript (Movies will be loaded here by JavaScript) -->
    </div>

    <!-- Indikator Loading (Loading Indicator) -->
    <div id="loading" class="hidden text-center py-12">
        <div class="inline-block relative w-16 h-16">
            <div class="loading-spinner"></div>
        </div>
        <p class="mt-4 text-gray-500 font-medium animate-pulse">{{ __('messages.loading') }}</p>
    </div>

    <!-- State Kosong (Empty State) -->
    <div id="empty-state" class="hidden text-center py-20 bg-white rounded-3xl border border-gray-100 shadow-sm">
        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl shadow-inner">🎬</div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('messages.no_results') }}</h3>
        <p class="text-gray-500 max-w-sm mx-auto">{{ __('messages.try_different') }}</p>
    </div>
</div>
@endsection

<!-- Konfigurasi untuk JS (Configuration for JS) -->
<div id="movie-config"
    data-search-route="{{ route('movies.search') }}"
    data-msg-search-placeholder="{{ __('messages.search_placeholder') }}"
    data-msg-loading="{{ __('messages.loading') }}"
    data-msg-no-results="{{ __('messages.no_results') }}"
    data-msg-details="{{ __('messages.details') }}"
    data-msg-error-title="{{ __('messages.error_loading') }}"
    data-msg-error-desc="{{ __('messages.error_loading_desc') }}"
    data-msg-search-empty="{{ __('messages.search_empty_title') }}"
    style="display: none;"></div>

@push('scripts')
<script>
    // Ambil konfigurasi dari DOM (Get configuration from DOM)
    const configElement = document.getElementById('movie-config');
    const config = {
        routes: {
            search: configElement.dataset.searchRoute
        },
        messages: {
            searchPlaceholder: configElement.dataset.msgSearchPlaceholder,
            loading: configElement.dataset.msgLoading,
            noResults: configElement.dataset.msgNoResults,
            details: configElement.dataset.msgDetails,
            errorTitle: configElement.dataset.msgErrorTitle,
            errorDesc: configElement.dataset.msgErrorDesc,
            searchEmpty: configElement.dataset.msgSearchEmpty
        }
    };

    let currentPage = 1;
    let loading = false;
    let hasMore = true;
    let currentSearch = {
        title: '',
        year: '',
        type: ''
    };

    // Fungsi Lazy Load Gambar (Image Lazy Loading Function)
    function lazyLoadImages() {
        const images = document.querySelectorAll('.lazy-image');

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.onload = () => {
                        img.classList.remove('opacity-0', 'scale-95');
                        img.classList.add('opacity-100', 'scale-100');
                        img.parentElement.classList.remove('animate-pulse', 'bg-gray-200');
                    };
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => observer.observe(img));
    }

    // Fungsi Memuat Film (Load Movies Function)
    async function loadMovies(reset = false) {
        if (loading || (!hasMore && !reset)) return;

        if (reset) {
            currentPage = 1;
            hasMore = true;
            $('#movies-grid').empty();
            $('#empty-state').addClass('hidden');
        }

        loading = true;
        $('#loading').removeClass('hidden');

        try {
            const url = new URL(config.routes.search);
            url.searchParams.append('title', currentSearch.title);
            url.searchParams.append('year', currentSearch.year);
            url.searchParams.append('type', currentSearch.type);
            url.searchParams.append('page', currentPage);

            const response = await fetch(url);
            const data = await response.json();

            $('#loading').addClass('hidden');

            if (data.Response === 'True') {
                const movies = data.Search;

                if (movies.length > 0) {
                    movies.forEach(movie => {
                        const poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/300x450?text=No+Poster';

                        // Template Kartu Film Modern (Modern Movie Card Template)
                        const movieCard = `
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-primary-500/10 border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full">
                            <div class="relative w-full pb-[150%] overflow-hidden bg-gray-200 animate-pulse">
                                <img data-src="${poster}" 
                                     alt="${movie.Title}"
                                     class="lazy-image absolute inset-0 w-full h-full object-cover transition-all duration-700 opacity-0 scale-95 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-1 group-hover:text-primary-600 transition-colors">${movie.Title}</h3>
                                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-medium">${movie.Year}</span>
                                    <span>•</span>
                                    <span class="capitalize">${movie.Type}</span>
                                </div>
                                <div class="mt-auto">
                                    <a href="/movies/${movie.imdbID}" 
                                       class="block w-full text-center bg-white border border-gray-200 text-gray-700 font-medium py-2.5 px-4 rounded-xl hover:bg-primary-50 hover:text-primary-600 hover:border-primary-100 transition-all duration-200">
                                        ${config.messages.details}
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;

                        $('#movies-grid').append(movieCard);
                    });

                    lazyLoadImages();

                    currentPage++;
                    hasMore = movies.length === 10; // OMDb returns 10 items per page
                } else {
                    hasMore = false;
                }
            } else {
                if (currentPage === 1) {
                    $('#movies-grid').empty();
                    $('#empty-state').removeClass('hidden');
                }
                hasMore = false;
            }
        } catch (error) {
            console.error('Error loading movies:', error);
            $('#loading').addClass('hidden');
            Swal.fire({
                icon: 'error',
                title: config.messages.errorTitle,
                text: config.messages.errorDesc,
                confirmButtonColor: '#ef4444'
            });
        } finally {
            loading = false;
        }
    }

    // Scroll Tak Terbatas (Infinite Scroll)
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
            loadMovies();
        }
    });

    // Klik Tombol Cari (Search Button Click)
    $('#search-button').click(function() {
        currentSearch = {
            title: $('#search-title').val(),
            year: $('#search-year').val(),
            type: $('#search-type').val()
        };

        if (!currentSearch.title) {
            Swal.fire({
                icon: 'warning',
                title: config.messages.searchEmpty,
                text: config.messages.searchPlaceholder,
                confirmButtonColor: '#f59e0b',
                customClass: {
                    popup: 'rounded-2xl',
                    confirmButton: 'rounded-xl px-6 py-2.5'
                }
            });
            return;
        }

        loadMovies(true);
    });

    // Pencarian saat tekan Enter (Search on Enter Key)
    $('#search-title, #search-year, #search-type').keypress(function(e) {
        if (e.which === 13) {
            $('#search-button').click();
        }
    });

    // Inisialisasi awal (Initial Load)
    $(document).ready(function() {
        $('#search-title').val('Marvel'); // Default search yang lebih menarik
        $('#search-button').click();
    });
</script>
@endpush