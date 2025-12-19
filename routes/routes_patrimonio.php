<?php

use App\Http\Controllers\PatrimonioController;

Route::prefix('patrimonio')->group(function () {
    Route::get('/informacao/{material_numero_patrimonio}', [PatrimonioController::class, 'informacao']);
    Route::get('/listagem_geral', [PatrimonioController::class, 'listagem_geral']);
});
