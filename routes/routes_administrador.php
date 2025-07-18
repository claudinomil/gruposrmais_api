<?php

use App\Http\Controllers\AdministradorController;

Route::prefix('administrador')->group(function () {
    Route::get('/backup/banco/carregar', [AdministradorController::class, 'backup_banco_carregar']);
    Route::get('/backup/banco/criar', [AdministradorController::class, 'backup_banco_criar']);
});
