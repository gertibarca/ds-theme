<?php get_header(); ?>

<div class="single-container">
    <main class="single-main">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <article class="single-post">
            <h1 class="post-title"><?php the_title(); ?></h1>
            <p class="post-meta">
                Posted on <?php echo get_the_date(); ?> by <?php echo get_the_author(); ?>
            </p>
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            <p class="post-categories">
                <strong>Categories:</strong> <?php the_category(', '); ?>
            </p>
            <p class="post-tags">
                <strong>Tags:</strong> <?php the_tags('', ', ', ''); ?>
            </p>
            <div class="post-content">
               <?php the_content(); ?>
           </div>
            <div class="post-edit">
               <?php edit_post_link('Edit Post'); ?>
           </div>
       </article>
        <div class="comments-section">
            <?php comments_template(); ?>
        </div>
        <?php endwhile; endif; ?>
    </main>
    <aside class="single-sidebar">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>