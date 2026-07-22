<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | عرض صفحة الخدمات للطالب
    |--------------------------------------------------------------------------
    */
  public function index()
{
  $services = Service::all();

$routes = [

    'وقف القيد'     => 'stop-enrollment',

    'إعادة القيد'   => 'reopen-enrollment',

    'التظلم'        => 'appeal',

        'بيان حالة'    => null,

        'شهادة تخرج'   => null,
    ];

    return view(
        'dashboard-student.services',
        compact('services', 'routes')
    );
}
   
    /*
    |--------------------------------------------------------------------------
    | لوحة إدارة الخدمات (المسؤول)
    |--------------------------------------------------------------------------
    */
    public function adminIndex()
    {
         // جلب جميع الخدمات من قاعدة البيانات
        $services = Service::all();

        // إرسال البيانات للواجهة
        return view(
            'services.index',
            compact('services')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | حفظ خدمة جديدة
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        // التحقق من صحة البيانات المدخلة
        $request->validate([

            'service_name' =>
            'required|max:255',

            'description' =>
            'nullable'

        ]);

        // إنشاء خدمة جديدة
        Service::create([

            'service_name' =>
            $request->service_name,

            'description' =>
            $request->description,

            // أي خدمة جديدة تكون مفعلة تلقائياً
            'status' =>
            'active'

        ]);

        // الرجوع للصفحة مع رسالة نجاح
        return back()->with(
            'success',
            'تم إضافة الخدمة بنجاح'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | تعديل خدمة
    |--------------------------------------------------------------------------
    */
    public function update(
        Request $request,
        $id
    )
    {
        // البحث عن الخدمة
        $service =
        Service::findOrFail($id);

        // تحديث البيانات
        $service->update([

            'service_name' =>
            $request->service_name,

            'description' =>
            $request->description

        ]);

        return back()->with(
            'success',
            'تم تعديل الخدمة بنجاح'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | حذف خدمة
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        // البحث عن الخدمة
        $service =
        Service::findOrFail($id);

        // حذف الخدمة
        $service->delete();

        return back()->with(
            'success',
            'تم حذف الخدمة بنجاح'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | تفعيل أو إيقاف الخدمة
    |--------------------------------------------------------------------------
    */
    public function toggleStatus($id)
    {
        // جلب الخدمة
        $service =
        Service::findOrFail($id);

        // إذا كانت مفعلة تصبح موقفة
        if(
            $service->status
            ==
            'active'
        )
        {
            $service->status =
            'inactive';
        }
        else
        {
            // وإذا كانت موقفة تصبح مفعلة
            $service->status =
            'active';
        }

        // حفظ التعديل
        $service->save();

        return back()->with(
            'success',
            'تم تحديث حالة الخدمة'
        );
    }
    public function search(Request $request)
{
    $search = $request->search;

    $services = Service::when($search, function ($query) use ($search) {

        $query->where(
            'service_name',
            'LIKE',
            "%{$search}%"
        );

    })->get();

    return response()->json($services);
}
}