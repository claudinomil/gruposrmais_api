<?php

use App\Http\Controllers\PatrimonioController;

Route::prefix('patrimonio')->group(function () {
    Route::get('/informacao/{material_numero_patrimonio}', [PatrimonioController::class, 'informacao']);
});
