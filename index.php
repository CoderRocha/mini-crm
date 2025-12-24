<?php

require('init.php');

if (isset($_GET['delete-post'])) {
    if (!is_logged_in()) {
        redirect_to('login.php');
    }
    
    $current_user = get_logged_in_user();
    $id = $_GET['delete-post'];
    
    if (!check_hash('delete-post-' . $id, $_GET['hash'])) {
        die('Erro ao deletar o Post. Tente novamente.');
    }
    
    $post = get_post($id);
    if ($post && can_delete_post($current_user, $post)) {
        delete_post($id);
        redirect_to('index.php?success=deleted');
    } else {
        die('Você não tem permissão para deletar este post.');
    }
    die();
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = isset($_GET['per_page']) ? intval($_GET['per_page']) : 20;

$allowed_per_page = [10, 20, 30, 40, 50];
if (!in_array($per_page, $allowed_per_page)) {
    $per_page = 20;
}

$post_found = false;
$all_posts = [];
$total_posts = 0;
$total_pages = 1;

if (isset($_GET['view'])) {
    $post_found = get_post($_GET['view']);
    if ($post_found) {
        $all_posts = [$post_found];
    }
} else {
    $all_posts = get_all_posts($search, $page, $per_page);
    $total_posts = get_posts_count($search);
    $total_pages = max(1, ceil($total_posts / $per_page));
}

$current_user = is_logged_in() ? get_logged_in_user() : null;

?>

<?php require('templates/header.php'); ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
    <div class="success">Post deletado com sucesso!</div>
<?php endif; ?>

<?php if (!isset($_GET['view'])): ?>
    <div class="search-bar">
        <form method="get" action="" class="search-form">
            <input type="text" name="search" placeholder="Pesquisar posts..." value="<?php echo htmlspecialchars($search, ENT_QUOTES); ?>" class="search-input">
            <input type="hidden" name="per_page" value="<?php echo $per_page; ?>">
            <button type="submit" class="button">Pesquisar</button>
            <?php if ($search): ?>
                <a href="?" class="button button-outline">Limpar</a>
            <?php endif; ?>
        </form>
    </div>
<?php endif; ?>

<div class="posts">
    <?php if (empty($all_posts)): ?>
        <p>Nenhum post encontrado.</p>
    <?php else: ?>
        <?php foreach ($all_posts as $post): ?>
            <article class="post">
                <header>
                    <h2 class="post-title">
                        <a href="?view=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?></a>
                    </h2>
                    <?php if (isset($post['display_name'])): ?>
                        <div class="post-author">
                            Por: <strong><?php echo htmlspecialchars($post['display_name'], ENT_QUOTES); ?></strong>
                            <span class="user-type-badge user-type-<?php echo $post['user_type']; ?>">
                                <?php echo get_user_type_name($post['user_type']); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                </header>
                <div class="post-content">
                    <?php if ($post_found): ?>
                        <?php echo $post['content']; ?>
                    <?php else: ?>
                        <?php echo $post['excerpt']; ?>
                        <p><a href="?view=<?php echo $post['id']; ?>">Ler mais...</a></p>
                    <?php endif; ?>
                </div>
                <footer>
                    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <span class="post-date">
                            Publicado em:
                            <?php
                            $date = new DateTime($post['published_on']);
                            echo $date->format('d M Y');
                            ?>
                        </span>
                        <?php if ($current_user && can_delete_post($current_user, $post)): ?>
                            <a href="?delete-post=<?php echo $post['id']; ?>&hash=<?php echo generate_hash('delete-post-' . $post['id']); ?>"
                               onclick="return confirm('Tem certeza que deseja deletar este post?');"
                               class="button button-outline" style="font-size: 1.2rem; padding: 0.5rem 1.5rem;">
                                Deletar Post
                            </a>
                        <?php endif; ?>
                    </div>
                </footer>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php if (!isset($_GET['view']) && $total_posts > 0): ?>
    <div class="pagination">
        <div class="pagination-per-page">
            <select name="per_page" id="per_page" onchange="window.location.href='?search=<?php echo urlencode($search); ?>&per_page=' + this.value">
                <?php foreach ($allowed_per_page as $num): ?>
                    <option value="<?php echo $num; ?>" <?php echo $per_page == $num ? 'selected' : ''; ?>><?php echo $num; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <?php if ($total_pages > 1): ?>
        <div class="pagination-numbers">
            <?php
            $start_page = max(1, $page - 2);
            $end_page = min($total_pages, $page + 2);
            
            if ($page <= 3) {
                $start_page = 1;
                $end_page = min(5, $total_pages);
            }
            
            if ($page >= $total_pages - 2) {
                $start_page = max(1, $total_pages - 4);
                $end_page = $total_pages;
            }
            
            if ($start_page > 1): ?>
                <a href="?search=<?php echo urlencode($search); ?>&page=1&per_page=<?php echo $per_page; ?>" class="pagination-number">1</a>
                <?php if ($start_page > 2): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                <?php if ($i == $page): ?>
                    <span class="pagination-number pagination-current"><?php echo $i; ?></span>
                <?php else: ?>
                    <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $i; ?>&per_page=<?php echo $per_page; ?>" class="pagination-number"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php if ($end_page < $total_pages): ?>
                <?php if ($end_page < $total_pages - 1): ?>
                    <span class="pagination-ellipsis">...</span>
                <?php endif; ?>
                <a href="?search=<?php echo urlencode($search); ?>&page=<?php echo $total_pages; ?>&per_page=<?php echo $per_page; ?>" class="pagination-number"><?php echo $total_pages; ?></a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php require('templates/footer.php');