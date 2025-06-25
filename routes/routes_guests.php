<?php

use App\Http\Controllers\GuestController;

Route::prefix('guests')->group(function () {
    Route::get('/validar_cartao_emergencial/{submodulo}/{id}', [GuestController::class, 'validar_cartao_emergencial']);
});
