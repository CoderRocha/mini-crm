<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function get_post_1_titulo()
{
    $post_1_titulo = 'Lorem ipsum dolor sit amet';
    return $post_1_titulo;
}

function get_post_1_conteudo()
{
    $post_1_conteudo = 'Mauris lobortis, turpis sit amet pulvinar hendrerit, elit ligula accumsan ligula, ut interdum massa elit vitae justo.';
    return $post_1_conteudo;
}

function get_post_2_titulo()
{
    $post_2_titulo = 'Mauris lobortis, turpis sit amet pulvinar hendrerit';
    return $post_2_titulo;
}

function get_post_2_conteudo()
{
    $post_2_conteudo = 'Maecenas malesuada malesuada eleifend. Nam lobortis risus in est sollicitudin, ut egestas orci pharetra.';
    return $post_2_conteudo;
}

?>

<h1>
    <?php echo $my_var; ?>
</h1>