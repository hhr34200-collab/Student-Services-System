<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        Notification::where(
            'user_id',
            Auth::id()
        )->where(
            'is_read',
            false
        )->update([
            'is_read' => true
        ]);

        $notifications = Notification::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();

        return view(
            'dashboard-student.notifications',
            compact('notifications')
        );
    }

    public function readAll()
    {
        Notification::where(
            'user_id',
            Auth::id()
        )->update([
            'is_read' => true
        ]);

        return back();
    }

    public function deleteSelected(Request $request)
    {
        Notification::whereIn(
            'id',
            $request->notifications
        )->delete();

        return back();
    }
    /*
|--------------------------------------------------------------------------
| إشعارات الموظف
|--------------------------------------------------------------------------
*/

public function employeeNotifications()
{
    /*
    |--------------------------------------------------------------------------
    | تعليم الإشعارات غير المقروءة كمقروءة
    |--------------------------------------------------------------------------
    */

    Notification::where(

        'user_id',

        Auth::id()

    )

    ->where(

        'is_read',

        false

    )

    ->update([

        'is_read' => true

    ]);

    /*
    |--------------------------------------------------------------------------
    | جلب جميع الإشعارات
    |--------------------------------------------------------------------------
    */

    $notifications = Notification::where(

        'user_id',

        Auth::id()

    )

    ->latest()

    ->paginate(10);

    /*
    |--------------------------------------------------------------------------
    | عرض الصفحة
    |--------------------------------------------------------------------------
    */

    return view(

        'employees.notifications',

        compact('notifications')

    );
}
}