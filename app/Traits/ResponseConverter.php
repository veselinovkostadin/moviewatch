<?php

namespace App\Traits;

trait ResponseConverter
{

    protected function convertGenres($genres): array
    {

        $genresConverted = [];
        foreach ($genres as $key => $value) {
            $genresConverted[$value["id"]] = ["name" => $value["name"], "id" => $value['id']];
        }

        return $genresConverted;
    }
}
