<?php require('init.php') ?>

<?php

if (!is_logged_in()) {
    redirect_to('login.php');
}

$current_user = get_logged_in_user();
$error = false;
$error_message = '';
$success = false;

if (isset($_POST['submit-update-profile'])) {
    if (! check_hash('update-profile', $_POST['hash'])) {
        die('Erro ao atualizar perfil. Tente novamente.');
    }

    $email = trim($_POST['email']);
    $display_name = trim($_POST['display_name']);
    $bio = trim($_POST['bio']);

    if (empty($email) || empty($display_name)) {
        $error = true;
        $error_message = "Preencha todos os campos obrigatórios.";
    } else {
        if (update_user($current_user['id'], $email, $display_name, $bio)) {

            $updated_user = get_user_by_id($current_user['id']);
            unset($updated_user['password']);
            $_SESSION['user'] = $updated_user;
            $current_user = $updated_user;
            $success = true;
        } else {
            $error = true;
            $error_message = "Erro ao atualizar perfil. Tente novamente!";
        }
    }
}

$user_posts = [];
if (isset($current_user['id'])) {
    global $app_db;
    $user_id = intval($current_user['id']);
    $query = "SELECT * FROM posts WHERE user_id = $user_id ORDER BY published_on DESC LIMIT 10";
    $result = $app_db->query($query);
    $user_posts = $app_db->fetch_all($result);
}

?>

<?php require('templates/header.php'); ?>

<h2>Meu Perfil</h2>

<?php if ($success): ?>
    <div class="success">Perfil atualizado com sucesso!</div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES); ?></div>
<?php endif; ?>

<div class="profile-container">
    <div class="profile-info">
        <h3>Informações do Perfil</h3>
        <form action="" method="post">
            <label for="username">Usuário</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($current_user['username'], ENT_QUOTES); ?>" disabled>
            <small>O nome de usuário não pode ser alterado.</small>

            <label for="user_type">Tipo de Usuário</label>
            <input type="text" name="user_type" id="user_type" value="<?php echo get_user_type_name($current_user['user_type']); ?>" disabled>
            <small>O tipo de usuário não pode ser alterado.</small>

            <label for="display_name">Nome de Exibição *</label>
            <input type="text" name="display_name" id="display_name" required value="<?php echo htmlspecialchars($current_user['display_name'], ENT_QUOTES); ?>">

            <label for="email">Email *</label>
            <input type="email" name="email" id="email" required value="<?php echo htmlspecialchars($current_user['email'], ENT_QUOTES); ?>">

            <label for="bio">Bio</label>
            <textarea name="bio" id="bio" rows="4"><?php echo htmlspecialchars($current_user['bio'] ?? '', ENT_QUOTES); ?></textarea>

            <input type="hidden" name="hash" value="<?php echo htmlspecialchars(generate_hash('update-profile'), ENT_QUOTES); ?>">

            <p>
                <input type="submit" name="submit-update-profile" value="Atualizar Perfil">
            </p>
        </form>
    </div>

    <div class="profile-posts">
        <h3>Meus Posts Recentes</h3>
        <?php if (empty($user_posts)): ?>
            <p>Você ainda não criou nenhum post.</p>
            <?php if (can_create_post($current_user)): ?>
                <p><a href="<?php echo SITE_URL; ?>/new-post.php" class="button">Criar Primeiro Post</a></p>
            <?php endif; ?>
        <?php else: ?>
            <ul class="user-posts-list">
                <?php foreach ($user_posts as $post): ?>
                    <li>
                        <a href="<?php echo SITE_URL; ?>/?view=<?php echo $post['id']; ?>">
                            <?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?>
                        </a>
                        <span class="post-date-small">
                            <?php
                            $date = new DateTime($post['published_on']);
                            echo $date->format('d/m/Y');
                            ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>

<?php require('templates/footer.php'); ?>