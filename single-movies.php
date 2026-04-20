<?php get_header(); ?>

<div class="movie-hero">
    <?php if(has_post_thumbnail()): ?>
        <div class="movie-bg">
            <?php the_post_thumbnail('full'); ?>
        </div>
    <?php endif; ?>

    <div class="movie-overlay"></div>

    <div class="movie-content container">
        <h1><?php the_title(); ?></h1>

        <div class="movie-meta">
            <span><?php echo get_the_date(); ?></span>
            <span>⭐ <?php echo get_post_meta(get_the_ID(), 'rating', true); ?>/10</span>
        </div>

        <div class="movie-description">
            <?php the_content(); ?>
        </div>

        <div class="movie-actions">
            <a href="#" class="btn btn-danger">▶ Watch Trailer</a>
            <a href="#" class="btn btn-outline-light">+ Add to List</a>
        </div>
    </div>
</div>
<a href="#" class="btn btn-danger watch-trailer" 
   data-trailer="<?php echo get_post_meta(get_the_ID(), 'trailer_url', true); ?>">
   ▶ Watch Trailer
</a>

<?php get_footer(); ?>