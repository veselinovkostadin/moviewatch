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

        dd($favorites);
    }
}
