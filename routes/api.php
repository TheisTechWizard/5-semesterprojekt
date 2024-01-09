<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['prefix' => '/user'], function () {
//     Route::get('/email', [UserController::class, 'getUserByEmail'])->name('getUsersByEmail');
// });
// dd(Sanctum::currentApplicationUrlWithPort());
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    //Users endpoints
    Route::get('/users', [UserController::class, 'getUsers'])->name('getUsers');
    Route::get('/users/{id}', [UserController::class, 'getUsersById'])->name('getUsersById');
    Route::post('/users/{id}/courses', [UserController::class, 'addCoursesToUser'])->name('addCoursesToUser');

    Route::put('/users/{id}/courses', [UserController::class, 'updateCourseIsComplete'])->name('updateCourseIsComplete');


    //Courses endpoints
    //Route::get('/courses', [CourseController::class, 'getCourseByName'])->name('getCourseByName');
    Route::get('/courses', [CourseController::class, 'getCourses'])->name('getCourses');
    Route::get('/courses/{id}', [CourseController::class, 'getCourseById'])->name('getCourseById');

    Route::post('/courses', [CourseController::class, 'createCourse'])->name('createCourse');

    Route::get('/user/courses', [CourseController::class, 'getCoursesByLoggedInUser'])->name('getCoursesByLoggedInUser');

    //Lessons endpoints
    Route::get('/lessons', [LessonController::class, 'getLessons'])->name('getLessons');
    Route::get('/lessons/{id}', [LessonController::class, 'getLessonById'])->name('getLessonById');

    Route::post('/lessons', [LessonController::class, 'createLessons'])->name('createLessons');

    Route::post('/materials', [MaterialController::class, 'createMaterials'])->name('createMaterials');
});
