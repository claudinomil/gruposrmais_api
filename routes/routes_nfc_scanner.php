<?php

use App\Http\Controllers\NfcScannerController;

Route::prefix('nfc_scanner')->group(function () {
    Route::get('/leitura/{codigo}', [NfcScannerController::class, 'leitura'])->middleware(['auth:api']);
});
