<?php

namespace App\Http\Middleware;

use Closure;

class LanguageSwitcher
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \App::setLocale( ((\Session::has('locale'))? \Session::get('locale') : \Config::get('locale')) );
        return $next($request);
    }
}
