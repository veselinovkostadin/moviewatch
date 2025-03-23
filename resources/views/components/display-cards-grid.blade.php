<div class="grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 grid-cols-2
gap-y-6 mt-3">
@if($isMovie)
    @foreach ($items as $item)
        <x-movie-card :movie="$item" :genres="$genres"/>
    @endforeach
@else
    @foreach ($items as $item)
        <x-show-card :show="$item" :genres="$genres"/>
    @endforeach
@endif
</div>