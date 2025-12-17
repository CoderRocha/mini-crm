<?php

// debug de erros
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

setlocale( LC_TIME, 'pt_BR' );
date_default_timezone_set( 'America/Sao_Paulo' );

// conexão com o banco d dados
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'mini_crm';
$port = '3306';

$app_db = mysqli_connect($host, $user, $password, $database, $port);

if ($app_db === false) {
    die("Erro ao conectar com o banco de dados");
}

require( 'inc/posts.php' );