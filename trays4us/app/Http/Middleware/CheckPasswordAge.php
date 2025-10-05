<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;

class CheckPasswordAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        // Get the current route name
        $currentRouteName = $request->route()->getName();

        // Exclude the password change routes from the middleware check
        if (in_array($currentRouteName, ['admin.change-password', 'admin.change-password-save'])) {
            return $next($request); // Allow access to password change routes without checking the password age
        }

        // Assuming you store the password last updated date in the users table as 'password_changed_at'
        if (Session::has('is_admin') && !empty(Session::get('is_admin'))) {
            $is_admin = Session::get('is_admin');
            $user = User::find($is_admin->id);
            $passwordUpdatedAt = $user['password_changed_at'];

            if ($passwordUpdatedAt) {
                $daysSinceUpdate = Carbon::parse($passwordUpdatedAt)->diffInDays(now());

                // Show reminder if the password will expire in 10 days or less
                $daysUntilExpiration = 90 - $daysSinceUpdate;
                if ($daysUntilExpiration <= 10 && $daysUntilExpiration > 0) {
                    // Add a reminder to the session
                    Session::flash('password_reminder', "Your password will expire in $daysUntilExpiration days. Please update it. <a href='" . route('admin.change-password') . "'>Click Here</a>.");
                }

                // Redirect to change password if it's been more than 90 days
                if ($daysSinceUpdate > 90) {
                    return redirect()->route('admin.change-password')
                        ->with('message', 'Your password is expired. Please update it.');
                }
            }
        }

        return $next($request);  // Allow the request to continue if the password is valid
    }
}
