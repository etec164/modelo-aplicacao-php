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

    // Captura o id via método 'POST'
    $id = $_POST['id'];

    /* Define que esta página somente será acessivel por administradores ou o usuário
     * com o id especificado. */
    necessitaAutorizacao(false, $id);
    
    // Define o valor das variáveis 'senha' e 'senha_confirm' recebendo os dados de '_POST'
    $senha = $_POST['senha'];
    $senha_confirm = $_POST['senha_confirm'];
    // Verifica se a 'senha'  e a confirmação são diferêntes
    if($senha != '' && $senha != $senha_confirm) {
        // Atribui o valor false para 'senha'
        $senha = false;
        // Registra uma mensagem de erro
        registrarMensagem('usuario_update.php', 'Senha e Senha de Confirmação Diferêntes', MSG_ERRO);
        redirecionarPara('usuario_update.php?id='.$id);
    }
    // Caso o usuário seja administrador valida a variável 'administrador'
    $administrador = (estaAutorizado(TRUE)) ?
        filter_input(INPUT_POST, 'administrador', FILTER_VALIDATE_BOOLEAN) : 0;

    // Insere dados no banco
    if($senha != false) {
        /* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
         * uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
         $bd = obterConexao();
         /* Cria um comando SQL do PDO para ser executado contendo a consulta que
          * criará um novo registro de usuário */
         $comando = $bd->prepare(
             'UPDATE usuarios SET senha = :s WHERE id = :i');
         /* Executa o comando preparado atribuindo os valores de 'email' e 'senha'
          * e 'administrador' aos parâmetros da consulta, utilizando SHA256 para
          * encriptar a senha */
        $result = $comando->execute(
             [':s' => hash('sha256', $senha), ':i' => $id]);
        // Verifica se o comando foi executado sem erros e cria a respectiva mensagem
        $mensagem = ($result) ? 'Senha Alterada com Sucesso' : 'Erro ao Alterar Senha';
        // Caso o usuário seja administrador
        if(estaAutorizado(TRUE)) {
            registrarMensagem('usuarios.php', $mensagem);
            // Redireciona para página com a lista de usuários
            redirecionarPara('usuarios.php');
        } else {
            registrarMensagem('usuario_update.php', $mensagem);
            // Redireciona para página inicial
            redirecionarPara('usuario_update.php?id='.$id);
        }
    }
    if(estaAutorizado(TRUE)) {
        /* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
         * uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
        $bd = obterConexao();
        /* Cria um comando SQL do PDO para ser executado contendo a consulta que
         * criará um novo registro de usuário */
        $comando = $bd->prepare(
            'UPDATE usuarios SET administrador = :a WHERE id = :i');
        /* Executa o comando preparado atribuindo os valores de 'email' e 'senha'
         * e 'administrador' aos parâmetros da consulta, utilizando SHA256 para
         * encriptar a senha */
       $result = $comando->execute(
            [':a' => $administrador, ':i' => $id]);
       // Verifica se o comando foi executado sem erros e cria a respectiva mensagem
       $mensagem = ($result) ? 'Função Alterada com Sucesso' : 'Erro ao Alterar Função';
       // Caso o usuário seja administrador
       if(estaAutorizado(TRUE)) {
           registrarMensagem('usuarios.php', $mensagem);
           // Redireciona para página com a lista de usuários
           redirecionarPara('usuarios.php');
       } else {
           registrarMensagem('usuario_update.php', $mensagem);
           // Redireciona para página inicial
           redirecionarPara('usuario_update.php?id='.$id);
       }
    }
    redirecionarPara('usuario_update.php?id='.$id);
} else {
    // Redireciona para página com o formulário de inserção
    redirecionarPara('usuario_update.php?id='.$id);
}