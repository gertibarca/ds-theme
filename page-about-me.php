<?php
/* Template Name: About Me */
get_header();
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="display-4 text-primary mb-4 border-bottom pb-2">About Me</h1>
            
            <div class="entry-content lead">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>