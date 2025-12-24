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
			<button class="menu-toggle" aria-label="Toggle menu" aria-expanded="false">
				<span></span>
				<span></span>
				<span></span>
			</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
	const menuToggle = document.querySelector('.menu-toggle');
	const mainMenu = document.querySelector('.main-menu');
	
	if (menuToggle && mainMenu) {
		function closeMenu() {
			mainMenu.classList.remove('menu-open');
			menuToggle.classList.remove('active');
			menuToggle.setAttribute('aria-expanded', 'false');
		}
		
		function openMenu() {
			mainMenu.classList.add('menu-open');
			menuToggle.classList.add('active');
			menuToggle.setAttribute('aria-expanded', 'true');
		}
		
		menuToggle.addEventListener('click', function(e) {
			e.stopPropagation();
			const isExpanded = this.getAttribute('aria-expanded') === 'true';
			if (isExpanded) {
				closeMenu();
			} else {
				openMenu();
			}
		});
		
		const menuLinks = mainMenu.querySelectorAll('a');
		menuLinks.forEach(link => {
			link.addEventListener('click', function() {
				if (window.innerWidth <= 768) {
					closeMenu();
				}
			});
		});
		
		document.addEventListener('click', function(e) {
			if (window.innerWidth <= 768 && mainMenu.classList.contains('menu-open')) {
				if (!mainMenu.contains(e.target) && !menuToggle.contains(e.target)) {
					closeMenu();
				}
			}
		});
		
		window.addEventListener('resize', function() {
			if (window.innerWidth > 768) {
				closeMenu();
			}
		});
	}
});
</script>

<div id="content">