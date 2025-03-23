<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class MovieSearch extends Component
{
    public $search = "";
    public $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {
            $this->results = collect(Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/search/movie?query=" . $this->search)
                ->json()["results"])
                ->filter(function ($movie) {
                    return !is_null($movie['poster_path']);
                })
                ->take(10)
                ->all();
        }
        // dump($this->results);
    }


    public function render()
    {
        return view('livewire.movie-search');
    }
}
