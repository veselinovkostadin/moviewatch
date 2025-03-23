@section("title", "Browse movies")
<div>
        <p class="text-orange-600 text-4xl">{{__('Genres')}}</p>
        <div class="flex flex-wrap space-x-2 space-y-2">
            @foreach($genres as $key => $genre)
                <label class="cursor-pointer">
                    <input 
                        wire:key="{{$key}}"
                        type="checkbox" 
                        wire:model.live="selectedGenre"
                        value="{{ $key }}" 
                        class="hidden"
                    >
                    @if(in_array($key,$selectedGenre))
                        <span class="border border-orange-300 px-2 py-1 rounded-lg text-white hover:border-orange-200 transition ease-in duration-100">
                            {{ $genre["name"] }}
                        </span>
                    @else
                        <span class="border border-orange-400 px-2 py-1 rounded-lg text-orange-400 hover:border-orange-300 transition ease-in duration-100 hover:text-orange-200">
                            {{ $genre["name"] }}
                        </span>
                    @endif
                </label>
            @endforeach

            @if(count($selectedGenre) > 0)
                <svg wire:click="$set('selectedGenre',[])" 
                    class="cursor-pointer"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle><path d="m15 9-6 6"></path><path d="m9 9 6 6"></path>
                </svg>
            @endif
        </div>
  
    <div class="grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 grid-cols-2
        gap-y-6 mt-3">
            @foreach ($movies as $movie)
                <x-movie-card :movie="$movie" :genres="$genres"/>
            @endforeach
    </div>
</div>
