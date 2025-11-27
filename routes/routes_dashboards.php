<?php

use App\Http\Controllers\DashboardController;

Route::prefix('dashboards')->group(function () {
    Route::get('/graficos', [DashboardController::class, 'graficos'])->middleware(['auth:api']);
    Route::get('/grafico/dados/{grafico_id}', [DashboardController::class, 'grafico_dados'])->middleware(['auth:api']);
});