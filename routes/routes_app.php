<?php

use App\Http\Controllers\AppController;

Route::prefix('app')->group(function () {
    // Clientes
    Route::get('clientes/registros', [AppController::class, 'clientes_registros'])->middleware(['auth:api']);
    Route::get('clientes/edificacao/sistemas_preventivos/{edificacao_id}', [AppController::class, 'clientes_edificacao_sistemas_preventivos'])->middleware(['auth:api']);
    Route::get('clientes/sistema_preventivo/informacao/{sistema_preventivo_numero}', [AppController::class, 'clientes_sistema_preventivo_informacao']); //->middleware(['auth:api']);

    // Dashboards
    Route::get('dashboards/operacoes', [AppController::class, 'dashboards_operacoes'])->middleware(['auth:api']);
    Route::get('dashboards/funcionarios/funcoes', [AppController::class, 'dashboards_funcionarios_funcoes'])->middleware(['auth:api']);
});
