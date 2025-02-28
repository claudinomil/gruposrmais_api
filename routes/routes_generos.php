<?php

use App\Http\Controllers\GeneroController;

Route::prefix('generos')->group(function () {
    Route::get('/index/{empresa_id}', [GeneroController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [GeneroController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [GeneroController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [GeneroController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [GeneroController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [GeneroController::class, 'destroy'])->middleware(['auth:api']);
});
