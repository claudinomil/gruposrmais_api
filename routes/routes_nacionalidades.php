<?php

use App\Http\Controllers\NacionalidadeController;

Route::prefix('nacionalidades')->group(function () {
    Route::get('/index', [NacionalidadeController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [NacionalidadeController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [NacionalidadeController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [NacionalidadeController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [NacionalidadeController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [NacionalidadeController::class, 'destroy'])->middleware(['auth:api']);
});
