<a href="{{url('/movie/genres?genre=' . $genre["id"]) }}" class="flex items-center border border-orange-400 px-2 rounded-lg text-orange-400 hover:border-orange-300 transition ease-in duration-100 hover:text-orange-200" 
@click.stop
wire:navigate>
    {{$genre["name"]}}
</a>