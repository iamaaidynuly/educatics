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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [AdminController::class, 'loginPage']);
Route::get('/admin', [AdminController::class, 'loginPage'])->name('login');
Route::post('login', [AdminController::class, 'login'])->name('admin.login');

Route::get('/pdf-download', [AdminController::class, 'pdf']);

Route::get('certificate', [\App\Http\Controllers\Admin\CertificateController::class, 'get']);

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
    Route::resource('tariff-texts', \App\Http\Controllers\Admin\TariffTextController::class);
    Route::resource('about-us', \App\Http\Controllers\Admin\AboutUController::class);
    Route::resource('stories', \App\Http\Controllers\Admin\StoryController::class);
    Route::resource('prof-tests', \App\Http\Controllers\Admin\ProfTestController::class);
    Route::resource('answers', \App\Http\Controllers\Admin\AnswerController::class);
    Route::resource('video', \App\Http\Controllers\Admin\VideoController::class);
    Route::resource('docs', \App\Http\Controllers\Admin\DocController::class);

    Route::resource('main-page', \App\Http\Controllers\Admin\MainPageController::class);
    Route::resource('social', \App\Http\Controllers\Admin\SocialController::class);
    Route::resource('feedback', \App\Http\Controllers\Admin\FeedbackController::class);
    Route::resource('footer-doc', \App\Http\Controllers\Admin\FooterDocController::class);
    Route::resource('spheres', \App\Http\Controllers\Admin\SphereController::class);
    Route::resource('reviews', \App\Http\Controllers\Admin\ReviewController::class);
    Route::resource('questions',  \App\Http\Controllers\Admin\QuestionController::class);
    Route::resource('question-answer', \App\Http\Controllers\Admin\QuestionAnswerController::class);
    Route::resource('faq',  \App\Http\Controllers\Admin\FaqController::class);
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    Route::resource('course-page', \App\Http\Controllers\Admin\CoursePageController::class);
    Route::resource('prof-test-page', \App\Http\Controllers\Admin\ProfTestPageController::class);
    Route::resource('event-page', \App\Http\Controllers\Admin\EventPageController::class);
    Route::resource('footer', \App\Http\Controllers\Admin\FooterController::class);
    Route::resource('transactions', \App\Http\Controllers\Admin\TransactionController::class);
    Route::resource('promocodes', \App\Http\Controllers\Admin\PromocodeController::class);
    Route::resource('contacts', \App\Http\Controllers\Admin\ContactController::class);
    Route::post('docs-store', [\App\Http\Controllers\Admin\DocController::class, 'store'])->name('docs-store');
    Route::get('course-seo/{id}', [\App\Http\Controllers\Admin\CourseController::class, 'seo'])->name('course-seo');
    Route::post('course-seo-update', [\App\Http\Controllers\Admin\CourseController::class, 'updateSeo'])->name('course-seo-update');

    Route::get('user-course-add/{id}', [\App\Http\Controllers\Admin\UserController::class, 'addCourse'])->name('user-course-add');
    Route::post('user-course-store', [\App\Http\Controllers\Admin\UserController::class, 'storeCourse'])->name('user-course-store');
    Route::delete('user-course-destroy', [\App\Http\Controllers\Admin\UserController::class, 'destroyCourse'])->name('user-course-destroy');

    Route::get('users-export', [\App\Http\Controllers\Admin\UserController::class, 'export'])->name('users-export');
});
