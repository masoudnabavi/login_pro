<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use Cookie;
use Illuminate\Http\Request;

class logoutSecondUserController extends Controller
{
    protected function index()
    {
        switch (env('useCookie')){
            case 0:
                session()->forget('secondUserToken');
                break;
            case 1:
                Cookie::queue(Cookie::forget('secondUserToken'));
                    break;
        }
        return redirect()->route('dashboard');
    }
}
