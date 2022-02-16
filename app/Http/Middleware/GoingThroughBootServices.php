<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Game;
use App\Models\Player;
use Illuminate\Http\Request;
use App\Custom\Services\BootServices;

class GoingThroughBootServices
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
        if(!$request->user()->player){
            BootServices::init('vanilla');
        }
        return $next($request);
    }
}
