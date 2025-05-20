<?php

use App\Http\Middleware\LogApiRequest;
use Illuminate\Support\Facades\Route;


//Descomentar para controlar as requisições feitas para a API
//Route::middleware([LogApiRequest::class])->group(function () {


//Auth
require __DIR__ . '/routes_auth.php';

//Empresas
require __DIR__ . '/routes_empresas.php';

//Ferramentas
require __DIR__ . '/routes_ferramentas.php';

//Notificacoes
require __DIR__ . '/routes_notificacoes.php';

//Transacoes
require __DIR__ . '/routes_transacoes.php';

//Grupos
require __DIR__ . '/routes_grupos.php';

//Users
require __DIR__ . '/routes_users.php';

//Bancos
require __DIR__ . '/routes_bancos.php';

//Departamentos
require __DIR__ . '/routes_departamentos.php';

//Funcionarios
require __DIR__ . '/routes_funcionarios.php';

//Generos
require __DIR__ . '/routes_generos.php';

//EstadosCivis
require __DIR__ . '/routes_estados_civis.php';

//Nacionalidades
require __DIR__ . '/routes_nacionalidades.php';

//Naturalidades
require __DIR__ . '/routes_naturalidades.php';

//Funcoes
require __DIR__ . '/routes_funcoes.php';

//Escolaridades
require __DIR__ . '/routes_escolaridades.php';

//Identityorgans
require __DIR__ . '/routes_identidade_orgaos.php';

//Operacoes
require __DIR__ . '/routes_operacoes.php';

//Situacoes
require __DIR__ . '/routes_situacoes.php';

//Estados
require __DIR__ . '/routes_estados.php';

//Clientes
require __DIR__ . '/routes_clientes.php';

//Clientes Servicos
require __DIR__ . '/routes_clientes_servicos.php';

//Dashboards
require __DIR__ . '/routes_dashboards.php';

//Fornecedores
require __DIR__ . '/routes_fornecedores.php';

//Servicos
require __DIR__ . '/routes_servicos.php';

//Ordens Servicos
require __DIR__ . '/routes_ordens_servicos.php';

//Propostas
require __DIR__ . '/routes_propostas.php';

//Visitas Técnicas
require __DIR__ . '/routes_visitas_tecnicas.php';

//Brigadas Incêndios
require __DIR__ . '/routes_brigadas.php';

//Submodulos
require __DIR__ . '/routes_submodulos.php';

//Qrcodes
require __DIR__ . '/routes_qrcodes.php';

//Veículos
require __DIR__ . '/routes_veiculos.php';

//Clientes Executivos
require __DIR__ . '/routes_clientes_executivos.php';

//Relatórios
require __DIR__ . '/routes_relatorios.php';

//Mapas
require __DIR__ . '/routes_mapas.php';

//Mapas Pontos Interesse
require __DIR__ . '/routes_mapas_pontos_interesse.php';


//});
