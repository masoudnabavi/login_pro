<?php

namespace masoudnabavi\login_pro\App\Http\Controllers\authentication;


use App\Http\Controllers\Controller;
use masoudnabavi\login_pro\App\Mail\AuthMails;
use masoudnabavi\login_pro\App\Http\Models\twofactorauthentication;
use masoudnabavi\login_pro\App\Http\Models\User;
use Cookie;
use Illuminate\Http\Request;
use Mail;

class twoStepAuthUserController extends Controller
{

    public static function sendCode($request)
    {
        switch (env('useCookie')) {
            case 0:
                if (!session('user_id'))
                    return redirect()->route('loginUserGet');

                $two_step_code = uniqid();


                twofactorauthentication::twoStepAuthAdd($two_step_code, $request->user_id);
                $userData = User::getUserData($request->user_id);
                Mail::to($userData->email)->send(new AuthMails($request));
                return response()->json(['code' => 200, 'description' => 'کد ارسال شد.', 'data' => null]);
                //return redirect()->route('2stepCheckGet');
                break;
            case 1:
                if (!Cookie::get('user_id'))
                    return redirect()->route('loginUserGet');

                $two_step_code = uniqid();

                twofactorauthentication::twoStepAuthAdd($two_step_code, $request->user_id);
                $userData = User::getUserData($request->user_id);
                Mail::to($userData->email)->send(new AuthMails($request));
                return response()->json(['code' => 200, 'description' => 'کد ارسال شد.', 'data' => null]);
                //return redirect()->route('2stepCheckGet');

                break;
        }
    }

    protected function indexCheck()
    {
        return view('login_pro::user.two_step_check');
    }

    protected function check(Request $request)
    {
        $count=0;

        $user_id = null;
        switch (env('useCookie')) {
            case 0:
                if (!session('user_id'))
                    return redirect()->route('loginUserGet');

                $user_id = session('user_id');
                break;
            case 1:
                if (!Cookie::get('user_id'))
                    return redirect()->route('loginUserGet');

                $user_id = Cookie::get('user_id');
                break;
        }

        if (!twofactorauthentication::twoStepAuthCheck($user_id, $request->twoStepCode)) {
            $count++;
            User::addCounter($count,$user_id);
            if ($count<=env('sentCodeLimitNumber')) {
                User::blockUser($user_id,1);
                return response()->json(['code' => 400, 'description' => 'حساب شما مسدود شده است!', 'data' => null]);
            }
            return response()->json(['code' => 400, 'description' => 'کد وارد شده صحیح نمی باشد.', 'data' => null]);
        }

        $count=0;
        User::addCounter($count,$user_id);
        if (User::blockUser($user_id,1))
            User::blockUser($user_id,0);

        return response()->json(['code' => 200, 'description' => 'با موفقیت وارد شدید.', 'data' => null]);

    }
}
