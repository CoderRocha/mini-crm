<?php require('init.php') ?>

<?php

if (!is_logged_in()) {
    redirect_to('login.php');
}

$current_user = get_logged_in_user();
if (!can_register_users($current_user)) {
    redirect_to('index.php');
}

$error = false;
$error_message = '';
$success = false;

if (isset($_POST['submit-register'])) {
    if (! check_hash('register', $_POST['hash'])) {
        die('Erro ao registrar usuário. Tente novamente.');
    }

    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email = trim($_POST['email']);
    $user_type = intval($_POST['user_type']);
    $display_name = trim($_POST['display_name']);
    $bio = trim($_POST['bio']);

    if (empty($username) || empty($password) || empty($email) || empty($display_name)) {
        $error = true;
        $error_message = "Preencha todos os campos obrigatórios.";
    } elseif (username_exists($username)) {
        $error = true;
        $error_message = "Este nome de usuário já está em uso.";
    } elseif ($user_type < 1 || $user_type > 4) {
        $error = true;
        $error_message = "Tipo de usuário inválido.";
    } else {
        if (create_user($username, $password, $email, $user_type, $display_name, $bio)) {
            $success = true;
        } else {
            $error = true;
            $error_message = "Erro ao criar usuário. Tente novamente.";
        }
    }
}

?>

<?php require('templates/header.php'); ?>

<h2>Cadastrar Novo Usuário</h2>

<?php if ($success): ?>
    <div class="success">Usuário cadastrado com sucesso!</div>
<?php endif; ?>

<?php if ($error): ?>
    <div class="error"><?php echo htmlspecialchars($error_message, ENT_QUOTES); ?></div>
<?php endif; ?>

<form action="" method="post">
    <label for="username">Usuário *</label>
    <input type="text" name="username" id="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username'], ENT_QUOTES) : ''; ?>">

    <label for="password">Senha *</label>
    <input type="password" name="password" id="password" required>

    <label for="email">Email *</label>
    <input type="email" name="email" id="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_QUOTES) : ''; ?>">

    <label for="display_name">Nome de Exibição *</label>
    <input type="text" name="display_name" id="display_name" required value="<?php echo isset($_POST['display_name']) ? htmlspecialchars($_POST['display_name'], ENT_QUOTES) : ''; ?>">

    <label for="user_type">Tipo de Usuário *</label>
    <select name="user_type" id="user_type" required>
        <option value="1" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 1) ? 'selected' : ''; ?>>Player</option>
        <option value="2" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 2) ? 'selected' : ''; ?>>Indie Dev</option>
        <option value="3" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 3) ? 'selected' : ''; ?>>Player/Dev</option>
        <option value="4" <?php echo (isset($_POST['user_type']) && $_POST['user_type'] == 4) ? 'selected' : ''; ?>>Admin</option>
    </select>

    <label for="bio">Bio</label>
    <textarea name="bio" id="bio" rows="4"><?php echo isset($_POST['bio']) ? htmlspecialchars($_POST['bio'], ENT_QUOTES) : ''; ?></textarea>

    <input type="hidden" name="hash" value="<?php echo htmlspecialchars(generate_hash('register'), ENT_QUOTES); ?>">

    <p>
        <input type="submit" name="submit-register" value="Cadastrar Usuário">
    </p>
</form>

<?php require('templates/footer.php'); ?>