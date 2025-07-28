<?php

use App\Http\Controllers\SubmoduloController;

Route::prefix('submodulos')->group(function () {
    Route::get('/research/{fieldSearch}/{fieldValue}/{fieldReturn}', [SubmoduloController::class, 'research'])->middleware(['auth:api']);
});
