
<div class="bg-slate-800 flex flex-col p-4 w-[160px] md:w-[200px] lg:w-[260px] xl:w-[270px] hover:bg-slate-600 transition ease-out duration-400 cursor-pointer rounded-xl"
    x-data="{ redirectTo: '' }" 
    x-init="redirectTo = '{{ route('movie.show', ['movie' => $movie['id']]) }}'"
    x-on:click="window.location.href = redirectTo"
>
    <div class="inline-block">
        <img 
        src="{{ 'https://image.tmdb.org/t/p/w200/' . $movie['poster_path'] }}" 
        alt="Movie Image"
        class="object-cover w-full rounded-md hover:opacity-75 transition ease-out duration-200"
        >
    </div>
    <div class="flex flex-col mt-2">
        <p class="text-white font-semibold text-xl">{{$movie["original_title"]}}</p>
        <div class="text-gray-300 text-sm mt-1 relative">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="yellow" class="size-4 mb-1">
                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                </svg>
                <span class="ms-1">{{round($movie["vote_average"],2)}}</span>
                <span class="mx-3">|</span>
                <span>{{\Carbon\Carbon::parse($movie["release_date"])->format('d M Y')}}</span>
            </div>

            <div class="flex flex-wrap space-x-1 space-y-1">
                @php
                    dd($movie)
                @endphp
                @foreach($movie["genre_ids"] as $genre)
                    <x-genre-tag :genre="$genres[$genre]"/>
                @endforeach
            </div>
        </div>
    </div>
</div>