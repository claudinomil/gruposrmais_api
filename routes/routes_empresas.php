<?php

use App\Http\Controllers\EmpresaController;

Route::prefix('empresas')->group(function () {
    Route::get('/index', [EmpresaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [EmpresaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [EmpresaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [EmpresaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [EmpresaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [EmpresaController::class, 'destroy'])->middleware(['auth:api']);
});
