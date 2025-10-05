<?php

namespace App\Http\Middleware;

use App\Models\Users;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class IsAdmin
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
        if(Session::has('is_admin') && !empty(Session::get('is_admin'))){
            View::share('is_admin', Session::get('is_admin'));
            return $next($request);
        }
        return redirect(route('tfubacksecurelogin'));
    }
}
