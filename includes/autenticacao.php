<?php
/* Inicia uma sessão caso não tenha uma ativa */
function iniciarSessao() {
    // Verifica se não existe uma sessão ativa
    if(!(session_status() == PHP_SESSION_ACTIVE)) {
        // Inicia uma sessão
        session_start();
    }
}

function encerrarSessao() {
    // Inicia a sessão
    iniciarSessao();
    // Destroi a sessão atual
    session_destroy();
}

/* Verifica se o usuário está logado. Retorna Verdadeiro ou Falso */
function estaAutenticado() {
    // Inicia uma sessão
    iniciarSessao();
    /* Verifica se variáveis de sessão 'usuario_id', 'usuario_email' e
     * 'usuario_administrador' estão definidas. */
    if (
        isset($_SESSION['usuario_email']) &&
        isset($_SESSION['usuario_id']) &&
        isset($_SESSION['usuario_administrador'])) {
            // Retorna Verdadeiro
            return TRUE;
    }
    // Retorna Falso
    return false;
}

/* Verifica se o usuário atual atende às exigências passadas via parâmetro
 * caso não seja fornecido nenhum parâmetro basta o usuário estar logado.
 * Retorna Verdadeiro ou Falso */
function estaAutorizado($somente_administrador = FALSE, $usuario_id = NULL) {
    // Verifica se o usuário está logado
    if(estaAutenticado()) {
        /* Verifica se foi informado o id de um usuário específico na função e
         * em caso positivo verifica se este id correnponde ao do usuário logado */
        if ($_SESSION['usuario_administrador'] == 1) {
            return true;
        } else if($usuario_id != NULL &&
                    $usuario_id != $_SESSION['usuario_id']) {
            // Caso o teste anterior falhe retorna falso
            return false;
        }
        /* Verifica se o acesso é restriro à admnistradores e caso seja, verifica
         * se o usuário logado é um administrador */
        if ($somente_administrador && $_SESSION['usuario_administrador'] == 0) {
            // Caso o teste anterior falhe retorna falso
            return false;
        }
        // Retorna Verdadeiro
        return true;
    }
    // Retorna Falso
    return false;
}

/* Função que verifica se existe um usuário que corresponda aos valores de
 * 'email' e 'senha' passados como parâmetro e registra sessão caso exista.
 * Retorna Verdadeiro ou Falso */
function registrarAutenticacao($email, $senha) {
    // Inclui o script 'includes/conexao_de_dados.php'
    require_once 'includes/conexao_de_dados.php';
    // Verifica se os parêmetros 'email' e 'senha' não estão em branco (string vazia)
    if($email != '' && $senha != '') {
        /* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
         * uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
        $bd = obterConexao();
        /* Cria um comando SQL do PDO para ser executado contendo a consulta que
         * pesquisará por usuários que possuam o email e a senha passados
         * nos parâmetros 'email' e 'senha' */
        $comando = $bd->prepare(
            'SELECT * FROM usuarios WHERE email = :e AND senha = :s');
        /* Executa o comando preparado atribuindo os valores de 'email' e 'senha'
         * aos parâmetros da consulta utilizando SHA256 para encriptar a senha */
        $comando->execute([':e' => $email, ':s' => hash('sha256', $senha)]);
        // Verifica se a consulta retornou algum usuário
        if($usuario = $comando->fetch()) {
            // Cria uma sessão para o usuário
            iniciarSessao();
            // Define os atributos da sessão conforme os dados do usuário consultado
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_administrador'] = $usuario['administrador'];
            // Retorna verdadeiro
            return true;
        } else {
            // Retorna Falso
            return false;
        }
    }
    // Retorna Falso
    return false;
}

/* Verifica se o usuário atual atende às exigências passadas via parâmetro
 * caso não seja fornecido nenhum parâmetro basta o usuário estar logado.
 * Caso o usuário não possua autorização o fluxo será redirecionado para
 * uma página de erro. */
function necessitaAutorizacao($somente_administrador = FALSE, $usuario_id = NULL) {
    // Inclui o arquivo 'includes/requisicao.php'
    require_once 'includes/requisicao.php';
    // Verifica se o valor inverso (!) da função 'estaAutorizado' é Verdadeiro
    if(!estaAutorizado($somente_administrador, $usuario_id)) {
        // Redireciona para página de erro
        redirecionarPara('erro_403.php');
    }
}