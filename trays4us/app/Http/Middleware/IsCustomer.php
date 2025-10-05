<?php

namespace App\Http\Middleware;

use App\Models\Cart;
use App\Models\Users;
use Closure;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class IsCustomer
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
        if(Session::has('is_customer') && !empty(Session::get('is_customer'))){
            $is_customer = Session::get('is_customer');
            View::share('is_customer', Session::get('is_customer'));
            return $next($request);
        }
        Session()->put('url.intended', url()->current());
        return redirect(route('sign-in'));
    }
}
