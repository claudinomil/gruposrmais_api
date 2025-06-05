<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterClientesRenameAndAddColumns extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Renomeando as colunas existentes
            $table->renameColumn('projeto_scip', 'doc_cbmerj_projeto_scip');
            $table->renameColumn('laudo_exigencias', 'doc_cbmerj_laudo_exigencias');
            $table->renameColumn('certificado_aprovacao', 'doc_cbmerj_certificado_aprovacao');
            $table->renameColumn('certificado_aprovacao_simplificado', 'doc_cbmerj_certificado_aprovacao_simplificado');
            $table->renameColumn('certificado_aprovacao_assistido', 'doc_cbmerj_certificado_aprovacao_assistido');

            // Adicionando novas colunas
            $table->integer('doc_pj_cnpj')->nullable();
            $table->integer('doc_pj_representante_legal')->nullable();
            $table->integer('doc_pj_contrato_social')->nullable();
            $table->integer('doc_pj_rgi')->nullable();
            $table->integer('doc_pj_contrato_locacao')->nullable();
            $table->integer('doc_pf_cpf')->nullable();
            $table->integer('doc_pf_representante_legal')->nullable();
            $table->integer('doc_pf_contrato_social')->nullable();
            $table->integer('doc_pf_rgi')->nullable();
            $table->integer('doc_pf_contrato_locacao')->nullable();
            $table->integer('doc_vt_memoria_descritiva')->nullable();
            $table->integer('doc_vt_certificado_funcionamento')->nullable();
        });
    }

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            // Voltando os nomes antigos
            $table->renameColumn('doc_cbmerj_projeto_scip', 'projeto_scip');
            $table->renameColumn('doc_cbmerj_laudo_exigencias', 'laudo_exigencias');
            $table->renameColumn('doc_cbmerj_certificado_aprovacao', 'certificado_aprovacao');
            $table->renameColumn('doc_cbmerj_certificado_aprovacao_simplificado', 'certificado_aprovacao_simplificado');
            $table->renameColumn('doc_cbmerj_certificado_aprovacao_assistido', 'certificado_aprovacao_assistido');

            // Removendo as colunas adicionadas
            $table->dropColumn('doc_pj_cnpj');
            $table->dropColumn('doc_pj_representante_legal');
            $table->dropColumn('doc_pj_contrato_social');
            $table->dropColumn('doc_pj_rgi');
            $table->dropColumn('doc_pj_contrato_locacao');
            $table->dropColumn('doc_pf_cpf');
            $table->dropColumn('doc_pf_representante_legal');
            $table->dropColumn('doc_pf_contrato_social');
            $table->dropColumn('doc_pf_rgi');
            $table->dropColumn('doc_pf_contrato_locacao');
            $table->dropColumn('doc_vt_memoria_descritiva');
            $table->dropColumn('doc_vt_certificado_funcionamento');
        });
    }
}
