<?php

use App\Http\Controllers\DashboardController;

Route::prefix('dashboards')->group(function () {
    Route::get('/index/{data}/{empresa_id}', [DashboardController::class, 'index'])->middleware(['auth:api']);
});
