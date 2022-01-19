<?php

namespace App\Http\Controllers;

use App\Models\Games;
use App\Models\Players;
use App\Models\Villages;
use App\Models\Buildings;
use Illuminate\Http\Request;
use App\Custom\Helpers\Local;
use App\Custom\Helpers\Mayor;
use App\Custom\Helpers\Realm;
use App\Custom\Helpers\Builder;
use App\Custom\Helpers\Marechal;
use App\Custom\Helpers\Architect;
use Illuminate\Support\Facades\Auth;
use App\Custom\Services\BootServices;
use App\Custom\Services\DeckServices;
use App\Custom\Services\StartGameServices;

class TestController extends Controller
{
    public function t(Request $request)
    {
        return DeckServices::nextCards('lord')->skip(1)->first()->disaster;
    }

}
