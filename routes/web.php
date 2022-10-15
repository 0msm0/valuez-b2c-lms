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
    Route::get('dashboard', 'dashboard')->name('dashboard');
    Route::get('login', 'index')->name('login');
    Route::post('process-login', 'authuser')->name('login.process');
    Route::get('registration', 'registration')->name('register-user');
    Route::post('process-registration', 'createuser')->name('register.process');
    Route::get('signout', 'signout')->name('signout');
});


Route::controller(SchoolController::class)->group(function () {
    Route::get('manage-school', 'index')->name('school.list');
    Route::get('add-new-school', 'addschool')->name('school.add');
    Route::get('update-school', 'editschool')->name('school.edit');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('manage-course', 'index')->name('course.list');
});

Route::controller(LessonPlanController::class)->group(function () {
    Route::get('manage-lesson-plan', 'index')->name('lesson.plan.list');
});

Route::controller(ProgramController::class)->group(function () {
    Route::get('manage-program', 'index')->name('program.list');
});
