<?php
/* Cria e retorna uma conexão com o banco de dados MySQL conforme as
 * configurações contidas no arquivo 'config/banco_de_dados.php'. */
function obterConexao() {
    /* Lê o arquivo 'banco_de_dados.php' e armazena seu contaúdo em 'config' */
    $config = include('config/banco_de_dados.php');
    // Cria uma conexão PDO conforme as informações contidas em 'config'
    $conexao = new \PDO(
        'mysql:host='.$config['host'].
        ';port='.$config['port'].
        ';dbname='.$config['dbname'],
        $config['user'], $config['password']);
    // Retorna a conexão criada;
    return $conexao;
}