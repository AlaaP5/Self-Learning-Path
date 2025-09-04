<?php

use App\Http\Controllers\Api\ConceptImportController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\StudentAnswerController;
use App\Http\Controllers\SubjectController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/concepts/import', [ConceptImportController::class, 'import']);

Route::post('/login', [AuthController::class, 'requestLogin']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/subjects/getAll', [SubjectController::class, 'getSubjects']);
    Route::post('/resources/getAll', [ResourceController::class, 'getResources']);
    Route::post('/exam/getQuestion', [ExamController::class, 'getQuesOfExam']);
    Route::post('/answers/submit', [StudentAnswerController::class, 'store']);



});
