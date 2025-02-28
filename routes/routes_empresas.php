<?php

use App\Http\Controllers\EmpresaController;

Route::prefix('empresas')->group(function () {
    Route::get('/index/{empresa_id}', [EmpresaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EmpresaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [EmpresaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [EmpresaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [EmpresaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [EmpresaController::class, 'destroy'])->middleware(['auth:api']);
});
