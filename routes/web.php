<?php

use App\Http\Controllers\ComboController;
use App\Http\Controllers\InscriptionController;
use App\Models\Course;
use App\Models\Inscription;
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

Route::get('/certificate/{id}', InscriptionController::class . '@certificate')->name('certificate');
Route::get('/get-insciptions-cetec-register-excel/{course_id}', ComboController::class . '@getInsciptionsCetecRegisterExcel')->name('getInsciptionsCetecRegisterExcel');
Route::get('/get-insciptions-cetec-approveds-excel/{course_id}', ComboController::class . '@getInscriptionCetecApprovedsExport')->name('getInsciptionsCetecRegisterExcel');
Route::get('/test/{course_id}', function ($course_id) {
    $course = Course::find($course_id);
    if (!$course) abort(404);
    //load teacher
    $teacher = $course->load('teacher');
    // load if state is inscrito
    $inscriptions = Inscription::where('course_id', $course_id)->where('state', 'Inscrito')->get();
    // load students
    $inscriptions->load('student');
    // total aproveds
    $total_aproveds = $inscriptions->count();
    // total desaproveds
    $total_desaproveds = Inscription::where('course_id', $course_id)->where('state', 'Reprobado')->count();
    return view('inscriptionCetecApprovedsExport', [
        'course' => $course,
        'inscriptions' => $inscriptions,
        'teacher' => $teacher,
        'total_aproveds' => $total_aproveds,
        'total_desaproveds' => $total_desaproveds,
        'total_inscriptions' => $total_aproveds + $total_desaproveds
    ]);
});
