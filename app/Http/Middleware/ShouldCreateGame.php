<?php

namespace App\Http\Middleware;

use App\Custom\Services\BootServices;
use Closure;
use App\Models\Game;
use Illuminate\Http\Request;

class ShouldCreateGame
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
        if(!Game::current()){
            BootServices::init('vanilla');
        }
        return $next($request);
    }
}
