<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StopEnrollmentController;
use App\Http\Controllers\MyRequestsController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReopenEnrollmentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AppealController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseAssignmentController;
use App\Http\Controllers\UserGuideController;
use App\Http\Controllers\ReportController;



// التعديل هنا: إذا دخل المستخدم للموقع وهو مسجل دخوله سابقاً، سيتم تسجيل خروجه فوراً وتوجيهه لصفحة الدخول
Route::get('/', function () {
    if (Auth::check()) {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
    return redirect()->route('login');
});

// قمنا بإخراج عرض صفحة تسجيل الدخول من الـ guest middleware لتظهر دائماً
Route::get('/login', [LoginController::class, 'showLogin'])->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
});

 
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');


Route::get('/register', [RegisterController::class, 'showRegister'])
    ->name('register');

Route::post('/register', [RegisterController::class,'store'])
    ->name('register.store');   
 
Route::get('/home', [HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');
    
Route::post('/get-student-data', [RegisterController::class, 'getStudentData'])
    ->name('student.data');

/*
|--------------------------------------------------------------------------
| إدارة الخدمات
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // صفحة إدارة الخدمات
    Route::get('/services', [ServiceController::class, 'adminIndex'])
        ->name('services.index');

    // إضافة خدمة
    Route::post('/services/store', [ServiceController::class, 'store'])
        ->name('services.store');

    // تعديل خدمة
    Route::post('/services/{id}/update', [ServiceController::class, 'update'])
        ->name('services.update');

    // حذف خدمة
    Route::get('/services/{id}/delete', [ServiceController::class, 'destroy'])
        ->name('services.delete');

    // تغيير حالة الخدمة
    Route::get('/services/{id}/status', [ServiceController::class, 'toggleStatus'])
        ->name('services.status');

    Route::get('/services/search',  [ServiceController::class, 'search']  )
        ->name('services.search');
});

/*
|--------------------------------------------------------------------------
| خدمات الطالب
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/student/services', [ServiceController::class, 'index'])
        ->name('student.services');
    Route::get('/students/search', [StudentController::class, 'search'])
    ->name('students.search');

});

Route::get(
    '/stop-enrollment',
    [StopEnrollmentController::class, 'create']
)->name('stop-enrollment');

Route::post(
    '/stop-enrollment/store',
    [StopEnrollmentController::class, 'store']
)->name('stop-enrollment.store');

Route::get(
    '/my-requests',
    [MyRequestsController::class,'index']
)->name('my-requests');

Route::get(
    '/my-requests/{id}',
    [MyRequestsController::class,'show']
)->name('my-requests.show');

Route::get(
    '/my-requests/{id}/print',
    [MyRequestsController::class,'print']
)->name('my-requests.print');


Route::post(
    '/my-requests/{id}/complete',
    [MyRequestsController::class,'completeRequest']
)->name('my-requests.complete');


Route::middleware('auth')->group(function () {

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    )->name('notifications');

    Route::get(
        '/notifications/unread-count',
        [NotificationController::class, 'getUnreadCount']
    )->name('notifications.unreadCount');

    Route::get(
        '/notifications/check-new',
        [NotificationController::class, 'checkNewNotifications']
    )->name('notifications.checkNew');

});

Route::post(
    '/notifications/read-all',
    [NotificationController::class,'readAll']
)->name('notifications.readAll');

Route::post(
    '/notifications/delete-selected',
    [NotificationController::class,'deleteSelected']
)->name('notifications.deleteSelected');
Route::get(
    '/employee/notifications',
    [NotificationController::class,'employeeNotifications']
)->name('employee.notifications');



Route::middleware(['auth'])->group(function () {


Route::get(
    '/profile',
    [ProfileController::class, 'index']
)->name('profile');

Route::post(
    '/profile/verify-password',
    [ProfileController::class, 'verifyPassword']
)->name('profile.verifyPassword');

Route::post(
    '/profile/update',
    [ProfileController::class, 'update']
)->name('profile.update');

Route::get(
    '/attachments',
    [ProfileController::class, 'attachments']
)->name('attachments');
});


Route::middleware(['auth'])->group(function () {

    Route::get(
        '/reopen-enrollment',
        [ReopenEnrollmentController::class, 'create']
    )->name('reopen-enrollment');

    Route::post(
        '/reopen-enrollment',
        [ReopenEnrollmentController::class, 'store']
    )->name('reopen-enrollment.store');

});
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/admin',
        [AdminController::class, 'index']
    )->name('admin.dashboard');

});
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/employee',
        [EmployeeDashboardController::class, 'index']
    )->name('employee.dashboard');

    Route::get(
        '/employee/request/{id}',
        [EmployeeDashboardController::class, 'show']
    )->name('employee.request.show');

    Route::post(
        '/employee/request/{id}/approve',
        [EmployeeDashboardController::class, 'approve']
    )->name('employee.request.approve');

    Route::post(
        '/employee/request/{id}/save-approval',
        [EmployeeDashboardController::class, 'saveApproval']
    )->name('employee.request.saveApproval');

Route::post(
    '/employee/request/{id}/reject',
    [EmployeeDashboardController::class, 'reject']
)->name('employee.request.reject');
Route::post(

    '/employee/request/{id}/return',

    [EmployeeDashboardController::class,'returnRequest']

)->name('employee.request.return');
Route::get(
    '/employee/review-requests',
    [EmployeeDashboardController::class, 'reviewRequests']
)->name('employee.review');
Route::get(
    '/employee/need-complete',
    [EmployeeDashboardController::class,'needComplete']
)->name('employee.need-complete');
Route::get(
    '/employee/archive',
    [EmployeeDashboardController::class,'archive']
)->name('employee.archive');

    Route::get(
        '/employee/profile',
        [EmployeeDashboardController::class,'profile']
    )->name('employee.profile');




});
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/requests/{id}/next',
        [RequestController::class, 'moveNext']
    )->name('requests.next');

});
Route::middleware(['auth'])->group(function () {

    Route::get(
        '/requests',
        [RequestController::class, 'index']
    )->name('requests.index');
    
    Route::get('/admin/requests/{id}/json', [RequestController::class, 'showJson'])->name('requests.json');

});



use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/create-admin', function () {

    $admin = User::where(
        'email',
        'admin@admin.com'
    )->first();

    if ($admin) {

        return 'حساب الأدمن موجود مسبقاً';

    }

   User::create([

    'username' => 'admin',

    'email' => 'admin@admin.com',

    'password' => Hash::make('123456'),

    'role_id' => 1,

    'student_id' => null,

    'employee_id' => null,

]);

    return 'تم إنشاء حساب الأدمن بنجاح';

});
Route::middleware(['auth'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/search-existing', [EmployeeController::class, 'searchExisting'])->name('employees.searchExisting');
    Route::post('/employees/store-new', [EmployeeController::class, 'storeNew'])->name('employees.storeNew');
    Route::post('/employees/link-existing', [EmployeeController::class, 'linkExisting'])->name('employees.linkExisting');
    Route::post('/employees/update/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::get('/employees/delete/{id}', [EmployeeController::class, 'delete'])->name('employees.delete');
    Route::get('/employees/toggle-status/{id}', [EmployeeController::class, 'toggleStatus'])->name('employees.toggleStatus');
    Route::get(
    '/employee/request/{id}/print',
    [EmployeeDashboardController::class, 'print']
)->name('employee.request.print');
Route::get(
    '/attachment/{id}',
    [EmployeeDashboardController::class,'downloadAttachment']
)->name('attachment.download');
});


Route::get(
    '/employee/request/{id}/print',
    [EmployeeDashboardController::class, 'print']
)->name('employee.request.print');
Route::get(
    '/attachment/{id}',
    [EmployeeDashboardController::class,'downloadAttachment']
)->name('attachment.download');

Route::middleware(['auth'])->group(function () {

    Route::get('/students', [StudentController::class, 'index'])
        ->name('students.index');

    Route::post('/students/store', [StudentController::class, 'store'])
        ->name('students.store');

    Route::post('/students/{id}/update', [StudentController::class, 'update'])
        ->name('students.update');

    Route::post('/students/{id}/delete', [StudentController::class, 'destroy'])
        ->name('students.destroy');

    Route::get('/students/{id}/toggle-status', [StudentController::class, 'toggleStatus'])
        ->name('students.toggleStatus');

});
/*
|--------------------------------------------------------------------------
| خدمة التظلم
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |------------------------------------------------------------
    | عرض صفحة التظلم
    |------------------------------------------------------------
    */

    Route::get(
        '/appeal',
        [AppealController::class, 'create']
    )->name('appeal');

    /*
    |------------------------------------------------------------
    | حفظ طلب التظلم
    |------------------------------------------------------------
    */

    Route::post(
        '/appeal/store',
        [AppealController::class, 'store']
    )->name('appeal.store');

    /*
    |------------------------------------------------------------
    | جلب المقررات حسب الفصل الدراسي
    |------------------------------------------------------------
    */

    Route::get(
        '/appeal/courses',
        [AppealController::class, 'getCourses']
    )->name('appeal.courses');

});

/*
|--------------------------------------------------------------------------
| إدارة المقررات
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/courses',
        [CourseController::class, 'index']
    )->name('courses.index');

    Route::post(
        '/courses/store',
        [CourseController::class, 'store']
    )->name('courses.store');

    Route::post(
        '/courses/{id}/update',
        [CourseController::class, 'update']
    )->name('courses.update');

    Route::post(
        '/courses/{id}/delete',
        [CourseController::class, 'destroy']
    )->name('courses.delete');

    Route::get(
        '/courses/{id}/toggle-status',
        [CourseController::class, 'toggleStatus']
    )->name('courses.toggleStatus');

});
/*
|--------------------------------------------------------------------------
| إدارة الكليات
|--------------------------------------------------------------------------
*/

Route::get(
    '/colleges',
    [CollegeController::class, 'index']
)->name('colleges.index');


Route::post(
    '/colleges/store',
    [CollegeController::class, 'store']
)->name('colleges.store');


Route::post(
    '/colleges/{id}/update',
    [CollegeController::class, 'update']
)->name('colleges.update');


Route::post(
    '/colleges/{id}/delete',
    [CollegeController::class, 'destroy']
)->name('colleges.delete');


Route::get(
    '/colleges/{id}/toggle-status',
    [CollegeController::class, 'toggleStatus']
)->name('colleges.toggleStatus');
/*
|--------------------------------------------------------------------------
| إدارة الأقسام
|--------------------------------------------------------------------------
*/

Route::get(
    '/departments',
    [DepartmentController::class,'index']
)->name('departments.index');


Route::post(
    '/departments/store',
    [DepartmentController::class,'store']
)->name('departments.store');


Route::post(
    '/departments/{id}/update',
    [DepartmentController::class,'update']
)->name('departments.update');


Route::post(
    '/departments/{id}/delete',
    [DepartmentController::class,'destroy']
)->name('departments.delete');
/*
|--------------------------------------------------------------------------
| توزيع المقررات
|--------------------------------------------------------------------------
*/

Route::get(

    '/course-assignments',

    [CourseAssignmentController::class,'index']

)->name('course-assignments.index');


Route::post(

    '/course-assignments/store',

    [CourseAssignmentController::class,'store']

)->name('course-assignments.store');


Route::post(

    '/course-assignments/{id}/update',

    [CourseAssignmentController::class,'update']

)->name('course-assignments.update');


Route::post(

    '/course-assignments/{id}/delete',

    [CourseAssignmentController::class,'destroy']

)->name('course-assignments.delete');


Route::get('/user-guide', [UserGuideController::class, 'index'])
    ->name('user-guide');
    

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/admin/reports',
        [ReportController::class, 'report']
    )->name('admin.reports');

    Route::get(
        '/admin/reports/pdf',
        [ReportController::class, 'downloadPdf']
    )->name('admin.reports.report-pdf');

});