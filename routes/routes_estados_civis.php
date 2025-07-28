<?php

use App\Http\Controllers\EstadoCivilController;

Route::prefix('estados_civis')->group(function () {
    Route::get('/index', [EstadoCivilController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EstadoCivilController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EstadoCivilController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EstadoCivilController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EstadoCivilController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EstadoCivilController::class, 'destroy'])->middleware(['auth:api']);
});
