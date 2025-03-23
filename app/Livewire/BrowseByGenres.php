<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Computed;

class BrowseByGenres extends Component
{

    public $genres = [];
    public $selectedGenre = [];
    public $movies = [];
    private $genreIds = "";

    public function mount()
    {
        $response = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.url') . "/genre/movie/list")->json()["genres"];

        $this->movies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.url') . "/movie/popular")->json()["results"];

        foreach ($response as $value) {
            $this->genres[$value["id"]] = ["name" => $value["name"], "id" => $value['id']];
        }

        if (request()->has("genre")) {
            $genre = request()->query('genre');

            if (key_exists($genre, $this->genres)) {
                $this->selectedGenre[] = $genre;
                $this->updatedSelectedGenre();
            }
        }
    }

    public function updatedSelectedGenre()
    {
        $this->genreIds = implode(',', $this->selectedGenre);

        $this->movies = Http::withToken(config('services.tmdb.token'))
            ->get(config('services.tmdb.url') . "/discover/movie", [
                'with_genres' =>  $this->genreIds,
            ])->json()["results"];
    }

    #[Layout("layouts.app")]
    public function render()
    {
        return view('livewire.browse-by-genres');
    }
}
