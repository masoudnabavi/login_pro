<?php

namespace masoudnabavi\login_pro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\login_pro\App\Http\Models\User;
use Illuminate\Http\Request;
use Validator;

class forgetAndChangePasswordController extends Controller
{
    protected function indexForget()
    {
        return view('login_pro::user.forget');
    }
    protected function indexChange()
    {
        return view('login_pro::user.changePassword');
    }

    protected function validatorForget(Request $request)
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

    protected function forget(Request $request)
    {

        $validateFails = $this->validatorForget($request);
        if ($validateFails)
            return $validateFails;


        if ($request->mobile) {

            if (!User::ValidateUserForForgotPassword('mobile', $request->mobile, $request->birth_date, $request->id))
                return response()->json(['code' => 401, 'description' => 'پارامتر های ورودی معتبر نمی باشد.', 'data' => null]);
            else
                return response()->json(['code' => 200, 'description' => 'لطفا رمز عبور جدید را وارد نمایید.', 'data' => null]);
        }
        if ($request->email) {

            if (!User::ValidateUserForForgotPassword('email', $request->email, $request->birth_date, $request->id))
                return response()->json(['code' => 401, 'description' => 'پارامتر های ورودی معتبر نمی باشد.', 'data' => null]);
            else
                return response()->json(['code' => 200, 'description' => 'لطفا رمز عبور جدید را وارد نمایید.', 'data' => null]);

        }
        if ($request->username) {

            if (!User::ValidateUserForForgotPassword('username', $request->username, $request->birth_date, $request->id))
                return response()->json(['code' => 401, 'description' => 'پارامتر های ورودی معتبر نمی باشد.', 'data' => null]);
            else
                return response()->json(['code' => 200, 'description' => 'لطفا رمز عبور جدید را وارد نمایید.', 'data' => null]);
        }
        if ($request->national_code) {

            if (!User::ValidateUserForForgotPassword('national_code', $request->national_code, $request->birth_date, $request->id))
                return response()->json(['code' => 401, 'description' => 'پارامتر های ورودی معتبر نمی باشد.', 'data' => null]);
            else
                return response()->json(['code' => 200, 'description' => 'لطفا رمز عبور جدید را وارد نمایید.', 'data' => null]);

        }
    }


    protected function validatorChange(Request $request)
    {
        $validation = Validator::make(($request->all()),
            [
                'new_password' => 'required|confirmed|string|min:6|max:200'
            ]
        );

        if ($validation->fails())
            return response()->json(['code' => 400, 'description' => $validation->getMessageBag()->all()[0], 'data' => null]);
    }

    protected function change(Request $request)
    {

        $validateFails = $this->validatorchange($request);
        if ($validateFails)
            return $validateFails;

        User::ChangePassword($request->password,$request->id);
        return response()->json(['code' => 200, 'description' => 'رمز عبور با موفقیت تغییر کرد.', 'data' => null]);

    }
}
