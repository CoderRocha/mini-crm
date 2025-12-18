<?php

require('init.php');

$error = false;
$title = '';
$excerpt = '';
$content = '';

if (isset($_POST['submit-new-post'])) {
    // se enviou o formulario
    $title = $_POST['title'];
    $excerpt = $_POST['excerpt'];
    $content = $_POST['content'];

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
    <input type="text" name="title" id="title" value="<?php echo $title; ?>">

    <label for="excerpt">Excerto</label>
    <input type="text" name="excerpt" id="excerpt" value="<?php echo $excerpt; ?>">

    <label for="content">Conteúdo (Obrigatório)</label>
    <textarea name="content" id="content" cols="30" rows="30"><?php echo $content; ?></textarea>

    <p>
        <input type="submit" name="submit-new-post" value="Novo Post">
    </p>
</form>
<?php require('templates/footer.php');