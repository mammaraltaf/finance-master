<?php

namespace App\Http\Middleware;

use App\Classes\Enums\UserTypesEnum;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @param string|null ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
////                if (Auth::user()->user_type == 'user') {
////                    return redirect()->route('user.select-company');
////                }
//                return redirect(Auth::user()->user_type.RouteServiceProvider::DASHBOARD);
////                return redirect()->route('/');
                $user = Auth::user();

                // Redirect based on user role
                switch ($user->user_type) {
                    case UserTypesEnum::Admin:
                    case UserTypesEnum::SuperAdmin:
                        return redirect()->route($user->user_type . '.dashboard');
                        break;
                    case UserTypesEnum::Manager:
                    case UserTypesEnum::Finance:
                    case UserTypesEnum::User:
                    case UserTypesEnum::Director:
                    case UserTypesEnum::Accounting:
                    case UserTypesEnum::Spectator:
                        return redirect()->route($user->user_type . '.select-company');
                        break;
                    default:
                        return redirect()->route($user->user_type . '.dashboard');
                }
            }
        }

        return $next($request);


    }
}
