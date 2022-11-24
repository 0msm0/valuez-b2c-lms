<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\WebPage;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('home', [AuthController::class, 'dashboard']);

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('process-login', 'authuser')->name('login.process');
    Route::get('signout', 'signout')->name('signout');
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
    Route::post('remove-lesson-plan', 'destroy')->name('lesson.plan.remove');
    Route::post('lesson-plan-add', 'store')->name('lesson.plan.store');
    Route::post('lesson-plan-edit', 'edit')->name('lesson.plan.update');
});

Route::middleware('auth')->prefix('program')->controller(ProgramController::class)->group(function () {
    Route::get('manage-program', 'index')->name('program.list');
    Route::get('add-program', 'addprogram')->name('program.add');
    Route::get('update-program', 'editprogram')->name('program.edit');
    Route::post('remove-program', 'destroy')->name('program.remove');
    Route::post('program-add', 'store')->name('program.store');
    Route::post('program-edit', 'edit')->name('program.update');
});

Route::middleware('auth')->prefix('school')->controller(AuthController::class)->group(function () {
    Route::get('manage-teacher', 'userlist')->name('teacher.list');
    Route::get('add-teacher', 'addUser')->name('teacher.add');
    Route::get('update-teacher', 'updateUser')->name('teacher.edit');
    Route::post('teacher-remove', 'destroy')->name('teacher.remove');
    Route::post('teacher-add', 'createuser')->name('teacher.store');
    Route::post('teacher-edit', 'edituser')->name('teacher.update');
});

Route::middleware('auth')->prefix('teacher')->group(function () {
    Route::get('class-list', [ProgramController::class,'TeacherClasslist'])->name('teacher.class.list');
    Route::get('course-list/{class}', [WebPage::class,'courselist'])->name('teacher.course.list');
    Route::get('lesson-plan-list/{classid}/{course}', [WebPage::class,'lessonPlan'])->name('teacher.lesson.list');
});

Route::get('send-mail', function () {   
    $details = [
        'title' => 'Mail from LMS.com',
        'body' => 'This is for testing email using smtp'
    ];   
    \Mail::to('test@lms.democlicks.com')->send(new \App\Mail\TestMail($details));   
    dd("Email is Sent.");
});