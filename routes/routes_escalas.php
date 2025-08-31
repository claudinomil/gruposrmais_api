<?php

use App\Http\Controllers\EscalaController;

Route::prefix('escalas')->group(function () {
    Route::get('/index', [EscalaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EscalaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EscalaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EscalaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EscalaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EscalaController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [EscalaController::class, 'auxiliary'])->middleware(['auth:api']);
});
