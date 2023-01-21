<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\{WebPage, Notification, ReportController, UserController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('isLogin')->get('/', function () {
    return redirect(route('login'));
});

Route::get('home', [AuthController::class, 'dashboard']);
Route::get('signout', [AuthController::class,'signout'])->name('signout');

Route::middleware('isLogin')->controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('process-login', 'authuser')->name('login.process');   
});

Route::middleware('auth')->get('master-dashboard', [AuthController::class, 'AdminDash'])->name('admin-dashboard');
Route::middleware('auth')->get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

Route::middleware('auth')->prefix('school')->controller(SchoolController::class)->group(function () {
    Route::get('manage-school', 'index')->name('school.list');
    Route::get('add-new-school', 'addschool')->name('school.add');
    Route::get('update-school', 'editschool')->name('school.edit');
    Route::post('remove-school', 'destroy')->name('school.remove');
    Route::post('school-add', 'store')->name('school.store');
    Route::post('school-edit', 'edit')->name('school.update');
    Route::post('school-status', 'change_status')->name('school.status');
    Route::post('teacher-status', 'change_user_status')->name('teacher.status');
    Route::post('fetch-cities', 'CityList')->name('city.json');
    Route::get('users-logs-list/{userid}', 'viewLogs')->name('user.logs.list');
});

Route::middleware('auth')->prefix('course')->controller(CourseController::class)->group(function () {
    Route::get('manage-course', 'index')->name('course.list');
    Route::get('add-course', 'addcourse')->name('course.add');
    Route::get('update-course', 'editcourse')->name('course.edit');
    Route::post('remove-course', 'destroy')->name('course.remove');
    Route::post('course-add', 'store')->name('course.store');
    Route::post('course-edit', 'edit')->name('course.update');
});

Route::middleware('auth')->prefix('lesson-plan')->controller(LessonPlanController::class)->group(function () {
    Route::get('manage-lesson-plan', 'index')->name('lesson.plan.list');
    Route::get('add-lesson-plan', 'addlessonplan')->name('lesson.plan.add');
    Route::get('update-lesson-plan', 'editlessonplan')->name('lesson.plan.edit');
    Route::get('remove-lesson-plan', 'destroy')->name('lesson.plan.remove');
    Route::post('lesson-plan-add', 'store')->name('lesson.plan.store');
    Route::post('lesson-plan-edit', 'edit')->name('lesson.plan.update');
});

Route::middleware('auth')->prefix('grade')->controller(ProgramController::class)->group(function () {
    Route::get('manage-grade', 'index')->name('program.list');
    Route::get('add-grade', 'addprogram')->name('program.add');
    Route::get('update-grade', 'editprogram')->name('program.edit');
    Route::post('remove-grade', 'destroy')->name('program.remove');
    Route::post('grade-add', 'store')->name('program.store');
    Route::post('grade-edit', 'edit')->name('program.update');
});

Route::middleware('auth')->prefix('school')->controller(AuthController::class)->group(function () {
    Route::get('manage-teacher', 'userlist')->name('teacher.list');
    Route::get('add-teacher', 'addUser')->name('teacher.add');
    Route::get('update-teacher', 'updateUser')->name('teacher.edit');
    Route::post('teacher-remove', 'destroy')->name('teacher.remove');
    Route::post('teacher-add', 'createuser')->name('teacher.store');
    Route::post('teacher-edit', 'edituser')->name('teacher.update');
    Route::get('teacher-list', 'teacherList')->name('school.teacher.list');
    Route::post('reset-password', 'resetPassword')->name('user.password');

    Route::get('manage-school-admin', 'SchoolAdmin')->name('school.admin');
    Route::get('update-school-admin/{userid}', 'updateAdminUser')->name('school.admin.edit');
});

Route::middleware('auth')->prefix('teacher')->group(function () {
    Route::get('class-list', [ProgramController::class, 'TeacherClasslist'])->name('teacher.class.list');
    Route::get('course-list/{class}', [WebPage::class, 'courselist'])->name('teacher.course.list');
    Route::get('lesson-plan-list/{classid}/{course}', [WebPage::class, 'lessonPlan'])->name('teacher.lesson.list');
    Route::post('save-plan-report', [WebPage::class, 'setUserReport'])->name('report.save.plan');
});

Route::middleware('auth')->prefix('whats-new')->controller(Notification::class)->group(function () {
    Route::get('manage-notification', 'index')->name('notify.list');
    Route::get('add-notification', 'addnewNotification')->name('notify.add');
    Route::post('add-update-notify', 'addUpdateNotify')->name('notify.store');
    Route::get('view-whats-new', 'viewNotify')->name('notify.schoolview');
});

Route::middleware('auth')->prefix('users')->controller(UserController::class)->group(function () {
    Route::get('manage-users', 'index')->name('users.admin.list');
    Route::get('add-master-user', 'AddAdminUser')->name('users.admin.add');
    Route::get('update-master-user', 'editAdminUser')->name('users.admin.edit');
    Route::post('store-master-user', 'AddUpdateAdminUser')->name('users.admin.store');
    Route::post('master-user-remove', 'destroy')->name('users.admin.remove');
});

Route::middleware('auth')->prefix('reports')->controller(ReportController::class)->group(function () {
    Route::get('view-engagement', 'index')->name('report.school.view');
});
Route::get('send-mail', function () {
    $details = [
        'view' => 'emails.test',
        'subject' => 'Test Mail form LMS',
        'title' => 'Mail from Valuez hut',
        'body' => 'This is for testing email using smtp'
    ];
    \Mail::to('itrahul.com@gmail.com')->send(new \App\Mail\TestMail($details));
    dd("Email is Sent.");
});
