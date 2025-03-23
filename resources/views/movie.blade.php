@section("title","Movie - ". $movie["original_title"])
<x-app-layout>
    <div class="min-h-screen">
        <div class="flex flex-col items-center space-y-6 md:flex-row">
                <img class="bg-red-400 h-[400px] w-[300px] flex-2"
                    alt="Movie Banner"
                    src="{{ config("services.tmdb.img_url") . "/w500/" . $movie['poster_path'] }}"
                ></img>
            <div class="flex-1 ps-4 space-y-2 text-gray-200">
                <p class="text-5xl text-gray-50 text-semibold">{{$movie["original_title"]}} <span class="text-2xl">({{ \Carbon\Carbon::parse($movie["release_date"])->format('Y') }})</span></p>
                <div class="flex justify-between border-b border-t-gray-100">
                    <p class="text-gray-200">Runtime: <span>{{$movie["runtime"]}}</span> minutes</p>
                    <p>Rating: <span>{{round($movie["vote_average"],2)}}</span> ({{$movie["vote_count"]}})</p>
                </div>

                <p class="pt-6 border-b border-b-gray-100 pb-2">
                    {{$movie["overview"]}}
                </p>
                
                @if(count($cast) > 0)
                    <div class="space-y-2 pt-6">
                        @if($cast['director'])
                            <a href="{{route('person.show',$cast['director']['id'])}}" class="text-md">Director: {{$cast["director"]['name']}}</a>
                        @else
                        <p>Director: Unknown</p>
                        @endif
                        <div class="text-md"><span>Writers:</span>
                            @forelse ($cast["writers"] as $writer)
                                <a href="{{route('person.show',$writer['id'])}}">{{ $writer["original_name"] }}@if(!$loop->last),@endif
                                </a>
                            @empty
                                <span>Unknown</span>
                            @endforelse
                        </div>
                        <div class="text-md"><span>Writers:</span>
                            @forelse ($cast["popularActors"] as $actor)
                                <a href="{{route('person.show',$actor['id'])}}">{{ $actor["original_name"] }}@if(!$loop->last),@endif
                                </a>
                            @empty
                                <span>Unknown</span>
                            @endforelse
                        </div>
                    </div>
                @endif
                <div class="flex justify-between">
                    <div class="flex space-x-2 flex-wrap">
                        <p class="text-md">Genres:</p>
                        @foreach ($movie["genres"] as $genre)
                            <x-genre-tag :genre="$genre"/>
                        @endforeach
                    </div>
                    
                    @if(auth()->check())
                        <div class="sm:text-sm md:text-lg">
                            @livewire("add-to-favorite-button",["isMovie" => true,"id" => $movie["id"]])  
                        </div>
                    @endif
                </div>
            </div>

        </div>
        
        <hr class="my-6">

        @livewire('video-sources', ['movieId' => $movie["id"]])


        <hr class="my-6">
        @if(count($movieImages) > 0)
            <div x-data="{ selectedImg:'', isOpen:false }">
                <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 grid-cols-1
                gap-y-6"
                >
                    @foreach($movieImages as $img)
                        <img src="{{ config('services.tmdb.img_url') . "/w300/" . $img["file_path"] }}" 
                        alt="Movie Image"
                        class="rounded-lg cursor-pointer"
                        @click="selectedImg = '{{config('services.tmdb.img_url') . "/w780/" . $img['file_path']}}'; isOpen=true"
                        >
                    @endforeach
                </div>

                <div x-show="isOpen" 
                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" 
                    @click.self="isOpen = false"
                    x-transition>

                    <div class="bg-gray-700 p-4 rounded-lg shadow-lg max-w-fit w-full h-fit">
                        <img :src="selectedImg" alt="Popup Image" class="w-full rounded-lg">

                        <button @click="isOpen = false" 
                                @keydown.escape.window="isOpen = false"
                            class="mt-4 w-full text-center text-white bg-red-500 py-2 rounded-lg">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>

</x-app-layout>