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
    </head>
    <body>
        <h1>Exemplo de Aplicação</h1>
        <ul>
            <li>
                <?php if(estaAutorizado()): ?>
                <a href="logout.php">Logout (<?= $_SESSION['usuario_email'] ?>)</a>
                <?php else: ?>
                <a href="login.php">Login</a>
                <?php endif; ?>
            </li>
            <li><a href="usuario_insert.php">Registrar Usuário</a></li>
            <?php if(estaAutorizado(true)): ?>
            <li><a href="usuarios.php">Lista de Usuários</a></li>
            <?php endif; ?>
        </ul>
        <div id="mensagens">
            <ul>
                <?php while($msg = obterMensagem(basename(__FILE__))): ?>
                <li><?= $msg['mensagem'] ?></li>
                <?php endwhile ?>
            </ul>
        </div>
    </body>
</html>