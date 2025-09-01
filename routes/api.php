<?php

use App\Http\Controllers\Api\ConceptImportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/concepts/import', [ConceptImportController::class, 'import']);
