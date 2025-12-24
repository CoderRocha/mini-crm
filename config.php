<?php

// Debug de erros
// Remover isso em produção
error_reporting( E_ALL );
ini_set( 'display_errors', 1 );

define( 'SITE_URL', 'http://localhost/mini-crm' );
define( 'SITE_TIMEZONE', 'America/Sao_Paulo' );
define( 'SITE_LANG', 'pt-br' );

// Conexão com o banco de dados
// Mudar os dados ao ir em produção
define( 'DB_HOST', 'localhost' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_DATABASE', 'mini_crm' );
define( 'DB_PORT', '3306' );