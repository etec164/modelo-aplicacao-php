<?php
// Define as constantes que serão utilizadas pelas funções a seguir
define('MSG_OK', 0);
define('MSG_ERRO', 1);
define('MSG_INFO', 2);

/* Registra a mensagem passada como parâmetro bem como a página à qual se destina */
function registrarMensagem($pagina_destinataria, $mensagem, $tipo = MSG_INFO) {
    // Inclui o arquivo 'includes/autenticacao.php'
    require_once 'includes/autenticacao.php';
    // Inicia uma nova sessão através da função 'obterSessao' [autenticacao.php]
    iniciarSessao();
    /* Verifica se o vetor nomeado como o conteúdo de 'pagina_destinataria' existe
     * na variável de sessão 'mensagens'. */ 
    if(!isset($_SESSION['mensagens'][$pagina_destinataria])) {
        // Cria o vetor
        $_SESSION['mensagens'][$pagina_destinataria] = [];
    }
    /* Adiciona a mensagem passada como parâmetro ao fim do vetor nomeado como a
     * 'pagina_destinataria' na variável de sessão 'mensagens'.*/
    array_push(
        $_SESSION['mensagens'][$pagina_destinataria],
        ['tipo' => $tipo, 'mensagem' => $mensagem]);
}

/* Obtêm a próxima mensagem registrada para a 'pagina_destinataria' passada como
 * parâmetro. Retorna Falso caso não possua mensagem. */
function obterMensagem($pagina_destinataria) {
    require_once 'includes/autenticacao.php';
    iniciarSessao();
    return isset($_SESSION['mensagens'][$pagina_destinataria]) ?
        array_shift($_SESSION['mensagens'][$pagina_destinataria]) : false;
}