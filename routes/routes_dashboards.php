<?php

use App\Http\Controllers\DashboardController;

Route::prefix('dashboards')->group(function () {
    Route::get('/graficos/{grafico_grupo_id}', [DashboardController::class, 'graficos'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [DashboardController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/grupo/informacoes/{grafico_grupo_id}/{cliente_id}/{edificacao_id}/{edificacao_nivel_id}', [DashboardController::class, 'grupo_informacoes'])->middleware(['auth:api']);

    Route::get('/grafico/dados/grafico_1', [DashboardController::class, 'grafico_1_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_2', [DashboardController::class, 'grafico_2_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_3', [DashboardController::class, 'grafico_3_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_4', [DashboardController::class, 'grafico_4_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_5', [DashboardController::class, 'grafico_5_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_6', [DashboardController::class, 'grafico_6_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_7', [DashboardController::class, 'grafico_7_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_8', [DashboardController::class, 'grafico_8_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_9', [DashboardController::class, 'grafico_9_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_10', [DashboardController::class, 'grafico_10_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_11/{cliente_id}/{edificacao_id}/{edificacao_nivel_id}', [DashboardController::class, 'grafico_11_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_12/{cliente_id}/{edificacao_id}/{edificacao_nivel_id}', [DashboardController::class, 'grafico_12_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_13/{cliente_id}/{edificacao_id}/{edificacao_nivel_id}', [DashboardController::class, 'grafico_13_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_14/{cliente_id}/{edificacao_id}/{edificacao_nivel_id}', [DashboardController::class, 'grafico_14_dados'])->middleware(['auth:api']);
    Route::get('/grafico/dados/grafico_15/{cliente_id}/{edificacao_id}/{edificacao_nivel_id}', [DashboardController::class, 'grafico_15_dados'])->middleware(['auth:api']);
});
