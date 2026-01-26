<?php

use App\Http\Controllers\ClientesFuncionarioController;

Route::prefix('clientes_funcionarios')->group(function () {
    Route::get('/index', [ClientesFuncionarioController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [ClientesFuncionarioController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ClientesFuncionarioController::class, 'filter'])->middleware(['auth:api']);

    // Modal funcionarios_modal_info
    Route::get('/modalInfo/modal_info/{id}', [ClientesFuncionarioController::class, 'modal_info'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos/{funcionario_id}', [ClientesFuncionarioController::class, 'documentos'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos_mensais/{funcionario_id}', [ClientesFuncionarioController::class, 'documentos_mensais'])->middleware(['auth:api']);
});
