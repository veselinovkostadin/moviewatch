@section("title","Tv Shows")
<x-app-layout>

    <x-display-cards-grid :genres="$genres" :items="$popularShows" :isMovie="false"></x-display-cards-grid>
</x-app-layout>