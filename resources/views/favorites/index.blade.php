@extends('layouts.app')

@section('title', 'Favorit Saya - Movie App')

@section('content')
<div class="space-y-8">
    <!-- Header Halaman (Page Header) -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">{{ __('messages.my_favorites') }}</h1>
            <p class="text-gray-500 mt-1">{{ __('messages.my_favorites_desc') }}</p>
        </div>
        <a href="{{ route('movies.index') }}" class="inline-flex items-center text-primary-600 font-medium hover:text-primary-700 transition-colors">
            <i class="fas fa-plus-circle mr-2"></i> Tambah Lebih Banyak
        </a>
    </div>

    @if($favorites->count() > 0)
    <!-- Grid Film Favorit (Favorites Movie Grid) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @foreach($favorites as $favorite)
        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-primary-500/10 border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full relative">
            <!-- Tombol Hapus (Remove Button) -->
            <button onclick="confirmRemoveFavorite('{{ $favorite->imdb_id }}', '{{ addslashes($favorite->title) }}')"
                class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-red-500 hover:bg-red-500 hover:text-white rounded-xl w-10 h-10 flex items-center justify-center shadow-lg shadow-black/5 transition-all duration-300 z-20 group-hover:scale-110 active:scale-95"
                title="Hapus dari favorit">
                <i class="fas fa-trash-alt"></i>
            </button>

            <!-- Poster Film -->
            <div class="relative w-full pb-[150%] overflow-hidden bg-gray-100">
                @if($favorite->poster && $favorite->poster !== 'N/A')
                <img src="{{ $favorite->poster }}"
                    alt="{{ $favorite->title }}"
                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 group-hover:scale-105">
                @else
                <div class="absolute inset-0 flex flex-col items-center justify-center bg-gray-50 text-gray-400">
                    <i class="fas fa-image text-4xl mb-2"></i>
                    <span class="text-xs uppercase tracking-widest font-semibold text-gray-400">No Poster</span>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

            <!-- Informasi Film (Movie Info) -->
            <div class="p-5 flex flex-col flex-grow">
                <h3 class="font-bold text-lg text-gray-900 mb-1 line-clamp-1 group-hover:text-primary-600 transition-colors">{{ $favorite->title }}</h3>
                <div class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                    <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-medium">{{ $favorite->year }}</span>
                    <span>•</span>
                    <span class="capitalize">{{ $favorite->type }}</span>
                </div>
                <div class="mt-auto">
                    <a href="{{ route('movies.show', $favorite->imdb_id) }}"
                        class="block w-full text-center bg-white border border-gray-200 text-gray-700 font-medium py-2.5 px-4 rounded-xl hover:bg-primary-50 hover:text-primary-600 hover:border-primary-100 transition-all duration-200">
                        {{ __('messages.details') }}
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <!-- Tampilan Kosong (Empty State) -->
    <div class="text-center py-24 bg-white rounded-3xl border border-gray-100 shadow-sm transition-all duration-500 hover:shadow-md">
        <div class="w-32 h-32 bg-primary-50 rounded-full flex items-center justify-center mx-auto mb-8 text-6xl shadow-inner animate-pulse">
            <i class="fas fa-star text-primary-400 rotate-12"></i>
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900 mb-3 tracking-tight">{{ __('messages.no_favorites') }}</h2>
        <p class="text-gray-500 max-w-sm mx-auto mb-10 leading-relaxed">{{ __('messages.start_searching') }}</p>
        <a href="{{ route('movies.index') }}"
            class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-10 rounded-2xl shadow-lg shadow-primary-500/30 transition-all duration-300 transform hover:-translate-y-1 active:translate-y-0 text-lg">
            <i class="fas fa-search mr-3"></i> {{ __('messages.search_movies') }}
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
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-6 py-2.5',
                cancelButton: 'rounded-xl px-6 py-2.5'
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
                            popup: 'rounded-2xl'
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
                            popup: 'rounded-2xl',
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
                        popup: 'rounded-2xl',
                        confirmButton: 'rounded-xl px-6 py-2.5'
                    }
                });
            }
        });
    }
</script>
@endpush
```