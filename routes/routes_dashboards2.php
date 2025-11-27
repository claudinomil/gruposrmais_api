<?php

use App\Http\Controllers\Dashboard2Controller;

Route::prefix('dashboards2')->group(function () {
    Route::get('/graficos', [Dashboard2Controller::class, 'graficos'])->middleware(['auth:api']);
    Route::get('/grafico/dados/{grafico_id}', [Dashboard2Controller::class, 'grafico_dados'])->middleware(['auth:api']);
});