<?php

namespace App\Http\Controllers;

use App\Events\LogInEvent;
use App\Events\ReadyEvent;
use App\Events\LogOutEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogEventController extends Controller
{
    public function login()
    {

        $username = Auth::user()->username;
        $template = '<span class="lobby-player" id="'.$username.'">'.$username.'</span>';

        event(new LogInEvent($template));

    }

    public function logout()
    {
        event(new LogOutEvent(Auth::user()->username));
    }

}
