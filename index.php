<?php
get_header(); 
?>

<main>
    <h2>Welcome to <?php bloginfo('name'); ?></h2>
    <p>This is my custom WordPress theme called DS Theme. You can edit this content from the WordPress admin panel.</p>

    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
            <article>
                <h3><?php the_title(); ?></h3>
                <div>
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile;
    else : ?>
        <p>No posts found. Please add some content!</p>
    <?php endif; ?>
</main>

<?php
get_footer(); 
?>
