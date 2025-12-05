<?php

use App\Http\Controllers\FuncionarioController;

Route::prefix('funcionarios')->group(function () {
    Route::get('/index', [FuncionarioController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [FuncionarioController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [FuncionarioController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [FuncionarioController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [FuncionarioController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [FuncionarioController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [FuncionarioController::class, 'auxiliary'])->middleware(['auth:api']);

    //Modal funcionarios_modal_info
    Route::get('/modalInfo/modal_info/{id}', [FuncionarioController::class, 'modal_info'])->middleware(['auth:api']);
    Route::get('/modalInfo/estatisticas/{id}', [FuncionarioController::class, 'estatisticas'])->middleware(['auth:api']);
    Route::post('/uploadFotografia/upload_fotografia_documento', [FuncionarioController::class, 'upload_fotografia_documento'])->middleware(['auth:api']);
    Route::post('/uploadFotografia/upload_fotografia_cartao_emergencial', [FuncionarioController::class, 'upload_fotografia_cartao_emergencial'])->middleware(['auth:api']);
    Route::post('/uploadDocumento/upload_documento', [FuncionarioController::class, 'upload_documento'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos/{funcionario_id}', [FuncionarioController::class, 'documentos'])->middleware(['auth:api']);
    Route::delete('/modalInfo/deletar_documento/destroy/{id}', [FuncionarioController::class, 'deletar_documento'])->middleware(['auth:api']);
    Route::get('/modalInfo/tomadores_servicos/{funcionario_id}', [FuncionarioController::class, 'tomadores_servicos'])->middleware(['auth:api']);
    Route::get('/modalInfo/verificar_documentos_mensais/{funcionario_id}/{mes}/{ano}', [FuncionarioController::class, 'verificar_documentos_mensais'])->middleware(['auth:api']);
    Route::post('/uploadDocumentoMensal/upload_documento_mensal', [FuncionarioController::class, 'upload_documento_mensal'])->middleware(['auth:api']);
    Route::get('/modalInfo/documentos_mensais/{funcionario_id}', [FuncionarioController::class, 'documentos_mensais'])->middleware(['auth:api']);
    Route::delete('/modalInfo/deletar_documento_mensal/destroy/{id}', [FuncionarioController::class, 'deletar_documento_mensal'])->middleware(['auth:api']);

    //Dados para Cartões Emergenciais
    Route::get('/cartoes_emergenciais/registros', [FuncionarioController::class, 'cartoes_emergenciais_registros'])->middleware(['auth:api']);
    Route::get('/cartoes_emergenciais/dados/{ids}', [FuncionarioController::class, 'cartoes_emergenciais_dados'])->middleware(['auth:api']);

    //Ação: funcionario_acao_1
    Route::get('/funcionarioAcao1/funcionario_acao_1_grade_funcionarios', [FuncionarioController::class, 'funcionario_acao_1_grade_funcionarios'])->middleware(['auth:api']);
    Route::get('/funcionarioAcao1/funcionario_acao_1_gerar_pdf_dados/{funcionarios_ids}', [FuncionarioController::class, 'funcionario_acao_1_gerar_pdf_dados'])->middleware(['auth:api']);
});
