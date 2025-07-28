<?php

use App\Http\Controllers\EscolaridadeController;

Route::prefix('escolaridades')->group(function () {
    Route::get('/index', [EscolaridadeController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EscolaridadeController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EscolaridadeController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EscolaridadeController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EscolaridadeController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EscolaridadeController::class, 'destroy'])->middleware(['auth:api']);
});
