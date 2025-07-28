<?php

use App\Http\Controllers\APAGARVTController;

Route::prefix('visitas_tecnicas')->group(function () {
    Route::get('/index', [APAGARVTController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [APAGARVTController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [APAGARVTController::class, 'filter'])->middleware(['auth:api']);
    Route::put('/update/{id}', [APAGARVTController::class, 'update'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [APAGARVTController::class, 'auxiliary'])->middleware(['auth:api']);

    Route::get('/medidas_seguranca/{np}/{atc}/{grupo}/{divisao}', [APAGARVTController::class, 'medidas_seguranca'])->middleware(['auth:api']);
});
