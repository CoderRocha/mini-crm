<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Indie Games Hub</title>
	<link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/style.css"></head>
<body>

<nav id="site-navigation" role="navigation" class="row row-center">
	<div class="column">
		<h1>
			<a href="index.php">Indie Games Hub</a>
		</h1>
		<ul class="main-menu column clearfix">
			<li><a href="<?php echo SITE_URL; ?>/index.php">Home</a></li>
			<?php if ( is_logged_in() ): 
				$current_user = get_logged_in_user();
			?>
				<li><a href="<?php echo SITE_URL; ?>/profile.php">Meu Perfil</a></li>
				<?php if (can_create_post($current_user)): ?>
					<li><a href="<?php echo SITE_URL; ?>/new-post.php">Novo Post</a></li>
				<?php endif; ?>
				<?php if (can_register_users($current_user)): ?>
					<li><a href="<?php echo SITE_URL; ?>/register.php">Cadastrar Usuário</a></li>
				<?php endif; ?>
				<?php if (is_admin($current_user)): ?>
					<li><a href="<?php echo SITE_URL; ?>/admin">Painel Adm</a></li>
				<?php endif; ?>
				<li><a href="<?php echo SITE_URL; ?>?logout=true">Logout</a></li>
			<?php else: ?>
				<li><a href="<?php echo SITE_URL; ?>/login.php">Login</a></li>
			<?php endif; ?>
		</ul>
	</div>
</nav>

<div id="content">