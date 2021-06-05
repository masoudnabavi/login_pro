<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\LoginUser;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Cookie;
use Illuminate\Http\Request;
use Session;
use Validator;

class loginUserController extends Controller
{
    protected function index()
    {
        //return LoginUser::CheckUserAuthenticationData(1);
        return view('login_pro::user.login');
    }

    protected function doLogin($dataBaseColName, $input, $password = null)
    {
        switch (env('usePassword')) {
            case 0:
                $user_id = User::loginWithoutPassword($dataBaseColName, $input);

                break;

            case 1:
                $user_id = User::loginWithPassword($dataBaseColName, $input, $password);

                break;
        }

        if (!$user_id) return response()->json(['code' => 401, 'description' => 'خطا در احراز هویت!', 'data' => null]);


        switch (env('useCookie')) {
            case 0:
                Session::put('token', User::getToken($user_id));


                if (!User::twoStepAuthStatus($user_id)) {
                    if (User::blockUser($user_id, 1))
                        return response()->json(['code' => 400, 'description' => 'حساب شما مسدود شده است!', 'data' => null]);

                    LoginUser::updateLoginUser($user_id);

                    return response()->json(['code' => 202, 'description' => 'شما با موفقیت وارد شدید.', 'data' => null]);
                }
                twoStepAuthUserController::sendCode($user_id);
                break;
            case 1:

                if (!User::twoStepAuthStatus($user_id)) {
                    if (User::blockUser($user_id, 1))
                        return response()->json(['code' => 400, 'description' => 'حساب شما مسدود شده است!', 'data' => null]);

                    LoginUser::updateLoginUser($user_id);
                    Cookie::make('token', User::getToken($user_id), 3600);
                    return response()->json(['code' => 202, 'description' => 'شما با موفقیت وارد شدید.', 'data' => null]);
                }
                twoStepAuthUserController::sendCode($user_id);

                break;
        }

    }

    protected function validator(Request $request)
    {
        $validation = Validator::make(($request->all()),
            [
                'mobile' => 'sometimes|iran_mobile',
                'email' => 'sometimes|email',
                'username' => 'sometimes|string|min:3|max:100',
                'national_code' => 'sometimes|melli_code',
                'password' => 'sometimes|string|min:6|max:200'
            ]
        );

        if ($validation->fails())
            return response()->json(['code' => 400, 'description' => $validation->getMessageBag()->all()[0], 'data' => null]);
    }

    protected function login(Request $request)
    {

        $validateFails = $this->validator($request);
        if ($validateFails)
            return $validateFails;

        switch (env('usePassword')) {
            //Just One Input, Without Password
            case 0:
                //Just Get Mobile Number For Login
                if ($request->mobile) {

                    if (User::dataIsValid('mobile', $request->mobile))
                        return $this->doLogin('mobile', $request->mobile);

                    return response()->json(['code' => 401, 'description' => 'شماره موبایل معتبر نمی باشد.', 'data' => null]);
                } //Just Get Email For Login
                else if ($request->email) {

                    if (User::dataIsValid('email', $request->email))
                        return $this->doLogin('email', $request->email);

                    return response()->json(['code' => 401, 'description' => 'ادرس ایمیل معتبر نمی باشد.', 'data' => null]);
                } //Just Get UserName For Login
                else if ($request->username) {

                    if (User::dataIsValid('username', $request->username))
                        return $this->doLogin('username', $request->username);

                    return response()->json(['code' => 401, 'description' => 'نام کاربری معتبر نمی باشد.', 'data' => null]);

                } //Just Get NationalCode For Login
                else if ($request->national_code) {


                    if (User::dataIsValid('national_code', $request->national_code))
                        return $this->doLogin('national_code', $request->national_code);

                    return response()->json(['code' => 401, 'description' => 'کدملی معتبر نمی باشد.', 'data' => null]);
                } else return response()->json(['code' => 400, 'description' => 'پارامترهای ورودی صحیح نمی باشند!', 'data' => null]);

                break;
            //Input`s With Password
            case 1:
                // Get Mobile Number And Password For Login
                if ($request->mobile) {

                    if (User::dataWithPasswordIsValid('mobile', $request->mobile, $request->password))
                        return $this->doLogin('mobile', $request->mobile, $request->password);

                    return response()->json(['code' => 401, 'description' => 'شماره موبایل یا رمزعبور معتبر نمی باشد.', 'data' => null]);
                } // Get Email And Password For Login
                else if ($request->email) {

                    if (User::dataWithPasswordIsValid('email', $request->email, $request->password))
                        return $this->doLogin('email', $request->email, $request->password);

                    return response()->json(['code' => 401, 'description' => 'ادرس ایمیل یا رمزعبور معتبر نمی باشد.', 'data' => null]);
                } // Get UserName And Password  For Login
                else if ($request->username) {

                    if (User::dataWithPasswordIsValid('username', $request->username, $request->password))
                        return $this->doLogin('username', $request->username, $request->password);

                    return response()->json(['code' => 401, 'description' => 'نام کاربری یا رمزعبور معتبر نمی باشد.', 'data' => null]);

                } // Get NationalCode And Password  For Login
                else if ($request->national_code) {


                    if (User::dataWithPasswordIsValid('national_code', $request->national_code, $request->password))
                        return $this->doLogin('national_code', $request->national_code, $request->password);

                    return response()->json(['code' => 401, 'description' => 'کدملی یا رمزعبور معتبر نمی باشد.', 'data' => null]);
                } else return response()->json(['code' => 400, 'description' => 'پارامترهای ورودی صحیح نمی باشند!', 'data' => null]);

                break;
            //Wrong Input
            default:
                return "خطا در سیستم لطفا با پشتیبانی تماس بگیرید، کد خطا: envPasswordUsageLogin";
                break;
        }
    }


}
