<?php

use App\Http\Controllers\IdentidadeOrgaoController;

Route::prefix('identidade_orgaos')->group(function () {
    Route::get('/index', [IdentidadeOrgaoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [IdentidadeOrgaoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [IdentidadeOrgaoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [IdentidadeOrgaoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [IdentidadeOrgaoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [IdentidadeOrgaoController::class, 'destroy'])->middleware(['auth:api']);
});
