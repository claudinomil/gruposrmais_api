<?php

use App\Http\Controllers\ProdutoEntradaController;

Route::prefix('produtos_entradas')->group(function () {
    Route::get('/index', [ProdutoEntradaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ProdutoEntradaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ProdutoEntradaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ProdutoEntradaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ProdutoEntradaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [ProdutoEntradaController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ProdutoEntradaController::class, 'auxiliary'])->middleware(['auth:api']);

    // Modal
    Route::get('/modalInfo/modal_info/{id}', [ProdutoEntradaController::class, 'modal_info'])->middleware(['auth:api']);
    Route::post('/uploadNotaFiscal/upload_nota_fiscal', [ProdutoEntradaController::class, 'upload_nota_fiscal'])->middleware(['auth:api']);

    // Executar Entrada
    Route::get('/executar_entrada/{id}', [ProdutoEntradaController::class, 'executar_entrada'])->middleware(['auth:api']);
});
