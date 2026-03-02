<?php get_header(); ?>

<div class="bg-primary text-white text-center py-5 mb-5">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to My Blog</h1>
        <p class="lead">Bootstrap 5 is officially integrated and working!</p>
        <a href="#main-content" class="btn btn-outline-light btn-lg mt-3">View Posts</a>
    </div>
</div>

<div id="main-content" class="container">
    <div class="row">

        <!-- MAIN CONTENT -->
        <div class="col-lg-8">
            <?php if ( have_posts() ) : ?>
                <div class="row">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm h-100">

                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail(
                                        'medium_large',
                                        array( 'class' => 'card-img-top img-fluid' )
                                    ); ?>
                                <?php endif; ?>

                                <div class="card-body">
                                    <h2 class="card-title h4">
                                        <a href="<?php the_permalink(); ?>" class="text-decoration-none text-dark">
                                            <?php the_title(); ?>
                                        </a>
                                    </h2>

                                    <p class="card-text text-muted small">
                                        Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?>
                                    </p>

                                    <div class="card-text mb-3">
                                        <?php the_excerpt(); ?>
                                    </div>

                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">
                                        Read More
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center my-4">
                    <?php the_posts_pagination( array(
                        'mid_size'  => 2,
                        'prev_text' => '« Previous',
                        'next_text' => 'Next »',
                    ) ); ?>
                </div>

            <?php else : ?>
                <div class="alert alert-info">
                    No posts found.
                </div>
            <?php endif; ?>
        </div>

        <!-- SIDEBAR -->
        <div class="col-lg-4">
            <?php get_sidebar( 'primary' ); ?>
        </div>

    </div>
</div>

<?php get_footer(); ?>