<?php
// Redireciona o script para a url passada como parâmetro
function redirecionarPara($url) {
    header('Location:'.$url);
    exit();
}