<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CriarSubmodulos extends Controller
{
    public $error = '';

    public function index($password)
    {
        if ($password == 'claudino1971') {
            return $this->create('', '');
        } else {
            return 'Acesso Negado!!!';
        }
    }

    public function create($success='', $errors='')
    {
        return view('criarsubmodulos.create', compact('success', 'errors'));
    }

    public function store(Request $request)
    {
        $referenciaNomePlural = '';
        $referenciaNomeSingular = '';

        $submoduloNomePlural = '';
        $submoduloNomeSingular = '';

        if (isset($request['referencia_name_plural'])) {$referenciaNomePlural = $request['referencia_name_plural'];}
        if (isset($request['referencia_name_singular'])) {$referenciaNomeSingular = $request['referencia_name_singular'];}
        if (isset($request['submodulo_name_plural'])) {$submoduloNomePlural = $request['submodulo_name_plural'];}
        if (isset($request['submodulo_name_singular'])) {$submoduloNomeSingular = $request['submodulo_name_singular'];}

        //Verificar errors''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //campos vazios
        if ($referenciaNomePlural == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Referência - Plural (Não pode ficar em branco)');
        }

        if ($referenciaNomeSingular == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Referência - Singular (Não pode ficar em branco)');
        }

        if ($submoduloNomePlural == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Submódulo - Plural (Não pode ficar em branco)');
        }

        if ($submoduloNomeSingular == '') {
            $this->error = 'SIM';

            return $this->create('', 'Nome Submódulo - Singular (Não pode ficar em branco)');
        }

        //Verificar se já existe o Model
        if (file_exists('../app/Models/' . $submoduloNomeSingular . '.php')) {
            $this->error = 'SIM';

            return $this->create('', $submoduloNomeSingular . ' já Existe.');
        }

        //Verificar se já existe o Controller
        if (file_exists('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php')) {
            $this->error = 'SIM';

            return $this->create('', $submoduloNomeSingular . 'Controller já Existe.');
        }

        //Verificar se já existe o Observer
        if (file_exists('../app/Observers/' . $submoduloNomeSingular . 'Observer.php')) {
            $this->error = 'SIM';

            return $this->create('', $submoduloNomeSingular . 'Observer já Existe.');
        }

        //Verificar se já existe o Request
        if (file_exists('../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php')) {
            $this->error = 'SIM';

            return $this->create('', $submoduloNomeSingular . 'StoreRequest já Existe.');
        }

        //Verificar se já existe o Request
        if (file_exists('../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php')) {
            $this->error = 'SIM';

            return $this->create('', $submoduloNomeSingular . 'UpdateRequest já Existe.');
        }

        if ($this->error == '') {
            //MODEL'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando Model igual ao Referencia
            copy('../app/Models/'.$referenciaNomeSingular.'.php', '../app/Models/' . $submoduloNomeSingular . '.php');

            //Substituindo no Model novo
            if (file_exists('../app/Models/' . $submoduloNomeSingular . '.php')) {
                $this->substituir('../app/Models/' . $submoduloNomeSingular . '.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../app/Models/' . $submoduloNomeSingular . '.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../app/Models/' . $submoduloNomeSingular . '.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../app/Models/' . $submoduloNomeSingular . '.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //CONTROLLER''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando Controller igual ao ReferenciaController
            copy('../app/Http/Controllers/'.$referenciaNomeSingular.'Controller.php', '../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php');

            //Substituindo no Controller novo
            if (file_exists('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php')) {
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../app/Http/Controllers/' . $submoduloNomeSingular . 'Controller.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //STOREREQUEST''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando StoreRequest igual ao ReferenciaStoreRequest
            copy('../app/Http/Requests/'.$referenciaNomeSingular.'StoreRequest.php', '../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php');

            //Substituindo no StoreRequest novo
            if (file_exists('../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php')) {
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'StoreRequest.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //UPDATEREQUEST'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando UpdateRequest igual ao ReferenciaUpdateRequest
            copy('../app/Http/Requests/'.$referenciaNomeSingular.'UpdateRequest.php', '../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php');

            //Substituindo no UpdateRequest novo
            if (file_exists('../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php')) {
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../app/Http/Requests/' . $submoduloNomeSingular . 'UpdateRequest.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //MIGRATION'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando Migration igual ao 2022_09_23_202908_create_referencia_table.php
            $migration_name = date('Y') . '_' . date('m') . '_' . date('d') . '_' . date('His') . '_' . 'create_' . strtolower($submoduloNomePlural) . '_table.php';

            if (strtolower($referenciaNomePlural) == 'departamentos') {
                copy('../database/migrations/2022_09_23_193322_create_departamentos_table.php', '../database/migrations/' . $migration_name);
            }

            if (strtolower($referenciaNomePlural) == 'funcionarios') {
                copy('../database/migrations/2022_09_23_202908_create_funcionarios_table.php', '../database/migrations/' . $migration_name);
            }

            if (strtolower($referenciaNomePlural) == 'clientes') {
                copy('../database/migrations/2022_10_25_221829_create_clientes_table.php', '../database/migrations/' . $migration_name);
            }

            //Substituindo no Migration novo
            if (file_exists('../database/migrations/' . $migration_name)) {
                $this->substituir('../database/migrations/' . $migration_name, $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../database/migrations/' . $migration_name, strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../database/migrations/' . $migration_name, $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../database/migrations/' . $migration_name, strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //OBSERVER''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            //Criando Observer igual ao ReferenciaObserver
            copy('../app/Observers/'.$referenciaNomeSingular.'Observer.php', '../app/Observers/' . $submoduloNomeSingular . 'Observer.php');

            //Substituindo no Observer novo
            if (file_exists('../app/Observers/' . $submoduloNomeSingular . 'Observer.php')) {
                $this->substituir('../app/Observers/' . $submoduloNomeSingular . 'Observer.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../app/Observers/' . $submoduloNomeSingular . 'Observer.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../app/Observers/' . $submoduloNomeSingular . 'Observer.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../app/Observers/' . $submoduloNomeSingular . 'Observer.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //ROUTE'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Criando Route igual ao routes_referencias
            copy('../routes/routes_'.strtolower($referenciaNomePlural).'.php', '../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php');

            //Substituindo no route novo
            if (file_exists('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php')) {
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', $referenciaNomePlural, $submoduloNomePlural);
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', strtolower($referenciaNomePlural), strtolower($submoduloNomePlural));
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', $referenciaNomeSingular, $submoduloNomeSingular);
                $this->substituir('../routes/' . 'routes_' . strtolower($submoduloNomePlural) . '.php', strtolower($referenciaNomeSingular), strtolower($submoduloNomeSingular));
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            return $this->create('Criado com sucesso!!!', '');
        }
    }

    public function substituir($file, $stringSearch, $stringReplace)
    {
        //Open para ler e modificar
        $fh = fopen($file, 'r+');
        $dados = fread($fh, filesize($file));
        $new_data = str_replace($stringSearch, $stringReplace, $dados);
        fclose($fh);

        //Open de escrever
        $fh = fopen($file, 'r+');
        fwrite($fh, $new_data);
        fclose($fh);
    }
}
