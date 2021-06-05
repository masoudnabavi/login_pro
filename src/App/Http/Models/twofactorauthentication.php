<?php

namespace masoudnabavi\LoginPro\App\Http\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class twofactorauthentication extends Model
{
    public static function twoStepAuthAdd($two_step_code, $user_id)
    {
        $user = new twofactorauthentication();
        $user->last_time_code_sent = Carbon::now();
        $user->user_id = $user_id;
        $user->two_step_code = md5($two_step_code);
        $user->save();

    }

    public static function twoStepAuthCheck($id, $code)
    {
        return (new twofactorauthentication)
            ->where('id', $id)
            ->where('two_step_code', md5($code));
    }

}
