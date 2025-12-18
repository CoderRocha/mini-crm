<?php

if (!file_exists('config.php')) {
    die('ERRO: O arquivo config.php não existe!');
}

require 'config.php';

setlocale(LC_TIME, SITE_LANG);
date_default_timezone_set(SITE_TIMEZONE);

$app_db = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);
if ($app_db === false) {
    die("Erro ao conectar com o banco de dados");
}

require('inc/posts.php');
require('inc/helpers.php');