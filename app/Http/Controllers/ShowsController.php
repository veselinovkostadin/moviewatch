<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseConverter;
use Mockery\CountValidator\Exact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ShowsController extends Controller
{
    use ResponseConverter;

    public function index()
    {
        try {

            $popularShows = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/trending/tv/day")->json()["results"];

            $genresApi = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/genre/tv/list")->json();

            $genres = $this->convertGenres($genresApi["genres"]);

            return view("shows.index", compact("popularShows", "genres"));
        } catch (Exception $e) {
            Log::channel('tmdb')->error('TMDb API Error: ' . $e->getMessage());

            return response()->view('errors.503', ['message' => 'Service unavailable. Please try again later.'], 503);
        }
    }

    public function show($showId)
    {
        try {
            $response = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/tv/$showId", [
                    'append_to_response' => 'season/1'
                ]);


            if ($response->status() == 404) {
                return response()->view('errors.404', ['message' => 'Resource not found.'], 404);
            }

            $show = $response->json();

            if (!isset($show["season/1"])) {
                return response()->view('errors.404', ['message' => 'Seasons data not found.'], 404);
            }

            $season = $show["season/1"];

            $numberOfEpisodes = count($season["episodes"]);

            return view("shows.show", compact("show", "numberOfEpisodes", "season"));
        } catch (Exception $e) {
            Log::channel('tmdb')->error('TMDb API Error: ' . $e->getMessage());

            return response()->view('errors.503', ['message' => 'Service unavailable. Please try again later.'], 503);
        }
    }
}
