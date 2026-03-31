<?php

use App\Http\Controllers\EquipamentoPreventivoController;

Route::prefix('equipamentos_preventivos')->group(function () {
    Route::get('/index', [EquipamentoPreventivoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EquipamentoPreventivoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EquipamentoPreventivoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EquipamentoPreventivoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EquipamentoPreventivoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EquipamentoPreventivoController::class, 'destroy'])->middleware(['auth:api']);
});
