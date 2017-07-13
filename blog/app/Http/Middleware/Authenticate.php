<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                // return response('Unauthorized.', 401);

                if(\Request::isMethod('post')) {
                    $return = ['error'=>'1','success'=>'0','msg'=> trans('auth.unauthorized').'<br />'.trans('auth.unauthorized_message')];
                    return \Response::json($return);
                }

                if(\Request::isMethod('get')) {
                    return view('errors.401');
                }
                
            } else {
                return redirect()->guest('login');
            }
        }

        return $next($request);
    }
}
