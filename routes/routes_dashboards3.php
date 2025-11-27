<?php

use App\Http\Controllers\Dashboard3Controller;

Route::prefix('dashboards3')->group(function () {
    Route::get('/graficos', [Dashboard3Controller::class, 'graficos'])->middleware(['auth:api']);
    Route::get('/grafico/dados/{grafico_id}', [Dashboard3Controller::class, 'grafico_dados'])->middleware(['auth:api']);
});