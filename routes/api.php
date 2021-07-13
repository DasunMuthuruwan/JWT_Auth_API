<?php

use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);

Route::group(['middleware' => ['auth:api']], function(){

    Route::get('profile',[UserController::class,'profile']);
    Route::get('logout',[UserController::class,'logout']);

    Route::post('enrollment-course',[CourseController::class,'courseEnrolment']);
    Route::get('total-courses',[CourseController::class,'totalCourses']);
    Route::get('delete-course/{id}',[CourseController::class,'deleteCourse']);
});
