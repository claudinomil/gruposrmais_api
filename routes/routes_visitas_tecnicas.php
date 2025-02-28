<?php

use App\Http\Controllers\VisitaTecnicaController;

Route::prefix('visitas_tecnicas')->group(function () {
    Route::get('/index/{empresa_id}', [VisitaTecnicaController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [VisitaTecnicaController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}/{empresa_id}', [VisitaTecnicaController::class, 'filter'])->middleware(['auth:api']);
    Route::put('/update/{id}/{empresa_id}', [VisitaTecnicaController::class, 'update'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables/{empresa_id}', [VisitaTecnicaController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/medidas_seguranca/{np}/{atc}/{grupo}/{divisao}', [VisitaTecnicaController::class, 'medidas_seguranca'])->middleware(['auth:api']);
});
