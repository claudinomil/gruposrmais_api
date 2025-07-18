<?php

namespace App\Providers;

use App\Models\Banco;
use App\Models\ClienteExecutivo;
use App\Models\Departamento;
use App\Models\AdminCliente;
use App\Models\Empresa;
use App\Models\Fornecedor;
use App\Models\Funcionario;
use App\Models\Cliente;
use App\Models\Genero;
use App\Models\Grupo;
use App\Models\IdentidadeOrgao;
use App\Models\EstadoCivil;
use App\Models\Nacionalidade;
use App\Models\Naturalidade;
use App\Models\Operacao;
use App\Models\Funcao;
use App\Models\Escolaridade;
use App\Models\OrdemServico;
use App\Models\Proposta;
use App\Models\Situacao;
use App\Models\User;
use App\Models\Veiculo;
use App\Observers\BancoObserver;
use App\Observers\ClienteExecutivoObserver;
use App\Observers\DepartamentoObserver;
use App\Observers\EmpresaObserver;
use App\Observers\FornecedorObserver;
use App\Observers\FuncionarioObserver;
use App\Observers\ClienteObserver;
use App\Observers\GeneroObserver;
use App\Observers\GrupoObserver;
use App\Observers\IdentidadeOrgaoObserver;
use App\Observers\EstadoCivilObserver;
use App\Observers\NacionalidadeObserver;
use App\Observers\NaturalidadeObserver;
use App\Observers\OperacaoObserver;
use App\Observers\FuncaoObserver;
use App\Observers\EscolaridadeObserver;
use App\Observers\OrdemServicoObserver;
use App\Observers\PropostaObserver;
use App\Observers\SituacaoObserver;
use App\Observers\UserObserver;
use App\Observers\VeiculoObserver;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    public function boot(): void
    {
        Banco::observe(BancoObserver::class);
        Cliente::observe(ClienteObserver::class);
        ClienteExecutivo::observe(ClienteExecutivoObserver::class);
        Departamento::observe(DepartamentoObserver::class);
        Empresa::observe(EmpresaObserver::class);
        Escolaridade::observe(EscolaridadeObserver::class);
        EstadoCivil::observe(EstadoCivilObserver::class);
        Fornecedor::observe(FornecedorObserver::class);
        Funcao::observe(FuncaoObserver::class);
        Funcionario::observe(FuncionarioObserver::class);
        Genero::observe(GeneroObserver::class);
        Grupo::observe(GrupoObserver::class);
        IdentidadeOrgao::observe(IdentidadeOrgaoObserver::class);
        Nacionalidade::observe(NacionalidadeObserver::class);
        Naturalidade::observe(NaturalidadeObserver::class);
        Operacao::observe(OperacaoObserver::class);
        OrdemServico::observe(OrdemServicoObserver::class);
        Proposta::observe(PropostaObserver::class);
        Situacao::observe(SituacaoObserver::class);
        User::observe(UserObserver::class);
        Veiculo::observe(VeiculoObserver::class);
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
