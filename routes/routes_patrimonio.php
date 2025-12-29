<?php

use App\Http\Controllers\PatrimonioController;

Route::prefix('patrimonio')->group(function () {
    Route::get('/informacao/{material_numero_patrimonio}', [PatrimonioController::class, 'informacao']);
    Route::get('/listagem_geral', [PatrimonioController::class, 'listagem_geral']);

    // Retornar todas as Situações de um Patrimônio
    Route::get('/patrimonio_situacoes/{material_entrada_item_id}', [PatrimonioController::class, 'patrimonio_situacoes']);
});
