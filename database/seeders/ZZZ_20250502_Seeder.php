<?php

namespace Database\Seeders;

use App\Models\FormaPagamento;
use App\Models\FormaPagamentoStatus;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Mapa;
use App\Models\PontoInteresse;
use App\Models\PontoTipo;
use App\Models\OrdemServicoPrioridade;
use App\Models\OrdemServicoStatus;
use App\Models\OrdemServicoTipo;
use App\Models\Relatorio;
use App\Models\Servico;
use App\Models\ServicoTipo;
use App\Models\VeiculoCategoria;
use App\Models\VeiculoCombustivel;
use App\Models\VeiculoMarca;
use App\Models\VeiculoModelo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Permissao;

class ZZZ_20250502_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Submódulos
        DB::table('submodulos')->insert([
            ['id' => '30', 'modulo_id' => '1', 'name' => 'Mapas', 'menu_text' => 'Mapas', 'menu_url' => 'mapas', 'menu_route' => 'mapas', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'mapas', 'prefix_route' => 'mapas', 'mobile' => 0, 'menu_text_mobile' => 'Meus Mapas', 'viewing_order' => 120]
        ]);

        //Permissões
        Permissao::create(['id' => 142, 'submodulo_id' => 30, 'name' => 'mapas_list', 'description' => 'Visualizar Registro - Mapas']);
        Permissao::create(['id' => 143, 'submodulo_id' => 30, 'name' => 'mapas_create', 'description' => 'Criar Registro - Mapas']);
        Permissao::create(['id' => 144, 'submodulo_id' => 30, 'name' => 'mapas_show', 'description' => 'Visualizar Registro - Mapas']);
        Permissao::create(['id' => 145, 'submodulo_id' => 30, 'name' => 'mapas_edit', 'description' => 'Editar Registro - Mapas']);
        Permissao::create(['id' => 146, 'submodulo_id' => 30, 'name' => 'mapas_destroy', 'description' => 'Deletar Registro - Mapas']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 142]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 143]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 144]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 145]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 146]);

        //Mapa Ponto Tipo
        PontoTipo::create(['id' => 1, 'name' => 'Hospital']);
        PontoTipo::create(['id' => 2, 'name' => 'Ponto Turístico']);
        PontoTipo::create(['id' => 3, 'name' => 'Escola']);
        PontoTipo::create(['id' => 4, 'name' => 'Quartel PMERJ']);
        PontoTipo::create(['id' => 5, 'name' => 'Quartel CBMERJ']);
        PontoTipo::create(['id' => 6, 'name' => 'Endereço Residencial']);
        PontoTipo::create(['id' => 7, 'name' => 'Endereço Comercial']);

        //Pontos no Mapa
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Samaritano', 'descricao' => 'Hospital localizado em Botafogo', 'latitude' => -22.9676, 'longitude' => -43.1869, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Barra DOr', 'descricao' => 'Hospital na Barra da Tijuca', 'latitude' => -22.9991, 'longitude' => -43.3659, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Unimed Rio', 'descricao' => 'Hospital da rede Unimed', 'latitude' => -22.9045, 'longitude' => -43.2096, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Rio Mar', 'descricao' => 'Hospital na região do Recreio', 'latitude' => -22.9891, 'longitude' => -43.4024, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Vitória', 'descricao' => 'Hospital na Zona Oeste', 'latitude' => -22.9645, 'longitude' => -43.2301, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Municipal Souza Aguiar', 'descricao' => 'Hospital público no Centro', 'latitude' => -22.9068, 'longitude' => -43.1801, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Municipal Miguel Couto', 'descricao' => 'Hospital de emergência na Zona Sul', 'latitude' => -22.9711, 'longitude' => -43.2291, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Municipal Salgado Filho', 'descricao' => 'Hospital público em Méier', 'latitude' => -22.8725, 'longitude' => -43.2811, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Municipal Lourenço Jorge', 'descricao' => 'Hospital na Barra da Tijuca', 'latitude' => -22.9998, 'longitude' => -43.3652, 'icone' => 'house.png']);
        PontoInteresse::create(['ponto_tipo_id' => 1, 'name' => 'Hospital Municipal Rocha Faria', 'descricao' => 'Hospital em Campo Grande', 'latitude' => -22.8853, 'longitude' => -43.5657, 'icone' => 'house.png']);

        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Cristo Redentor', 'descricao' => 'Estátua do Cristo Redentor no alto do Corcovado', 'latitude' => -22.9519, 'longitude' => -43.2105, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Pão de Açúcar', 'descricao' => 'Montanha icônica com vista panorâmica do Rio', 'latitude' => -22.9486, 'longitude' => -43.1566, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Praia de Copacabana', 'descricao' => 'Famosa praia do Rio de Janeiro', 'latitude' => -22.9714, 'longitude' => -43.1822, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Praia de Ipanema', 'descricao' => 'Praia famosa, especialmente pela música "Garota de Ipanema"', 'latitude' => -22.9837, 'longitude' => -43.1937, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Maracanã', 'descricao' => 'Estádio histórico de futebol no Rio de Janeiro', 'latitude' => -22.9127, 'longitude' => -43.2302, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Museu do Amanhã', 'descricao' => 'Museu de ciência e inovação no centro do Rio', 'latitude' => -22.9028, 'longitude' => -43.1913, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Jardim Botânico', 'descricao' => 'Grande área verde com plantas raras e nativas', 'latitude' => -22.9681, 'longitude' => -43.2193, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Lagoa Rodrigo de Freitas', 'descricao' => 'Lagoa cercada por praias e áreas de lazer', 'latitude' => -22.9833, 'longitude' => -43.2192, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Escadaria Selarón', 'descricao' => 'Escadaria colorida que conecta os bairros de Santa Teresa e Lapa', 'latitude' => -22.9069, 'longitude' => -43.1824, 'icone' => 'battlefield.png']);
        PontoInteresse::create(['ponto_tipo_id' => 2, 'name' => 'Parque Nacional da Tijuca', 'descricao' => 'Área de mata atlântica e trilhas no Rio de Janeiro', 'latitude' => -22.9523, 'longitude' => -43.2153, 'icone' => 'battlefield.png']);

        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Quartel do Comando Geral', 'descricao' => 'Sede do Comando Geral da Polícia Militar do RJ', 'latitude' => -22.9094, 'longitude' => -43.1795, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Operações Policiais Especiais (BOPE)', 'descricao' => 'Batalhão especializado em operações especiais da PMERJ', 'latitude' => -22.9254, 'longitude' => -43.2663, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia de Choque (BPChq)', 'descricao' => 'Batalhão especializado no controle de distúrbios civis', 'latitude' => -22.9156, 'longitude' => -43.2023, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Centro', 'descricao' => 'Batalhão responsável pela segurança na área central do Rio', 'latitude' => -22.9036, 'longitude' => -43.1800, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Botafogo', 'descricao' => 'Batalhão responsável pela segurança na região de Botafogo', 'latitude' => -22.9541, 'longitude' => -43.1840, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Ipanema', 'descricao' => 'Batalhão responsável pela segurança na região de Ipanema', 'latitude' => -22.9807, 'longitude' => -43.1927, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Copacabana', 'descricao' => 'Batalhão responsável pela segurança na região de Copacabana', 'latitude' => -22.9747, 'longitude' => -43.1872, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Tijuca', 'descricao' => 'Batalhão responsável pela segurança na região da Tijuca', 'latitude' => -22.9283, 'longitude' => -43.2398, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Barra da Tijuca', 'descricao' => 'Batalhão responsável pela segurança na região da Barra da Tijuca', 'latitude' => -23.0025, 'longitude' => -43.3669, 'icone' => 'presentation.png']);
        PontoInteresse::create(['ponto_tipo_id' => 4, 'name' => 'Batalhão de Polícia Militar (BPM) Jardim Botânico', 'descricao' => 'Batalhão responsável pela segurança na região do Jardim Botânico', 'latitude' => -22.9578, 'longitude' => -43.2175, 'icone' => 'presentation.png']);

        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Quartel Central CBMERJ', 'descricao' => 'Sede do Corpo de Bombeiros Militar do RJ', 'latitude' => -22.9067, 'longitude' => -43.1789, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 1º BBM', 'descricao' => 'Batalhão responsável pela região central do Rio de Janeiro', 'latitude' => -22.9193, 'longitude' => -43.1801, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 2º BBM', 'descricao' => 'Batalhão responsável pela zona norte do Rio de Janeiro', 'latitude' => -22.9245, 'longitude' => -43.2472, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 3º BBM', 'descricao' => 'Batalhão responsável pela zona sul do Rio de Janeiro', 'latitude' => -22.9727, 'longitude' => -43.1891, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 4º BBM', 'descricao' => 'Batalhão responsável pela zona oeste do Rio de Janeiro', 'latitude' => -23.0023, 'longitude' => -43.3645, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 5º BBM', 'descricao' => 'Batalhão responsável pela região da Baixada Fluminense', 'latitude' => -22.7791, 'longitude' => -43.4087, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 6º BBM', 'descricao' => 'Batalhão responsável pela segurança nas áreas de Niterói e São Gonçalo', 'latitude' => -22.8824, 'longitude' => -43.1056, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 7º BBM', 'descricao' => 'Batalhão responsável pela região do Rio de Janeiro e arredores', 'latitude' => -22.9985, 'longitude' => -43.3650, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 8º BBM', 'descricao' => 'Batalhão responsável pela segurança na região de Copacabana', 'latitude' => -22.9804, 'longitude' => -43.1850, 'icone' => 'triskelion.png']);
        PontoInteresse::create(['ponto_tipo_id' => 5, 'name' => 'Batalhão de Bombeiros Militar - 9º BBM', 'descricao' => 'Batalhão responsável pela segurança nas áreas da Barra da Tijuca e Recreio', 'latitude' => -23.0020, 'longitude' => -43.3668, 'icone' => 'triskelion.png']);
    }
}
