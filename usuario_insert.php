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
        <link href="assets/css/default.css" rel="stylesheet" />
    </head>
    <body>
        <?php require_once 'assets/layout/header.php' ?>
        <div id="container">
            <h1>Novo Usuário</h1>
            <!-- Cria o formulário para novo usuário -->
            <form action="usuario_insert_confirm.php" method="post">
                <label class="form-control">E-Mail:</label>
                <input class="form-control" type="email" name="email" />
                <label class="form-control">Senha:</label>
                <input class="form-control" type="password" name="senha" />
                <label class="form-control">Confirmação de Senha:</label>
                <input class="form-control" type="password" name="senha_confirm" />
                <label class="form-inline-control">Usuário Administrador:</label>
                <!-- Utiliza a função 'estaAutorizado' [autenticacao.php] para verificar se o
                    usuário logado é administrador. Caso não seja inclui atributo 'disabled'
                    no controle 'checkbox' -->
                <input class="form-inline-control" type="checkbox" name="administrador" <?= estaAutorizado(TRUE) ? '' : 'disabled' ?> />
                <input class="form-button" type="submit" value="Criar Usuário" />
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
        </div>
        <?php require_once 'assets/layout/footer.php' ?>
    </body>
</html>