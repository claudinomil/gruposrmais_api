<?php

use App\Http\Controllers\CriarSubmodulos;
use Illuminate\Support\Facades\Route;
use App\Models\Empresa;

//Route::get('/', function () {
//    return view('welcome');
//});

//Rotas para Criar Submódulos (Controller / Views / Js)
Route::get('/criarsubmodulos/{password}', [CriarSubmodulos::class, 'index'])->name('criarsubmodulos.index');
Route::post('/criarsubmodulos', [CriarSubmodulos::class, 'store'])->name('criarsubmodulos.store');

//Rota para retornar todas as Empresas do Grupo SR+
Route::get('empresas_grupo_srmais', function () {
    return Empresa::all();
});

//Limpar Caches via Navegador - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
Route::get('/clear-all-cache', function() {
    $retorno = '';

    //Limpar cache do aplicativo:
    Artisan::call('cache:clear');
    $retorno .= 'cache:clear'.'<br>';

    //Limpar cache de rota:
    Artisan::call('route:cache');
    $retorno .= 'route:cache'.'<br>';

    //Limpar cache de configuração:
    Artisan::call('config:cache');
    $retorno .= 'config:cache'.'<br>';

    //Clear view cache:
    Artisan::call('view:clear');
    $retorno .= 'view:clear'.'<br>';

    //Limpe todo o aplicativo de todos os tipos de cache:
    Artisan::call('optimize:clear');
    $retorno .= 'optimize:clear'.'<br>';

    echo $retorno;
});
//Limpar Caches via Navegador - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
