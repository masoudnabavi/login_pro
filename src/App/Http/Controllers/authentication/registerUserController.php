<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\LoginUser;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Illuminate\Http\Request;
use Validator;

class registerUserController extends Controller
{
    protected function index()
    {
        return view('login_pro::user.register');
    }

    protected function validator(Request $request)
    {
        $validation = Validator::make(($request->all()),
            [
                'mobile' => 'sometimes|unique:users|iran_mobile',
                'email' => 'sometimes|unique:users|email',
                'username' => 'sometimes|string|min:3|max:100|unique:users',
                'national_code' => 'sometimes|unique:users|melli_code',
                'password' => 'sometimes|string|min:6|max:200|unique:users'
            ]
        );

        if ($validation->fails())
            return response()->json(['code' => 400, 'description' => $validation->getMessageBag()->all()[0], 'data' => null]);
    }

    protected function register(Request $request)
    {
        $validateFails = $this->validator($request);
        if ($validateFails)
            return $validateFails;

        switch (env('usePassword')) {
            //Just One Input Without Password
            case 0:
                if (!$request->mobile && !$request->email && !$request->username && !$request->national_code)
                    return response()->json(['code' => 400, 'description' => 'پارامترهای ورودی صحیح نمی باشند!', 'data' => null]);

                $user_id=User::addUser($request);
                LoginUser::addLoginUser($user_id);
                return response()->json(['code' => 200, 'description' => 'شما با موفقیت ثبت نام شدید.', 'data' => null]);

                break;
            //Input`s With Password
            case 1:
                if (!$request->mobile && !$request->email && !$request->username && !$request->national_code && !$request->password)
                    return response()->json(['code' => 400, 'description' => 'پارامترهای ورودی صحیح نمی باشند!', 'data' => null]);

                $user_id=User::addUser($request);
                LoginUser::addLoginUser($user_id);
                return response()->json(['code' => 200, 'description' => 'شما با موفقیت ثبت نام شدید.', 'data' => null]);

                break;
            //Wrong Input
            default:
                return "خطا در سیستم لطفا با پشتیبانی تماس بگیرید، کد خطا: envPasswordUsageRegister";
                break;
        }
    }
}
