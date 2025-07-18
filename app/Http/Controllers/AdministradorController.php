<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class AdministradorController extends Controller
{
    public function index()
    {
        $content = array();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, '', $content);
    }

    public function backup_banco_carregar()
    {
        $disk = Storage::disk('backup_system');
        $path = env('APP_NAME');
        $files = $disk->files($path);

        $backups = collect($files)->filter(fn($file) => str_ends_with($file, '.zip'))->map(function ($file) use ($disk) {
            return [
                'nome' => basename($file),
                'data' => date('d/m/Y H:i', $disk->lastModified($file)),
                'tamanho' => round($disk->size($file) / 1048576, 2) . ' MB',
            ];
        })->sortByDesc('data')->values();

        return response()->json($backups);
    }

    public function backup_banco_criar()
    {
        Artisan::call('backup:run --only-db');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
