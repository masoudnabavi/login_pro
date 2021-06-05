<?php

namespace masoudnabavi\login_pro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use Cookie;
use Illuminate\Http\Request;

class logoutController extends Controller
{
    protected function index()
    {
        switch (env('useCookie')){
            case 0:
                session()->forget('user_id');
                session()->forget('secondUserToken');
                break;
            case 1:
                Cookie::queue(Cookie::forget('user_id'));
                Cookie::queue(Cookie::forget('secondUserToken'));
                    break;
        }
        return redirect()->route('loginUserGet');
    }
}
