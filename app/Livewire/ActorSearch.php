<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ActorSearch extends Component
{
    public $search = "";
    public $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {
            $this->results = collect(Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/search/person?query=" . $this->search)
                ->json()["results"])
                ->take(10)
                ->all();
        }

        dd($this->results);
    }

    public function render()
    {
        return view('livewire.actor-search');
    }
}
