<div class="flex-col justify-center items-center space-y-6 py-5">
    <iframe allowfullscreen scrolling="no" src="{{$currentStreamService . $movieId}}"
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