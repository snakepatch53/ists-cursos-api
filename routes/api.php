<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\SocialNetworkController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1'], function () {

    // USERS
    Route::resource('users', UserController::class);
    Route::post('users/{id}', [UserController::class, 'updateWithImages']);

    // SOCIAL NETWORKS
    Route::resource('social-networks', SocialNetworkController::class);

    // IMAGES
    Route::resource('images', ImageController::class);
    Route::post('images/{id}', [ImageController::class, 'updateWithImage']);

    // INSTITUTIONS
    Route::resource('institutions', InstitutionController::class);
    Route::post('institutions/{id}', [InstitutionController::class, 'updateWithLogo']);

    // STUDENTS
    Route::resource('students', StudentController::class);

    // TEMPLATES
    Route::resource('templates', TemplateController::class);

    // INSCRIPTIONS
    Route::resource('inscriptions', InscriptionController::class);

    // COURSES
    Route::resource('courses', CourseController::class);
    Route::post('courses/{id}', [CourseController::class, 'updateWithImage']);
});
