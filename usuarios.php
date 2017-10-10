<?php
// Inclui o arquivo 'includes/conexao_de_dados.php'
require_once 'includes/conexao_de_dados.php';
// Inclui o arquivo 'includes/autenticacao.php'
require_once 'includes/autenticacao.php';
// Inclui o arquivo 'includes/mensagem.php'
require_once 'includes/mensagem.php';

// Define que esta página somente será acessivel por administradores
necessitaAutorizacao(true);

/* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
* uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
$bd = obterConexao();
/* Cria um comando SQL do PDO para ser executado contendo a consulta que
 * retornará todos os usuários cadastrados */
$comando = $bd->prepare(
    'SELECT * FROM usuarios ORDER BY email');
 /* Executa o comando preparado */
$result = $comando->execute();
// Armazena o resultado da consulta no vetor 'usuarios'
$usuarios = $comando->fetchAll(\PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Usuários</title>
        <link href="assets/css/default.css" rel="stylesheet" />
    </head>
    <body>
        <?php require_once 'assets/layout/header.php' ?>
        <div id="container">
            <h1>Usuários</h1>
            <a href="usuario_insert.php">Novo Usuario</a>
            <table class="table">
                <tr>
                    <th>Id</th>
                    <th>E-Mail</th>
                    <th>Administrador</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach($usuarios as $u): ?>
                <tr>
                    <td class="center"><?= $u['id'] ?></td>
                    <td><?= $u['email'] ?></td>
                    <td class="center"><?= $u['administrador'] ? 'SIM' : 'NÃO' ?></td>
                    <td class="center"><a href="usuario_update.php?id=<?= $u['id'] ?>">Editar</a></td>
                    <td class="center"><a href="usuario_delete.php?id=<?= $u['id'] ?>">Remover</a></td>
                </tr>
                <?php endforeach; ?>
            </table>
            <!-- Lista as mensagens para esta página caso existam -->
            <div id="mensagens">
                <ul>
                    <!-- Utiliza a função 'obterMensagem' [mensagem.php] passando como parâmetro
                        o nome do arquivo atual através da função 'basename(__FILE__)', para
                        ler as mensagens caso existam. -->
                    <?php while($msg = obterMensagem(basename(__FILE__))): ?>
                    <li><?= $msg['mensagem'] ?></li>
                    <?php endwhile ?>
                </ul>
            </div>
        </div>
        <?php require_once 'assets/layout/footer.php' ?>
    </body>
</html>