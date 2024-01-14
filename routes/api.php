<?php

use App\Http\Controllers\ComboController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MailboxController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


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
        // MAILBOXES
        Route::resource('mailboxes', MailboxController::class)->except(['store']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        // USERS
        Route::post('logout', [UserController::class, 'logout']);
        // COURSES
        Route::post('courses', [CourseController::class, 'store']);
        Route::post('courses/{id}', [CourseController::class, 'updateWithImage']);
        // INSCRIPTIONS
        Route::put('inscriptions/update-state-and-certificate-code/{id}', [ComboController::class, 'updateStateAndCertificateCode']);
    });

    // USERS
    Route::post('login', [UserController::class, 'login']);
    Route::resource('users', UserController::class)->except(['store', 'update', 'destroy']);
    // SOCIAL NETWORKS
    Route::resource('social-networks', SocialNetworkController::class)->except(['store', 'update', 'destroy']);
    // IMAGES
    Route::resource('images', ImageController::class)->except(['store', 'update', 'destroy']);
    // INSTITUTIONS
    Route::resource('institutions', InstitutionController::class)->except(['store', 'update', 'destroy']);
    // STUDENTS
    Route::resource('students', StudentController::class)->except(['store', 'update', 'destroy']);
    // TEMPLATES
    Route::resource('templates', TemplateController::class)->except(['store', 'update', 'destroy']);
    // INSCRIPTIONS
    Route::resource('inscriptions', InscriptionController::class)->except(['store', 'update', 'destroy']);
    // COURSES
    Route::resource('courses', CourseController::class)->except(['store', 'update', 'destroy']);
    // MAILBOXES
    Route::resource('mailboxes', MailboxController::class)->except(['index', 'update', 'destroy']);
    // COMBOS
    Route::post('inscriptions/enroll-register-student-or-not', [ComboController::class, 'enroll_registerStudentOrNot']);
    Route::post('inscriptions/show-certificates', [ComboController::class, 'showCertificates']);
});
