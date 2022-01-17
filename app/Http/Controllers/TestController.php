<?php

namespace App\Http\Controllers;

use App\Custom\Services\GameBootServices;
use App\Models\Games;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function test()
    {
        return GameBootServices::init('vanilla');
    }
}
