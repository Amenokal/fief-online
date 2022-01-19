<?php

namespace App\Custom\Helpers;

class Librarian {

    public static function decipherJson(string $path)
    {
        return collect(json_decode(file_get_contents(storage_path('data/'.$path)), true));
    }

}