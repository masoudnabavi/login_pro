<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Cookie;
use Session;

class getLoginUserDataController extends Controller
{
    public static function getLoginUserId()
    {

        switch (env('useCookie')) {
            case 0:
                if (Session::get('secondUserToken'))
                    return User::getUserData(User::getUserId(Session::get('secondUserToken')));
                return User::getUserData(User::getUserId(Cookie::get('token')));

                break;
            case 1:
                if (Cookie::get('secondUserToken'))
                    return User::getUserData(User::getUserId(Session::get('secondUserToken')));
                return User::getUserData(User::getUserId( Cookie::get('token')));

                break;
        }
    }
}
