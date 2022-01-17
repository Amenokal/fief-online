<?php

namespace App\Http\Controllers;

use App\Custom\Services\BootServices;
use App\Custom\Services\GoldServices;
use App\Models\Games;
use App\Models\Players;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return GoldServices::transfer(Players::auth(), 3, Games::current()->players()->skip(1)->first());
    }
}
