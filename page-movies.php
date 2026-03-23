<?php
/* Template Name: Movies Archive */
get_header();
?>

<div class="container my-5">
    <div class="bg-light p-5 mb-4 rounded-3 shadow-sm text-center">
        <h1 class="display-4 fw-bold">All Movies</h1>
        <p class="lead text-muted">Explore all Movies added in the system</p>
    </div>

    <div class="row">
        <?php
        // WP_Query për Movies
        $movies_query = new WP_Query(array(
            'post_type'      => 'movies',
            'posts_per_page' => -1, // shfaq të gjitha
        ));

        if($movies_query->have_posts()) :
            while($movies_query->have_posts()) : $movies_query->the_post(); ?>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if(has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', array('class'=>'card-img-top img-fluid')); ?>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                <?php the_title(); ?>
                            </a>
                        </h5>
                        <p class="card-text"><?php the_excerpt(); ?></p>
                    </div>
                    <div class="card-footer text-muted small">
                        Posted on <?php echo get_the_date(); ?>
                    </div>
                </div>
            </div>

        <?php
            endwhile;
            wp_reset_postdata();
        else : ?>
            <div class="col-12">
                <p class="alert alert-info">No movies found.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>