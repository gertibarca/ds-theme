<?php get_header(); ?>

<div class="wrap">

    <div id="primary" class="content-area">
        <main id="main" class="site-main"> 

            <h1>
                Search Results for: "<?php echo get_search_query(); ?>"
            </h1>

            <?php if ( have_posts() ) : ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <article id="post-<?php the_ID(); ?>">

                        <h2>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h2>

                        <p>
                            <?php the_excerpt(); ?>
                        </p>

                    </article>

                <?php endwhile; ?>

            <?php else : ?>

                <p>No results found. Please try another search.</p>

                <?php get_search_form(); ?>

            <?php endif; ?>

        </main>
    </div>

</div>

<?php get_footer(); ?>