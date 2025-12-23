<?php

/**
 * Redireciona a uma URL
 *
 * @param $path
 */
function redirect_to($path)
{
    header('Location: ' . SITE_URL . '/' . $path);
    die();
}

function generate_hash( $action ) {
	return md5( $action );
}

/**
 * Validar Hash
 *
 * @param $action
 * @param $hash
 *
 * @return bool
 */
function check_hash( $action, $hash ) {
	if ( generate_hash( $action ) == $hash ) {
		return true;
	}
	return false;
}

/**
 * Verifica se o usuário está logado
 */

function is_logged_in() {
	return isset( $_SESSION['user'] ) && isset( $_SESSION['user']['id'] );
}

/**
 * Retorna o usuário logado
 */
function get_logged_in_user() {
	return isset( $_SESSION['user'] ) ? $_SESSION['user'] : null;
}

/**
 * Realiza o login
 */

function login( $username, $password ) {
	$user = get_user_by_username( $username );
	
	if ( $user && password_verify( $password, $user['password'] ) ) {
		unset( $user['password'] );
		$_SESSION['user'] = $user;
		return true;
	}

	return false;
}

/**
 * Realiza o logout
 */

function logout() {
	unset( $_SESSION['user'] );
	redirect_to( 'index.php' );
	session_destroy();
}