<?php require __DIR__ . '/../../templates/header.php'; ?>

<?php if (isset($_GET['success'])): ?>
    <div class="success">
        Post criado com sucesso!
    </div>
<?php endif; ?>

<h2>Lista de Posts</h2>

<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Data</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($all_posts as $post): 
            $current_user = get_logged_in_user();
            $can_delete = can_delete_post($current_user, $post);
        ?>
        <tr>
                <td>
                    <a href="<?php echo SITE_URL; ?>/?view=<?php echo $post['id']; ?>">
                        <?php echo htmlspecialchars($post['title'], ENT_QUOTES); ?>
                    </a>
                </td>
                <td><?php echo isset($post['display_name']) ? htmlspecialchars($post['display_name'], ENT_QUOTES) : 'N/A'; ?></td>
                <td>
                    <?php
                    $date = new DateTime($post['published_on']);
                    echo $date->format('d/m/Y');
                    ?>
                </td>
                <td>
                    <?php if ($can_delete): ?>
                        <a href="<?php echo SITE_URL . '/admin?action=list-posts&delete-post=' . $post['id'] ?>&hash=<?php echo generate_hash('delete-post-' . $post['id']); ?>" 
                           onclick="return confirm('Tem certeza que deseja deletar este post?');"
                           class="button button-outline">Deletar</a>
                    <?php else: ?>
                        <span class="text-muted">Sem permissão</span>
                    <?php endif; ?>
                </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php require __DIR__ . '/../../templates/footer.php'; ?>