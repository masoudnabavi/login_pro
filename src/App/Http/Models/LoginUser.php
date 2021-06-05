<?php

namespace masoudnabavi\LoginPro\App\Http\Models;

use Browser;
use Exception;
use Illuminate\Database\Eloquent\Model;

class LoginUser extends Model
{
    public static function addLoginUser($user_id)
    {
        $loginuser = new LoginUser();
        $loginuser->ip = self::getUserIpAddr();
        $loginuser->browser = Browser::browserFamily();
        $loginuser->os = Browser::platformName();
        $loginuser->user_id = $user_id;
        $loginuser->save();
    }

    public static function updateLoginUser($user_id)
    {
        $loginuser = (new LoginUser)->find($user_id);
        $loginuser->ip = self::getUserIpAddr();
        $loginuser->browser = Browser::browserFamily();
        $loginuser->os = Browser::platformName();
        $loginuser->update();
    }

    public static function deleteLoginUser($request)
    {
        try {
            (new LoginUser)
                ->find($request->user_id)
                ->delete();
        } catch (Exception $e) {
        }
    }

    public static function getLoginUserData($id)
    {
        return (new LoginUser)
            ->where('user_id', $id)
            ->first();
    }

    public static function getUserIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public static function CheckUserAuthenticationData($id)
    {
        $data = self::getLoginUserData($id);
        if ($data->ip == self::getUserIpAddr() &&
            $data->os == Browser::platformName() &&
            $data->browser == Browser::browserFamily())
            return true;
        return false;

    }
}
