@extends('layouts.app')

@section('title', 'Favorit Saya - Movie App')

@push('styles')
<style>
    .stagger-item {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Stagger delay for up to 12 items */
    .stagger-item:nth-child(1) {
        animation-delay: 0.1s;
    }

    .stagger-item:nth-child(2) {
        animation-delay: 0.15s;
    }

    .stagger-item:nth-child(3) {
        animation-delay: 0.2s;
    }

    .stagger-item:nth-child(4) {
        animation-delay: 0.25s;
    }

    .stagger-item:nth-child(5) {
        animation-delay: 0.3s;
    }

    .stagger-item:nth-child(6) {
        animation-delay: 0.35s;
    }

    .stagger-item:nth-child(7) {
        animation-delay: 0.4s;
    }

    .stagger-item:nth-child(8) {
        animation-delay: 0.45s;
    }

    .stagger-item:nth-child(9) {
        animation-delay: 0.5s;
    }

    .stagger-item:nth-child(10) {
        animation-delay: 0.55s;
    }

    .stagger-item:nth-child(11) {
        animation-delay: 0.6s;
    }

    .stagger-item:nth-child(12) {
        animation-delay: 0.65s;
    }
</style>
@endpush

@section('content')
<div class="space-y-10 mb-12">
    <!-- Header Banner Modern (Modern Header Banner) -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-primary-800 rounded-3xl p-8 md:p-12 shadow-2xl shadow-primary-500/20">
        <!-- Elemen Dekoratif (Decorative Elements) -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-64 h-64 bg-black/10 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex flex-col md:flex-row items-center gap-6 text-center md:text-left">
                <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center text-4xl text-white shadow-inner animate-float">
                    <i class="fas fa-heart"></i>
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight mb-2">
                        {{ __('messages.my_favorites') }}
                    </h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                        <p class="text-primary-100 text-lg opacity-90">{{ __('messages.my_favorites_desc') }}</p>
                        @if($favorites->count() > 0)
                        <span class="inline-flex items-center px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full border border-white/20">
                            <i class="fas fa-layer-group mr-1.5"></i> {{ $favorites->count() }} {{ $favorites->count() > 1 ? __('messages.stats_movies') : __('messages.movie') }}
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <a href="{{ route('movies.index') }}" class="group inline-flex items-center px-6 py-3 bg-white text-primary-600 font-bold rounded-xl shadow-lg hover:bg-primary-50 hover:-translate-y-1 transition-all duration-300">
                <i class="fas fa-plus-circle mr-2 group-hover:rotate-90 transition-transform duration-500"></i> {{ __('messages.add_more') }}
            </a>
        </div>
    </div>

    @if($favorites->count() > 0)
    <!-- Grid Film Favorit (Favorites Movie Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($favorites as $favorite)
        <div class="stagger-item group bg-white rounded-3xl shadow-sm hover:shadow-2xl hover:shadow-primary-500/15 border border-gray-100 overflow-hidden transition-all duration-500 transform flex flex-col h-full relative">

            <!-- Badge Tipe & Rating (Type & Rating Badge) -->
            <div class="absolute top-4 left-4 z-20 flex flex-col gap-2">
                <span class="px-3 py-1 bg-white/90 backdrop-blur-md text-primary-600 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm border border-primary-100/50">
                    {{ $favorite->type }}
                </span>
            </div>

            <!-- Tombol Hapus (Remove Button) -->
            <button onclick="confirmRemoveFavorite('{{ $favorite->imdb_id }}', '{{ addslashes($favorite->title) }}')"
                class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-red-500 hover:bg-red-500 hover:text-white rounded-xl w-10 h-10 flex items-center justify-center shadow-lg shadow-black/5 transition-all duration-300 z-20 group-hover:scale-110 active:scale-95 border border-red-100"
                title="{{ __('messages.remove_from_favorites') }}">
                <i class="fas fa-trash-alt"></i>
            </button>

            <!-- Poster Film -->
            <div class="relative w-full pb-[150%] overflow-hidden bg-gray-100">
                @if($favorite->poster && $favorite->poster !== 'N/A')
                <div class="absolute inset-0 bg-gray-200 animate-pulse"></div>
                <img src="{{ $favorite->poster }}"
                    alt="{{ $favorite->title }}"
                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                    onload="this.previousElementSibling.remove()">
                @else
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50 text-gray-400">
                    <i class="fas fa-image text-4xl mb-2"></i>
                    <span class="text-xs uppercase tracking-widest font-semibold text-gray-400">No Poster</span>
                </div>
                @endif

                <!-- Overlay Hover -->
                <div class="absolute inset-0 bg-gradient-to-t from-primary-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500 flex flex-col justify-end p-6">
                    <span class="text-white/70 text-sm font-medium mb-1">{{ $favorite->year }}</span>
                    <h4 class="text-white font-bold text-lg leading-tight">{{ $favorite->title }}</h4>
                </div>
            </div>

            <!-- Informasi Film (Movie Info) -->
            <div class="p-6 flex flex-col flex-grow bg-white">
                <div class="mb-5 flex-grow">
                    <h3 class="font-bold text-lg text-gray-900 line-clamp-2 group-hover:text-primary-600 transition-colors leading-snug">
                        {{ $favorite->title }}
                    </h3>
                    <div class="flex items-center mt-2 space-x-3 text-gray-500">
                        <span class="flex items-center text-xs">
                            <i class="far fa-calendar-alt mr-1.5 text-primary-400"></i> {{ $favorite->year }}
                        </span>
                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                        <span class="flex items-center text-xs capitalize">
                            <i class="fas fa-film mr-1.5 text-primary-400"></i> {{ $favorite->type }}
                        </span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-50">
                    <a href="{{ route('movies.show', $favorite->imdb_id) }}"
                        class="flex items-center justify-center w-full bg-primary-50 text-primary-600 font-bold py-3 px-4 rounded-xl hover:bg-primary-600 hover:text-white transition-all duration-300 group/btn">
                        <span>{{ __('messages.details') }}</span>
                        <i class="fas fa-arrow-right ml-2 group-hover/btn:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Tampilan Kosong (Empty State) -->
    <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm transition-all duration-500 hover:shadow-xl hover:shadow-primary-500/5">
        <div class="relative inline-block mb-8">
            <div class="w-32 h-32 bg-primary-50 rounded-full flex items-center justify-center text-6xl shadow-inner group overflow-hidden">
                <i class="fas fa-star text-primary-400 animate-float translate-x-1 translate-y-1"></i>
                <div class="absolute inset-0 bg-gradient-to-tr from-primary-500/10 to-transparent"></div>
            </div>
            <div class="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center border border-gray-100 animate-bounce">
                <i class="fas fa-plus text-primary-600 text-xs"></i>
            </div>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">{{ __('messages.no_favorites') }}</h2>
        <p class="text-gray-500 max-w-sm mx-auto mb-10 leading-relaxed text-lg">{{ __('messages.start_searching') }}</p>
        <a href="{{ route('movies.index') }}"
            class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg shadow-primary-500/30 transition-all duration-300 transform hover:-translate-y-1 active:translate-y-0 text-lg group">
            <i class="fas fa-search mr-3 group-hover:scale-110 transition-transform"></i> {{ __('messages.search_movies') }}
        </a>
    </div>
    @endif
</div>

<!-- Konfigurasi untuk JS (Configuration for JS) -->
<div id="favorites-config"
    data-msg-confirm-title="{{ __('messages.remove_favorite_confirm_title') }}"
    data-msg-confirm-text="{{ __('messages.remove_favorite_confirm_text') }}"
    data-msg-yes="{{ __('messages.remove_favorite_yes') }}"
    data-msg-cancel="{{ __('messages.remove_favorite_cancel') }}"
    data-msg-success="{{ __('messages.remove_favorite_success') }}"
    data-msg-processing="{{ __('messages.processing') }}"
    data-msg-error-title="{{ __('messages.oops') }}"
    data-msg-error-desc="{{ __('messages.favorite_remove_failed') }}"
    data-msg-server-error="{{ __('messages.server_error') }}"
    style="display: none;"></div>

@push('scripts')
<script>
    /**
     * Fungsi Konfirmasi Hapus Favorit (Confirm Remove Favorite Function)
     * Menggunakan SweetAlert2 untuk konfirmasi agar senada dengan UI aplikasi
     */
    function confirmRemoveFavorite(imdbId, title) {
        const config = document.getElementById('favorites-config').dataset;
        const confirmText = config.msgConfirmText.replace(':title', title);

        Swal.fire({
            title: config.msgConfirmTitle,
            text: confirmText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: config.msgYes,
            cancelButtonText: config.msgCancel,
            customClass: {
                popup: 'rounded-3xl p-8',
                confirmButton: 'rounded-xl px-8 py-3 font-bold',
                cancelButton: 'rounded-xl px-8 py-3 font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                removeFavorite(imdbId);
            }
        });
    }

    /**
     * Fungsi Eksekusi Hapus Favorit (Execute Remove Favorite Function)
     */
    function removeFavorite(imdbId) {
        const config = document.getElementById('favorites-config').dataset;

        // Tampilkan loading state
        Swal.fire({
            title: config.msgProcessing,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            customClass: {
                popup: 'rounded-3xl'
            }
        });

        $.ajax({
            url: `/favorites/${imdbId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: config.msgSuccess,
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-3xl'
                        }
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: config.msgErrorTitle,
                        text: config.msgErrorDesc,
                        confirmButtonColor: '#4f46e5',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-xl px-6 py-2.5'
                        }
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: config.msgErrorTitle,
                    text: config.msgServerError,
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-3xl',
                        confirmButton: 'rounded-xl px-6 py-2.5'
                    }
                });
            }
        });
    }
</script>
@endpush
@endsection