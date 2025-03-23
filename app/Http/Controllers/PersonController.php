<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseConverter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class PersonController extends Controller
{
    use ResponseConverter;


    public function show($personId)
    {
        // try {
        $person = Http::withToken(config('services.tmdb.token'))
            ->get(
                config("services.tmdb.url") . "/person/$personId",
                [
                    "append_to_response" => "movie_credits"
                ]
            )->json();

        $genresApi = Http::withToken(config('services.tmdb.token'))
            ->get(config("services.tmdb.url") . "/genre/movie/list")
            ->json()["genres"];


        $genres = $this->convertGenres($genresApi);

        if (empty($person)) {
            throw new Exception("Failed to fetch person info for $personId", 503);
        }


        $person["movie_credits"]["cast"] = collect($person["movie_credits"]["cast"])->unique('id')
            ->reject(fn($movie) => is_null($movie['poster_path']) || strlen($movie['overview']) == 0)
            ->sortByDesc('vote_average')
            ->values()->toArray();

        $person["movie_credits"]["crew"] = collect($person["movie_credits"]["crew"])->unique('id')
            ->reject(fn($movie) => is_null($movie['poster_path'] || strlen($movie['overview']) == 0))
            ->sortByDesc('vote_average')
            ->values()->toArray();
        dump($person);

        return view("person.show", compact("person", "genres"));
        // } catch (Exception $e) {
        //     Log::channel("tmdb")->error("TMDb API Error: " . $e->getMessage());
        //     return response()->view('errors.503', ['message' => 'Service unavailable. Please try again later.'], 503);
        // }
    }
}
