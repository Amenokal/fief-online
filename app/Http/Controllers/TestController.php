<?php

namespace App\Http\Controllers;

use App\Classes\GameBooter;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function boot(Request $request){

        $gb = new GameBooter('vanilla');
        $gb->init();

    }
}
