<?php

require('init.php');
require('templates/header.php');

$result = mysqli_query($app_db, "SELECT * FROM posts");
$all_posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

$post_found = false;
if (isset($_GET['view'])) {
    $query = "SELECT * FROM posts WHERE id = " . $_GET['view'];
    $result = mysqli_query($app_db, $query);
    if ($result) {
        $post_found = mysqli_fetch_assoc($result);
        $all_posts = [$post_found];
    }
}

?>
<div class="posts">
    <?php foreach ($all_posts as $post): ?>
        <article class="post">
            <header>
                <h2 class="post-title">
                    <a href="?view=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
                </h2>
            </header>
            <div class="post-content">
                <?php if ($post_found): ?>
                    <?php echo $post['content']; ?>
                <?php else: ?>
                    <?php echo $post['excerpt']; ?>
                <?php endif; ?>
            </div>
            <footer>
                <span class="post-date">
                    Publicado em:
                    <?php
                    $date = new DateTime($post['published_on']);
                    echo $date->format('d M Y');
                    ?>
                </span>

            </footer>
        </article>
    <?php endforeach; ?>
</div>

<?php require('templates/footer.php'); ?>