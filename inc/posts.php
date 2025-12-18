<?php

/**
 * Retorna todos os posts
 */
function get_all_posts() {
    global $app_db;
	$result = $app_db->query( "SELECT * FROM posts" );
	return $app_db->fetch_all( $result );
}

/**
 * Insere um novo post
 *
 * @param $title
 * @param $excerpt
 * @param $content
 */
function insert_post( $title, $excerpt, $content ) {
    global $app_db;

	$published_on = date( 'Y-m-d H:i:s' );

	$title = $app_db->real_escape_string( $title );
	$excerpt = $app_db->real_escape_string( $excerpt );
	$content = $app_db->real_escape_string( $content );

    $query = "INSERT INTO posts
	( title, excerpt, content, published_on )
	VALUES ( '$title', '$excerpt', '$content', '$published_on' )";

	$result = $app_db->query( $query );
}

/**
 * Busca e retorna um Post
 * Se não encontrar, retorna false
 */
function get_post( $post_id ) {
    global $app_db;

	$post_id = intval( $post_id );

	$query = "SELECT * FROM posts WHERE id = " . $post_id;
	$result = $app_db->query( $query );

	return $app_db->fetch_assoc( $result );
}

/**
 * Deleta um post
 *
 * @param $id
 */
function delete_post( $id ) {
    global $app_db;

	$result = $app_db->query( "DELETE FROM posts WHERE id = $id" );
}