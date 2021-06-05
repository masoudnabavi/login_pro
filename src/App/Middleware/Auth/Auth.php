<?php

namespace  masoudnabavi\LoginPro\App\Http\Middleware\Auth;

use App\Http\Models\User;
use Closure;
use Cookie;
use Illuminate\Http\Request;
use Redirect;
use Session;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if ($this->isLogin($request))
            return $next($request);

        return Redirect::route('loginUserGet');
    }

    protected function isLogin($request)
    {

        switch (env('useCookie')) {
            case 0:
                if (Session::get('token') == User::dataIsValid('token',Session::get('token')))
                    return true;

                return false;

                break;
            case 1:

                if (Cookie::get('token') == User::dataIsValid('token',Cookie::get('token')))
                    return true;

                return false;

                break;
        }
    }

}
