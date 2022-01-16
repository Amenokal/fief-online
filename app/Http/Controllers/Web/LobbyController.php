<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\ReadyEvent;
use Illuminate\Http\Request;
use App\Events\ChatMessageEvent;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class LobbyController extends Controller
{

    public function index(Request $request)
    {
        // TODO : make a middleware for this 2 ->
        // log user in
        $user = User::where('username', Auth::user()->username)->first();
        $user->update(['is_logged'=>true]);
        // get other logged users
        $loggedPlayers = User::where('is_logged', true)->get();

        return view('layouts.lobby', [
            'user' => $user,
            'loggedPlayers' => $loggedPlayers
        ]);
    }

    public function newMsg(Request $request)
    {
        $message = '<p><strong>'. Auth::user()->username .'</strong> : ' . $request->message .'</p>';
        event(new ChatMessageEvent($message));
    }

    public function isReady()
    {
        $user = Auth::user();
        $user->is_ready = !$user->is_ready;
        event(new ReadyEvent($user->username));
        return redirect()->intended(RouteServiceProvider::GAME);
    }
}
