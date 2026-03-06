<?php

use App\Http\Controllers\VistoriaSistemaController;

Route::prefix('vistorias_sistemas')->group(function () {
    Route::get('/index', [VistoriaSistemaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [VistoriaSistemaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [VistoriaSistemaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [VistoriaSistemaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [VistoriaSistemaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [VistoriaSistemaController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [VistoriaSistemaController::class, 'auxiliary'])->middleware(['auth:api']);

    //Rotas Perguntas individuais
    Route::put('/pergunta/updatePergunta/{vistoria_sistema_dado_id}', [VistoriaSistemaController::class, 'updatePergunta'])->middleware(['auth:api']);
});
