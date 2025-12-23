<?php

if (!file_exists( __DIR__ . '/config.php')) {
	die('ERRO: O arquivo config.php não existe!');
}

session_start();

require 'config.php';

setlocale(LC_TIME, SITE_LANG);
date_default_timezone_set(SITE_TIMEZONE);

require( 'inc/class-db.php' );
require( 'inc/posts.php' );
require( 'inc/users.php' );
require( 'inc/helpers.php' );

$app_db = new DB(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE, DB_PORT);

if ( isset( $_GET['logout'] ) ) {
	logout();
}