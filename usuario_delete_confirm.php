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
    
    
    /* Utiliza a função 'obterConexao()' [conexao_de_dados.php] para estabelecer
     * uma conexão com o banco de dados e armazena sua referência na variável 'bd' */
    $bd = obterConexao();
    /* Cria um comando SQL do PDO para ser executado contendo a consulta que
     * criará um novo registro de usuário */
    $comando = $bd->prepare(
        'DELETE FROM usuarios WHERE id = :i');
    /* Executa o comando preparado */
    $result = $comando->execute([':i' => $id]);
    // Verifica se o comando foi executado sem erros e cria a respectiva mensagem
    $mensagem = ($result) ? 'Usuário Removido' : 'Erro ao Remover Usuário';
    // Caso o usuário seja administrador
    if(estaAutorizado(TRUE)) {
        registrarMensagem('usuarios.php', $mensagem);
        // Redireciona para página com a lista de usuários
        redirecionarPara('usuarios.php');
    } else {
        registrarMensagem('usuario_delete.php', $mensagem);
        // Redireciona para página inicial
        redirecionarPara('usuario_delete.php?id='.$id);
    }
} else {
    // Redireciona para página com o formulário de inserção
    redirecionarPara('usuario_delete.php?id='.$id);
}