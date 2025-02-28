<?php

namespace App\Providers;

use App\Models\Banco;
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
use App\Models\Notificacao;
use App\Models\Operacao;
use App\Models\Funcao;
use App\Models\Escolaridade;
use App\Models\Situacao;
use App\Models\Ferramenta;
use App\Models\User;
use App\Observers\BancoObserver;
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
use App\Observers\NotificacaoObserver;
use App\Observers\OperacaoObserver;
use App\Observers\FuncaoObserver;
use App\Observers\EscolaridadeObserver;
use App\Observers\SituacaoObserver;
use App\Observers\FerramentaObserver;
use App\Observers\UserObserver;

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
        Empresa::observe(EmpresaObserver::class);
        Banco::observe(BancoObserver::class);
        Cliente::observe(ClienteObserver::class);
        Departamento::observe(DepartamentoObserver::class);
        Escolaridade::observe(EscolaridadeObserver::class);
        EstadoCivil::observe(EstadoCivilObserver::class);
        Ferramenta::observe(FerramentaObserver::class);
        Fornecedor::observe(FornecedorObserver::class);
        Funcao::observe(FuncaoObserver::class);
        Funcionario::observe(FuncionarioObserver::class);
        Genero::observe(GeneroObserver::class);
        Grupo::observe(GrupoObserver::class);
        IdentidadeOrgao::observe(IdentidadeOrgaoObserver::class);
        Nacionalidade::observe(NacionalidadeObserver::class);
        Naturalidade::observe(NaturalidadeObserver::class);
        Notificacao::observe(NotificacaoObserver::class);
        Operacao::observe(OperacaoObserver::class);
        Situacao::observe(SituacaoObserver::class);
        User::observe(UserObserver::class);
    }

    public function shouldDiscoverEvents()
    {
        return false;
    }
}
