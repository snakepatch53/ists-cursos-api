<?php

use App\Http\Controllers\ComboController;
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
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {
        // USERS
        Route::resource('users', UserController::class)->except(['index', 'show']);
        Route::post('users/{id}', [UserController::class, 'updateWithImages']);
        // SOCIAL NETWORKS
        Route::resource('social-networks', SocialNetworkController::class)->except(['index', 'show']);
        // IMAGES
        Route::resource('images', ImageController::class)->except(['index', 'show']);
        Route::post('images/{id}', [ImageController::class, 'updateWithImage']);
        // INSTITUTIONS
        Route::resource('institutions', InstitutionController::class)->except(['index', 'show']);
        Route::post('institutions/{id}', [InstitutionController::class, 'updateWithLogo']);
        // STUDENTS
        Route::resource('students', StudentController::class)->except(['index', 'show']);
        // TEMPLATES
        Route::resource('templates', TemplateController::class)->except(['index', 'show']);
        // INSCRIPTIONS
        Route::resource('inscriptions', InscriptionController::class)->except(['index', 'show']);
        // COURSES
        Route::resource('courses', CourseController::class)->except(['index', 'show', 'store']);
    });

    Route::middleware(['auth:sanctum', 'responsible'])->group(function () {
        // COURSES
        Route::put('courses/{id}', [CourseController::class, 'updatePublished']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        // USERS
        Route::post('logout', [UserController::class, 'logout']);
        // COURSES
        Route::post('courses', [CourseController::class, 'store']);
        Route::post('courses/{id}', [CourseController::class, 'updateWithImage']);
    });

    // USERS
    Route::post('login', [UserController::class, 'login']);
    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{id}', [UserController::class, 'show']);
    // SOCIAL NETWORKS
    Route::get('social-networks', [SocialNetworkController::class, 'index']);
    Route::get('social-networks/{id}', [SocialNetworkController::class, 'show']);
    // IMAGES
    Route::get('images', [ImageController::class, 'index']);
    Route::get('images/{id}', [ImageController::class, 'show']);
    // INSTITUTIONS
    Route::get('institutions', [InstitutionController::class, 'index']);
    Route::get('institutions/{id}', [InstitutionController::class, 'show']);
    // STUDENTS
    Route::get('students', [StudentController::class, 'index']);
    Route::get('students/{id}', [StudentController::class, 'show']);
    // TEMPLATES
    Route::get('templates', [TemplateController::class, 'index']);
    Route::get('templates/{id}', [TemplateController::class, 'show']);
    // INSCRIPTIONS
    Route::get('inscriptions', [InscriptionController::class, 'index']);
    Route::get('inscriptions/{id}', [InscriptionController::class, 'show']);
    // COURSES
    Route::get('courses', [CourseController::class, 'index']);
    Route::get('courses/{id}', [CourseController::class, 'show']);
    // COMBOS
    Route::post('enroll-register-student-or-not', [ComboController::class, 'enroll_registerStudentOrNot']);
});
