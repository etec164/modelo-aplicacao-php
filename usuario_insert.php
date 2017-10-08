<?php
// Inclui o script 'includes/autenticacao.php'
require_once 'includes/autenticacao.php';
// Inclui o script 'includes/mensagem.php'
require_once 'includes/mensagem.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Novo Usuário</title>
    </head>
    <body>
        <h1>Novo Usuário</h1>
        <!-- Cria o formulário para novo usuário -->
        <form action="usuario_insert_confirm.php" method="post">
            <label>E-Mail:</label>
            <input type="email" name="email" />
            <label>Senha</label>
            <input type="password" name="senha" />
            <label>Confirmação de Senha</label>
            <input type="password" name="senha_confirm" />
            <label>Usuário Administrador</label>
            <!-- Utiliza a função 'estaAutorizado' [autenticacao.php] para verificar se o
                 usuário logado é administrador. Caso não seja inclui atributo 'disabled'
                 no controle 'checkbox' -->
            <input type="checkbox" name="administrador" <?= estaAutorizado(TRUE) ? '' : 'disabled' ?> />
            <input type="submit" value="Criar Usuário" />
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