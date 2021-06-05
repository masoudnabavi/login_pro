<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Illuminate\Http\Request;
use Validator;

class deleteUserController extends Controller
{
    protected function validator(Request $request)
    {
        $validation = Validator::make(($request->all()), [
            'id' => 'required|exists:users'
        ]);

        if ($validation->fails())
            return response()->json(['code' => 400, 'description' => $validation->getMessageBag()->all()[0], 'data' => null]);
    }

    protected function delete(Request $request)
    {
        $validateFails = $this->validator($request);
        if ($validateFails)
            return $validateFails;

        User::deleteUser($request);

        return response()->json(['code' => 200, 'description' => 'اطلاعات با موفقیت حذف شد.', 'data' => null]);
    }
}
