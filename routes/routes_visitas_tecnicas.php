<?php

use App\Http\Controllers\VisitaTecnicaController;

Route::prefix('visitas_tecnicas')->group(function () {
    Route::get('/index', [VisitaTecnicaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [VisitaTecnicaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [VisitaTecnicaController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [VisitaTecnicaController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [VisitaTecnicaController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [VisitaTecnicaController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [VisitaTecnicaController::class, 'auxiliary'])->middleware(['auth:api']);

    //Rotas Perguntas individuais
    Route::put('/pergunta/updatePergunta/{visita_tecnica_dado_id}', [VisitaTecnicaController::class, 'updatePergunta'])->middleware(['auth:api']);

    //Visitas Técnicas Perguntas
    Route::put('/visitas_tecnicas_perguntas/atualizar_pergunta/{id}', [VisitaTecnicaController::class, 'atualizar_pergunta'])->middleware(['auth:api']);

    //Visitas Técnicas Perguntas Completa / Sintética)
    Route::get('/visitas_tecnicas_perguntas/perguntas_completa_sintetica/{vt_cs}', [VisitaTecnicaController::class, 'perguntas_completa_sintetica'])->middleware(['auth:api']);
});
