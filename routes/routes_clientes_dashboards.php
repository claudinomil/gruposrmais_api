<?php

use App\Http\Controllers\ClientesDashboardController;

Route::prefix('clientes_dashboards')->group(function () {
    Route::get('/graficos', [ClientesDashboardController::class, 'graficos'])->middleware(['auth:api']);
    Route::get('/grafico/dados/{grafico_id}', [ClientesDashboardController::class, 'grafico_dados'])->middleware(['auth:api']);
});
