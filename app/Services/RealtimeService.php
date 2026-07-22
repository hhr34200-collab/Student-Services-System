<?php

namespace App\Services;

use App\Events\RequestUpdatedEvent;

class RealtimeService
{
    /*
    |--------------------------------------------------------------------------
    | تحديث واجهة مستخدم
    |--------------------------------------------------------------------------
    */

    public static function refresh(int $userId)
    {
        event(

            new RequestUpdatedEvent($userId)

        );
    }


    /*
    |--------------------------------------------------------------------------
    | تحديث الطالب
    |--------------------------------------------------------------------------
    */

    public static function refreshStudent(int $userId)
    {
        self::refresh($userId);
    }

    /*
    |--------------------------------------------------------------------------
    | تحديث الموظف
    |--------------------------------------------------------------------------
    */

    public static function refreshEmployee(int $userId)
    {
        self::refresh($userId);
    }
}