<?php

use App\Http\Controllers\SubmoduloController;

Route::prefix('submodulos')->group(function () {
    Route::get('/research/{fieldSearch}/{fieldValue}/{fieldReturn}/{empresa_id}', [SubmoduloController::class, 'research'])->middleware(['auth:api']);
});
