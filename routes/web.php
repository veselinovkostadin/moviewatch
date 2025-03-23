<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShowsController;
use App\Livewire\BrowseByGenres;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, "index"])->name('dashboard');

Route::get('/tvshows', [ShowsController::class, "index"])->name("tvShows");
Route::get("/tvshows/{show}", [ShowsController::class, "show"])->name("tvshow.show");

Route::get("/movie/genres", BrowseByGenres::class)->name("genres.browse");
Route::get("/movie/{movie}", [MovieController::class, "show"])->name("movie.show");


Route::get("/person/{personId}", [PersonController::class, "show"])->name("person.show");

Route::middleware('auth')->group(function () {
    Route::get("/favorites", [FavoriteController::class, "show"])->name("favorites.show");

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get("/test", function () {
    return view("test");
});

require __DIR__ . '/auth.php';
