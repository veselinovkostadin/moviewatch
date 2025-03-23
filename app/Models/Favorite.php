<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = [
        'imdb_id',
        'title',
        'poster_path',
        'vote_average',
        'language',
        'isMovie',
        "release_date"
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorite_movie');
    }

    public function getOriginalLanguageAttribute()
    {
        return $this->attributes9["language"];
    }

    public function setOriginalLanguageAttribute($value)
    {
        $this->attributes['language'] = $value;
    }

    public function getOriginalTitleAttribute()
    {
        return $this->attributes9["title"];
    }

    public function setOriginalTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
    }
}
