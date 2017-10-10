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
        <title>Modelo de Aplicação</title>
        <link href="assets/css/default.css" rel="stylesheet" />
    </head>
    <body>
        <?php require_once 'assets/layout/header.php' ?>
        <div id="container">
            <div id="mensagens">
                <ul>
                    <?php while($msg = obterMensagem(basename(__FILE__))): ?>
                    <li><?= $msg['mensagem'] ?></li>
                    <?php endwhile ?>
                </ul>
            </div>
        </div>
        <?php require_once 'assets/layout/footer.php' ?>
    </body>
</html>