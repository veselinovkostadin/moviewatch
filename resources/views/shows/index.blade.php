@section("title","Tv Shows")
<x-app-layout>
    <div class="flex justify-between items-center">
        <p class="text-orange-600 text-4xl">{{__('Popular Series')}}</p>
        @livewire("series-search")
    </div>

    <x-display-cards-grid :genres="$genres" :items="$popularShows" :isMovie="false"></x-display-cards-grid>
</x-app-layout>