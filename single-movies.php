<?php get_header(); ?>

<div class="container my-5">
    <?php if(have_posts()) : while(have_posts()) : the_post(); ?>
        <article class="card p-4 mb-4 shadow-sm">
            <h1 class="card-title"><?php the_title(); ?></h1>
            
            <?php if(has_post_thumbnail()) : ?>
                <div class="mb-3">
                    <?php the_post_thumbnail('large', array('class'=>'img-fluid rounded')); ?>
                </div>
            <?php endif; ?>

            <div class="card-text">
                <?php the_content(); ?>
            </div>

            <p class="text-muted mt-3">
                Posted on <?php echo get_the_date(); ?>
            </p>
        </article>
    <?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>