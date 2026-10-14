<?php

$urlBase = 'http://127.0.0.1/gruposrmais-api/public/api';

/*
|--------------------------------------------------------------------------
| 1. Criar AppPessoa de teste
|--------------------------------------------------------------------------
*/

$idOperacaoInsert = '33333333-3333-4333-8333-333333333333';

$dadosAppPessoa = [
    'nome' => 'Teste DELETE Concorrencia',
    'apelido' => 'DELETE Mesmo UUID',
];

$ch = curl_init($urlBase . '/app_pessoas');

curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($dadosAppPessoa),
    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'Accept: application/json',
        'X-Operacao-Id: ' . $idOperacaoInsert,
    ],
]);

$resposta = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($resposta === false) {
    die(
        "Erro ao criar AppPessoa: " .
        curl_error($ch) .
        PHP_EOL
    );
}

curl_close($ch);

echo "========================================" . PHP_EOL;
echo "CRIANDO APP PESSOA DE TESTE" . PHP_EOL;
echo "========================================" . PHP_EOL;

echo "HTTP: " . $httpCode . PHP_EOL;
echo "Resposta: " . $resposta . PHP_EOL;

if ($httpCode !== 201) {
    die(
        "Não foi possível criar a AppPessoa de teste." .
        PHP_EOL
    );
}

$dadosResposta = json_decode(
    $resposta,
    true
);

$idAppPessoa = $dadosResposta['id'] ?? null;

if (!$idAppPessoa) {
    die(
        "API não retornou o ID da AppPessoa." .
        PHP_EOL
    );
}

echo "ID da AppPessoa criada: " . $idAppPessoa . PHP_EOL;
echo PHP_EOL;


/*
|--------------------------------------------------------------------------
| 2. UUID usado pelas duas requisições DELETE
|--------------------------------------------------------------------------
*/

$idOperacaoDelete =
    '44444444-4444-4444-8444-444444444444';


/*
|--------------------------------------------------------------------------
| 3. Função para criar DELETE
|--------------------------------------------------------------------------
*/

function criarDelete(
    string $url,
    string $idOperacao
) {

    $ch = curl_init($url);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => [
            'Accept: application/json',
            'X-Operacao-Id: ' . $idOperacao,
        ],
    ]);

    return $ch;
}


/*
|--------------------------------------------------------------------------
| 4. Criar duas requisições simultâneas
|--------------------------------------------------------------------------
*/

$urlDelete =
    $urlBase . '/app_pessoas/' . $idAppPessoa;

$ch1 = criarDelete(
    $urlDelete,
    $idOperacaoDelete
);

$ch2 = criarDelete(
    $urlDelete,
    $idOperacaoDelete
);


/*
|--------------------------------------------------------------------------
| 5. Executar simultaneamente
|--------------------------------------------------------------------------
*/

$multi = curl_multi_init();

curl_multi_add_handle($multi, $ch1);
curl_multi_add_handle($multi, $ch2);

$executando = null;

do {

    $status = curl_multi_exec(
        $multi,
        $executando
    );

    if ($executando) {
        curl_multi_select($multi);
    }

} while (
    $executando &&
    $status === CURLM_OK
);


/*
|--------------------------------------------------------------------------
| 6. Recuperar respostas
|--------------------------------------------------------------------------
*/

$resposta1 = curl_multi_getcontent($ch1);
$resposta2 = curl_multi_getcontent($ch2);

$httpCode1 = curl_getinfo(
    $ch1,
    CURLINFO_HTTP_CODE
);

$httpCode2 = curl_getinfo(
    $ch2,
    CURLINFO_HTTP_CODE
);


/*
|--------------------------------------------------------------------------
| 7. Exibir resultado
|--------------------------------------------------------------------------
*/

echo "========================================" . PHP_EOL;
echo "CONCORRÊNCIA DELETE" . PHP_EOL;
echo "========================================" . PHP_EOL;

echo PHP_EOL;

echo "AppPessoa: " . $idAppPessoa . PHP_EOL;

echo "UUID DELETE:" . PHP_EOL;
echo $idOperacaoDelete . PHP_EOL;

echo PHP_EOL;

echo "REQUISIÇÃO 1" . PHP_EOL;
echo "HTTP: " . $httpCode1 . PHP_EOL;
echo "Resposta: " . $resposta1 . PHP_EOL;

echo PHP_EOL;

echo "REQUISIÇÃO 2" . PHP_EOL;
echo "HTTP: " . $httpCode2 . PHP_EOL;
echo "Resposta: " . $resposta2 . PHP_EOL;

echo PHP_EOL;


/*
|--------------------------------------------------------------------------
| 8. Encerrar handles
|--------------------------------------------------------------------------
*/

curl_multi_remove_handle(
    $multi,
    $ch1
);

curl_multi_remove_handle(
    $multi,
    $ch2
);

curl_multi_close($multi);


/*
|--------------------------------------------------------------------------
| 9. Resultado esperado
|--------------------------------------------------------------------------
*/

if (
    $httpCode1 === 200 &&
    $httpCode2 === 200
) {

    echo "========================================" . PHP_EOL;
    echo "TESTE APROVADO" . PHP_EOL;
    echo "========================================" . PHP_EOL;

    echo "As duas requisições retornaram HTTP 200." . PHP_EOL;
    echo "Ambas devem retornar a mesma resposta." . PHP_EOL;

} else {

    echo "========================================" . PHP_EOL;
    echo "TESTE FALHOU" . PHP_EOL;
    echo "========================================" . PHP_EOL;
}
