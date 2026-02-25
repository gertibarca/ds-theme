<?php
/* Template Name: DS Portfolio */
get_header();
?>

<div class="container my-5">
    <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-5 fw-bold text-dark">DS Portfolio Template</h1>
            <p class="col-md-12 fs-4 text-muted">This is Gerti</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <article class="bg-white p-4">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; endif; ?>
            </article>
        </div>
    </div>
</div>

<?php get_footer(); ?>