<x-app-layout>
    @section('title', 'Favorites')
    <section class="my-2">
        <p class="text-orange-600 text-4xl">{{__('Favorite movies')}}</p>

        <x-display-cards-grid :items="$movies"></x-display-cards-grid>
    </section>

    <div class="border-t border-orange-600 my-8"></div>

    <section class="my-2">
        <p class="text-orange-600 text-4xl">{{__('Favorite Series')}}</p>

        <x-display-cards-grid :items="$series" :isMovie="false"></x-display-cards-grid>
        
    </section>
</x-app-layout>
