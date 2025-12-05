<?php

use App\Http\Controllers\MaterialController;

Route::prefix('materiais')->group(function () {
    Route::get('/index', [MaterialController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [MaterialController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [MaterialController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [MaterialController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [MaterialController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [MaterialController::class, 'destroy'])->middleware(['auth:api']);
    Route::get('/auxiliary/tables', [MaterialController::class, 'auxiliary'])->middleware(['auth:api']);

    // Modal materiais_modal_info
    Route::get('/modalInfo/modal_info/{id}', [MaterialController::class, 'modal_info'])->middleware(['auth:api']);
    Route::post('/uploadFotografia/upload_fotografia', [MaterialController::class, 'upload_fotografia'])->middleware(['auth:api']);
});
