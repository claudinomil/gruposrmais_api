<?php

use App\Http\Controllers\ProdutoListagemGeralController;

Route::prefix('produtos_listagem_geral')->group(function () {
    Route::get('/index', [ProdutoListagemGeralController::class, 'index'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [ProdutoListagemGeralController::class, 'filter'])->middleware(['auth:api']);
});
