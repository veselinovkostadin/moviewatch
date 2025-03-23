<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseConverter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    use ResponseConverter;

    public function index()
    {
        try {
            $responses = Http::pool(fn($pool) => [
                $pool->as('movies')->withToken(config('services.tmdb.token'))
                    ->get(config('services.tmdb.url') . "/movie/popular"),

                $pool->as('genres')->withToken(config('services.tmdb.token'))
                    ->get(config('services.tmdb.url') . "/genre/movie/list"),
            ]);

            $popularMovies = optional($responses['movies']->json())["results"] ?? [];
            $genresApi = optional($responses['genres']->json())["genres"] ?? [];

            $genres = $this->convertGenres($genresApi);

            return view("dashboard", ["popularMovies" => $popularMovies, "genres" => $genres]);
        } catch (Exception $e) {
            Log::channel("tmdb")->error("TMDb API Error: " . $e->getMessage());
            return response()->view('errors.503', ['message' => 'Service unavailable. Please try again later.'], 503);
        }
    }

    public function show($movieId)
    {
        try {
            $movie = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/movie/$movieId", [
                    "append_to_response" => "credits,images"
                ])->json();

            if (isset($movie["credits"])) {
                $credits = $movie["credits"];
                $cast["director"] = collect($credits["crew"])->firstWhere('job', "Director") ?? null;
                $cast["writers"] = collect($credits['crew'])->where('job', "Writer")->toArray();
                $cast["popularActors"] = collect($credits["cast"])->take(3)->toArray();
            } else {
                $cast = [];
            }

            if (isset($movie["images"])) {
                $movieImages = $movie["images"]["backdrops"];
            } else {
                $movieImages = [];
            }

            return view('movie', compact(['movie', "cast", "movieImages"]));
        } catch (Exception $e) {
            Log::channel("tmdb")->error("TMDb API Error: " . $e->getMessage());
            return response()->view('errors.503', ['message' => 'Service unavailable. Please try again later.'], 503);
        }
    }
}
