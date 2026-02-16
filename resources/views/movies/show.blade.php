@extends('layouts.app')

@section('title', $movie['Title'] . ' - Movie App')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Poster -->
            <div class="md:w-1/3">
                @if($movie['Poster'] !== 'N/A')
                    <img src="{{ $movie['Poster'] }}" 
                         alt="{{ $movie['Title'] }}"
                         class="w-full h-auto">
                @else
                    <div class="bg-gray-200 h-full flex items-center justify-center p-8">
                        <span class="text-gray-500">No Poster</span>
                    </div>
                @endif
            </div>
            
            <!-- Details -->
            <div class="md:w-2/3 p-8">
                <div class="flex justify-between items-start mb-6">
                    <h1 class="text-3xl font-bold">{{ $movie['Title'] }} ({{ $movie['Year'] }})</h1>
                    
                    <!-- Favorite Button -->
                    <button id="favorite-btn" 
                            data-imdb-id="{{ $movie['imdbID'] }}"
                            data-title="{{ $movie['Title'] }}"
                            data-year="{{ $movie['Year'] }}"
                            data-type="{{ $movie['Type'] }}"
                            data-poster="{{ $movie['Poster'] !== 'N/A' ? $movie['Poster'] : '' }}"
                            class="px-6 py-2 rounded-lg font-bold transition duration-300 
                                   {{ $movie['is_favorite'] ? 'bg-red-500 hover:bg-red-600 text-white' : 'bg-gray-200 hover:bg-gray-300 text-gray-700' }}">
                        <i class="fas fa-heart mr-2"></i>
                        <span>{{ $movie['is_favorite'] ? __('messages.remove_from_favorites') : __('messages.add_to_favorites') }}</span>
                    </button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h3 class="text-lg font-bold mb-2">{{ __('messages.genre') }}</h3>
                        <p class="text-gray-700 mb-4">{{ $movie['Genre'] ?? 'N/A' }}</p>
                        
                        <h3 class="text-lg font-bold mb-2">{{ __('messages.director') }}</h3>
                        <p class="text-gray-700 mb-4">{{ $movie['Director'] ?? 'N/A' }}</p>
                        
                        <h3 class="text-lg font-bold mb-2">{{ __('messages.actors') }}</h3>
                        <p class="text-gray-700 mb-4">{{ $movie['Actors'] ?? 'N/A' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-bold mb-2">{{ __('messages.plot') }}</h3>
                        <p class="text-gray-700 mb-4">{{ $movie['Plot'] ?? 'N/A' }}</p>
                        
                        <h3 class="text-lg font-bold mb-2">{{ __('messages.rating') }}</h3>
                        <div class="space-y-2">
                            @if(isset($movie['Ratings']))
                                @foreach($movie['Ratings'] as $rating)
                                    <div class="flex items-center">
                                        <span class="text-sm font-medium w-24">{{ $rating['Source'] }}:</span>
                                        <span class="text-sm">{{ $rating['Value'] }}</span>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-gray-700">N/A</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$('#favorite-btn').click(function() {
    const btn = $(this);
    const isFavorite = btn.hasClass('bg-red-500');
    const imdbId = btn.data('imdb-id');
    
    if (isFavorite) {
        // Remove from favorites
        $.ajax({
            url: `/favorites/${imdbId}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    btn.removeClass('bg-red-500 hover:bg-red-600 text-white')
                       .addClass('bg-gray-200 hover:bg-gray-300 text-gray-700');
                    btn.find('span').text('{{ __("messages.add_to_favorites") }}');
                }
            }
        });
    } else {
        // Add to favorites
        $.ajax({
            url: '{{ route("favorites.store") }}',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                imdb_id: imdbId,
                title: btn.data('title'),
                year: btn.data('year'),
                type: btn.data('type'),
                poster: btn.data('poster')
            },
            success: function(response) {
                if (response.success) {
                    btn.removeClass('bg-gray-200 hover:bg-gray-300 text-gray-700')
                       .addClass('bg-red-500 hover:bg-red-600 text-white');
                    btn.find('span').text('{{ __("messages.remove_from_favorites") }}');
                }
            }
        });
    }
});
</script>
@endpush