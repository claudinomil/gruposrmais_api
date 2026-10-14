<?php

/*
|--------------------------------------------------------------------------
| TESTE DE IDEMPOTÊNCIA CONCORRENTE
|--------------------------------------------------------------------------
|
| Envia duas requisições POST simultâneas usando o MESMO
| X-Operacao-Id.
|
| Resultado esperado:
|
| Request 1 -> HTTP 201
| Request 2 -> HTTP 201
|
| As duas devem retornar o MESMO ID da AppPessoa.
|
| No banco:
|
| app_pessoas                  -> 1 registro
| app_operacoes_sincronizacao  -> 1 registro
| transacoes               -> 1 auditoria INSERT
|
|--------------------------------------------------------------------------
*/

$url = 'http://127.0.0.1/gruposrmais-api/public/api/app_pessoas';

/*
|--------------------------------------------------------------------------
| UUID ÚNICO DESTE TESTE
|--------------------------------------------------------------------------
*/

$idOperacao = '11111111-1111-4111-8111-111111111111';

/*
|--------------------------------------------------------------------------
| DADOS
|--------------------------------------------------------------------------
*/

$dados = json_encode([
    'nome' => 'Teste Concorrencia',
    'apelido' => 'Mesmo UUID',
]);

/*
|--------------------------------------------------------------------------
| FUNÇÃO PARA CRIAR UMA REQUISIÇÃO
|--------------------------------------------------------------------------
*/

function criarRequisicao(
    string $url,
    string $idOperacao,
    string $dados
) {

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_POST => true,

        CURLOPT_POSTFIELDS => $dados,

        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
            'X-Operacao-Id: ' . $idOperacao,
        ],

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_HEADER => false,

        CURLOPT_TIMEOUT => 30,
    ]);

    return $ch;
}

/*
|--------------------------------------------------------------------------
| CRIA DUAS REQUISIÇÕES
|--------------------------------------------------------------------------
*/

$ch1 = criarRequisicao(
    $url,
    $idOperacao,
    $dados
);

$ch2 = criarRequisicao(
    $url,
    $idOperacao,
    $dados
);

/*
|--------------------------------------------------------------------------
| MULTI CURL
|--------------------------------------------------------------------------
|
| As duas requisições são executadas simultaneamente.
|
*/

$multiHandle = curl_multi_init();

curl_multi_add_handle(
    $multiHandle,
    $ch1
);

curl_multi_add_handle(
    $multiHandle,
    $ch2
);

/*
|--------------------------------------------------------------------------
| EXECUTA
|--------------------------------------------------------------------------
*/

$executando = null;

do {

    $status = curl_multi_exec(
        $multiHandle,
        $executando
    );

    if ($executando) {

        curl_multi_select(
            $multiHandle,
            1.0
        );
    }

} while ($executando && $status === CURLM_OK);

/*
|--------------------------------------------------------------------------
| RECUPERA RESULTADOS
|--------------------------------------------------------------------------
*/

$resultados = [];

foreach ([$ch1, $ch2] as $indice => $ch) {

    $resultado = curl_multi_getcontent($ch);

    $httpCode = curl_getinfo(
        $ch,
        CURLINFO_HTTP_CODE
    );

    $erro = curl_error($ch);

    $resultados[] = [
        'requisicao' => $indice + 1,
        'http' => $httpCode,
        'erro_curl' => $erro ?: null,
        'resposta' => $resultado,
    ];

    curl_multi_remove_handle(
        $multiHandle,
        $ch
    );

    curl_close($ch);
}

curl_multi_close($multiHandle);

/*
|--------------------------------------------------------------------------
| EXIBE RESULTADO
|--------------------------------------------------------------------------
*/

echo PHP_EOL;
echo "====================================================" . PHP_EOL;
echo " TESTE DE CONCORRÊNCIA / IDEMPOTÊNCIA" . PHP_EOL;
echo "====================================================" . PHP_EOL;

echo PHP_EOL;

echo "URL:" . PHP_EOL;
echo $url . PHP_EOL;

echo PHP_EOL;

echo "ID da operação:" . PHP_EOL;
echo $idOperacao . PHP_EOL;

echo PHP_EOL;

foreach ($resultados as $resultado) {

    echo "----------------------------------------------------" . PHP_EOL;

    echo "Requisição: ";
    echo $resultado['requisicao'];
    echo PHP_EOL;

    echo "HTTP: ";
    echo $resultado['http'];
    echo PHP_EOL;

    if ($resultado['erro_curl']) {

        echo "Erro cURL: ";
        echo $resultado['erro_curl'];
        echo PHP_EOL;
    }

    echo "Resposta:" . PHP_EOL;

    $json = json_decode(
        $resultado['resposta'],
        true
    );

    if ($json !== null) {

        echo json_encode(
            $json,
            JSON_PRETTY_PRINT |
            JSON_UNESCAPED_UNICODE
        );
        echo PHP_EOL;

    } else {

        echo $resultado['resposta'];
        echo PHP_EOL;
    }
}

echo PHP_EOL;

echo "====================================================" . PHP_EOL;
echo " FIM DO TESTE" . PHP_EOL;
echo "====================================================" . PHP_EOL;

echo PHP_EOL;
