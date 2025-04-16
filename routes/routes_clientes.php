<?php

use App\Http\Controllers\ClienteController;

Route::prefix('clientes')->group(function () {
    Route::get('/index/{empresa_id}', [ClienteController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [ClienteController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [ClienteController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [ClienteController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [ClienteController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables/{empresa_id}', [ClienteController::class, 'auxiliary'])->middleware(['auth:api']);

    //Modal clientes_modal_info
    Route::get('/modalInfo/modal_info/{id}', [ClienteController::class, 'modal_info'])->middleware(['auth:api']);
    Route::post('/uploadDocumentoPdf/upload_documento_pdf', [ClienteController::class, 'upload_documento_pdf'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos_pdf/{cliente_id}', [ClienteController::class, 'documentos_pdf'])->middleware(['auth:api']);
    Route::delete('/modalInfo/deletar_documento_pdf/destroy/{id}/{empresa_id}', [ClienteController::class, 'deletar_documento_pdf'])->middleware(['auth:api']);

    //Visita Técnica
    Route::get('/visita_tecnica/{id}', [ClienteController::class, 'visita_tecnica'])->middleware(['auth:api']);

    //Cliente Serviços
    Route::get('/cliente_servicos_index/{id}', [ClienteController::class, 'cliente_servicos_index'])->middleware(['auth:api']);
    Route::get('/cliente_servicos_show/{id}', [ClienteController::class, 'cliente_servicos_show'])->middleware(['auth:api']);
    Route::post('/cliente_servicos_store', [ClienteController::class, 'cliente_servicos_store'])->middleware(['auth:api']);
    Route::put('/cliente_servicos_update/{id}', [ClienteController::class, 'cliente_servicos_update'])->middleware(['auth:api']);
    Route::delete('/cliente_servicos_destroy/{id}', [ClienteController::class, 'cliente_servicos_destroy'])->middleware(['auth:api']);
});
