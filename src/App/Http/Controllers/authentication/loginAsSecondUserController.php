<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Cookie;
use Illuminate\Http\Request;

class loginAsSecondUserController extends Controller
{
    protected function LoginAsSecond($user_id)
    {
        if (!User::getToken($user_id))
            User::loginAsSecondUser($user_id);
        return User::getToken($user_id);
    }

    protected function saveSecondUserToken(Request $request)
    {

        if (!$request->user_id)
            return response()->json(['code' => 401, 'description' => 'خطا در پارامتر های ارسالی', 'data' => null]);

        switch (env('useCookie')) {
            case 0:
                session(['secondUserToken' => $this->LoginAsSecond($request->user_id)]);
                break;
            case 1:
                Cookie::make('secondUserToken', $this->LoginAsSecond($request->user_id), 3600);
                break;
        }
        //Return To Dashboard
        //return redirect()->route('clientAreaDashboard');
        return getLoginUserDataController::getLoginUserId();
    }
}
