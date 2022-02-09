<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Game;
use Illuminate\Http\Request;

class ConnectingPlayerToGame
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Game::current() && !$request->user()->in_game)
        {
            $request->user()->update(['in_game' => true]);
        }

        return $next($request);
    }
}
