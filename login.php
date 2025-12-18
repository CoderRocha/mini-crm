<?php require('init.php') ?>

<?php

$error = false;

if (isset($_POST['submit-login'])) {
    if (! check_hash('login', $_POST['hash'])) {
        die('Erro ao realizar login. Tente novamente.');
    }

    if (! login($_POST['username'], $_POST['password'])) {
        $error = true;
    }
}

if (is_logged_in()) {
    redirect_to('index.php');
}

?>

<?php require('templates/header.php'); ?>

<h2>Login</h2>

<?php if ($error): ?>
    <div class="error"><?php echo "Usuário ou senha incorretos." ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="username">Usuário</label>
    <input type="text" name="username" id="username">

    <label for="password">Senha</label>
    <input type="password" name="password" id="password">

    <input type="hidden" name="hash" value="<?php echo htmlspecialchars(generate_hash('login'), ENT_QUOTES); ?>">

    <p>
        <input type="submit" name="submit-login" value="Login">
    </p>
</form>

<?php require('templates/footer.php'); ?>