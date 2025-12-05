<?php

namespace Database\Seeders;

use App\Models\Cor;
use App\Models\DocumentoMensalFuncionario;

use Illuminate\Database\Seeder;

class ZZZ_20251129_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Documentos Mensais Funcionários
        DocumentoMensalFuncionario::create(['id' => 1, 'name' => 'FOLHA DE PAGAMENTO', 'ordem' => 10]);
        DocumentoMensalFuncionario::create(['id' => 2, 'name' => 'CONTRACHEQUE', 'ordem' => 20]);
        DocumentoMensalFuncionario::create(['id' => 3, 'name' => 'VALE REFEIÇÃO', 'ordem' => 30]);
        DocumentoMensalFuncionario::create(['id' => 4, 'name' => 'VALE TRANSPORTE', 'ordem' => 40]);

        // Cores
        Cor::create(['name' => 'Amarelo', 'hexadecimal' => '#FFFF00']);
        Cor::create(['name' => 'Azul', 'hexadecimal' => '#0000FF']);
        Cor::create(['name' => 'Azul-claro', 'hexadecimal' => '#ADD8E6']);
        Cor::create(['name' => 'Azul-escuro', 'hexadecimal' => '#00008B']);
        Cor::create(['name' => 'Bege', 'hexadecimal' => '#F5F5DC']);
        Cor::create(['name' => 'Bordô', 'hexadecimal' => '#800000']);
        Cor::create(['name' => 'Branco', 'hexadecimal' => '#FFFFFF']);
        Cor::create(['name' => 'Bronze', 'hexadecimal' => '#CD7F32']);
        Cor::create(['name' => 'Cáqui', 'hexadecimal' => '#C3B091']);
        Cor::create(['name' => 'Caramelo', 'hexadecimal' => '#AF6E4D']);
        Cor::create(['name' => 'Cinza', 'hexadecimal' => '#808080']);
        Cor::create(['name' => 'Cinza-claro', 'hexadecimal' => '#D3D3D3']);
        Cor::create(['name' => 'Cinza-escuro', 'hexadecimal' => '#505050']);
        Cor::create(['name' => 'Creme', 'hexadecimal' => '#FFFDD0']);
        Cor::create(['name' => 'Dourado', 'hexadecimal' => '#FFD700']);
        Cor::create(['name' => 'Grafite', 'hexadecimal' => '#383838']);
        Cor::create(['name' => 'Laranja', 'hexadecimal' => '#FFA500']);
        Cor::create(['name' => 'Lilás', 'hexadecimal' => '#C8A2C8']);
        Cor::create(['name' => 'Marfim', 'hexadecimal' => '#FFFFF0']);
        Cor::create(['name' => 'Marrom', 'hexadecimal' => '#8B4513']);
        Cor::create(['name' => 'Mostarda', 'hexadecimal' => '#FFDB58']);
        Cor::create(['name' => 'Oliva', 'hexadecimal' => '#808000']);
        Cor::create(['name' => 'Prata', 'hexadecimal' => '#C0C0C0']);
        Cor::create(['name' => 'Preto', 'hexadecimal' => '#000000']);
        Cor::create(['name' => 'Rosa', 'hexadecimal' => '#FFC0CB']);
        Cor::create(['name' => 'Roxo', 'hexadecimal' => '#800080']);
        Cor::create(['name' => 'Salmão', 'hexadecimal' => '#FA8072']);
        Cor::create(['name' => 'Verde', 'hexadecimal' => '#008000']);
        Cor::create(['name' => 'Verde-claro', 'hexadecimal' => '#90EE90']);
        Cor::create(['name' => 'Verde-escuro', 'hexadecimal' => '#006400']);
        Cor::create(['name' => 'Vermelho', 'hexadecimal' => '#FF0000']);
        Cor::create(['name' => 'Vinho', 'hexadecimal' => '#722F37']);
    }
}
