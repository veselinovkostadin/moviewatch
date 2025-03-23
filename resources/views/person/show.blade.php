<x-app-layout>

    <div class="min-h-screen">
        <div class="flex flex-col items-center space-y-6 sm:flex-row">
            <img class="bg-red-400 h-[400px] w-[300px] flex-2"
                alt="Movie Banner"
                src="{{ config("services.tmdb.img_url") . "/w500/" . $person['profile_path'] }}"
            ></img>
            <div class="flex-1 ps-4 space-y-2 text-gray-200">
                <p class="text-5xl text-gray-50">{{$person["name"]}}</p>

                <p class="pt-4 border-b border-b-gray-100 border-t border-t-gray-100 pb-4 text-md">
                    {{$person["biography"]}}
                </p>

                <p class="text-md">Birthday: <span class="underline underline-offset-4">{{\Carbon\Carbon::parse($person["birthday"])->format('d M Y')}}</span></p>
                <p>Place of birth: <span class="underline underline-offset-4">{{$person["place_of_birth"]}}</span></p>

                @if($person["deathday"])
                    <p>Death: <span class="underline underline-offset-4">{{\Carbon\Carbon::parse($person["deathday"])->format('d M Y')}}</span></p>
                @endif

                <p>Gender: <span>{{$person["gender"] == 2 ? "Male" : "Female" }}</span></p>
            </div>
        </div>
       
        <hr class="my-6">

        <p>Actor: </p>
        <x-display-cards-grid :genres="$genres" :items="$person['movie_credits']['cast']"></x-display-cards-grid>
        

        <p>Producer: </p>
        <x-display-cards-grid :genres="$genres" :items="$person['movie_credits']['crew']"></x-display-cards-grid>
    </div>
</x-app-layout>