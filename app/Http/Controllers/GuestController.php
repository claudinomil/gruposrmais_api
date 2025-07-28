<?php

namespace App\Http\Controllers;

use App\Facades\SuporteFacade;
use App\Facades\Transacoes;
use App\Http\Requests\FuncionarioStoreRequest;
use App\Http\Requests\FuncionarioUpdateRequest;
use App\Models\ClienteExecutivo;
use App\Models\Departamento;
use App\Models\Genero;
use App\Models\ContratacaoTipo;
use App\Models\IdentidadeOrgao;
use App\Models\EstadoCivil;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Funcao;
use App\Models\Banco;
use App\Models\Escolaridade;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Funcionario;
use App\Models\FuncionarioDocumento;

class GuestController extends Controller
{
    public function validar_cartao_emergencial($submodulo, $id)
    {
        try {
            if ($submodulo == 'clientes_executivos') {
                $registro = ClienteExecutivo
                    ::leftJoin('nacionalidades', 'clientes_executivos.nacionalidade_id', 'nacionalidades.id')
                    ->leftJoin('identidade_orgaos', 'clientes_executivos.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
                    ->leftJoin('estados', 'clientes_executivos.personal_identidade_estado_id', '=', 'estados.id')
                    ->leftJoin('generos', 'clientes_executivos.genero_id', '=', 'generos.id')
                    ->select(['clientes_executivos.*', 'clientes_executivos.executivo_nome as name', 'nacionalidades.name as nacionalidadeName', 'identidade_orgaos.name as identidadeOrgaoName', 'estados.name as identidadeEstadoName', 'generos.name as generoName'])
                    ->where('clientes_executivos.id', '=', $id)
                    ->get()[0];
            }

            if ($submodulo == 'funcionarios') {
                $registro = Funcionario
                    ::leftJoin('nacionalidades', 'funcionarios.nacionalidade_id', 'nacionalidades.id')
                    ->leftJoin('identidade_orgaos', 'funcionarios.personal_identidade_orgao_id', '=', 'identidade_orgaos.id')
                    ->leftJoin('estados', 'funcionarios.personal_identidade_estado_id', '=', 'estados.id')
                    ->leftJoin('generos', 'funcionarios.genero_id', '=', 'generos.id')
                    ->select(['funcionarios.*', 'nacionalidades.name as nacionalidadeName', 'identidade_orgaos.name as identidadeOrgaoName', 'estados.name as identidadeEstadoName', 'generos.name as generoName'])
                    ->where('funcionarios.id', '=', $id)
                    ->get()[0];
            }

            if (!$registro) {
                return $this->sendResponse('Registro não encontrado.', 2040, null, null);
            } else {
                return $this->sendResponse('Registro enviado com sucesso.', 2000, null, $registro);
            }
        } catch (\Exception $e) {
            if (config('app.debug')) {
                return $this->sendResponse($e->getMessage(), 5000, null, null);
            }

            return $this->sendResponse('Houve um erro ao realizar a operação.', 5000, null, null);
        }
    }
}
