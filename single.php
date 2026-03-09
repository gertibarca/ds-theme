<?php get_header(); ?>

<div class="single-container">
    <main class="single-main">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <article class="single-post">

            <!-- Title -->
            <h1 class="post-title"><?php the_title(); ?></h1>

            <!-- Meta info -->
            <p class="post-meta">
                Posted on <?php echo get_the_date(); ?> by <?php echo get_the_author(); ?>
            </p>

            <!-- Featured image -->
            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>

            <!-- Categories -->
            <p class="post-categories">
                <strong>Categories:</strong> <?php the_category(', '); ?>
            </p>

            <!-- Tags -->
            <p class="post-tags">
                <strong>Tags:</strong> <?php the_tags('', ', ', ''); ?>
            </p>

            <!-- Content -->
            <div class="post-content">
                <?php the_content(); ?>
            </div>

            <!-- Edit link -->
            <div class="post-edit">
                <?php edit_post_link('Edit Post'); ?>
            </div>

        </article>

        <!-- Comments -->
        <div class="comments-section">
            <?php comments_template(); ?>
        </div>

        <?php endwhile; endif; ?>
    </main>

    <!-- Sidebar -->
    <aside class="single-sidebar">
        <?php get_sidebar(); ?>
    </aside>
</div>

<?php get_footer(); ?>