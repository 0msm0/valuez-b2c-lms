<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\ProgramController;
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


Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('login');
    Route::post('process-login', 'authuser')->name('login.process');
    Route::get('registration', 'registration')->name('register-user');
    Route::post('process-registration', 'createuser')->name('register.process');
    Route::get('signout', 'signout')->name('signout');
});

Route::get('dashboard', [AuthController::class,'dashboard'])->name('dashboard');

Route::middleware('auth')->controller(SchoolController::class)->group(function () {
    Route::get('manage-school', 'index')->name('school.list');
    Route::get('add-new-school', 'addschool')->name('school.add');
    Route::get('update-school', 'editschool')->name('school.edit');
});

Route::middleware('auth')->controller(CourseController::class)->group(function () {
    Route::get('manage-course', 'index')->name('course.list');
    Route::get('add-course', 'addcourse')->name('course.add');
    Route::get('update-course', 'editcourse')->name('course.edit');
    Route::post('remove-course', 'destroy')->name('course.remove');
    Route::post('course-add', 'store')->name('course.store');
    Route::post('course-edit', 'edit')->name('course.update');

});

Route::middleware('auth')->controller(LessonPlanController::class)->group(function () {
    Route::get('manage-lesson-plan', 'index')->name('lesson.plan.list');
    Route::get('add-lesson-plan', 'addlessonplan')->name('lesson.plan.add');
    Route::get('update-lesson-plan', 'editlessonplan')->name('lesson.plan.edit');
    Route::post('remove-lesson-plan', 'destroy')->name('lesson.plan.remove');
    Route::post('lesson-plan-add', 'store')->name('lesson.plan.store');
    Route::post('lesson-plan-edit', 'edit')->name('lesson.plan.update');
});

Route::middleware('auth')->controller(ProgramController::class)->group(function () {
    Route::get('manage-program', 'index')->name('program.list');
    Route::get('add-program', 'addprogram')->name('program.add');
    Route::get('update-program', 'editprogram')->name('program.edit');
    Route::post('remove-program', 'destroy')->name('program.remove');
    Route::post('program-add', 'store')->name('program.store');
    Route::post('program-edit', 'edit')->name('program.update');
});
