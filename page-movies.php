<?php
/* Template Name: Movies Archive */
get_header();

// Get featured movie for hero
$featured_args = array(
    'post_type' => 'movies',
    'posts_per_page' => 1,
    'orderby' => 'rand',
);
$featured_query = new WP_Query($featured_args);
$featured_movie = $featured_query->have_posts() ? $featured_query->posts[0] : null;
wp_reset_postdata();
?>

<!-- Hero Section -->
<div class=\"movies-hero\" <?php if ($featured_movie && has_post_thumbnail($featured_movie->ID)) { 
    echo 'style=\"background-image: url(' . get_the_post_thumbnail_url($featured_movie->ID, 'movie-hero') . ');\"';
} ?>>
    <div class=\"hero-background\" <?php if ($featured_movie && has_post_thumbnail($featured_movie->ID)) { 
        echo 'style=\"background-image: url(' . get_the_post_thumbnail_url($featured_movie->ID, 'movie-hero') . ');\"';
    } ?>></div>
    <div class=\"hero-overlay\"></div>
    <div class=\"hero-content\">
        <h1 class=\"hero-title\">?? Discover Great Movies</h1>
        <p class=\"hero-subtitle\">Explore our premium collection of films</p>
    </div>
</div>

<div class=\"movies-container\">
    <!-- Title -->
    <h2 class=\"page-title\">Our Movie Collection</h2>
    <p class=\"page-subtitle\">Browse through our curated selection of films</p>
    
    <!-- Search & Filter Controls -->
    <div class=\"movies-controls\">
        <div class=\"search-bar\">
            <input type=\"text\" class=\"search-input\" id=\"movieSearch\" placeholder=\"Search movies, actors, genres...\">
        </div>
        
        <div class=\"filter-buttons\" id=\"genreFilters\">
            <button class=\"filter-btn active\" data-genre=\"all\">All Genres</button>
            <?php
            $genres = get_terms(array(
                'taxonomy' => 'movie_genres',
                'hide_empty' => false,
            ));
            
            if (!empty($genres) && !is_wp_error($genres)) {
                foreach ($genres as $genre) {
                    echo '<button class=\"filter-btn\" data-genre=\"' . esc_attr($genre->slug) . '\">' . esc_html($genre->name) . '</button>';
                }
            }
            ?>
        </div>
    </div>
    
    <!-- Movies Grid -->
    <div class=\"movies-grid\" id=\"moviesGrid\">
        <?php
        $args = array(
            'post_type' => 'movies',
            'posts_per_page' => 12,
            'orderby' => 'date',
            'order' => 'DESC',
            'post_status' => 'publish',
        );
        
        $movies_query = new WP_Query($args);
        
        if ($movies_query->have_posts()) {
            while ($movies_query->have_posts()) {
                $movies_query->the_post();
                $movie_id = get_the_ID();
                $imdb_rating = get_post_meta($movie_id, '_movie_imdb_rating', true) ?: 0;
                $badge = get_post_meta($movie_id, '_movie_badge', true);
                $genres = wp_get_post_terms($movie_id, 'movie_genres', array('fields' => 'names'));
                
                // Generate star rating
                $stars = '';
                $rating = (float)$imdb_rating;
                for ($i = 0; $i < 5; $i++) {
                    if ($rating >= $i + 1) {
                        $stars .= '?';
                    } elseif ($rating > $i && $rating < $i + 1) {
                        $stars .= '?';
                    } else {
                        $stars .= '?';
                    }
                }
                ?>
                <div class=\"movie-card\">
                    <!-- Poster Image -->
                    <div class=\"movie-poster-wrapper\">
                        <?php if (has_post_thumbnail()) { ?>
                            <?php the_post_thumbnail('movie-card', array('class' => 'movie-poster')); ?>
                        <?php } else { ?>
                            <div class=\"movie-poster\" style=\"display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; font-size: 3rem;\">??</div>
                        <?php } ?>
                        
                        <?php if ($badge) { ?>
                            <span class=\"movie-badge\"><?php echo esc_html($badge); ?></span>
                        <?php } ?>
                    </div>
                    
                    <!-- Movie Info -->
                    <div class=\"movie-info\">
                        <h3 class=\"movie-title\"><?php the_title(); ?></h3>
                        
                        <!-- Genres -->
                        <?php if (!empty($genres)) { ?>
                            <div class=\"movie-genres\">
                                <?php foreach ($genres as $genre) { ?>
                                    <span class=\"genre-tag\"><?php echo esc_html($genre); ?></span>
                                <?php } ?>
                            </div>
                        <?php } ?>
                        
                        <!-- Rating -->
                        <?php if ($imdb_rating) { ?>
                            <div class=\"movie-rating\">
                                <span class=\"rating-stars\"><?php echo $stars; ?></span>
                                <span><?php echo esc_html(number_format($imdb_rating, 1)); ?>/10</span>
                            </div>
                        <?php } ?>
                        
                        <!-- Excerpt -->
                        <p class=\"movie-excerpt\"><?php echo wp_trim_words(get_the_excerpt(), 18, '...'); ?></p>
                        
                        <!-- Action Buttons -->
                        <div class=\"movie-footer\">
                            <a href=\"<?php the_permalink(); ?>\" class=\"btn-watch\">
                                <span>?</span> View Details
                            </a>
                            <button class=\"btn-bookmark\" title=\"Add to Watchlist\">?</button>
                        </div>
                    </div>
                </div>
                <?php
            }
            wp_reset_postdata();
        } else {
            ?>
            <div class=\"no-movies\" style=\"grid-column: 1 / -1;\">
                <div class=\"no-movies-icon\">??</div>
                <h3>No movies found</h3>
                <p>Add movies in the WordPress admin to get started!</p>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php
get_footer();
?>

<script>
jQuery(document).ready(function($) {
    // Filter by genre
    #genreFilters.on('click', '.filter-btn', function() {
        #genreFilters .filter-btn.removeClass('active');
        $(this).addClass('active');
        
        const selectedGenre = $(this).data('genre');
        console.log('Filter by genre:', selectedGenre);
    });
    
    // Simple search filter
    #movieSearch.on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        
        .movie-card.each(function() {
            const title = $(this).find('.movie-title').text().toLowerCase();
            const excerpt = $(this).find('.movie-excerpt').text().toLowerCase();
            const genres = $(this).find('.genre-tag').text().toLowerCase();
            
            if (title.includes(searchTerm) || excerpt.includes(searchTerm) || genres.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
    
    // Bookmark functionality
    .btn-bookmark.on('click', function(e) {
        e.preventDefault();
        $(this).toggleClass('active');
        $(this).text($(this).hasClass('active') ? '?' : '?');
    });
});
</script>
