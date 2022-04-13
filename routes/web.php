<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin', [AdminController::class, 'loginPage'])->name('login');
Route::post('login', [AdminController::class, 'login'])->name('admin.login');

Route::middleware('admin.auth')->group(function () {
    Route::post('logout', [AdminController::class, 'logout'])->name('admin.logout');
    Route::get('main', [AdminController::class, 'main'])->name('admin.main');
    Route::resource('cities', \App\Http\Controllers\Admin\CityController::class);
    Route::resource('schools', \App\Http\Controllers\Admin\SchoolController::class);
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::resource('course-intros', \App\Http\Controllers\Admin\CourseIntroController::class);
    Route::get('course-intros-get/{id}', [\App\Http\Controllers\Admin\CourseIntroController::class, 'get'])->name('course-intros.intros');
    Route::resource('test', \App\Http\Controllers\Admin\TestController::class);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('employees', \App\Http\Controllers\Admin\EmployeeController::class);
    Route::resource('tariffs', \App\Http\Controllers\Admin\TariffController::class);
});
