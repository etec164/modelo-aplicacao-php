<?php
// Inclui o arquivo 'includes/mensagem.php'
require_once 'includes/mensagem.php';

// Verifica se as variáveis de requisição 'POST' 'email' e 'senha' estão definidos
if(isset($_POST['email']) && isset($_POST['senha'])){
    // Inclui o arquivo 'includes/autenticacao.php'
    require_once 'includes/autenticacao.php';
    // Inclui o arquivo 'includes/requisicao.php'
    require_once 'includes/requisicao.php';
    // Verifica se o 'email' e 'senha' são válidos
    if(registrarAutenticacao($_POST['email'], $_POST['senha'])) {
        // Redireciona para a prágina inicial
        redirecionarPara('index.php');
    } else {
        // Registra uma mensagem de erro
        registrarMensagem('login.php', 'Usuário e/ou senha inválido(s)', MSG_ERRO);
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Login</title>
        <link href="assets/css/login.css" rel="stylesheet" />
    </head>
    <body>
        <form action="login.php" method="post">
            <h1>ETEC Forum - Login</h1>
            <label class="form-control">E-Mail:</label>
            <input class="form-control" type="text" name="email" />
            <label class="form-control">Senha</label>
            <input class="form-control" type="password" name="senha" />
            <input class="form-button" type="submit" value="Entrar" />
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