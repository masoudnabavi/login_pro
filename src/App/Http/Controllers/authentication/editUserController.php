<?php

namespace masoudnabavi\login_pro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\login_pro\App\Http\Models\User;
use Illuminate\Http\Request;
use Validator;

class editUserController extends Controller
{
    protected function index($id)
    {
        if (!User::dataIsValid('id',$id))
            return redirect()->back();

        $user = User::getUserData($id);

        return view('login_pro::user.edit', compact('user'));
    }

    protected function validator(Request $request)
    {
        $validation = Validator::make(($request->all()),
            [
                'id' => 'sometimes|exists:users',
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


    protected function edit(Request $request)
    {

        $validateFails = $this->validator($request);
        if ($validateFails)
            return $validateFails;


        if ($request->email)
            if (User::isDataNotUnique($request->id, $request->email,'email'))
                return response()->json(['code' => 400, 'description' => 'این ایمیل قبلا در سیستم ثبت شده است.', 'data' => null]);

        if ($request->mobile)
            if (User::isDataNotUnique($request->id, $request->mobile,'mobile'))
                return response()->json(['code' => 400, 'description' => 'این شماره موبایل قبلا در سیستم ثبت شده است.', 'data' => null]);

        if ($request->username)
            if (User::isDataNotUnique($request->id, $request->username,'username'))
                return response()->json(['code' => 400, 'description' => 'این نام کاربری قبلا در سیستم ثبت شده است.', 'data' => null]);

        if ($request->national_code)
            if (User::isDataNotUnique($request->id, $request->national_code,'national_code'))
                return response()->json(['code' => 400, 'description' => 'این کدملی قبلا در سیستم ثبت شده است.', 'data' => null]);


          User::editUser($request);

        return response()->json(['code' => 200, 'description' => 'اطلاعات با موفقیت ویرایش شد.', 'data' => null]);
    }
}
