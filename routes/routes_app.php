<?php

use App\Http\Controllers\AppController;

Route::prefix('app')->group(function () {
    // Clientes
    Route::get('clientes/registros', [AppController::class, 'clientes_registros'])->middleware(['auth:api']);
    Route::get('clientes/edificacao/sistemas_preventivos/{edificacao_id}', [AppController::class, 'clientes_edificacao_sistemas_preventivos'])->middleware(['auth:api']);
});
