<?php

namespace App\Http\Controllers;

use App\Models\EquipamentoPreventivo;
use Illuminate\Http\Request;

class NfcScannerController extends Controller
{
    public function leitura(Request $request)
    {
        $tipo = $request->tipo;
        $valor = $request->valor;

        if ($tipo === 'nfc') {
            $registro = EquipamentoPreventivo::where('nfc_uid', $valor)->first();
        }

        if ($tipo === 'qr') {
            $registro = EquipamentoPreventivo::where('codigo_qr', $valor)->first();
        }

        if (!$registro) {
            return response()->json(['erro' => 'Não encontrado'], 404);
        }

        return response()->json($registro);
    }
}
