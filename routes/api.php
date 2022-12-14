<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SchoolController;
use App\Http\Controllers\Api\FeedbackController;
use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('send-code', [AuthController::class, 'send']);
Route::post('check-code', [AuthController::class, 'check']);

Route::get('reset-password-code', [AuthController::class, 'resetPasswordCode']);
Route::get('reset-password-check-code', [AuthController::class, 'checkPasswordCode']);
Route::post('reset-password-correct', [AuthController::class, 'newPassword'])->middleware('auth:sanctum');

Route::get('cities', [CityController::class, 'get']);
Route::get('tariffs', [CityController::class, 'getTariff']);
Route::get('schools', [SchoolController::class, 'get']);
Route::get('courses', [CourseController::class, 'get']);
Route::get('courses-by-tariff', [CourseController::class, 'byTariff']);
Route::get('course-by-id', [CourseController::class, 'getOne']);
Route::get('course-intros', [CourseController::class, 'byId']);
Route::get('course-intro-by-id', [CourseController::class, 'getIntroById']);
Route::get('course-intro-test', [CourseController::class, 'getTest']);
Route::get('course-intro-videos', [CourseController::class, 'videos'])->middleware('auth:sanctum');
Route::get('about-us', [ApiController::class, 'about']);
Route::get('articles', [ApiController::class, 'article']);
Route::get('employees', [EmployeeController::class, 'get']);
Route::get('answers', [\App\Http\Controllers\Api\AnswerController::class, 'get']);
Route::get('prof-test', [\App\Http\Controllers\Api\ProfTestController::class, 'get']);
Route::get('prof-test/questions', [\App\Http\Controllers\Api\ProfTestController::class, 'questions']);

Route::post('prof-test/answer/submit', [\App\Http\Controllers\Api\ProfTestController::class, 'submit']);
Route::post('prof-test/answers/finish', [\App\Http\Controllers\Api\ProfTestController::class, 'finish']);
Route::post('prof-test/answers/decline', [\App\Http\Controllers\Api\ProfTestController::class, 'decline']);

Route::get('spheres', [\App\Http\Controllers\Api\SphereController::class, 'get']);
Route::get('session', [ApiController::class, 'session']);

Route::post('feedback', [\App\Http\Controllers\Api\FeedbackController::class, 'post']);

Route::get('socials', [ApiController::class, 'socials']);
Route::get('main-page', [ApiController::class, 'main']);
Route::get('get-footer', [ApiController::class, 'footer']);

Route::get('success-payment-promocode/{user}/{tariff}/{transaction}/{promocode}', [PaymentController::class, 'successPayment']);
Route::get('reject-payment/{user}/{tariff}/{transaction}', [PaymentController::class, 'reject']);

Route::get('success-payment/{user}/{tariff}/{transaction}', [PaymentController::class, 'success']);

Route::get('by-session-id', [\App\Http\Controllers\Api\ProfTestController::class, 'bySession']);

Route::get('reviews', [ApiController::class, 'reviews']);
Route::get('faq', [ApiController::class, 'faq']);
Route::get('statistics-student', [\App\Http\Controllers\Api\StatisticsController::class, 'students']);
Route::get('statistics-course', [\App\Http\Controllers\Api\StatisticsController::class, 'course']);
Route::get('events', [ApiController::class, 'events']);
Route::get('course-page', [ApiController::class, 'coursePage']);
Route::get('prof-test-page',[ApiController::class, 'profTest']);
Route::get('event-page',[ApiController::class, 'eventPage']);

Route::get('certificate', [\App\Http\Controllers\Admin\CertificateController::class, 'get']);

Route::prefix('V1')->middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $request->validate([
            'lang'  =>  'required',
        ]);

        return new \App\Http\Resources\UserResource($request->user());
    });
    Route::get('user-certificate', [AuthController::class, 'certificate']);

    Route::get('intros-by-course', [CourseController::class, 'intros']);
    Route::get('my-courses', [\App\Http\Controllers\Api\UserController::class, 'myCourses']);

    Route::post('/update-session-id', [AuthController::class, 'updateSession']);

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/payment', [PaymentController::class, 'payment']);

    Route::post('/add-to-basket', [\App\Http\Controllers\Api\BasketController::class, 'add']);
    Route::delete('/destroy-from-basket', [\App\Http\Controllers\Api\BasketController::class, 'delete']);
    Route::delete('/clear-basket', [\App\Http\Controllers\Api\BasketController::class, 'clear']);
    Route::get('/baskets', [\App\Http\Controllers\Api\BasketController::class, 'get']);
    Route::get('/basket-courses', [\App\Http\Controllers\Api\BasketController::class, 'courses']);
    Route::post('/reset-password', [AuthController::class, 'reset']);
    Route::post('/update-user', [AuthController::class, 'update']);
    Route::post('/upload-image',[AuthController::class, 'upload']);
    Route::post('/promocode', [PaymentController::class, 'promocode']);

    Route::prefix('course')->group(function () {
        Route::post('/answer', [\App\Http\Controllers\Api\UserController::class, 'submit']);
        Route::post('/test/finish', [\App\Http\Controllers\Api\UserController::class, 'finish']);
        Route::get('/test/results', [\App\Http\Controllers\Api\UserController::class, 'testResults']);
        Route::post('/video', [\App\Http\Controllers\Api\VideoController::class, 'get']);
    });
});
