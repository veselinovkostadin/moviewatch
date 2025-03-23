<x-app-layout>
    @section('title', 'Movies')
    <section>
        <div class="flex justify-between items-center">
            <p class="text-orange-600 text-4xl">{{__('Popular Movies')}}</p>
            @livewire("movie-search")
        </div>
        <x-display-cards-grid :genres="$genres" :items="$popularMovies"></x-display-cards-grid>
    </section>

    <section>
        
    </section>
</x-app-layout>
