<?php

namespace masoudnabavi\login_pro\App\Http\Models;


use masoudnabavi\login_pro\App\Http\Controllers\General\DatetimeConverter;
use Dirape\Token\Token;
use Exception;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public static function addUser($request)
    {
        $user = new User();

        if ($request->email)
            $user->email = $request->email;
        if ($request->mobile)
            $user->mobile = $request->mobile;
        if ($request->national_code)
            $user->national_code = $request->national_code;
        if ($request->username)
            $user->username = $request->username;
        if ($request->password)
            $user->birth_date = DatetimeConverter::jalaliToGregorian($request->birth_date, 'Y/m/d', 'Y-m-d');
        if ($request->password)
            $user->password = md5($request->password);

        $user->save();
        return $user->id;
    }

    public static function editUser($request)
    {
        $user = (new User)->find($request->id);

        if ($request->email)
            $user->email = $request->email;
        if ($request->mobile)
            $user->mobile = $request->mobile;
        if ($request->national_code)
            $user->national_code = $request->national_code;
        if ($request->username)
            $user->username = $request->username;
        if ($request->password)
            $user->birth_date = DatetimeConverter::jalaliToGregorian($request->birth_date, 'Y/m/d', 'Y-m-d');
        if ($request->password)
            $user->password = md5($request->password);

        $user->update();
    }

    public static function deleteUser($request)
    {
        try {
            (new User)
                ->find($request->id)
                ->delete();
        } catch (Exception $e) {
        }
    }

    public static function getUserData($id)
    {
        return (new User)
            ->where('id', $id)
            ->first();
    }

    public static function getUserId($Value)
    {
        return (new User)
            ->where('token', $Value)
            ->first()
            ->id;
    }

    public static function listUser()
    {
        return (new User)
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    //Check Is Data Exists In DataBase
    public static function dataIsValid($colName, $input)
    {
        return (new User)
            ->where($colName, $input)
            ->exists();
    }

    //Check Is Data Exists In DataBase
    public static function ValidateUserForForgotPassword($colName, $input, $birth_date, $id)
    {
        return (new User)
            ->where('id', $id)
            ->where('birth_date', DatetimeConverter::jalaliToGregorian($birth_date, 'Y/m/d', 'Y-m-d'))
            ->where($colName, $input)
            ->exists();
    }

    //first Input Select DataBase Column Name, Second Input is your Data, Third Input is your Password To Validate
    public static function dataWithPasswordIsValid($colName, $input, $password)
    {
        return (new User)
            ->where($colName, $input)
            ->where('password', md5($password))
            ->exists();
    }

    //first Input Select DataBase Column Name And Second Input is your Data to login
    public static function loginWithoutPassword($colName, $input)
    {
        $token = (new Token())->Unique('users', 'token', 30);

        $user = (new User)
            ->select('id', $colName, 'token')
            ->where($colName, $input)
            ->first();
        $user->token = $token;
        $user->update();
        return $user->id;
    }

    public static function loginAsSecondUser($user_id)
    {
        $token = (new Token())->Unique('users', 'token', 30);
        $user = (new User)
            ->select('id', 'token')
            ->where('id', $user_id)
            ->first();
        $user->token = $token;
        $user->update();
    }

    //first Input Select DataBase Column Name, Second Input is your Data, Third Input is your Password To login
    public static function loginWithPassword($colName, $input, $password)
    {
        $token = (new Token())->Unique('users', 'token', 30);

        $user = (new User)
            ->select('id', $colName, 'token', 'password')
            ->where($colName, $input)
            ->where('password', md5($password))
            ->first();
        $user->token = $token;
        $user->update();
        return $user->id;

    }

    public static function getToken($user_id)
    {
        return (new User)
            ->where('id', $user_id)
            ->first()
            ->token;
    }

    //first Input Is Your Data`s Id, Second Input Is Your Data, Third Input Is Your Database Column Name
    public static function isDataNotUnique($id, $input, $colName)
    {
        return (new User)
            ->where($colName, $input)
            ->where('id', '!=', $id)
            ->exists();
    }


    public static function ChangePassword($password, $id)
    {
        $user = (new User)->find($id);
        $user->password = md5($password);
        $user->update();
    }

    public static function twoStepAuthStatus($id)
    {
        return (new User)
            ->where('id', $id)
            ->first()
            ->two_factor_status;
    }

    public static function addCounter($count, $id)
    {
        $user = new User();
        $user->where('id', $id);
        $user->count_code_sent = $count;
        $user->update();
    }

    public static function blockUser($id, $status)
    {
        $user = new User();
        $user->where('id', $id);
        $user->blocked_user = $status;
        $user->update();
    }


}
