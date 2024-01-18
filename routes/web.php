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
Route::get('/get-inscription-moodle-csv-export/{course_id}', ComboController::class . '@getInscriptionMoodleCsvExport')->name('getInscriptionMoodleCsvExport');
