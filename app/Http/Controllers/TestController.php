<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Players;
use App\Models\Buildings;

class TestController extends Controller
{
    public function test()
    {
        dd(Buildings::where('game_id', Games::current()->id)->exists());
    }

}
