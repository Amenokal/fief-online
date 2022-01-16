<?php

namespace App\Custom\Helpers;

use App\Models\User;
use App\Models\Players;
use Illuminate\Support\Facades\Auth;

class CurrentUser {

    public static function get()
    {
        return User::where('username', Auth::user()->username)->first();
    }

    public static function player()
    {
        return Players::where('user_id', self::get()->id)->first();
    }

    public static function connect()
    {
        self::get()->update([
            'is_ready' => false,
            'in_game' => true
        ]);
    }

    public static function log_in()
    {
        self::get()->update(['is_logged'=>true]);
    }

    public static function log_out()
    {
        self::get()->update(['is_logged'=>false]);
    }

}