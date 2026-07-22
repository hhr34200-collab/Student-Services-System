<?php

namespace App\Services;

use App\Models\Notification;
use App\Events\NewNotificationEvent;

class NotificationService
{
    /*
    |--------------------------------------------------------------------------
    | إرسال إشعار
    |--------------------------------------------------------------------------
    |
    | تقوم هذه الدالة بـ:
    | 1- حفظ الإشعار في قاعدة البيانات.
    | 2- إرسال الإشعار الفوري عبر Reverb.
    |
    */

    public static function send(

        int $userId,

        string $title,

        string $message,

        string $type = 'info',

        ?int $requestId = null,

        ?string $actionUrl = null

    )
    {

        $notification = Notification::create([

            'user_id'      => $userId,

            'request_id'   => $requestId,

            'title'        => $title,

            'message'      => $message,

            'type'         => $type,

            'action_url'   => $actionUrl,

            'is_read'      => false

        ]);

        event(
            new NewNotificationEvent($notification)
        );

        return $notification;
    }
}