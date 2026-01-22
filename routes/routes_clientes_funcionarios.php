<?php

use App\Http\Controllers\ClientesFuncionarioController;

Route::prefix('clientes_funcionarios')->group(function () {
    Route::get('/index', [ClientesFuncionarioController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClientesFuncionarioController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ClientesFuncionarioController::class, 'filter'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [ClientesFuncionarioController::class, 'auxiliary'])->middleware(['auth:api']);

    //Modal funcionarios_modal_info
    Route::get('/modalInfo/modal_info/{id}', [ClientesFuncionarioController::class, 'modal_info'])->middleware(['auth:api']);
    Route::get('/modalInfo/estatisticas/{id}', [ClientesFuncionarioController::class, 'estatisticas'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos/{funcionario_id}', [ClientesFuncionarioController::class, 'documentos'])->middleware(['auth:api']);
    Route::get('/modalInfo/tomadores_servicos/{funcionario_id}', [ClientesFuncionarioController::class, 'tomadores_servicos'])->middleware(['auth:api']);
    Route::get('/modalInfo/verificar_documentos_mensais/{funcionario_id}/{mes}/{ano}', [ClientesFuncionarioController::class, 'verificar_documentos_mensais'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos_mensais/{funcionario_id}', [ClientesFuncionarioController::class, 'documentos_mensais'])->middleware(['auth:api']);

    //Dados para Cartões Emergenciais
    Route::get('/cartoes_emergenciais/registros', [ClientesFuncionarioController::class, 'cartoes_emergenciais_registros'])->middleware(['auth:api']);
    Route::get('/cartoes_emergenciais/dados/{ids}', [ClientesFuncionarioController::class, 'cartoes_emergenciais_dados'])->middleware(['auth:api']);
});
