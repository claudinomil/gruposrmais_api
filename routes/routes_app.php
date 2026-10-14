<?php

use App\Http\Controllers\AppController;

Route::prefix('app')->group(function () {
    // Clientes
    Route::get('clientes/registros', [AppController::class, 'clientes_registros'])->middleware(['auth:api']);
    Route::get('clientes/edificacao/sistemas_preventivos/{edificacao_id}', [AppController::class, 'clientes_edificacao_sistemas_preventivos'])->middleware(['auth:api']);
    Route::get('clientes/sistema_preventivo/informacao/{sistema_preventivo_numero}', [AppController::class, 'clientes_sistema_preventivo_informacao'])->middleware(['auth:api']);
    Route::get('clientes/edificacoes/vistorias', [AppController::class, 'clientes_edificacoes_vistorias']); //->middleware(['auth:api']);

    // Dashboards
    Route::get('dashboards/operacoes', [AppController::class, 'dashboards_operacoes'])->middleware(['auth:api']);
    Route::get('dashboards/funcionarios/funcoes', [AppController::class, 'dashboards_funcionarios_funcoes'])->middleware(['auth:api']);
});


// Rotas para testes do App React x Laravel - Início'''''''''''''''''''''''''''''''''''''''''''''''''''
// Rotas para testes do App React x Laravel - Início'''''''''''''''''''''''''''''''''''''''''''''''''''

// AppPessoaController
use App\Http\Controllers\AppPessoaController;

Route::get('/app_pessoas', [AppPessoaController::class, 'index']);
Route::post('/app_pessoas', [AppPessoaController::class, 'store']);
Route::put('/app_pessoas/{id}', [AppPessoaController::class, 'update']);
Route::delete('/app_pessoas/{id}', [AppPessoaController::class, 'delete']);

// AppVistoriaSistemaController
use App\Http\Controllers\AppVistoriaSistemaController;

Route::get('/app_vistorias_sistemas', [AppVistoriaSistemaController::class, 'index']);
Route::post('/app_vistorias_sistemas', [AppVistoriaSistemaController::class, 'store']);
Route::put('/app_vistorias_sistemas/{id}', [AppVistoriaSistemaController::class, 'update']);
Route::delete('/app_vistorias_sistemas/{id}', [AppVistoriaSistemaController::class, 'delete']);

// AppVistoriaSistemaDadoController
use App\Http\Controllers\AppVistoriaSistemaDadoController;

Route::get('/app_vistorias_sistemas_dados', [AppVistoriaSistemaDadoController::class, 'index']);
Route::post('/app_vistorias_sistemas_dados', [AppVistoriaSistemaDadoController::class, 'store']);
Route::put('/app_vistorias_sistemas_dados/{id}', [AppVistoriaSistemaDadoController::class, 'update']);
Route::delete('/app_vistorias_sistemas_dados/{id}', [AppVistoriaSistemaDadoController::class, 'delete']);

// Rotas para testes do App React x Laravel - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''
// Rotas para testes do App React x Laravel - Fim''''''''''''''''''''''''''''''''''''''''''''''''''''''
