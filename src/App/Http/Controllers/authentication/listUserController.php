<?php

namespace masoudnabavi\LoginPro\App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use masoudnabavi\LoginPro\App\Http\Models\User;
use Illuminate\Http\Request;
use Throwable;


class listUserController extends Controller
{
    protected function index(Request $request)
    {
        $list = User::listUser();

        if ($request->ajax()) {
            try {
                return view('login_pro::user.listLoad', ['list' => $list])->render();
            } catch (Throwable $e) {
            }
        }

        return view('login_pro::user.list', compact('list'));
    }
}
