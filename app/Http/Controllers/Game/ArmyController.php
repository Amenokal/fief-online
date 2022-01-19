<?php

namespace App\Http\Controllers\Game;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArmyController extends Controller
{
    public function test (Request $request)
    {
        dd($request);
    }
}
