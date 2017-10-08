<?php
// Inclui o arquivo 'includes/autenticacao.php'
require_once 'includes/autenticacao.php';
// Inclui o arquivo 'includes/requisicao.php'
require_once 'includes/requisicao.php';

encerrarSessao();
redirecionarPara('index.php');