<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\LoginUser;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Illuminate\Http\Request;
use Validator;

class addUserController extends Controller
{
    protected function index()
    {
        return view('login_pro::user.add');
    }

    protected function validator(Request $request)
    {
        $validation = Validator::make(($request->all()),
            [
                'mobile' => 'sometimes|iran_mobile|unique:users',
                'email' => 'sometimes|email|unique:users',
                'username' => 'sometimes|string|min:3|max:100|unique:users',
                'national_code' => 'sometimes|melli_code|unique:users',
                'password' => 'sometimes|string|min:6|max:200'
            ]
        );

        if ($validation->fails())
            return response()->json(['code' => 400, 'description' => $validation->getMessageBag()->all()[0], 'data' => null]);
    }


    protected function add(Request $request)
    {
        $validateFails = $this->validator($request);
        if ($validateFails)
            return $validateFails;

        $user_id=User::addUser($request);
        LoginUser::addLoginUser($user_id);
        return response()->json(['code' => 200, 'description' => 'اطلاعات با موفقیت افزوده شد.', 'data' => null]);

    }
}
