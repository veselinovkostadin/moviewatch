<div 
    class="relative flex-col justify-center items-center h-fit"
    x-data="{ isOpen:false }"
     @click.away="isOpen = false"
    >
    <div>
        <input type="text" class="border-1 border-gray-500 bg-gray-600 h-8 w-64 rounded-lg text-md text-gray-100 focus:outline-none"
            placeholder="Search..."
            wire:model.live.debounce.500ms="search"
            @focus="isOpen = true"
            @keydown="isOpen = true"
            >
    </div>
    @if(strlen($search) > 2)
        <div class="absolute w-64 bg-gray-800 border border-gray-500 rounded-md text-gray-100 mt-2 z-50"
            x-show="isOpen"
            @keydown.escape.window="isOpen = !isOpen"
            x-transition
        >
        @if(count($results) > 0)
                @foreach ($results as $movie)
                    <a href="{{route('movie.show',["movie" => $movie['id']])}}" class="border-b border-gray-600 text-lg py-3 px-1 flex items-center">

                            <img src="{{ config('services.tmdb.img_url') . "w45" . $movie["poster_path"] }}" alt="Movie poster">
                            <span class="text-xl ms-3">{{$movie["original_title"]}} ({{ \Carbon\Carbon::parse($movie["release_date"] ?? "")->format('Y') }})</span>
                        </a>

                    </li>
                @endforeach
        @else
            <div class="py-3 px-2">No results for {{ $search }}</div>
        @endif
        </div>
    @endif
</div>