<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Players;
use App\Models\Buildings;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Builder;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use Illuminate\Support\Facades\Auth;
use App\Custom\Services\StartGameServices;

class TestController extends Controller
{
    public function test()
    {
        StartGameServices::chooseVillage('tournus');
    }

}
