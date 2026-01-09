<?php

use App\Http\Controllers\ProdutoController;

Route::prefix('produtos')->group(function () {
    Route::get('/index', [ProdutoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ProdutoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ProdutoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ProdutoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ProdutoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [ProdutoController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ProdutoController::class, 'auxiliary'])->middleware(['auth:api']);

    // Modal produtos_modal_info
    Route::get('/modalInfo/modal_info/{id}', [ProdutoController::class, 'modal_info'])->middleware(['auth:api']);
    Route::post('/uploadFotografia/upload_fotografia', [ProdutoController::class, 'upload_fotografia'])->middleware(['auth:api']);
});
