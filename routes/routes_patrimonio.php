<?php

use App\Http\Controllers\PatrimonioController;

Route::prefix('patrimonio')->group(function () {
    Route::get('/informacao/{produto_numero_patrimonio}', [PatrimonioController::class, 'informacao']);
    Route::get('/listagem_geral', [PatrimonioController::class, 'listagem_geral']);

    // Retornar todas as Situações de um Patrimônio
    Route::get('/patrimonio_situacoes/{produto_entrada_item_id}', [PatrimonioController::class, 'patrimonio_situacoes']);
});
