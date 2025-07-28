<?php

use App\Http\Controllers\GeneroController;

Route::prefix('generos')->group(function () {
    Route::get('/index', [GeneroController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [GeneroController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [GeneroController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [GeneroController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [GeneroController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [GeneroController::class, 'destroy'])->middleware(['auth:api']);
});
