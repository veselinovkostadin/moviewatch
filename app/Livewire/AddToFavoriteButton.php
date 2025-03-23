<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AddToFavoriteButton extends Component
{
    public $id;
    public $isMovie;
    public $text;
    public $isFavorite = false;
    public $itemApi;
    public $itemDbId; // if exists in the database get its id
    public $itemFound = false;

    public function mount()
    {
        if ($this->isMovie) {
            $this->itemApi = Http::withToken(config("services.tmdb.token"))
                ->get(config("services.tmdb.url") . "/movie/" . $this->id)->json();
        } else {
            $this->itemApi = Http::withToken(config("services.tmdb.token"))
                ->get(config("services.tmdb.url") . "/tv/" . $this->id)->json();
        }

        if (isset($this->itemApi["id"])) {
            $this->itemFound = true;
            $itemInDb = Favorite::where("imdb_id", $this->itemApi["id"])->first();

            if ($itemInDb) {
                $this->isFavorite = Auth::user()->favorites()->wherePivot("favorite_id", $itemInDb->id)->exists();
            }
        }

        if ($this->isFavorite) {
            $this->text = "Remove from favorites";
        } else {
            $this->text = "Add to favorites";
        }

        dump($this->itemApi);
    }

    public function toggleFavorite()
    {
        if ($this->itemFound) {
            if (!$this->itemDbId) {
                $this->getOrCreateInDb();
            }

            if (!$this->isFavorite) {
                Auth::user()->favorites()->attach($this->itemDbId);
                $this->text = "Remove from favorites";
                $this->isFavorite = !$this->isFavorite;
            } else {
                Auth::user()->favorites()->detach($this->itemDbId);
                $this->text = "Add to favorites";
                $this->isFavorite = !$this->isFavorite;
            }
        }
    }

    private function getOrCreateInDb()
    {
        $itemInDb = Favorite::where("imdb_id", $this->itemApi["id"])->first();
        if ($itemInDb) {
            $this->itemDbId = $itemInDb->id;
        } else {
            // add movie to local db
            $favorite =  Favorite::create([
                'imdb_id' => $this->itemApi["id"],
                'title' => isset($this->itemApi["original_title"]) ? $this->itemApi["original_title"] : $this->itemApi["name"], // ['original_title'] for movies, ['name'] for stroing series
                'poster_path' => $this->itemApi['poster_path'],
                'vote_average' => $this->itemApi['vote_average'],
                'language' => $this->itemApi["original_language"],
                'release_date' => isset($this->itemApi["release_date"]) ? $this->itemApi["release_date"] : $this->itemApi["first_air_date"],
                'isMovie' => $this->isMovie,
            ]);

            $this->itemDbId = $favorite->id;
        }
    }

    public function render()
    {
        return view('livewire.add-to-favorite-button');
    }
}
