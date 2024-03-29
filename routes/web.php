<?php

use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\StudentLoginController;
use App\Http\Controllers\Auth\StudentRegistrationController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', HomeController::class)->name('home');
Route::get('/home', HomeController::class);


Route::middleware('guest')->group(function () {
    Route::get('/registration', [RegistrationController::class, 'show'])->name('registration.show');
    Route::post('/registration', [RegistrationController::class, 'store'])->name('registration.store');
    
    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/student/registration', [RegistrationController::class, 'show'])->name('student.registration.show');
    Route::post('/student/registration', [RegistrationController::class, 'store'])->name('student.registration.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'delete'])->name('logout');

    Route::get('/course/my', [CourseController::class, 'my'])->name('course.my');
    Route::get('/course/saved', [CourseController::class, 'saved'])->name('course.saved');
    Route::post('/course/{course}/save', [CourseController::class, 'save'])->name('course.save');
    Route::resource('course', CourseController::class)->except(['index', 'show']);

    Route::get('/test/my', [TestController::class, 'my'])->name('test.my');
    Route::get('/test/saved', [TestController::class, 'saved'])->name('test.saved');
    Route::post('/test/{test}/save', [TestController::class, 'save'])->name('test.save');
    Route::post('/test/{test}/publish', [TestController::class, 'publish'])->name('test.publish');
    Route::resource('test', TestController::class)->except(['index', 'show', 'update']);

    Route::get('/exam', [ExamController::class, 'index'])->name('exam.index');
    Route::resource('test.exam', ExamController::class)->shallow()->except(['index']);

    route::get('/testing', [TestingController::class, 'index'])->name('testing.index');

    Route::resource('user', UserController::class)->only(['edit', 'update', 'destroy']);

    Route::get('/password/change', [PasswordController::class, 'show'])->name('password.change');
    Route::post('/password/change', [PasswordController::class, 'store'])->name('password.store');
});

Route::resource('course', CourseController::class)->only(['index', 'show']);

Route::post('/test/{test}/start', [TestController::class, 'start'])->name('test.start');
Route::resource('test', TestController::class)->only(['index', 'show']);

Route::get('/join', [ExamController::class, 'join'])->name('exam.join');
Route::post('/join', [ExamController::class, 'start'])->name('exam.start');

Route::get('/testing/{session}', [TestingController::class, 'show'])->name('testing.show');
Route::delete('/testing/{session}', [TestingController::class, 'complete'])->name('testing.complete');
Route::get('/testing/{session}/result', [TestingController::class, 'result'])->name('testing.result');

Route::resource('user', UserController::class)->only(['show']);

Route::get('/about', [PagesController::class, 'about'])->name('pages.about');
Route::get('/zno', [PagesController::class, 'zno'])->name('pages.zno');