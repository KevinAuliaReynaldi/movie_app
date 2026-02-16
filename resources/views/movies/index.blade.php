@extends('layouts.app')

@section('title', 'Movies - Movie App')

@section('content')
<div class="max-w-7xl mx-auto px-4">
    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold mb-6">{{ __('messages.search_movies') }}</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="md:col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('messages.search_placeholder') }}
                </label>
                <input type="text" 
                       id="search-title" 
                       placeholder="{{ __('messages.search_placeholder') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('messages.year') }}
                </label>
                <input type="number" 
                       id="search-year" 
                       placeholder="YYYY"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
            </div>
            
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">
                    {{ __('messages.type') }}
                </label>
                <select id="search-type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                    <option value="">{{ __('messages.all_types') }}</option>
                    <option value="movie">{{ __('messages.movie') }}</option>
                    <option value="series">{{ __('messages.series') }}</option>
                    <option value="episode">{{ __('messages.episode') }}</option>
                </select>
            </div>
        </div>
        
        <div class="mt-4">
            <button id="search-button" 
                    class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                <i class="fas fa-search mr-2"></i>{{ __('messages.search_button') }}
            </button>
        </div>
    </div>
    
    <!-- Movies Grid -->
    <div id="movies-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <!-- Movies will be loaded here -->
    </div>
    
    <!-- Loading Indicator -->
    <div id="loading" class="hidden text-center py-8">
        <div class="loading-spinner mx-auto"></div>
        <p class="mt-4 text-gray-600">{{ __('messages.loading') }}</p>
    </div>
    
    <!-- Empty State -->
    <div id="empty-state" class="hidden text-center py-16">
        <div class="text-6xl mb-4">🎬</div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">{{ __('messages.no_results') }}</h3>
        <p class="text-gray-600">{{ __('messages.try_different') }}</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
let currentPage = 1;
let loading = false;
let hasMore = true;
let currentSearch = {
    title: '',
    year: '',
    type: ''
};

// Lazy load images
function lazyLoadImages() {
    const images = document.querySelectorAll('.lazy-image');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.add('loaded');
                observer.unobserve(img);
            }
        });
    });
    
    images.forEach(img => observer.observe(img));
}

// Load movies
async function loadMovies(reset = false) {
    if (loading || (!hasMore && !reset)) return;
    
    if (reset) {
        currentPage = 1;
        hasMore = true;
        $('#movies-grid').empty();
    }
    
    loading = true;
    $('#loading').removeClass('hidden');
    
    try {
        const response = await fetch(`{{ route("movies.search") }}?title=${encodeURIComponent(currentSearch.title)}&year=${currentSearch.year}&type=${currentSearch.type}&page=${currentPage}`);
        const data = await response.json();
        
        $('#loading').addClass('hidden');
        
        if (data.Response === 'True') {
            const movies = data.Search;
            
            if (movies.length > 0) {
                movies.forEach(movie => {
                    const poster = movie.Poster !== 'N/A' ? movie.Poster : 'https://via.placeholder.com/300x450?text=No+Poster';
                    
                    const movieCard = `
                        <div class="movie-card bg-white rounded-lg shadow-lg overflow-hidden">
                            <div class="relative pb-[150%] overflow-hidden bg-gray-200">
                                <img data-src="${poster}" 
                                     alt="${movie.Title}"
                                     class="lazy-image absolute inset-0 w-full h-full object-cover">
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-2 truncate">${movie.Title}</h3>
                                <p class="text-gray-600 text-sm mb-2">${movie.Year}</p>
                                <p class="text-gray-500 text-xs mb-4">${movie.Type}</p>
                                <a href="/movies/${movie.imdbID}" 
                                   class="inline-block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-300">
                                    {{ __('messages.details') }}
                                </a>
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
    } finally {
        loading = false;
    }
}

// Infinite scroll
$(window).scroll(function() {
    if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
        loadMovies();
    }
});

// Search button click
$('#search-button').click(function() {
    currentSearch = {
        title: $('#search-title').val(),
        year: $('#search-year').val(),
        type: $('#search-type').val()
    };
    
    if (!currentSearch.title) {
        alert('{{ __("messages.search_placeholder") }}');
        return;
    }
    
    $('#empty-state').addClass('hidden');
    loadMovies(true);
});

// Search on enter key
$('#search-title, #search-year, #search-type').keypress(function(e) {
    if (e.which === 13) {
        $('#search-button').click();
    }
});

// Initial load with default search
$(document).ready(function() {
    $('#search-title').val('movie');
    $('#search-button').click();
});
</script>
@endpush