<?php

//$url = '2f.com.br';
if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '127.0.0.1') {
    define('DB_HOST', 'localhost', true);
    define('DB_USER', 'root', true);
    define('DB_PASS', '', true);
    define('DB_BASE', 'affinity', true);
}

/*
elseif($_SERVER['SERVER_NAME'] == $url || $_SERVER['SERVER_NAME'] == 'www' . $url) {
    //to do - definir em produção
    //define('DB_HOST', 'holden_saude.mysql.dbaas.com.br', true);
    //define('DB_USER', 'holden_saude', true);
    //define('DB_PASS', 'suporte-2f', true);
    //define('DB_BASE', 'holden_saude', true);
    //define('EMAIL_ENVIO', true, true);
}
*/
