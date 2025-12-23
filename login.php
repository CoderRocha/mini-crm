<?php require('init.php') ?>

<?php

$error = false;
$error_message = '';
$registered = isset($_GET['registered']) && $_GET['registered'] == 1;

if (isset($_POST['submit-login'])) {
    if (! check_hash('login', $_POST['hash'])) {
        die('Erro ao realizar login. Tente novamente.');
    }

    if (! login($_POST['username'], $_POST['password'])) {
        $error = true;
        $error_message = "Usuário ou senha incorretos.";
    } else {
        redirect_to('index.php');
    }
}

if (is_logged_in()) {
    redirect_to('index.php');
}

?>

<?php require('templates/header.php'); ?>

<h2>Login</h2>

<?php if ($registered): ?>
    <div class="success">Conta criada com sucesso! Faça login para continuar.</div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES); ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="username">Usuário</label>
    <input type="text" name="username" id="username" required>

    <label for="password">Senha</label>
    <input type="password" name="password" id="password" required>

    <input type="hidden" name="hash" value="<?php echo htmlspecialchars(generate_hash('login'), ENT_QUOTES); ?>">

    <p>
        <input type="submit" name="submit-login" value="Login">
    </p>
</form>

<p style="margin-top: 2rem; text-align: center;">
    Não tem uma conta? <a href="<?php echo SITE_URL; ?>/register.php">Cadastre-se aqui</a>
</p>

<?php require('templates/footer.php'); ?>