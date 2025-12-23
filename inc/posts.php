<?php

/**
 * Retorna todos os posts
 */
function get_all_posts($search = '', $page = 1, $per_page = 20) {
    global $app_db;
    
    $offset = ($page - 1) * $per_page;
    $per_page = intval($per_page);
    $offset = intval($offset);
    
    $where = '';
    if (!empty($search)) {
        $search = $app_db->real_escape_string($search);
        $where = "WHERE p.title LIKE '%$search%' OR p.excerpt LIKE '%$search%' OR p.content LIKE '%$search%'";
    }
    
    $query = "SELECT p.*, u.username, u.display_name, u.user_type 
              FROM posts p 
              LEFT JOIN users u ON p.user_id = u.id 
              $where
              ORDER BY p.published_on DESC 
              LIMIT $per_page OFFSET $offset";
    
    $result = $app_db->query($query);
    return $app_db->fetch_all($result);
}

/**
 * Retorna o total de posts (paginação)
 */
function get_posts_count($search = '') {
    global $app_db;
    
    $where = '';
    if (!empty($search)) {
        $search = $app_db->real_escape_string($search);
        $where = "WHERE title LIKE '%$search%' OR excerpt LIKE '%$search%' OR content LIKE '%$search%'";
    }
    
    $query = "SELECT COUNT(*) as total FROM posts $where";
    $result = $app_db->query($query);
    $row = $app_db->fetch_assoc($result);
    return intval($row['total']);
}

/**
 * Insere um novo post
 *
 * @param $title
 * @param $excerpt
 * @param $content
 * @param $user_id
 */
function insert_post( $title, $excerpt, $content, $user_id = null ) {
    global $app_db;

    if ($user_id === null) {
        $current_user = get_logged_in_user();
        $user_id = $current_user ? $current_user['id'] : 1;
    }

	$published_on = date( 'Y-m-d H:i:s' );

	$title = $app_db->real_escape_string( $title );
	$excerpt = $app_db->real_escape_string( $excerpt );
	$content = $app_db->real_escape_string( $content );
	$user_id = intval( $user_id );

    $query = "INSERT INTO posts
	( title, excerpt, content, published_on, user_id )
	VALUES ( '$title', '$excerpt', '$content', '$published_on', $user_id )";

	$result = $app_db->query( $query );
}

/**
 * Busca e retorna um Post
 * Se não encontrar, retorna false
 */
function get_post( $post_id ) {
    global $app_db;

	$post_id = intval( $post_id );

	$query = "SELECT p.*, u.username, u.display_name, u.user_type 
	          FROM posts p 
	          LEFT JOIN users u ON p.user_id = u.id 
	          WHERE p.id = $post_id";
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
    $id = intval($id);
	$result = $app_db->query( "DELETE FROM posts WHERE id = $id" );
}