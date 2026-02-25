<?php

use App\Http\Controllers\ClienteController;

Route::prefix('clientes')->group(function () {
    Route::get('/index', [ClienteController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClienteController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ClienteController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [ClienteController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [ClienteController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [ClienteController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ClienteController::class, 'auxiliary'])->middleware(['auth:api']);

    //Modal clientes_modal_info
    Route::get('/modalInfo/modal_info/{id}', [ClienteController::class, 'modal_info'])->middleware(['auth:api']);
    Route::get('/modalInfo/estatisticas/{id}', [ClienteController::class, 'estatisticas'])->middleware(['auth:api']);
    Route::post('/uploadLogotipo/upload_logotipo_principal', [ClienteController::class, 'upload_logotipo_principal'])->middleware(['auth:api']);
    Route::post('/uploadLogotipo/upload_logotipo_relatorios', [ClienteController::class, 'upload_logotipo_relatorios'])->middleware(['auth:api']);
    Route::post('/uploadLogotipo/upload_logotipo_cartao_emergencial', [ClienteController::class, 'upload_logotipo_cartao_emergencial'])->middleware(['auth:api']);
    Route::post('/uploadLogotipo/upload_logotipo_menu', [ClienteController::class, 'upload_logotipo_menu'])->middleware(['auth:api']);
    Route::post('/uploadDocumento/upload_documento', [ClienteController::class, 'upload_documento'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos/{cliente_id}', [ClienteController::class, 'documentos'])->middleware(['auth:api']);
    Route::delete('/modalInfo/deletar_documento/destroy/{id}', [ClienteController::class, 'deletar_documento'])->middleware(['auth:api']);

    Route::get('/modalInfo/documentos_exigidos/{cliente_id}', [ClienteController::class, 'documentos_exigidos'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos_exigidos_dados/{cliente_id}', [ClienteController::class, 'documentos_exigidos_dados'])->middleware(['auth:api']);
    Route::post('/modalInfo/documentos_exigidos_save', [ClienteController::class, 'documentos_exigidos_save'])->middleware(['auth:api']);

    Route::get('/modalInfo/propostas/{cliente_id}', [ClienteController::class, 'propostas'])->middleware(['auth:api']);
    Route::get('/modalInfo/ordens_servicos/{cliente_id}', [ClienteController::class, 'ordens_servicos'])->middleware(['auth:api']);
    Route::get('/modalInfo/visitas_tecnicas/{cliente_id}', [ClienteController::class, 'visitas_tecnicas'])->middleware(['auth:api']);
    Route::get('/modalInfo/brigadas_incendios/{cliente_id}', [ClienteController::class, 'brigadas_incendios'])->middleware(['auth:api']);
    Route::get('/modalInfo/clientes_rede/{cliente_id}', [ClienteController::class, 'clientes_rede'])->middleware(['auth:api']);
    Route::get('/modalInfo/clientes_principal/{cliente_id}', [ClienteController::class, 'clientes_principal'])->middleware(['auth:api']);
});
