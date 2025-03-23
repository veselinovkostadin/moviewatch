<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SeriesSearch extends Component
{

    public $search = "";
    public $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) > 2) {
            $this->results = collect(Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/search/tv?query=" . $this->search)
                ->json()["results"])
                ->filter(function ($series) {
                    return !is_null($series['poster_path']);
                })
                ->take(10)
                ->all();
        }
    }


    public function render()
    {
        return view('livewire.series-search');
    }
}
