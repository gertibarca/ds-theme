<div class="movie-card">

    <?php if(has_post_thumbnail()): ?>
        <?php the_post_thumbnail('medium', ['class'=>'w-100']); ?>
    <?php endif; ?>

    <div class="p-3">
        <h5>
            <a href="<?php the_permalink(); ?>" class="text-white text-decoration-none">
                <?php the_title(); ?>
            </a>
        </h5>

        <p class="text-muted small">
            ⭐ <?php echo get_post_meta(get_the_ID(), 'rating', true); ?>/10
        </p>
    </div>

</div>