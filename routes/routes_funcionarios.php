<?php

use App\Http\Controllers\FuncionarioController;

Route::prefix('funcionarios')->group(function () {
    Route::get('/index/{empresa_id}', [FuncionarioController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FuncionarioController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [FuncionarioController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store/{empresa_id}', [FuncionarioController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [FuncionarioController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}/{empresa_id}', [FuncionarioController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables/{empresa_id}', [FuncionarioController::class, 'auxiliary'])->middleware(['auth:api']);

    //Modal funcionarios_modal_info
    Route::get('/modalInfo/modal_info/{id}', [FuncionarioController::class, 'modal_info'])->middleware(['auth:api']);
    Route::put('/uploadFoto/upload_foto/{id}', [FuncionarioController::class, 'upload_foto'])->middleware(['auth:api']);
    Route::post('/uploadDocumento/upload_documento', [FuncionarioController::class, 'upload_documento'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos/{funcionario_id}', [FuncionarioController::class, 'documentos'])->middleware(['auth:api']);
    Route::delete('/modalInfo/deletar_documento/destroy/{id}/{empresa_id}', [FuncionarioController::class, 'deletar_documento'])->middleware(['auth:api']);

    //Dados para Cartões Emergenciais
    Route::get('/cartoes_emergenciais/registros', [FuncionarioController::class, 'cartoes_emergenciais_registros'])->middleware(['auth:api']);
    Route::get('/cartoes_emergenciais/dados/{empresa_id}/{ids}', [FuncionarioController::class, 'cartoes_emergenciais_dados'])->middleware(['auth:api']);

    //Ação: funcionario_acao_1
    Route::get('/funcionarioAcao1/funcionario_acao_1_grade_funcionarios/{empresa_id}', [FuncionarioController::class, 'funcionario_acao_1_grade_funcionarios'])->middleware(['auth:api']);
    Route::get('/funcionarioAcao1/funcionario_acao_1_gerar_pdf_dados/{funcionarios_ids}/{empresa_id}', [FuncionarioController::class, 'funcionario_acao_1_gerar_pdf_dados'])->middleware(['auth:api']);
});
