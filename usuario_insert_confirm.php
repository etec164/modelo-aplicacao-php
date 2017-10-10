<?php
// Verifica se o método de requisião utilizado é o POST
if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Inclui o arquivo 'includes/conexao_de_dados.php'
    require_once 'includes/conexao_de_dados.php';
    // Inclui o arquivo 'includes/autenticacao.php'
    require_once 'includes/autenticacao.php';
    // Inclui o arquivo 'includes/mensagem.php'
    require_once 'includes/mensagem.php';
    // Inclui o arquivo 'includes/requisicao.php'
    require_once 'includes/requisicao.php';

    // Valida o email recebido retornando false se o email não for válido
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    
    // Verifica se o email foi validado
    if($email == false) {
        // Registra uma mensagem de erro caso o email não seja válido
        registrarMensagem('usuario_insert.php', 'Endereço de e-mail inválido', MSG_ERRO);
    }
    // Define o valor das variáveis 'senha' e 'senha_confirm' recebendo os dados de '_POST'
    $senha = $_POST['senha'];
    $senha_confirm = $_POST['senha_confirm'];
    // Verifica se a 'senha'  e a confirmação são diferêntes
    if($senha != $senha_confirm) {
        // Atribui o valor false para 'senha'
        $senha = false;
        // Registra uma mensagem de erro
        registrarMensagem('usuario_insert.php', 'Senha e Senha de Confirmação Diferêntes', MSG_ERRO);
    } else if ($senha == '') {
        // Atribui o valor false para 'senha'
        $senha = false;
        // Registra uma mensagem de erro
        registrarMensagem('usuario_insert.php', 'Deve ser digitada uma senha', MSG_ERRO);
    }
    // Verifica se uma das variáveis não são válidas
    if($email == false || $senha == false) {
        // Redireciona para página com o formulário de inserção
        redirecionarPara('usuario_insert.php');
    }
    // Caso o usuário seja administrador valida a variável 'administrador'
    $administrador = (estaAutorizado(TRUE)) ?
        $_POST['administrador'] == 'on' ? 1 : 0 : 0;

    // Insere dados no banco
    if($email != false && $senha != false) {
        /* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
         * uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
         $bd = obterConexao();
         /* Cria um comando SQL do PDO para ser executado contendo a consulta que
          * criará um novo registro de usuário */
         $comando = $bd->prepare(
             'INSERT INTO usuarios(email, senha, administrador) VALUES(:e, :s, :a)');
         /* Executa o comando preparado atribuindo os valores de 'email' e 'senha'
          * e 'administrador' aos parâmetros da consulta, utilizando SHA256 para
          * encriptar a senha */
        $result = $comando->execute(
             [':e' => $email, ':s' => hash('sha256', $senha), ':a' => $administrador]);
        // Verifica se o comando foi executado sem erros e cria a respectiva mensagem
        $mensagem = ($result) ? 'Usuário Criado com Sucesso' : 'Erro ao Criar Novo Usuário';
        registrarMensagem('usuarios.php', $mensagem);
        // Caso o usuário seja administrador
        if(estaAutorizado(TRUE)) {
            // Redireciona para página com a lista de usuários
            redirecionarPara('usuarios.php');
        } else {
            // Redireciona para página inicial
            redirecionarPara('index.php');
        }
    }
} else {
    // Redireciona para página com o formulário de inserção
    redirecionarPara('usuario_insert.php');
}