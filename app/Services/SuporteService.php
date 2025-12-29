<?php

namespace App\Services;

use App\Facades\Transacoes;
use App\Models\BlockTableOrRecord;
use App\Models\BrigadaIncendioEscala;
use App\Models\BrigadaIncendioEscalaBrigadista;
use App\Models\BrigadaIncendioMaterial;
use App\Models\ClienteSegurancaMedida;
use App\Models\Especialidade;
use App\Models\MaterialControleSituacaoItem;
use App\Models\MaterialEntradaItem;
use App\Models\OrdemServicoDestino;
use App\Models\OrdemServicoEquipe;
use App\Models\OrdemServicoExecutivo;
use App\Models\OrdemServicoServico;
use App\Models\OrdemServicoVeiculo;
use App\Models\PontoInteresseEspecialidade;
use App\Models\PropostaServico;
use App\Models\SegurancaMedida;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SuporteService
{
    /*
     * Verificar relacionamento em tabela
     * Retornar quantidade de registros
     */
    public function verificarRelacionamento($table, $field, $value)
    {
        $qtd = DB::table($table)->where($field, $value)->count();

        return $qtd;
    }

    /*
     * Retornar data formatada
     * A) Recebe formatos de datas: 99/99/9999 ou 99-99-9999 ou 9999/99/99 ou 9999-99-99
     * B) Depois retorna essa data no formato pedido pelo usuário
     * @PARAM op=1 = recebe qualquer data e retorna 99/99/9999
     * @PARAM op=2 = recebe qualquer data e retorna 99-99-9999
     * @PARAM op=3 = recebe qualquer data e retorna 9999/99/99
     * @PARAM op=4 = recebe qualquer data e retorna 9999-99-99
     */
    public function getDataFormatada($op, $data)
    {
        //Variáveis para formatar o retorno
        $dia = '';
        $mes = '';
        $ano = '';

        //Verificando recebimento da data
        if ($data == '') {
            $data = null;
        } else {
            //Retirando espaços
            $data = trim($data);
            $data = str_replace(" ", "", $data);

            //Formato: 9999-99-99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '-' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '-' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 9999/99/99
            if (is_numeric(substr($data, 0, 4)) and substr($data, 4, 1) == '/' and is_numeric(substr($data, 5, 2)) and substr($data, 7, 1) == '/' and is_numeric(substr($data, 8, 2))) {
                $dia = substr($data, 8, 2);
                $mes = substr($data, 5, 2);
                $ano = substr($data, 0, 4);
            }

            //Formato: 99-99-9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '-' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '-' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }

            //Formato: 99/99/9999
            if (is_numeric(substr($data, 0, 2)) and substr($data, 2, 1) == '/' and is_numeric(substr($data, 3, 2)) and substr($data, 5, 1) == '/' and is_numeric(substr($data, 6, 4))) {
                $dia = substr($data, 0, 2);
                $mes = substr($data, 3, 2);
                $ano = substr($data, 6, 4);
            }
        }

        //Retorno
        if ($dia == '' or $mes == '' or $ano == '' or $dia == '00' or $mes == '00' or $ano == '0000') {
            $data = null;
        } else {
            //Retorna no formato (99/99/9999)
            if ($op == 1) {$data = $dia.'/'.$mes.'/'.$ano;}

            //Retorna no formato (99-99-9999)
            if ($op == 2) {$data = $dia.'-'.$mes.'-'.$ano;}

            //Retorna no formato (9999/99/99)
            if ($op == 3) {$data = $ano.'/'.$mes.'/'.$dia;}

            //Retorna no formato (9999-99-99)
            if ($op == 4) {$data = $ano.'-'.$mes.'-'.$dia;}
        }

        return $data;
    }

    /*
     * Editar dados na tabela pontos_interesse_especialidades
     *
     * @PARAM op : 1(Incluir)  2(Alterar)  3(Excluir)
     */
    public function editPontosInteresseEspecialidades($op, $ponto_interesse_id, $request)
    {
        // Incluir ou Alterar
        if ($op == 1 or $op == 2) {
            // ponto_tipo_id
            $ponto_tipo_id = $request['ponto_tipo_id'];

            // especialidade_tipo_id para cada ponto_tipo_id (HARD CODE)'''''''''
            $especialidade_tipo_id = 0;

            if ($ponto_tipo_id == 1) {$especialidade_tipo_id = 1;} // Hospital
            if ($ponto_tipo_id == 2) {$especialidade_tipo_id = 0;} // Ponto Turístico
            if ($ponto_tipo_id == 3) {$especialidade_tipo_id = 2;} // Escola
            if ($ponto_tipo_id == 4) {$especialidade_tipo_id = 0;} // Quartel PMERJ
            if ($ponto_tipo_id == 5) {$especialidade_tipo_id = 0;} // Quartel CBMERJ
            if ($ponto_tipo_id == 6) {$especialidade_tipo_id = 0;} // Endereço Residencial
            if ($ponto_tipo_id == 7) {$especialidade_tipo_id = 0;} // Endereço Comercial
            //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            // Verificar se especialidade existe para ponto de interesse
            function especialidadeExiste($pon_int_id, $esp_id) {
                $count = PontoInteresseEspecialidade::where('ponto_interesse_id', $pon_int_id)->where('especialidade_id', $esp_id)->count();

                return $count;
            }

            // Especialidades filtradas
            $especialidadesVerificar = Especialidade::where('especialidade_tipo_id', $especialidade_tipo_id)->get();
            $especialidadesDeletar = Especialidade::where('especialidade_tipo_id', '!=', $especialidade_tipo_id)->get();
        }

        // Incluir
        if ($op == 1) {
            // Varrendo para incluir todas as marcadas
            foreach ($especialidadesVerificar as $especialidade) {
                if ($request['especialidade_'.$especialidade['id']]) {
                    PontoInteresseEspecialidade::create(['ponto_interesse_id' => $ponto_interesse_id, 'especialidade_id' => $especialidade['id']]);
                }
            }
        }

        // Alterar
        if ($op == 2) {
            // Varrendo para incluir as marcadas que não estejam gravadas na tabela e apagar as que não estão marcadas e estão gravadas na tabela
            foreach ($especialidadesVerificar as $especialidade) {
                if ($request['especialidade_'.$especialidade['id']]) {
                    if (especialidadeExiste($ponto_interesse_id, $especialidade['id']) == 0) {
                        PontoInteresseEspecialidade::create(['ponto_interesse_id' => $ponto_interesse_id, 'especialidade_id' => $especialidade['id']]);
                    }
                } else {
                    if (especialidadeExiste($ponto_interesse_id, $especialidade['id']) == 1) {
                        PontoInteresseEspecialidade::where('ponto_interesse_id', $ponto_interesse_id)->where('especialidade_id', $especialidade['id'])->delete();
                    }
                }
            }

            // Varrer para apagar as que estão marcadas (caso o usuário tenha alterado o ponto_tipo_id e não desmarcou as especialidades anteriores)
            foreach ($especialidadesDeletar as $especialidade) {
                if (especialidadeExiste($ponto_interesse_id, $especialidade['id']) == 1) {
                    PontoInteresseEspecialidade::where('ponto_interesse_id', $ponto_interesse_id)->where('especialidade_id', $especialidade['id'])->delete();
                }
            }
        }

        // Excluir
        if ($op == 3) {
            PontoInteresseEspecialidade::where('ponto_interesse_id', $ponto_interesse_id)->delete();
        }
    }

    /*
     * Editar dados na tabela brigadasIncendios_materiais
     *
     * @PARAM op : 1(Incluir)  2(Excluir)  3(Alterar)
     */
    public function editBrigadaIncendioMaterial($op, $brigada_incendio_id, $request)
    {
        // Array de Materiais Atuais ()chave pelo material_id para facilitar comparação)
        $materiaisAtuais = BrigadaIncendioMaterial::where('brigada_incendio_id', $brigada_incendio_id)->get()->keyBy('material_id');

        // Array de Materiais Recebidos
        $materiaisRecebidos = [];

        if ($op == 1 || $op == 3) {
            foreach ($request['mat_material_id'] ?? [] as $i => $material_id) {
                $materiaisRecebidos[$material_id] = [
                    'brigada_incendio_id'    => $brigada_incendio_id,
                    'material_id'            => $material_id,
                    'material_categoria_name'=> $request['mat_material_categoria_name'][$i] ?? null,
                    'material_name'          => $request['mat_material_name'][$i] ?? null,
                    'material_quantidade'    => $request['mat_material_quantidade'][$i] ?? null,
                ];
            }
        }

        // Varrer Materiais Atuais e excluir os que não existem mais
        foreach ($materiaisAtuais as $material_id => $registro) {
            if (!isset($materiaisRecebidos[$material_id]) && ($op == 2 || $op == 3)) {
                $dadosAnterior = $registro->toArray();
                $registro->delete();
                Transacoes::transacaoRecord(2, 3, 'brigadas_incendios', $dadosAnterior, $dadosAnterior);
            }
        }

        // Varrer Materiais Recebidos e inserir ou atualizar os que chegaram
        foreach ($materiaisRecebidos as $material_id => $dadosAtual) {
            if (isset($materiaisAtuais[$material_id])) {
                // Atualizar somente se houve mudança
                $registro = $materiaisAtuais[$material_id];
                $dadosAnterior = $registro->toArray();

                $registro->update($dadosAtual);

                Transacoes::transacaoRecord(2, 2, 'brigadas_incendios', $dadosAnterior, $dadosAtual);
            } else {
                // Inserir novo
                BrigadaIncendioMaterial::create($dadosAtual);

                Transacoes::transacaoRecord(2, 1, 'brigadas_incendios', $dadosAtual, $dadosAtual);
            }
        }
    }

    /*
     * Editar dados na tabela brigadasIncendios_escalas
     *
     * @PARAM op : 1(Incluir)  2(Excluir)  3(Alterar)
     */
    public function editBrigadaIncendioEscala($op, $brigada_incendio_id, $request)
    {
        // brigadas_incendios_escalas_brigadistas (EXCLUIR)
        $escalas = BrigadaIncendioEscala::where('brigada_incendio_id', $brigada_incendio_id)->get();
        foreach($escalas as $escala) {
            BrigadaIncendioEscalaBrigadista::where('brigada_incendio_escala_id', $escala['id'])->delete();
        }

        // Array de Escalas Atuais (chave composta: escala_tipo_id + posto)
        $escalasAtuais = BrigadaIncendioEscala::where('brigada_incendio_id', $brigada_incendio_id)
            ->get()
            ->keyBy(function ($item) {
                return $item->escala_tipo_id . '_' . str_replace(' ', '', $item->posto);
            });

        // Array de Escalas Recebidas
        $escalasRecebidas = [];

        if ($op == 1 || $op == 3) {
            foreach ($request['esc_escala_tipo_id'] ?? [] as $i => $escala_tipo_id) {
                $chave = $escala_tipo_id . '_' . (str_replace(' ', '', $request['esc_posto'][$i]) ?? null);

                $escalasRecebidas[$chave] = [
                    'brigada_incendio_id'                       => $brigada_incendio_id,
                    'escala_tipo_id'                            => $escala_tipo_id,
                    'id_linha_hiddens'                          => $request['esc_id_linha_hiddens'][$i] ?? null,
                    'escala_tipo_name'                          => $request['esc_escala_tipo_name'][$i] ?? null,
                    'escala_tipo_quantidade_alas'               => $request['esc_escala_tipo_quantidade_alas'][$i] ?? null,
                    'escala_tipo_quantidade_horas_trabalhadas'  => $request['esc_escala_tipo_quantidade_horas_trabalhadas'][$i] ?? null,
                    'escala_tipo_quantidade_horas_descanso'     => $request['esc_escala_tipo_quantidade_horas_descanso'][$i] ?? null,
                    'quantidade_brigadistas_por_ala'            => $request['esc_quantidade_brigadistas_por_ala'][$i] ?? null,
                    'quantidade_brigadistas_total'              => $request['esc_quantidade_brigadistas_total'][$i] ?? null,
                    'posto'                                     => $request['esc_posto'][$i] ?? null,
                    'hora_inicio_ala_1'                         => $request['esc_hora_inicio_ala_1'][$i] ?? null
                ];
            }
        }

        // Excluir escalas que não vieram mais no request
        foreach ($escalasAtuais as $chave => $registro) {
            if (!isset($escalasRecebidas[$chave]) && ($op == 2 || $op == 3)) {
                $dadosAnterior = $registro->toArray();

                // Deletar Escala
                $registro->delete();

                Transacoes::transacaoRecord(3, 3, 'brigadas_incendios', $dadosAnterior, $dadosAnterior);
            }
        }

        // Inserir ou atualizar escalas recebidas
        $fazerDelete = true;

        foreach ($escalasRecebidas as $chave => $dadosAtual) {
            if (isset($escalasAtuais[$chave])) {
                // Atualizar somente se houve mudança
                $registro = $escalasAtuais[$chave];
                $dadosAnterior = $registro->toArray();

                $registro->update($dadosAtual);

                // pegar o id
                $brigada_incendio_escala_id = $registro->id;

                Transacoes::transacaoRecord(3, 2, 'brigadas_incendios', $dadosAnterior, $dadosAtual);
            } else {
                // Inserir nova escala
                $registro = BrigadaIncendioEscala::create($dadosAtual);

                // pegar o id
                $brigada_incendio_escala_id = $registro->id;

                Transacoes::transacaoRecord(3, 1, 'brigadas_incendios', $dadosAtual, $dadosAtual);
            }

            // brigadas_incendios_escalas_brigadistas (INCLUIR)
            $ala = 0;
            $num = 0;

            for($i=1; $i<=$dadosAtual['escala_tipo_quantidade_alas']; $i++) {
                $ala++;

                for($x=1; $x<=$dadosAtual['quantidade_brigadistas_por_ala']; $x++) {
                    $num++;

                    $regArray = array();
                    $regArray['brigada_incendio_id'] = $brigada_incendio_id;
                    $regArray['brigada_incendio_escala_id'] = $brigada_incendio_escala_id;
                    $regArray['funcionario_id'] = $request['esc_funcionario_id_'.$num.'_'.$dadosAtual['id_linha_hiddens']];
                    $regArray['funcionario_name'] = $request['esc_funcionario_name_'.$num.'_'.$dadosAtual['id_linha_hiddens']];
                    $regArray['ala'] = $request['esc_ala_'.$num.'_'.$dadosAtual['id_linha_hiddens']];

                    BrigadaIncendioEscalaBrigadista::create($regArray);
                    Transacoes::transacaoRecord(4, 1, 'brigadas_incendios', $regArray, $regArray);
                }
            }
        }
    }

    /*
     * Editar dados na tabela brigadas_incendios_escalas_geradas
     *
     * @PARAM op : 1(Incluir)  2(Excluir)
     */
    public function editBrigadaIncendioEscalaGerada($op, $brigada_incendio_id, $request)
    {



        // FAZER ROTINA PARA:

        // . PEGAR TODAS AS ESCALAS GERADAS NO BANCO
        // . PEGAR TODAS AS ESCALAS GERADAS NO REQUEST
        // . VERIFICAR QUAIS ESTÃO NO BANCO E NÃO ESTÃO NO REQUEST E VER SE PODE EXCLUIR
        // . VERIFICAR QUAIS ESTÃO NO REQUEST E NÃO ESTÃO NO BANCO E INCLUIR



        // brigadas_incendios_escalas_brigadistas (EXCLUIR)
        $escalas = BrigadaIncendioEscala::where('brigada_incendio_id', $brigada_incendio_id)->get();
        foreach($escalas as $escala) {
            BrigadaIncendioEscalaBrigadista::where('brigada_incendio_escala_id', $escala['id'])->delete();
        }

        // Array de Escalas Atuais (chave composta: escala_tipo_id + posto)
        $escalasAtuais = BrigadaIncendioEscala::where('brigada_incendio_id', $brigada_incendio_id)
            ->get()
            ->keyBy(function ($item) {
                return $item->escala_tipo_id . '_' . str_replace(' ', '', $item->posto);
            });

        // Array de Escalas Recebidas
        $escalasRecebidas = [];

        if ($op == 1 || $op == 3) {
            foreach ($request['esc_escala_tipo_id'] ?? [] as $i => $escala_tipo_id) {
                $chave = $escala_tipo_id . '_' . (str_replace(' ', '', $request['esc_posto'][$i]) ?? null);

                $escalasRecebidas[$chave] = [
                    'brigada_incendio_id'                       => $brigada_incendio_id,
                    'escala_tipo_id'                            => $escala_tipo_id,
                    'id_linha_hiddens'                          => $request['esc_id_linha_hiddens'][$i] ?? null,
                    'escala_tipo_name'                          => $request['esc_escala_tipo_name'][$i] ?? null,
                    'escala_tipo_quantidade_alas'               => $request['esc_escala_tipo_quantidade_alas'][$i] ?? null,
                    'escala_tipo_quantidade_horas_trabalhadas'  => $request['esc_escala_tipo_quantidade_horas_trabalhadas'][$i] ?? null,
                    'escala_tipo_quantidade_horas_descanso'     => $request['esc_escala_tipo_quantidade_horas_descanso'][$i] ?? null,
                    'quantidade_brigadistas_por_ala'            => $request['esc_quantidade_brigadistas_por_ala'][$i] ?? null,
                    'quantidade_brigadistas_total'              => $request['esc_quantidade_brigadistas_total'][$i] ?? null,
                    'posto'                                     => $request['esc_posto'][$i] ?? null,
                    'hora_inicio_ala_1'                         => $request['esc_hora_inicio_ala_1'][$i] ?? null
                ];
            }
        }

        // Excluir escalas que não vieram mais no request
        foreach ($escalasAtuais as $chave => $registro) {
            if (!isset($escalasRecebidas[$chave]) && ($op == 2 || $op == 3)) {
                $dadosAnterior = $registro->toArray();

                // Deletar Escala
                $registro->delete();

                Transacoes::transacaoRecord(3, 3, 'brigadas_incendios', $dadosAnterior, $dadosAnterior);
            }
        }

        // Inserir ou atualizar escalas recebidas
        $fazerDelete = true;

        foreach ($escalasRecebidas as $chave => $dadosAtual) {
            if (isset($escalasAtuais[$chave])) {
                // Atualizar somente se houve mudança
                $registro = $escalasAtuais[$chave];
                $dadosAnterior = $registro->toArray();

                $registro->update($dadosAtual);

                // pegar o id
                $brigada_incendio_escala_id = $registro->id;

                Transacoes::transacaoRecord(3, 2, 'brigadas_incendios', $dadosAnterior, $dadosAtual);
            } else {
                // Inserir nova escala
                $registro = BrigadaIncendioEscala::create($dadosAtual);

                // pegar o id
                $brigada_incendio_escala_id = $registro->id;

                Transacoes::transacaoRecord(3, 1, 'brigadas_incendios', $dadosAtual, $dadosAtual);
            }

            // brigadas_incendios_escalas_brigadistas (INCLUIR)
            $ala = 0;
            $num = 0;

            for($i=1; $i<=$dadosAtual['escala_tipo_quantidade_alas']; $i++) {
                $ala++;

                for($x=1; $x<=$dadosAtual['quantidade_brigadistas_por_ala']; $x++) {
                    $num++;

                    $regArray = array();
                    $regArray['brigada_incendio_id'] = $brigada_incendio_id;
                    $regArray['brigada_incendio_escala_id'] = $brigada_incendio_escala_id;
                    $regArray['funcionario_id'] = $request['esc_funcionario_id_'.$num.'_'.$dadosAtual['id_linha_hiddens']];
                    $regArray['funcionario_name'] = $request['esc_funcionario_name_'.$num.'_'.$dadosAtual['id_linha_hiddens']];
                    $regArray['ala'] = $request['esc_ala_'.$num.'_'.$dadosAtual['id_linha_hiddens']];

                    BrigadaIncendioEscalaBrigadista::create($regArray);
                    Transacoes::transacaoRecord(4, 1, 'brigadas_incendios', $regArray, $regArray);
                }
            }
        }
    }

    /*
     * Editar dados na tabela materiais_entradas_itens
     *
     * @PARAM op : 1(Incluir)  2(Excluir)  3(Alterar)
     */
    public function editMaterialEntradaItem($op, $material_entrada_id, $request)
    {
        // Buscar todos os itens atuais da entrada
        $materiaisAtuais = MaterialEntradaItem::where('material_entrada_id', $material_entrada_id)->get();
        $materiaisAtuaisPorId = $materiaisAtuais->keyBy('id');

        // Montar array de itens recebidos do request
        $materiaisRecebidos = [];

        if (in_array($op, [1, 3])) {
            foreach ($request['mat_material_id'] ?? [] as $i => $material_id) {
                $materiaisRecebidos[] = [
                    'id'                            => $request['mat_material_item_id'][$i] ?? null, // ID real do item (ou null se novo)
                    'material_entrada_id'           => $material_entrada_id,
                    'material_id'                   => $material_id,
                    'material_categoria_name'       => $request['mat_material_categoria_name'][$i] ?? null,
                    'material_name'                 => $request['mat_material_name'][$i] ?? null,
                    'material_numero_patrimonio'    => $request['mat_material_numero_patrimonio'][$i] ?? null,
                    'material_valor_unitario'       => $request['mat_material_valor_unitario'][$i] ?? null,
                    'estoque_local_id'              => $request['estoque_local_id'],
                ];
            }
        }

        // IDs recebidos do frontend
        $idsRecebidos = collect($materiaisRecebidos)
            ->pluck('id')
            ->filter()
            ->toArray();

        // 1. Excluir registros que foram removidos da tela
        if (in_array($op, [2, 3])) {
            foreach ($materiaisAtuais as $registro) {
                if (!in_array($registro->id, $idsRecebidos)) {
                    $dadosAnterior = $registro->toArray();
                    $registro->delete();

                    Transacoes::transacaoRecord(2, 3, 'materiais_entradas', $dadosAnterior, $dadosAnterior);
                }
            }
        }

        // 2. Inserir ou atualizar registros recebidos
        foreach ($materiaisRecebidos as $dadosAtual) {
            // UPDATE — manter o mesmo ID
            if (!empty($dadosAtual['id']) && isset($materiaisAtuaisPorId[$dadosAtual['id']])) {
                $registro = $materiaisAtuaisPorId[$dadosAtual['id']];
                $dadosAnterior = $registro->toArray();

                // Atualiza apenas se algo mudou
                if ($this->editMaterialEntradaItemDadosDiferentes($registro, $dadosAtual)) {
                    $registro->update($dadosAtual);
                    Transacoes::transacaoRecord(2, 2, 'materiais_entradas', $dadosAnterior, $dadosAtual);
                }
            }

            // INSERT — novo item sem ID
            else {
                $novo = MaterialEntradaItem::create($dadosAtual);
                Transacoes::transacaoRecord(2, 1, 'materiais_entradas', $dadosAtual, $novo->toArray());
            }
        }
    }

    /**
     * Função auxiliar para detectar alterações entre o registro e o array atual.
     * Evita update desnecessário.
     */
    private function editMaterialEntradaItemDadosDiferentes($registro, $dados)
    {
        foreach ($dados as $campo => $valor) {
            if ($campo === 'id') {
                continue;
            }
            if ($registro->$campo != $valor) {
                return true;
            }
        }
        return false;
    }

    /*
     * Verificar se existe numero_patrimonio antes de editar dados na tabela materiais_entradas_itens
     */
    public function validarPatrimoniosDuplicados($request, $material_entrada_id = null)
    {
        $patrimonios = array_filter($request['mat_material_numero_patrimonio'] ?? []);

        if (empty($patrimonios)) {
            return; // nada a validar
        }

        // Buscar duplicados já existentes em outras entradas
        $query = MaterialEntradaItem::whereIn('material_numero_patrimonio', $patrimonios);

        if ($material_entrada_id) {
            $query->where('material_entrada_id', '!=', $material_entrada_id);
        }

        $duplicados = $query->pluck('material_numero_patrimonio')->toArray();

        if (!empty($duplicados)) {
            // Monta mensagem de validação no formato do Laravel
            $mensagem = [];
            foreach ($duplicados as $pat) {
                $mensagem["mat_material_numero_patrimonio"][] = "O número de patrimônio '{$pat}' já está cadastrado.";
            }

            // Lança ValidationException (Laravel trata automaticamente)
            throw ValidationException::withMessages($mensagem);
        }
    }
    /*
     * Editar dados na tabela ordens_servicos_servicos
     *
     * @PARAM op=1 : Incluir Serviços na Ordens Servicos
     * @PARAM op=2 : Excluir Serviços da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Serviços da Ordens Servicos (Todos) e Incluir Serviços na Ordens Servicos
     */
    public function editOrdemServicoServico($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os servicos da ordem_servico
            $ordemServicoServicos = OrdemServicoServico::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoServicos as $ordemServicoServico) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoServico;

                //Excluir
                OrdemServicoServico::where('id', $ordemServicoServico['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['servico_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['servico_id'] = $request['servico_id'][$i];
                    $dadosAtual['servico_item'] = $request['servico_item'][$i];
                    $dadosAtual['servico_nome'] = $request['servico_nome'][$i];
                    $dadosAtual['responsavel_funcionario_id'] = $request['responsavel_funcionario_id'][$i];
                    $dadosAtual['responsavel_funcionario_nome'] = $request['responsavel_funcionario_nome'][$i];

                    //Verificar ordem_servico_tipo_id
                    if ($request['ordem_servico_tipo_id'] == 1 or $request['ordem_servico_tipo_id'] == 2) {
                        $dadosAtual['servico_valor'] = $request['servico_valor'][$i];
                        $dadosAtual['servico_quantidade'] = $request['servico_quantidade'][$i];
                        $dadosAtual['servico_valor_total'] = $request['servico_valor_total'][$i];
                    } else if ($request['ordem_servico_tipo_id'] == 3) {
                        $dadosAtual['servico_valor'] = null;
                        $dadosAtual['servico_quantidade'] = null;
                        $dadosAtual['servico_valor_total'] = null;
                    }

                    //Incluir
                    OrdemServicoServico::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(2, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_veiculos
     *
     * @PARAM op=1 : Incluir Veículos na Ordens Servicos
     * @PARAM op=2 : Excluir Veículos da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Veículos da Ordens Servicos (Todos) e Incluir Veículos na Ordens Servicos
     */
    public function editOrdemServicoVeiculo($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os veiculos da ordem_servico
            $ordemServicoVeiculos = OrdemServicoVeiculo::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoVeiculos as $ordemServicoVeiculo) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoVeiculo;

                //Excluir
                OrdemServicoVeiculo::where('id', $ordemServicoVeiculo['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(3, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['veiculo_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['veiculo_id'] = $request['veiculo_id'][$i];
                    $dadosAtual['veiculo_item'] = $request['veiculo_item'][$i];
                    $dadosAtual['veiculo_marca'] = $request['veiculo_marca'][$i];
                    $dadosAtual['veiculo_modelo'] = $request['veiculo_modelo'][$i];
                    $dadosAtual['veiculo_placa'] = $request['veiculo_placa'][$i];
                    $dadosAtual['veiculo_combustivel'] = $request['veiculo_combustivel'][$i];

                    //Incluir
                    OrdemServicoVeiculo::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(3, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_executivos
     *
     * @PARAM op=1 : Incluir Executivos na Ordens Servicos
     * @PARAM op=2 : Excluir Executivos da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Executivos da Ordens Servicos (Todos) e Incluir Executivos na Ordens Servicos
     */
    public function editOrdemServicoExecutivo($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os executivos da ordem_servico
            $ordemServicoExecutivos = OrdemServicoExecutivo::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoExecutivos as $ordemServicoExecutivo) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoExecutivo;

                //Excluir
                OrdemServicoExecutivo::where('id', $ordemServicoExecutivo['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(4, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['cliente_executivo_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['cliente_executivo_id'] = $request['cliente_executivo_id'][$i];
                    $dadosAtual['cliente_executivo_item'] = $request['cliente_executivo_item'][$i];
                    $dadosAtual['cliente_executivo_nome'] = $request['cliente_executivo_nome'][$i];
                    $dadosAtual['cliente_executivo_funcao'] = $request['cliente_executivo_funcao'][$i];
                    $dadosAtual['cliente_executivo_veiculo_id'] = $request['cliente_executivo_veiculo_id'][$i];

                    //Incluir
                    OrdemServicoExecutivo::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(4, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }


    /*
     * Editar dados na tabela ordens_servicos_equipes
     *
     * @PARAM op=1 : Incluir Equipes na Ordens Servicos
     * @PARAM op=2 : Excluir Equipes da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Equipes da Ordens Servicos (Todos) e Incluir Equipes na Ordens Servicos
     */
    public function editOrdemServicoEquipe($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar as equipes da ordem_servico
            $ordemServicoEquipes = OrdemServicoEquipe::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoEquipes as $ordemServicoEquipe) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoEquipe;

                //Excluir
                OrdemServicoEquipe::where('id', $ordemServicoEquipe['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(6, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['equipe_funcionario_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['equipe_funcionario_id'] = $request['equipe_funcionario_id'][$i];
                    $dadosAtual['equipe_funcionario_item'] = $request['equipe_funcionario_item'][$i];
                    $dadosAtual['equipe_funcionario_nome'] = $request['equipe_funcionario_nome'][$i];
                    $dadosAtual['equipe_funcionario_funcao'] = $request['equipe_funcionario_funcao'][$i];
                    $dadosAtual['equipe_funcionario_veiculo_id'] = $request['equipe_funcionario_veiculo_id'][$i];

                    //Incluir
                    OrdemServicoEquipe::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(6, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela ordens_servicos_destinos
     *
     * @PARAM op=1 : Incluir Destinos na Ordens Servicos
     * @PARAM op=2 : Excluir Destinos da Ordens Servicos (Todos)
     * @PARAM op=3 : Excluir Destinos da Ordens Servicos (Todos) e Incluir Destinos na Ordens Servicos
     */
    public function editOrdemServicoDestino($op, $ordem_servico_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os destinos da ordem_servico
            $ordemServicoDestinos = OrdemServicoDestino::where('ordem_servico_id', $ordem_servico_id)->get();

            foreach ($ordemServicoDestinos as $ordemServicoDestino) {
                //Dados Anterior
                $dadosAnterior = $ordemServicoDestino;

                //Excluir
                OrdemServicoDestino::where('id', $ordemServicoDestino['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(5, 3, 'ordens_servicos', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['destino_ordem'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['ordem_servico_id'] = $ordem_servico_id;
                    $dadosAtual['destino_ordem'] = $request['destino_ordem'][$i];
                    $dadosAtual['destino_cep'] = $request['destino_cep'][$i];
                    $dadosAtual['destino_logradouro'] = $request['destino_logradouro'][$i];
                    $dadosAtual['destino_bairro'] = $request['destino_bairro'][$i];
                    $dadosAtual['destino_localidade'] = $request['destino_localidade'][$i];
                    $dadosAtual['destino_uf'] = $request['destino_uf'][$i];
                    $dadosAtual['destino_numero'] = $request['destino_numero'][$i];
                    $dadosAtual['destino_complemento'] = $request['destino_complemento'][$i];
                    $dadosAtual['destino_data_agendada'] = $request['destino_data_agendada_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_hora_agendada'] = $request['destino_hora_agendada_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_data_inicio'] = $request['destino_data_inicio_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_hora_inicio'] = $request['destino_hora_inicio_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_data_termino'] = $request['destino_data_termino_'.$request['destino_ordem'][$i]];
                    $dadosAtual['destino_hora_termino'] = $request['destino_hora_termino_'.$request['destino_ordem'][$i]];

                    //Incluir
                    OrdemServicoDestino::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(5, 1, 'ordens_servicos', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Editar dados na tabela clientes_seguranca_medidas
     *
     * @PARAM op=1 : Edição (verifica se é para Incluir, Alterar ou Excluir de acordo com os dados da Edificação)
     * @PARAM op=3 : Excluir (vai direto para Excluir todos os registros pertencentes ao Cliente)
     */
    public function editClienteSegurancaMedida($op, $cliente_id, $request)
    {
        //Editar
        if ($op == 1) {
            //Número de Pavimentos da Edificação (Colocar um valor hard code para poder executar a função corretamente)
            $numero_pavimentos = 50;

            //Buscar Segurança Medidas para percorrer
            $seguranca_medidas = SegurancaMedida::all();

            //Varrer os Pavimentos
            for($pavimento=1; $pavimento<=$numero_pavimentos; $pavimento++) {
                foreach ($seguranca_medidas as $seguranca_medida) {
                    //Segurança Medida Id
                    $seguranca_medida_id = $seguranca_medida['id'];

                    //Verificar se o Cliente já tem essa segurança medida para o Pavimento gravado no banco de dados
                    $clienteSegurancaMedida = ClienteSegurancaMedida::where('pavimento', $pavimento)->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $seguranca_medida_id)->get();

                    //Se tem no banco (Copiar como dados anterior)
                    if ($clienteSegurancaMedida->count() == 1) {
                        //Dados anterior (que está no banco de dados)
                        $dadosAnterior = $clienteSegurancaMedida[0];
                    }

                    //Verificando se existe dados para a empresa (testando um campo qualquer. Ex.: seguranca_medida_id)
                    if (isset($request['seguranca_medida_' . $pavimento . '_' . $seguranca_medida_id])) {
                        //Dados Atual
                        $dadosAtual = array();
                        $dadosAtual['pavimento'] = $pavimento;
                        $dadosAtual['cliente_id'] = $cliente_id;
                        $dadosAtual['seguranca_medida_id'] = $seguranca_medida_id;
                        $dadosAtual['quantidade'] = $request['quantidade_' . $pavimento . '_' . $seguranca_medida_id];
                        $dadosAtual['tipo'] = $request['tipo_' . $pavimento . '_' . $seguranca_medida_id];
                        $dadosAtual['observacao'] = $request['observacao_' . $pavimento . '_' . $seguranca_medida_id];

                        //Variavel para controle de operação $operacao (1: incluir / 2: alterar / 3: excluir)
                        $operacao = 0;

                        //Se não tem no banco (Mudar operação para inclusão)
                        if ($clienteSegurancaMedida->count() == 0) {$operacao = 1;}

                        //Se tem no banco (Mudar operação para alteração)
                        if ($clienteSegurancaMedida->count() == 1) {$operacao = 2;}

                        //Verificar se dados recebidos estão ok
                        if ($dadosAtual['pavimento'] == '') {$operacao = 0;}
                        if ($dadosAtual['cliente_id'] == '') {$operacao = 0;}
                        if ($dadosAtual['seguranca_medida_id'] == '') {$operacao = 0;}
                        if ($dadosAtual['quantidade'] == '') {$operacao = 0;}
                        if ($dadosAtual['tipo'] == '') {}
                        if ($dadosAtual['observacao'] == '') {}

                        //Se $operacao = 1
                        if ($operacao == 1) {
                            ClienteSegurancaMedida::create($dadosAtual);

                            //gravar transacao
                            Transacoes::transacaoRecord(2, 1, 'clientes', $dadosAtual, $dadosAtual);
                        }

                        //Se $operacao = 2
                        if ($operacao == 2) {
                            ClienteSegurancaMedida::where('pavimento', $pavimento)->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $seguranca_medida_id)->update($dadosAtual);

                            //gravar transacao
                            Transacoes::transacaoRecord(2, 2, 'clientes', $dadosAnterior, $dadosAtual);
                        }
                    } else {
                        //Se tem no banco e não tem no request (Mudar operação para exclusão)
                        if ($clienteSegurancaMedida->count() == 1) {
                            $operacao = 3;

                            //Se $operacao = 3
                            if ($operacao == 3) {
                                ClienteSegurancaMedida::where('pavimento', $pavimento)->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $seguranca_medida_id)->delete();

                                //gravar transacao
                                Transacoes::transacaoRecord(2, 3, 'clientes', $dadosAnterior, $dadosAnterior);
                            }
                        }
                    }
                }
            }
        }

        //Excluir
        if ($op == 3) {
            //Verificar as segurança medidas do Cliente
            $clienteSegurancaMedidas = ClienteSegurancaMedida::where('cliente_id', $cliente_id)->get();

            foreach ($clienteSegurancaMedidas as $clienteSegurancaMedida) {
                //Dados
                $dadosAnterior = $clienteSegurancaMedida;

                //Excluir
                ClienteSegurancaMedida::where('pavimento', $clienteSegurancaMedida['pavimento'])->where('cliente_id', $cliente_id)->where('seguranca_medida_id', $clienteSegurancaMedida['seguranca_medida_id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'clientes', $dadosAnterior, $dadosAnterior);
            }
        }
    }

    /*
     * Editar dados na tabela propostas_servicos
     *
     * @PARAM op=1 : Incluir Serviços na Proposta
     * @PARAM op=2 : Excluir Serviços da Proposta (Todos)
     * @PARAM op=3 : Excluir Serviços da Proposta (Todos) e Incluir Serviços na Proposta
     */
    public function editPropostaServico($op, $proposta_id, $request)
    {
        //Excluir
        if ($op == 2 or $op == 3) {
            //Verificar os servicos da proposta
            $propostaServicos = PropostaServico::where('proposta_id', $proposta_id)->get();

            foreach ($propostaServicos as $propostaServico) {
                //Dados Anterior
                $dadosAnterior = $propostaServico;

                //Excluir
                PropostaServico::where('id', $propostaServico['id'])->delete();

                //gravar transacao
                Transacoes::transacaoRecord(2, 3, 'propostas', $dadosAnterior, $dadosAnterior);
            }
        }

        //Incluir
        if ($op == 1 || $op == 3) {
            for ($i = 0; $i <= 50; $i++) {
                if (isset($request['servico_id'][$i])) {
                    //Dados Atual
                    $dadosAtual = array();
                    $dadosAtual['proposta_id'] = $proposta_id;
                    $dadosAtual['servico_id'] = $request['servico_id'][$i];
                    $dadosAtual['servico_item'] = $request['servico_item'][$i];
                    $dadosAtual['servico_nome'] = $request['servico_nome'][$i];
                    $dadosAtual['servico_valor'] = $request['servico_valor'][$i];
                    $dadosAtual['servico_quantidade'] = $request['servico_quantidade'][$i];
                    $dadosAtual['servico_valor_total'] = $request['servico_valor_total'][$i];

                    //Incluir
                    PropostaServico::create($dadosAtual);

                    //gravar transacao
                    Transacoes::transacaoRecord(2, 1, 'propostas', $dadosAtual, $dadosAtual);
                }
            }
        }
    }

    /*
     * Bloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
     *
     * @param   string      $tabela         : Nome da Tabela (ex: 'funcionarios')
     * @param   int|null    $tabela_id      : ID do registro (opcional, para travar um item específico)
     * @param   int         $timeOutMinutes : Tempo de expiração automática do lock (padrão: 3 min)
     *
     * @return  array                       : Retorna ['status' => 'ok'] ou ['status' => 'locked', 'message' => ...]
    */
    public static function bloquearTabelaRegistro($tabela, $tabela_id = null, $timeOutMinutes = 1)
    {
        // Usuário que está acessando
        $userId = Auth::id();

        // Sessão Hash para identificar Usuário, IP e Máquina
        $sessionHash = hash('sha256', $userId . '|' . session()->getId() . '|' . request()->ip());

        // Limpa locks antigos (expirados)
        BlockTableOrRecord::where('locked_at', '<', now()->subMinutes($timeOutMinutes))->delete();

        // Verifica se já há lock ativo
        $query = BlockTableOrRecord::where('tabela', $tabela);
        if ($tabela_id) {
            $query->where('tabela_id', $tabela_id);
        }

        $lock = $query->first();

        // Se existe lock e não é da mesma sessão, bloqueia
        if ($lock && $lock->session_hash !== $sessionHash) {
            return [
                'status' => 'locked',
                'message' => 'Este recurso está bloqueado por outro usuário ou sessão ativa.'
            ];
        }

        // Cria ou renova o lock para a sessão atual
        BlockTableOrRecord::updateOrCreate(
            ['tabela' => $tabela, 'tabela_id' => $tabela_id],
            [
                'user_id' => $userId,
                'session_hash' => $sessionHash,
                'locked_at' => now()
            ]
        );

        return ['status' => 'unlocked'];
    }

    /*
     * Desbloquear Tabela ou Registro para Edição (Incluir, Alterar e Excluir)
     *
     * @param   string      $tabela         : Nome da Tabela (ex: 'funcionarios')
     * @param   int|null    $tabela_id      : ID do registro (opcional, para destravar um item específico)
    */
    public static function desbloquearTabelaRegistro($tabela, $tabela_id = null)
    {
        // Usuário que está acessando
        $userId = Auth::id();

        // Sessão Hash para identificar Usuário, IP e Máquina
        $sessionHash = hash('sha256', $userId . '|' . session()->getId() . '|' . request()->ip());

        BlockTableOrRecord::where('tabela', $tabela)
            ->when($tabela_id, fn($q) => $q->where('tabela_id', $tabela_id))
            ->where('user_id', $userId)
            ->where('session_hash', $sessionHash)
            ->delete();
    }

    // Criar registro na tabela materiais_controle_situacoes_itens
    public static function gravarRegistroControleSituacao($material_entrada_item_id, $anterior_material_situacao_id, $atual_material_situacao_id, $anterior_estoque_local_id, $atual_estoque_local_id, $observacao, $data_alteracao, $hora_alteracao)
    {
        MaterialControleSituacaoItem::create([
            'material_entrada_item_id' => $material_entrada_item_id,
            'anterior_material_situacao_id' => $anterior_material_situacao_id,
            'atual_material_situacao_id' => $atual_material_situacao_id,
            'anterior_estoque_local_id' => $anterior_estoque_local_id,
            'atual_estoque_local_id' => $atual_estoque_local_id,
            'observacao' => $observacao,
            'data_alteracao' => $data_alteracao,
            'hora_alteracao' => $hora_alteracao
        ]);
    }
}
