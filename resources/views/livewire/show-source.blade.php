<div class="flex flex-col">
    <div class="flex flex-row">
        <div class="flex flex-col w-full">
            <div class="grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 grid-cols-2
            gap-y-3">
                @for($i=1;$i<=$numberOfSeasons;$i++)
                    <div class="text-white border border-white rounded px-2 text-lg cursor-pointer"
                    wire:click="changeSeason({{$i}})"
                    >Season {{$i}}</div>
                @endfor
            </div>
            <div class="flex flex-2 flex-col justify-center items-center space-y-6 py-5 w-2/3">
                <iframe allowfullscreen scrolling="no" src="{{$currentStreamService}}"
                    width="100%" height="600px"
                ></iframe>

                <div class="flex flex-wrap justify-center space-x-4">
                    @foreach($streamServices as $name => $service)
                        <div class="px-2 py-1 border text-lg border-orange-400 rounded-lg text-orange-400 cursor-pointer hover:border-orange-300 transition ease-in duration-200"
                            wire:click="changeStreamingService('{{ $name }}')"
                        >{{$name}}</div>
                    @endforeach
                </div>

                <div class="text-orange-500 text-wrap underline text-center text-xl">
                    Please use AdBlocker for better experience. :) 
                </div>
            </div>
        </div>
        <div class="flex flex-col flex-1">
            @for($i=1;$i<=count($season["episodes"]);$i++)
            <div class="text-white border border-white rounded px-2 text-lg cursor-pointer"
            wire:click="changeEpisode({{$i}})"
            >Episode {{$i}}</div>
        @endfor
        </div>
    </div>
<hr>
<div>
    <p class="text-white text-xl font-normal"><span class="font-semibold">Episode:</span> {{$episode["overview"] ?? ""}}</p>
    <hr>
    <p class="text-white text-lg font-normal"><span class="text-xl font-semibold">Season:</span> {{$season["overview"] ?? ""}}</p>
</div>
</div>

