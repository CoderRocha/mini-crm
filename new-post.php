<?php

require('init.php');

if (!is_logged_in()) {
    redirect_to('login.php');
}

$current_user = get_logged_in_user();
if (!can_create_post($current_user)) {
    redirect_to('index.php');
}

$error = false;
$title = '';
$excerpt = '';
$content = '';

if (isset($_POST['submit-new-post'])) {
    // se enviou o formulario
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $excerpt = filter_input(INPUT_POST, 'excerpt', FILTER_SANITIZE_STRING);
    $content = strip_tags($_POST['content'], '<br><p><a><img><div>');

    if (empty($title) || empty($content)) {
        $error = true;
    } else {
        insert_post($title, $excerpt, $content);
        // Redirecionar para a home
        redirect_to('index.php?success=true');
    }
}
?>

<?php require('templates/header.php'); ?>

<h2>Criar novo Post</h2>

<?php if ($error): ?>
    <div class="error">
        Erro no formulário.
    </div>
<?php endif; ?>

<form action="" method="post">
    <label for="title">Título (Obrigatório)</label>
    <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title, ENT_QUOTES); ?>" required>

    <label for="excerpt">Excerto</label>
    <input type="text" name="excerpt" id="excerpt" value="<?php echo htmlspecialchars($excerpt, ENT_QUOTES); ?>">

    <label for="content">Conteúdo (Obrigatório)</label>
    <textarea name="content" id="content" cols="30" rows="30"><?php echo htmlspecialchars($content, ENT_QUOTES); ?></textarea>

    <p>
        <input type="submit" name="submit-new-post" value="Novo Post">
    </p>
</form>
<?php require('templates/footer.php');