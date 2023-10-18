<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAppMode
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

        if(appSettings('app_mode')=='maintenance'){
            return redirect()->route('maintenance-page-mode');
        }
        return $next($request);

    }
}
