<?php

use App\Http\Controllers\ClienteExecutivoController;

Route::prefix('clientes_executivos')->group(function () {
    Route::get('/index/{empresa_id}', [ClienteExecutivoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteExecutivoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [ClienteExecutivoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [ClienteExecutivoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [ClienteExecutivoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [ClienteExecutivoController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables/{empresa_id}', [ClienteExecutivoController::class, 'auxiliary'])->middleware(['auth:api']);

    //Modal clientes_executivos_modal_info
    Route::get('/modalInfo/modal_info/{id}', [ClienteExecutivoController::class, 'modal_info'])->middleware(['auth:api']);
    Route::put('/uploadFoto/upload_foto/{id}', [ClienteExecutivoController::class, 'upload_foto'])->middleware(['auth:api']);
    Route::post('/uploadDocumento/upload_documento', [ClienteExecutivoController::class, 'upload_documento'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos/{cliente_executivo_id}', [ClienteExecutivoController::class, 'documentos'])->middleware(['auth:api']);
    Route::delete('/modalInfo/deletar_documento/destroy/{id}/{empresa_id}', [ClienteExecutivoController::class, 'deletar_documento'])->middleware(['auth:api']);

    //Dados para Cartões Emergenciais
    Route::get('/cartoes_emergenciais/registros', [ClienteExecutivoController::class, 'cartoes_emergenciais_registros'])->middleware(['auth:api']);
    Route::get('/cartoes_emergenciais/dados/{empresa_id}/{ids}', [ClienteExecutivoController::class, 'cartoes_emergenciais_dados'])->middleware(['auth:api']);
});
