<?php

require '../init.php';

if (! is_logged_in()) {
    redirect_to('../login.php');
}

$current_user = get_logged_in_user();

if (!is_admin($current_user)) {
    redirect_to('../index.php');
}

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'list-posts': {
            if (isset($_GET['delete-post'])) {
                $id = $_GET['delete-post'];
                if (! check_hash('delete-post-' . $id, $_GET['hash'])) {
                    die('Erro ao deletar o Post. Tente novamente.');
                }

                $post = get_post($id);
                if ($post && can_delete_post($current_user, $post)) {
                    delete_post($id);
                    redirect_to('admin?action=list-posts&success=true');
                } else {
                    die('Você não tem permissão para deletar este post.');
                }
                die();
            }

            $all_posts = get_all_posts('', 1, 1000);
            require 'templates/list-posts.php';
            break;
        }
    case 'new-post': {
            if (!can_create_post($current_user)) {
                redirect_to('../index.php');
            }

            $error = false;
            $title = '';
            $excerpt = '';
            $content = '';

            if (isset($_POST['submit-new-post'])) {

                // Se enviou o formulário
                $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
                $excerpt = filter_input(INPUT_POST, 'excerpt', FILTER_SANITIZE_STRING);
                $content = strip_tags($_POST['content'], '<br><p><a><img><div>');

                if (empty($title) || empty($content)) {
                    $error = true;
                } else {
                    insert_post($title, $excerpt, $content);
                    // Redirecionar para a Home
                    redirect_to('admin?action=list-posts&success=true');
                }
            }

            require 'templates/new-post.php';
            break;
        }
    default: {
            require 'templates/admin.php';
        }
}