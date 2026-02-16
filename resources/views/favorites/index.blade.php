@extends('layouts.app')

@section('title', 'Favorites - Movie App')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <h1 class="text-3xl font-bold mb-8">{{ __('messages.my_favorites') }}</h1>
    
    @if($favorites->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($favorites as $favorite)
                <div class="movie-card bg-white rounded-lg shadow-lg overflow-hidden relative group">
                    <!-- Remove Button -->
                    <button onclick="removeFavorite('{{ $favorite->imdb_id }}')"
                            class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10">
                        <i class="fas fa-times"></i>
                    </button>
                    
                    <!-- Poster -->
                    <div class="relative pb-[150%] overflow-hidden bg-gray-200">
                        @if($favorite->poster)
                            <img src="{{ $favorite->poster }}" 
                                 alt="{{ $favorite->title }}"
                                 class="absolute inset-0 w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-gray-500">No Poster</span>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Info -->
                    <div class="p-4">
                        <h3 class="font-bold text-lg mb-2 truncate">{{ $favorite->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ $favorite->year }}</p>
                        <p class="text-gray-500 text-xs mb-4">{{ $favorite->type }}</p>
                        <a href="{{ route('movies.show', $favorite->imdb_id) }}" 
                           class="inline-block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                            {{ __('messages.details') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="text-8xl mb-6">⭐</div>
            <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ __('messages.no_favorites') }}</h2>
            <p class="text-xl text-gray-600 mb-8">{{ __('messages.start_searching') }}</p>
            <a href="{{ route('movies.index') }}" 
               class="inline-block bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-8 rounded-lg transition duration-300 text-lg">
                <i class="fas fa-search mr-2"></i>{{ __('messages.search_movies') }}
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function removeFavorite(imdbId) {
    if (confirm('Are you sure you want to remove this movie from favorites?')) {
        $.ajax({
            url: `/favorites/${imdbId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    }
}
</script>
@endpush