<?php

use App\Http\Controllers\FerramentaController;

Route::prefix('ferramentas')->group(function () {
    Route::get('/index/{empresa_id}', [FerramentaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FerramentaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [FerramentaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [FerramentaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [FerramentaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [FerramentaController::class, 'destroy'])->middleware(['auth:api']);
});
