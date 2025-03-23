@section("title","Show - ". $show["original_name"])
<x-app-layout>
    <div class="min-h-screen">
        <div class="flex flex-col items-center space-y-6 md:flex-row">
                <img class="bg-red-400 h-[400px] w-[300px] flex-2"
                    alt="Show Banner"
                    src="{{ config("services.tmdb.img_url") . "/w500/" . $show['poster_path'] }}"
                ></img>
            <div class="flex-1 ps-4 space-y-2 text-gray-200">
                <p class="text-5xl text-gray-50 text-semibold">{{$show["original_name"]}} <span class="text-2xl">({{ \Carbon\Carbon::parse($show["first_air_date"])->format('M Y') }})</span></p>
                <div class="flex justify-between border-b border-t-gray-100">
                    <p class="text-gray-200">Seasons: <span>{{$show["number_of_seasons"]}}</span></p>
                    <p class="text-gray-200">Episodes: <span>{{$show["number_of_episodes"]}}</span></p>
                    <p>Rating: <span>{{round($show["vote_average"],2)}}</span> ({{$show["vote_count"]}})</p>
                </div>

                <p class="pt-6 border-b border-b-gray-100 pb-2">
                    {{$show["overview"]}}
                </p>
                
                <div class="space-y-2 pt-6">
                    <div class="text-md"><span>Creator:</span>
                        @forelse ($show["created_by"] as $creator)
                            <span>{{ $creator["name"] }}@if(!$loop->last),@endif

                            </span>
                        @empty
                            <span>Unknown</span>
                        @endforelse
                    </div>
                    <div class="text-md"><span>Production companies:</span>
                        @forelse ($show["production_companies"] as $company)
                            <span><span class="font-semibold">{{ $company["name"] }}</span> ({{ $company["origin_country"] }})@if(!$loop->last),@endif

                            </span>
                        @empty
                            <span>Unknown</span>
                        @endforelse
                    </div>
                </div>
                <div class="flex justify-between">
                    <div class="flex space-x-2 flex-wrap">
                        <p class="text-md">Genres:</p>
                        @foreach ($show["genres"] as $genre)
                            <x-genre-tag :genre="$genre"/>
                        @endforeach
                    </div>
                    @if(auth()->check())
                        <div class="sm:text-sm md:text-lg">
                            @livewire("add-to-favorite-button",["isMovie" => false,"id" => $show["id"]])  
                        </div>
                    @endif
                    
                </div>
            </div>

        </div>
        
        <hr class="my-6">

        @livewire('show-source', ['showId' => $show["id"],"numberOfSeasons" => $show["number_of_seasons"], "season" => $season])
    </div>
</x-app-layout>