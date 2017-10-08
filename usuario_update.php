<?php
// Inclui o arquivo 'includes/conexao_de_dados.php'
require_once 'includes/conexao_de_dados.php';
// Inclui o script 'includes/autenticacao.php'
require_once 'includes/autenticacao.php';
// Inclui o script 'includes/mensagem.php'
require_once 'includes/mensagem.php';
// Inclui o arquivo 'includes/requisicao.php'
require_once 'includes/requisicao.php';

// Captura o id via método 'GET'
$id = $_GET['id'];

/* Define que esta página somente será acessivel por administradores ou o usuário
 * com o id especificado. */
necessitaAutorizacao(false, $id);

/* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
* uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
$bd = obterConexao();
/* Cria um comando SQL do PDO para ser executado contendo a consulta que
 * retornará o usuário correspondente ao 'id' solicidado */
$comando = $bd->prepare(
    'SELECT * FROM usuarios WHERE id = :i');
 /* Executa o comando preparado */
$result = $comando->execute([':i' => $id]);
// Armazena o resultado da consulta no vetor 'usuarios'
$usuario = $comando->fetch(\PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Editar Usuário</title>
    </head>
    <body>
        <h1>Editar Usuário</h1>
        <!-- Cria o formulário para novo usuário -->
        <form action="usuario_update_confirm.php" method="post">
            <!-- Passa o id do usuário através de um campo oculto -->
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>" />
            <label>E-Mail:</label>
            <input type="email" name="email" value="<?= $usuario['email'] ?>" disabled />
            <label>Senha</label>
            <input type="password" name="senha" />
            <label>Confirmação de Senha</label>
            <input type="password" name="senha_confirm" />
            <label>Usuário Administrador</label>
            <!-- Utiliza a função 'estaAutorizado' [autenticacao.php] para verificar se o
                 usuário logado é administrador. Caso não seja inclui atributo 'disabled'
                 no controle 'checkbox' -->
            <input type="checkbox" name="administrador" <?= estaAutorizado(TRUE) ? '' : 'disabled' ?> <?= $usuario['administrador'] ? 'checked' : '' ?> />
            <input type="submit" value="Salvar" />
        </form>
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
    </body>
</html>