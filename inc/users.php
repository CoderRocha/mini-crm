<?php

/**
 * Retorna um usuário (por username)
 */
function get_user_by_username($username) {
    global $app_db;
    $username = $app_db->real_escape_string($username);
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = $app_db->query($query);
    return $app_db->fetch_assoc($result);
}

/**
 * Retorna um usuário (por ID)
 */
function get_user_by_id($user_id) {
    global $app_db;
    $user_id = intval($user_id);
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = $app_db->query($query);
    return $app_db->fetch_assoc($result);
}

/**
 * Verifica se username já existe
 */
function username_exists($username) {
    global $app_db;
    $username = $app_db->real_escape_string($username);
    $query = "SELECT COUNT(*) as count FROM users WHERE username = '$username'";
    $result = $app_db->query($query);
    $row = $app_db->fetch_assoc($result);
    return $row['count'] > 0;
}

/**
 * Cria um novo usuário
 */
function create_user($username, $password, $email, $user_type, $display_name, $bio = '') {
    global $app_db;
    
    $username = $app_db->real_escape_string($username);
    $email = $app_db->real_escape_string($email);
    $display_name = $app_db->real_escape_string($display_name);
    $bio = $app_db->real_escape_string($bio);
    $user_type = intval($user_type);
    
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $created_at = date('Y-m-d H:i:s');
    
    $query = "INSERT INTO users (username, password, email, user_type, display_name, bio, created_at)
              VALUES ('$username', '$password_hash', '$email', $user_type, '$display_name', '$bio', '$created_at')";
    
    return $app_db->query($query);
}

/**
 * Atualiza um usuário
 */
function update_user($user_id, $email, $display_name, $bio = '') {
    global $app_db;
    
    $user_id = intval($user_id);
    $email = $app_db->real_escape_string($email);
    $display_name = $app_db->real_escape_string($display_name);
    $bio = $app_db->real_escape_string($bio);
    
    $query = "UPDATE users SET email = '$email', display_name = '$display_name', bio = '$bio' WHERE id = $user_id";
    
    return $app_db->query($query);
}

/**
 * Retorna o tipo de usuário (como string)
 */
function get_user_type_name($user_type) {
    $types = [
        1 => 'Player',
        2 => 'Indie Dev',
        3 => 'Player/Dev',
        4 => 'Admin'
    ];
    return isset($types[$user_type]) ? $types[$user_type] : 'Desconhecido';
}

/**
 * Verifica se o usuário é admin
 */
function is_admin($user) {
    if (!$user || !isset($user['user_type'])) {
        return false;
    }
    return intval($user['user_type']) == 4;
}

/**
 * Verifica se o usuário pode criar posts
 */
function can_create_post($user) {
    if (!$user) return false;

    return true;
}

/**
 * Verifica se o usuário pode deletar um post
 */
function can_delete_post($user, $post) {
    if (!$user || !$post) return false;

    // Admins podem deletar qualquer post
    if (is_admin($user)) {
        return true;
    }

    // Usuários podem deletar apenas seus próprios posts
    if (isset($post['user_id']) && isset($user['id']) && $post['user_id'] == $user['id']) {
        return true;
    }

    return false;
}

/**
 * Verifica se o usuário pode cadastrar outros usuários
 */
function can_register_users($user) {
    if (!$user) return false;

    return is_admin($user);
}



