<?php

namespace Database\Seeders;

use App\Models\FormaPagamento;
use App\Models\FormaPagamentoStatus;
use App\Models\GrupoPermissao;
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

class ZZZ_20250315_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Submódulos
        DB::table('submodulos')->where('id', 25)->update(['name' => 'Clientes (Serviços)', 'menu_text' => 'Clientes (Serviços)']);

        DB::table('submodulos')->insert([
            ['id' => '26', 'modulo_id' => '1', 'name' => 'Ordens Serviços', 'menu_text' => 'Ordens Serviços', 'menu_url' => 'ordens_servicos', 'menu_route' => 'ordens_servicos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'ordens_servicos', 'prefix_route' => 'ordens_servicos', 'mobile' => 1, 'menu_text_mobile' => 'Minhas Ordens Serviços', 'viewing_order' => 90],
            ['id' => '27', 'modulo_id' => '4', 'name' => 'Veículos', 'menu_text' => 'Veículos', 'menu_url' => 'veiculos', 'menu_route' => 'veiculos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'veiculos', 'prefix_route' => 'veiculos', 'mobile' => 1, 'menu_text_mobile' => 'Meus Veículos', 'viewing_order' => 90],
            ['id' => '28', 'modulo_id' => '4', 'name' => 'Clientes (Executivos)', 'menu_text' => 'Clientes (Executivos)', 'menu_url' => 'clientes_executivos', 'menu_route' => 'clientes_executivos', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes_executivos', 'prefix_route' => 'clientes_executivos', 'mobile' => 1, 'menu_text_mobile' => 'Meus', 'viewing_order' => 100]
        ]);

        //Permissões
        Permissao::create(['id' => 126, 'submodulo_id' => 26, 'name' => 'ordens_servicos_list', 'description' => 'Visualizar Registro - Ordens Serviços']);
        Permissao::create(['id' => 127, 'submodulo_id' => 26, 'name' => 'ordens_servicos_create', 'description' => 'Criar Registro - Ordens Serviços']);
        Permissao::create(['id' => 128, 'submodulo_id' => 26, 'name' => 'ordens_servicos_show', 'description' => 'Visualizar Registro - Ordens Serviços']);
        Permissao::create(['id' => 129, 'submodulo_id' => 26, 'name' => 'ordens_servicos_edit', 'description' => 'Editar Registro - Ordens Serviços']);
        Permissao::create(['id' => 130, 'submodulo_id' => 26, 'name' => 'ordens_servicos_destroy', 'description' => 'Deletar Registro - Ordens Serviços']);

        Permissao::create(['id' => 131, 'submodulo_id' => 27, 'name' => 'veiculos_list', 'description' => 'Visualizar Registro - Veículos']);
        Permissao::create(['id' => 132, 'submodulo_id' => 27, 'name' => 'veiculos_create', 'description' => 'Criar Registro - Veículos']);
        Permissao::create(['id' => 133, 'submodulo_id' => 27, 'name' => 'veiculos_show', 'description' => 'Visualizar Registro - Veículos']);
        Permissao::create(['id' => 134, 'submodulo_id' => 27, 'name' => 'veiculos_edit', 'description' => 'Editar Registro - Veículos']);
        Permissao::create(['id' => 135, 'submodulo_id' => 27, 'name' => 'veiculos_destroy', 'description' => 'Deletar Registro - Veículos']);

        Permissao::create(['id' => 136, 'submodulo_id' => 28, 'name' => 'clientes_executivos_list', 'description' => 'Visualizar Registro - Clientes Executivos']);
        Permissao::create(['id' => 137, 'submodulo_id' => 28, 'name' => 'clientes_executivos_create', 'description' => 'Criar Registro - Clientes Executivos']);
        Permissao::create(['id' => 138, 'submodulo_id' => 28, 'name' => 'clientes_executivos_show', 'description' => 'Visualizar Registro - Clientes Executivos']);
        Permissao::create(['id' => 139, 'submodulo_id' => 28, 'name' => 'clientes_executivos_edit', 'description' => 'Editar Registro - Clientes Executivos']);
        Permissao::create(['id' => 140, 'submodulo_id' => 28, 'name' => 'clientes_executivos_destroy', 'description' => 'Deletar Registro - Clientes Executivos']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 126]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 127]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 128]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 129]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 130]);

        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 131]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 132]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 133]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 134]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 135]);

        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 136]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 137]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 138]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 139]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 140]);

        //Formas Pagamentos
        FormaPagamento::create(['id' => 1, 'name' => 'DINHEIRO']);
        FormaPagamento::create(['id' => 2, 'name' => 'PIX À VISTA']);
        FormaPagamento::create(['id' => 3, 'name' => 'CARTÃO DÉBITO']);
        FormaPagamento::create(['id' => 4, 'name' => 'CARTÃO CRÉDITO 1X']);
        FormaPagamento::create(['id' => 5, 'name' => 'CARTÃO CRÉDITO 2X']);
        FormaPagamento::create(['id' => 6, 'name' => 'CARTÃO CRÉDITO 3X']);
        FormaPagamento::create(['id' => 7, 'name' => 'CARTÃO CRÉDITO 4X']);
        FormaPagamento::create(['id' => 8, 'name' => 'CARTÃO CRÉDITO 5X']);
        FormaPagamento::create(['id' => 9, 'name' => 'CARTÃO CRÉDITO 6X']);
        FormaPagamento::create(['id' => 10, 'name' => 'CARTÃO CRÉDITO 7X']);
        FormaPagamento::create(['id' => 11, 'name' => 'CARTÃO CRÉDITO 8X']);
        FormaPagamento::create(['id' => 12, 'name' => 'CARTÃO CRÉDITO 9X']);
        FormaPagamento::create(['id' => 13, 'name' => 'CARTÃO CRÉDITO 10X']);
        FormaPagamento::create(['id' => 14, 'name' => 'CARTÃO CRÉDITO 11X']);
        FormaPagamento::create(['id' => 15, 'name' => 'CARTÃO CRÉDITO 12X']);

        //Ordens Serviços Tipos
        OrdemServicoTipo::create(['id' => 1, 'name' => 'ORDEM SERVIÇO INTERNA']);
        OrdemServicoTipo::create(['id' => 2, 'name' => 'ORDEM SERVIÇO EXTERNA']);
        OrdemServicoTipo::create(['id' => 3, 'name' => 'TRANSPORTE DE EXECUTIVOS']);

        //Ordens Serviços Status
        OrdemServicoStatus::create(['id' => 1, 'name' => 'ABERTA']);
        OrdemServicoStatus::create(['id' => 2, 'name' => 'EM ANDAMENTO']);
        OrdemServicoStatus::create(['id' => 3, 'name' => 'CONCLUÍDA']);
        OrdemServicoStatus::create(['id' => 4, 'name' => 'FINALIZADA']);
        OrdemServicoStatus::create(['id' => 5, 'name' => 'CANCELADA']);

        //Ordens Serviços Prioridades
        OrdemServicoPrioridade::create(['id' => 1, 'name' => 'BAIXA']);
        OrdemServicoPrioridade::create(['id' => 2, 'name' => 'MÉDIA']);
        OrdemServicoPrioridade::create(['id' => 3, 'name' => 'ALTA']);

        //Formas Pagamentos Status
        FormaPagamentoStatus::create(['id' => 1, 'name' => 'PENDENTE']);
        FormaPagamentoStatus::create(['id' => 2, 'name' => 'PAGO']);
        FormaPagamentoStatus::create(['id' => 3, 'name' => 'ATRASADO']);

        //Serviços Tipos
        ServicoTipo::create(['id' => 4, 'name' => 'TRANSPORTE']);

        //Serviços
        Servico::create(['id' => 7, 'empresa_id' => 1, 'name' => 'TRANSPORTE DE EXECUTIVOS', 'servico_tipo_id' => 4, 'valor' => '0.00']);

        //Veículo Categorias
        VeiculoCategoria::create(['id' => 1, 'name' => 'Particular']);
        VeiculoCategoria::create(['id' => 2, 'name' => 'Alugado']);
        VeiculoCategoria::create(['id' => 3, 'name' => 'Leasing']);

        //Veículo Combustiveis
        VeiculoCombustivel::create(['id' => 1, 'name' => 'Gasolina']);
        VeiculoCombustivel::create(['id' => 2, 'name' => 'Diesel']);
        VeiculoCombustivel::create(['id' => 3, 'name' => 'GNV - Gás Natural Veicular']);
        VeiculoCombustivel::create(['id' => 4, 'name' => 'Etanol - Álcool']);
        VeiculoCombustivel::create(['id' => 5, 'name' => 'Biodiesel']);
        VeiculoCombustivel::create(['id' => 6, 'name' => 'Eletricidade']);
        VeiculoCombustivel::create(['id' => 7, 'name' => 'Hidrogênio']);
        VeiculoCombustivel::create(['id' => 8, 'name' => 'Flex - Gasolina + Etanol']);
        VeiculoCombustivel::create(['id' => 9, 'name' => 'Híbrido - Gasolina + Eletricidade']);
        VeiculoCombustivel::create(['id' => 10, 'name' => 'Híbrido Plug-in - Gasolina + Eletricidade com recarga externa']);

        //Veículo Marcas
        VeiculoMarca::create(['id' => 1, 'name' => 'Volkswagen']);
        VeiculoMarca::create(['id' => 2, 'name' => 'Chevrolet']);
        VeiculoMarca::create(['id' => 3, 'name' => 'Fiat']);
        VeiculoMarca::create(['id' => 4, 'name' => 'Toyota']);
        VeiculoMarca::create(['id' => 5, 'name' => 'Honda']);
        VeiculoMarca::create(['id' => 6, 'name' => 'Ford']);
        VeiculoMarca::create(['id' => 7, 'name' => 'Nissan']);
        VeiculoMarca::create(['id' => 8, 'name' => 'Hyundai']);
        VeiculoMarca::create(['id' => 9, 'name' => 'BMW']);
        VeiculoMarca::create(['id' => 10, 'name' => 'Mercedes-Benz']);
        VeiculoMarca::create(['id' => 11, 'name' => 'Audi']);
        VeiculoMarca::create(['id' => 12, 'name' => 'Peugeot']);
        VeiculoMarca::create(['id' => 13, 'name' => 'Renault']);
        VeiculoMarca::create(['id' => 14, 'name' => 'Jeep']);
        VeiculoMarca::create(['id' => 15, 'name' => 'Mitsubishi']);
        VeiculoMarca::create(['id' => 16, 'name' => 'Kia']);
        VeiculoMarca::create(['id' => 17, 'name' => 'Chrysler']);
        VeiculoMarca::create(['id' => 18, 'name' => 'Land Rover']);
        VeiculoMarca::create(['id' => 19, 'name' => 'Volvo']);
        VeiculoMarca::create(['id' => 20, 'name' => 'Mazda']);

        //Veículo Modelos
        // Volkswagen
        VeiculoModelo::create(['id' => 1, 'veiculo_marca_id' => 1, 'name' => 'Fusca']);
        VeiculoModelo::create(['id' => 2, 'veiculo_marca_id' => 1, 'name' => 'Gol']);
        VeiculoModelo::create(['id' => 3, 'veiculo_marca_id' => 1, 'name' => 'Passat']);
        VeiculoModelo::create(['id' => 4, 'veiculo_marca_id' => 1, 'name' => 'Polo']);
        VeiculoModelo::create(['id' => 5, 'veiculo_marca_id' => 1, 'name' => 'Jetta']);

        // Chevrolet
        VeiculoModelo::create(['id' => 6, 'veiculo_marca_id' => 2, 'name' => 'Corsa']);
        VeiculoModelo::create(['id' => 7, 'veiculo_marca_id' => 2, 'name' => 'Onix']);
        VeiculoModelo::create(['id' => 8, 'veiculo_marca_id' => 2, 'name' => 'S10']);
        VeiculoModelo::create(['id' => 9, 'veiculo_marca_id' => 2, 'name' => 'Tracker']);

        // Fiat
        VeiculoModelo::create(['id' => 10, 'veiculo_marca_id' => 3, 'name' => 'Palio']);
        VeiculoModelo::create(['id' => 11, 'veiculo_marca_id' => 3, 'name' => 'Uno']);
        VeiculoModelo::create(['id' => 12, 'veiculo_marca_id' => 3, 'name' => 'Fiorino']);
        VeiculoModelo::create(['id' => 13, 'veiculo_marca_id' => 3, 'name' => 'Strada']);

        // Toyota
        VeiculoModelo::create(['id' => 14, 'veiculo_marca_id' => 4, 'name' => 'Corolla']);
        VeiculoModelo::create(['id' => 15, 'veiculo_marca_id' => 4, 'name' => 'Hilux']);
        VeiculoModelo::create(['id' => 16, 'veiculo_marca_id' => 4, 'name' => 'Etios']);

        // Honda
        VeiculoModelo::create(['id' => 17, 'veiculo_marca_id' => 5, 'name' => 'Civic']);
        VeiculoModelo::create(['id' => 18, 'veiculo_marca_id' => 5, 'name' => 'Fit']);
        VeiculoModelo::create(['id' => 19, 'veiculo_marca_id' => 5, 'name' => 'HR-V']);

        // Ford
        VeiculoModelo::create(['id' => 20, 'veiculo_marca_id' => 6, 'name' => 'Fiesta']);
        VeiculoModelo::create(['id' => 21, 'veiculo_marca_id' => 6, 'name' => 'Focus']);
        VeiculoModelo::create(['id' => 22, 'veiculo_marca_id' => 6, 'name' => 'EcoSport']);

        // Nissan
        VeiculoModelo::create(['id' => 23, 'veiculo_marca_id' => 7, 'name' => 'March']);
        VeiculoModelo::create(['id' => 24, 'veiculo_marca_id' => 7, 'name' => 'Versa']);
        VeiculoModelo::create(['id' => 25, 'veiculo_marca_id' => 7, 'name' => 'X-Trail']);

        // Hyundai
        VeiculoModelo::create(['id' => 26, 'veiculo_marca_id' => 8, 'name' => 'HB20']);
        VeiculoModelo::create(['id' => 27, 'veiculo_marca_id' => 8, 'name' => 'Creta']);
        VeiculoModelo::create(['id' => 28, 'veiculo_marca_id' => 8, 'name' => 'Tucson']);

        // BMW
        VeiculoModelo::create(['id' => 29, 'veiculo_marca_id' => 9, 'name' => 'X1']);
        VeiculoModelo::create(['id' => 30, 'veiculo_marca_id' => 9, 'name' => 'X3']);
        VeiculoModelo::create(['id' => 31, 'veiculo_marca_id' => 9, 'name' => '320i']);
        VeiculoModelo::create(['id' => 32, 'veiculo_marca_id' => 9, 'name' => 'M3']);

        // Mercedes-Benz
        VeiculoModelo::create(['id' => 33, 'veiculo_marca_id' => 10, 'name' => 'C-Class']);
        VeiculoModelo::create(['id' => 34, 'veiculo_marca_id' => 10, 'name' => 'E-Class']);
        VeiculoModelo::create(['id' => 35, 'veiculo_marca_id' => 10, 'name' => 'S-Class']);
        VeiculoModelo::create(['id' => 36, 'veiculo_marca_id' => 10, 'name' => 'GLC']);

        // Audi
        VeiculoModelo::create(['id' => 37, 'veiculo_marca_id' => 11, 'name' => 'A3']);
        VeiculoModelo::create(['id' => 38, 'veiculo_marca_id' => 11, 'name' => 'A4']);
        VeiculoModelo::create(['id' => 39, 'veiculo_marca_id' => 11, 'name' => 'Q5']);
        VeiculoModelo::create(['id' => 40, 'veiculo_marca_id' => 11, 'name' => 'Q7']);

        // Peugeot
        VeiculoModelo::create(['id' => 41, 'veiculo_marca_id' => 12, 'name' => '208']);
        VeiculoModelo::create(['id' => 42, 'veiculo_marca_id' => 12, 'name' => '2008']);
        VeiculoModelo::create(['id' => 43, 'veiculo_marca_id' => 12, 'name' => '3008']);
        VeiculoModelo::create(['id' => 44, 'veiculo_marca_id' => 12, 'name' => '5008']);

        // Renault
        VeiculoModelo::create(['id' => 45, 'veiculo_marca_id' => 13, 'name' => 'Logan']);
        VeiculoModelo::create(['id' => 46, 'veiculo_marca_id' => 13, 'name' => 'Duster']);
        VeiculoModelo::create(['id' => 47, 'veiculo_marca_id' => 13, 'name' => 'Sandero']);
        VeiculoModelo::create(['id' => 48, 'veiculo_marca_id' => 13, 'name' => 'Kwid']);

        // Jeep
        VeiculoModelo::create(['id' => 49, 'veiculo_marca_id' => 14, 'name' => 'Renegade']);
        VeiculoModelo::create(['id' => 50, 'veiculo_marca_id' => 14, 'name' => 'Compass']);
        VeiculoModelo::create(['id' => 51, 'veiculo_marca_id' => 14, 'name' => 'Cherokee']);
        VeiculoModelo::create(['id' => 52, 'veiculo_marca_id' => 14, 'name' => 'Grand Cherokee']);

        // Mitsubishi
        VeiculoModelo::create(['id' => 53, 'veiculo_marca_id' => 15, 'name' => 'L200']);
        VeiculoModelo::create(['id' => 54, 'veiculo_marca_id' => 15, 'name' => 'Outlander']);
        VeiculoModelo::create(['id' => 55, 'veiculo_marca_id' => 15, 'name' => 'Pajero']);

        // Kia
        VeiculoModelo::create(['id' => 56, 'veiculo_marca_id' => 16, 'name' => 'Sportage']);
        VeiculoModelo::create(['id' => 57, 'veiculo_marca_id' => 16, 'name' => 'Seltos']);
        VeiculoModelo::create(['id' => 58, 'veiculo_marca_id' => 16, 'name' => 'Cerato']);

        // Chrysler
        VeiculoModelo::create(['id' => 59, 'veiculo_marca_id' => 17, 'name' => 'Pacifica']);
        VeiculoModelo::create(['id' => 60, 'veiculo_marca_id' => 17, 'name' => 'Voyager']);

        // Land Rover
        VeiculoModelo::create(['id' => 61, 'veiculo_marca_id' => 18, 'name' => 'Defender']);
        VeiculoModelo::create(['id' => 62, 'veiculo_marca_id' => 18, 'name' => 'Discovery']);
        VeiculoModelo::create(['id' => 63, 'veiculo_marca_id' => 18, 'name' => 'Range Rover']);

        // Volvo
        VeiculoModelo::create(['id' => 64, 'veiculo_marca_id' => 19, 'name' => 'XC60']);
        VeiculoModelo::create(['id' => 65, 'veiculo_marca_id' => 19, 'name' => 'S90']);
        VeiculoModelo::create(['id' => 66, 'veiculo_marca_id' => 19, 'name' => 'V60']);

        // Mazda
        VeiculoModelo::create(['id' => 67, 'veiculo_marca_id' => 20, 'name' => 'CX-5']);
        VeiculoModelo::create(['id' => 68, 'veiculo_marca_id' => 20, 'name' => 'Mazda3']);
        VeiculoModelo::create(['id' => 69, 'veiculo_marca_id' => 20, 'name' => 'Mazda6']);
    }
}
