<?php

use App\Http\Controllers\UserSubmoduloFavoritoController;

Route::prefix('users_submodulos_favoritos')->group(function () {
    Route::get('/index', [UserSubmoduloFavoritoController::class, 'index'])->middleware(['auth:api']);
    Route::get('/show/{id}', [UserSubmoduloFavoritoController::class, 'show'])->middleware(['auth:api']);
    Route::get('/filter/{array_dados}', [UserSubmoduloFavoritoController::class, 'filter'])->middleware(['auth:api']);
    Route::post('/store', [UserSubmoduloFavoritoController::class, 'store'])->middleware(['auth:api']);
    Route::put('/update/{id}', [UserSubmoduloFavoritoController::class, 'update'])->middleware(['auth:api']);
    Route::delete('/destroy/{id}', [UserSubmoduloFavoritoController::class, 'destroy'])->middleware(['auth:api']);

    Route::get('/auxiliary/tables', [UserSubmoduloFavoritoController::class, 'auxiliary'])->middleware(['auth:api']);

    // Retorna Submódulos Favoritos do Usuário
    Route::get('/user_submodulos_favoritos/{user_id}', [UserSubmoduloFavoritoController::class, 'user_submodulos_favoritos'])->middleware(['auth:api']);
});
