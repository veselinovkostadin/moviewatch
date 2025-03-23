<x-app-layout>
<section>
    <div class="flex justify-between items-center">
        <p class="text-orange-600 text-4xl">{{__('Popular Actors')}}</p>
        @livewire("actor-search")
    </div>
</section>

</x-app-layout>