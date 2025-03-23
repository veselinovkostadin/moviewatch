<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class FavoriteController extends Controller
{

    public function show()
    {
        $favorites = Auth::user()->favorites;

        $movies = collect($favorites)->filter(function ($movie) {
            return $movie->isMovie;
        })->map->toArray();

        $movies = $favorites->filter(function ($movie) {
            return $movie->isMovie;
        })->map(function ($movie) {
            $array = $movie->toArray();
            $array['original_title'] = $array['title'];
            unset($array['title']);

            return $array;
        });


        $series = collect($favorites)->filter(function ($series) {
            return !$series->isMovie;
        })->map(function ($series) {
            $array = $series->toArray();
            $array["original_name"] = $array["title"];
            unset($array["title"]);
            $array["first_air_date"] = $array["release_date"];
            $array["original_language"] = $array["language"];

            return $array;
        });

        // dd($movies, $series, $favorites);

        return view("favorites.show", compact("movies", "series"));
    }
}
