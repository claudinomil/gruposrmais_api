<?php

namespace Database\Seeders;

use App\Models\Especialidade;
use App\Models\EspecialidadeTipo;
use App\Models\GrupoRelatorio;
use App\Models\Permissao;
use App\Models\PontoNatureza;
use App\Models\Relatorio;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20251107_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Alterar registro na tabela submodulos
        Submodulo::where('id', 31)->update(['modulo_id' => '4', 'menu_url' => 'pontos_interesse', 'menu_route' => 'pontos_interesse', 'prefix_permissao' => 'pontos_interesse', 'prefix_route' => 'pontos_interesse', 'viewing_order' => 85]);

        // Alterar registros na tabela permissoes
        Permissao::where('id', 147)->update(['name' => 'pontos_interesse_list']);
        Permissao::where('id', 148)->update(['name' => 'pontos_interesse_create']);
        Permissao::where('id', 149)->update(['name' => 'pontos_interesse_show']);
        Permissao::where('id', 150)->update(['name' => 'pontos_interesse_edit']);
        Permissao::where('id', 151)->update(['name' => 'pontos_interesse_destroy']);

        //Mapa Ponto Natureza
        PontoNatureza::create(['id' => 1, 'name' => 'Pública']);
        PontoNatureza::create(['id' => 2, 'name' => 'Privada']);
        PontoNatureza::create(['id' => 3, 'name' => 'Pública Federal']);
        PontoNatureza::create(['id' => 4, 'name' => 'Pública Estadual']);
        PontoNatureza::create(['id' => 5, 'name' => 'Pública Municipal']);
        PontoNatureza::create(['id' => 6, 'name' => 'Privada com fins lucrativos']);
        PontoNatureza::create(['id' => 7, 'name' => 'Privada sem fins lucrativos']);
        PontoNatureza::create(['id' => 8, 'name' => 'Privada Comunitária']);
        PontoNatureza::create(['id' => 9, 'name' => 'Privada Confessional']);
        PontoNatureza::create(['id' => 10, 'name' => 'Privada Filantrópica']);

        //agrupamento_id=2 : Diversos
        Relatorio::create(['id' => 8, 'agrupamento_id' => 2, 'name' => 'Ponto de Interesse', 'descricao' => '', 'ordem_visualizacao' => 3]);

        //grupo_id=1
        GrupoRelatorio::create(['grupo_id' => 1, 'relatorio_id' => 8]);

        // Especialidades Tipos
        EspecialidadeTipo::create(['id' => 1, 'name' => 'Médica']);
        EspecialidadeTipo::create(['id' => 2, 'name' => 'Educacional']);
        
        // Especialidades para Hospitais
        Especialidade::create(['id' => 1, 'name' => 'Alergia e Imunologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 2, 'name' => 'Anestesiologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 3, 'name' => 'Angiologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 4, 'name' => 'Cancerologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 5, 'name' => 'Cardiologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 6, 'name' => 'Cirurgia Cardiovascular', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 7, 'name' => 'Cirurgia da Mão', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 8, 'name' => 'Cirurgia de Cabeça e Pescoço', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 9, 'name' => 'Cirurgia do Aparelho Digestivo', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 10, 'name' => 'Cirurgia Geral', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 11, 'name' => 'Cirurgia Pediátrica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 12, 'name' => 'Cirurgia Plástica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 13, 'name' => 'Cirurgia Torácica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 14, 'name' => 'Cirurgia Vascular', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 15, 'name' => 'Clínica Médica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 16, 'name' => 'Coloproctologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 17, 'name' => 'Dermatologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 18, 'name' => 'Endocrinologia e Metabologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 19, 'name' => 'Endoscopia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 20, 'name' => 'Gastroenterologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 21, 'name' => 'Genética Médica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 22, 'name' => 'Geriatria', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 23, 'name' => 'Ginecologia e Obstetrícia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 24, 'name' => 'Hematologia e Hemoterapia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 25, 'name' => 'Homeopatia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 26, 'name' => 'Infectologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 27, 'name' => 'Mastologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 28, 'name' => 'Medicina de Família e Comunidade', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 29, 'name' => 'Medicina de Tráfego', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 30, 'name' => 'Medicina do Trabalho', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 31, 'name' => 'Medicina Esportiva', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 32, 'name' => 'Medicina Física e Reabilitação', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 33, 'name' => 'Medicina Intensiva', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 34, 'name' => 'Medicina Legal e Perícia Médica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 35, 'name' => 'Medicina Nuclear', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 36, 'name' => 'Medicina Preventiva e Social', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 37, 'name' => 'Nefrologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 38, 'name' => 'Neurocirurgia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 39, 'name' => 'Neurologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 40, 'name' => 'Nutrologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 41, 'name' => 'Oftalmologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 42, 'name' => 'Ortopedia e Traumatologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 43, 'name' => 'Otorrinolaringologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 44, 'name' => 'Patologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 45, 'name' => 'Patologia Clínica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 46, 'name' => 'Pediatria', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 47, 'name' => 'Pneumologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 48, 'name' => 'Psiquiatria', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 49, 'name' => 'Radiologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 50, 'name' => 'Radioterapia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 51, 'name' => 'Reumatologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 52, 'name' => 'Urologia', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 53, 'name' => 'Dor', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 54, 'name' => 'Medicina de Emergência', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 55, 'name' => 'Oncologia Clínica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 56, 'name' => 'Diagnóstico por Imagem', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 87, 'name' => 'Urgência/Emergência Clínica', 'especialidade_tipo_id' => 1]);
        Especialidade::create(['id' => 88, 'name' => 'Urgência/Emergência Clínica (24h)', 'especialidade_tipo_id' => 1]);

        // Especialidades para Escolas
        Especialidade::create(['id' => 57, 'name' => 'EDUCAÇÃO INFANTIL', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 58, 'name' => 'ENSINO FUNDAMENTAL I', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 59, 'name' => 'ENSINO FUNDAMENTAL II', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 60, 'name' => 'ENSINO MÉDIO', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 61, 'name' => 'EDUCAÇÃO DE JOVENS E ADULTOS (EJA)', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 62, 'name' => 'EDUCAÇÃO ESPECIAL', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 63, 'name' => 'EDUCAÇÃO INCLUSIVA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 64, 'name' => 'ORIENTAÇÃO EDUCACIONAL', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 65, 'name' => 'COORDENAÇÃO PEDAGÓGICA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 66, 'name' => 'PSICOPEDAGOGIA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 67, 'name' => 'PSICOLOGIA EDUCACIONAL', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 68, 'name' => 'FONOAUDIOLOGIA ESCOLAR', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 69, 'name' => 'NUTRIÇÃO ESCOLAR', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 70, 'name' => 'SERVIÇO SOCIAL ESCOLAR', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 71, 'name' => 'BIBLIOTECONOMIA ESCOLAR', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 72, 'name' => 'INFORMÁTICA EDUCATIVA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 73, 'name' => 'ARTES E CULTURA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 74, 'name' => 'EDUCAÇÃO FÍSICA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 75, 'name' => 'MÚSICA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 76, 'name' => 'LÍNGUA PORTUGUESA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 77, 'name' => 'LÍNGUA INGLESA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 78, 'name' => 'LÍNGUA ESPANHOLA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 79, 'name' => 'MATEMÁTICA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 80, 'name' => 'CIÊNCIAS', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 81, 'name' => 'HISTÓRIA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 82, 'name' => 'GEOGRAFIA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 83, 'name' => 'FILOSOFIA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 84, 'name' => 'SOCIOLOGIA', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 85, 'name' => 'ROBÓTICA EDUCACIONAL', 'especialidade_tipo_id' => 2]);
        Especialidade::create(['id' => 86, 'name' => 'EDUCAÇÃO AMBIENTAL', 'especialidade_tipo_id' => 2]);
    }
}