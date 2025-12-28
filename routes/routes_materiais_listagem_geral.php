<?php

use App\Http\Controllers\MaterialListagemGeralController;

Route::prefix('materiais_listagem_geral')->group(function () {
    Route::get('/index', [MaterialListagemGeralController::class, 'index'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MaterialListagemGeralController::class, 'filter'])->middleware(['auth:api']);
});
