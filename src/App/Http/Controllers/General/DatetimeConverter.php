<?php

namespace  masoudnabavi\LoginPro\App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use DateTime;
use Exception;
use Morilog\Jalali\CalendarUtils;

class DatetimeConverter extends Controller
{
    public static function jalaliToGregorian($date_time, $input_format, $response_format)
    {
        $date_time_formatted = date($input_format, strtotime($date_time));

        try {
            $date_time_formatted = CalendarUtils::createCarbonFromFormat($input_format, $date_time_formatted);
            $date_time_formatted = new DateTime($date_time_formatted);
            $date_time_formatted = $date_time_formatted->format($response_format);

            return $date_time_formatted;
        } catch (Exception $e) {
        }
    }
}
