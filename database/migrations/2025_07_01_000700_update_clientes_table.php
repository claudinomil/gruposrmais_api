<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClientesTable extends Migration
{
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('doc_cbmerj_projeto_scip');
            $table->dropColumn('doc_cbmerj_laudo_exigencias');
            $table->dropColumn('doc_cbmerj_certificado_aprovacao');
            $table->dropColumn('doc_cbmerj_certificado_aprovacao_simplificado');
            $table->dropColumn('doc_cbmerj_certificado_aprovacao_assistido');
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

    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->integer('doc_cbmerj_projeto_scip')->nullable();
            $table->integer('doc_cbmerj_laudo_exigencias')->nullable();
            $table->integer('doc_cbmerj_certificado_aprovacao')->nullable();
            $table->integer('doc_cbmerj_certificado_aprovacao_simplificado')->nullable();
            $table->integer('doc_cbmerj_certificado_aprovacao_assistido')->nullable();
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
}
