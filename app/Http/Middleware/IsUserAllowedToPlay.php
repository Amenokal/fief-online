<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Game;
use Illuminate\Http\Request;

class IsUserAllowedToPlay
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

        if(!Game::current() || $request->user()->player->turn_order === Game::current()->current_player || Game::current()->current_phase<2){
            return $next($request);
        }
        else{
            return back();
        }
    }
}
