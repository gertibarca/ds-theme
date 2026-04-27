<?php 
// If this is a movies archive, load the proper archive template
if (is_post_type_archive('movies')) {
    locate_template('archive-movies.php', true);
    exit;
}

get_header(); 
?>

<?php 
// Get featured movie (latest)
$featured_query = new WP_Query(array(
    'post_type'      => 'movies',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC'
));

if($featured_query->have_posts()) : 
    $featured_query->the_post();
    $featured_id = get_the_ID();
    $youtube_url = get_post_meta($featured_id, '_movie_youtube_url', true);
    $rating = get_post_meta($featured_id, '_movie_rating', true);
    $duration = get_post_meta($featured_id, '_movie_duration', true);
    $year = get_post_meta($featured_id, '_movie_year', true);
?>
<div class="featured-hero" <?php if(has_post_thumbnail()) echo 'style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.7)), url(' . get_the_post_thumbnail_url($featured_id, 'full') . '); background-size: cover; background-position: center;"'; ?>>
    <div class="featured-content">
        <h2 class="featured-badge">Featured Now</h2>
        <h1 class="featured-title"><?php the_title(); ?></h1>
        <p class="featured-description"><?php echo wp_trim_words(get_the_excerpt(), 35); ?></p>
        <?php if(get_the_term_list($featured_id, 'movie_genres', '', ' • ')) : ?>
            <p class="featured-genres">
                <strong>Genres:</strong> <?php echo get_the_term_list($featured_id, 'movie_genres', '', ' • '); ?>
                <?php if($year) echo " • <strong>Year:</strong> $year"; ?>
                <?php if($duration) echo " • <strong>Duration:</strong> {$duration} min"; ?>
                <?php if($rating) echo " • <strong>Rating:</strong> $rating/10"; ?>
            </p>
        <?php endif; ?>
        <div class="featured-buttons">
            <?php if($youtube_url): ?>
                <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" class="btn btn-play">▶ Watch Now</a>
            <?php endif; ?>
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#movieModal<?php echo $featured_id; ?>">+ More Info & Preview</button>
        </div>
    </div>
</div>

<!-- Featured Movie Modal -->
<div class="modal fade" id="movieModal<?php echo $featured_id; ?>" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php the_title(); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- YouTube Video Embed -->
                <?php if($youtube_url && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $youtube_url, $matches)): 
                    $video_id = $matches[1];
                ?>
                    <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(229, 9, 20, 0.3);">
                        <iframe 
                            width="100%" 
                            height="500" 
                            src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" 
                            title="<?php the_title(); ?>" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            style="border-radius: 12px;">
                        </iframe>
                    </div>
                <?php elseif(has_post_thumbnail()): ?>
                    <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(229, 9, 20, 0.3);">
                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 12px; display: block;')); ?>
                    </div>
                <?php endif; ?>

                <p><strong style="font-size: 16px; color: #e50914;">Plot:</strong></p>
                <p style="line-height: 1.8; color: rgba(255,255,255,0.85);"><?php the_content(); ?></p>
                
                <?php if($rating): ?>
                    <p><strong style="color: #e50914;">Rating:</strong> <span class="stars">★★★★★</span> <?php echo $rating; ?>/10</p>
                <?php endif; ?>
                
                <?php if($duration || $year): ?>
                    <p>
                        <strong style="color: #e50914;">Details:</strong> 
                        <?php if($year) echo "Released <strong>" . esc_html($year) . "</strong>"; ?>
                        <?php if($duration) echo " • Duration: <strong>{$duration} minutes</strong>"; ?>
                    </p>
                <?php endif; ?>
                
                <p><strong style="color: #e50914;">Genres:</strong> <?php echo get_the_term_list($featured_id, 'movie_genres', '', ', '); ?></p>
                
                <?php if($youtube_url): ?>
                    <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" class="btn btn-play" style="margin-top: 20px; display: inline-block;">▶ Watch Full Movie on YouTube</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php wp_reset_postdata(); endif; ?>

<div class="movies-section">
    <div class="container-fluid">
        <!-- Genre Filters -->
        <div class="genre-filters">
            <h3 class="filters-title">Browse by Genre</h3>
            <div class="filter-buttons">
                <button class="filter-btn active" data-genre="all">All Movies</button>
                <?php 
                $genres = get_terms(array(
                    'taxonomy' => 'movie_genres',
                    'hide_empty' => true,
                ));
                if(!empty($genres) && !is_wp_error($genres)):
                    foreach($genres as $genre):
                ?>
                <button class="filter-btn" data-genre="<?php echo $genre->slug; ?>">
                    <?php echo $genre->name; ?>
                </button>
                <?php endforeach; endif; ?>
            </div>
        </div>

        <!-- All Movies Grid -->
        <div id="all-movies" class="all-movies-section">
            <h2 class="section-title">All Movies</h2>
            
            <?php 
            $movies_query = new WP_Query(array(
                'post_type'      => 'movies',
                'posts_per_page' => -1,
                'orderby'        => 'date',
                'order'          => 'DESC'
            ));

            if($movies_query->have_posts()) : ?>
                <div class="movies-grid">
                    <?php while($movies_query->have_posts()) : $movies_query->the_post(); 
                        $movie_id = get_the_ID();
                        $movie_genres = wp_get_post_terms($movie_id, 'movie_genres', array('fields'=>'slugs'));
                        $genre_classes = implode(' ', $movie_genres);
                        $yt_url = get_post_meta($movie_id, '_movie_youtube_url', true);
                        $mov_rating = get_post_meta($movie_id, '_movie_rating', true);
                        $mov_duration = get_post_meta($movie_id, '_movie_duration', true);
                        $mov_year = get_post_meta($movie_id, '_movie_year', true);
                    ?>
                        <div class="movie-card movie-item <?php echo esc_attr($genre_classes); ?>" data-genres="<?php echo esc_attr($genre_classes); ?>">
                            <div class="movie-card-image">
                                <?php 
                                // Display featured image or YouTube thumbnail
                                if(has_post_thumbnail()) : 
                                ?>
                                    <?php the_post_thumbnail('medium', array('class'=>'card-img', 'alt' => get_the_title())); ?>
                                <?php 
                                elseif($yt_url && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $yt_url, $matches)): 
                                    $video_id = $matches[1];
                                ?>
                                    <img src="https://img.youtube.com/vi/<?php echo esc_attr($video_id); ?>/maxresdefault.jpg" alt="<?php echo esc_attr(get_the_title()); ?>" class="card-img" style="width: 100%; height: 100%; object-fit: cover;">
                                <?php else: ?>
                                    <div class="placeholder-image">
                                        <span style="font-size: 48px;">🎬</span>
                                        <p><?php echo esc_html(get_the_title()); ?></p>
                                    </div>
                                <?php endif; ?>
                                <div class="card-overlay">
                                    <?php if($yt_url): ?>
                                        <a href="<?php echo esc_url($yt_url); ?>" target="_blank" class="play-button" title="Watch on YouTube">▶</a>
                                    <?php else: ?>
                                        <button class="play-button" onclick="event.preventDefault();" data-bs-toggle="modal" data-bs-target="#movieModal<?php echo $movie_id; ?>" style="cursor: pointer;" title="View Details">ℹ</button>
                                    <?php endif; ?>
                                </div>
                                <?php if($mov_year): ?>
                                    <div style="position: absolute; top: 10px; right: 10px; background: rgba(229, 9, 20, 0.9); color: white; padding: 5px 10px; border-radius: 4px; font-size: 12px; font-weight: 600; z-index: 3;">
                                        <?php echo esc_html($mov_year); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="movie-card-content">
                                <h3 class="movie-title"><?php the_title(); ?></h3>
                                <p class="movie-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                                <?php if(!empty($movie_genres)) : ?>
                                    <p class="movie-genres">
                                        <?php echo get_the_term_list($movie_id, 'movie_genres', '', ', '); ?>
                                    </p>
                                <?php endif; ?>
                                <div class="movie-rating">
                                    <span class="stars">★★★★★</span>
                                    <?php if($mov_rating): ?>
                                        <span class="rating-value"><?php echo $mov_rating; ?>/10</span>
                                    <?php endif; ?>
                                </div>
                                <button class="view-details" data-bs-toggle="modal" data-bs-target="#movieModal<?php echo $movie_id; ?>">View Details →</button>
                            </div>
                        </div>

                        <!-- Movie Modal -->
                        <div class="modal fade" id="movieModal<?php echo $movie_id; ?>" tabindex="-1">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><?php the_title(); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <!-- YouTube Video Embed -->
                                        <?php if($yt_url && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $yt_url, $matches)): 
                                            $video_id = $matches[1];
                                        ?>
                                            <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(229, 9, 20, 0.3);">
                                                <iframe 
                                                    width="100%" 
                                                    height="400" 
                                                    src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" 
                                                    title="<?php the_title(); ?>" 
                                                    frameborder="0" 
                                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                                    allowfullscreen
                                                    style="border-radius: 12px;">
                                                </iframe>
                                            </div>
                                        <?php elseif(has_post_thumbnail()): ?>
                                            <div style="margin-bottom: 30px; border-radius: 12px; overflow: hidden; box-shadow: 0 8px 24px rgba(229, 9, 20, 0.3);">
                                                <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; border-radius: 12px; display: block;')); ?>
                                            </div>
                                        <?php endif; ?>

                                        <p><strong style="font-size: 16px; color: #e50914;">Plot:</strong></p>
                                        <p style="line-height: 1.8; color: rgba(255,255,255,0.85);"><?php the_content(); ?></p>
                                        
                                        <?php if($mov_rating): ?>
                                            <p><strong style="color: #e50914;">Rating:</strong> <span class="stars">★★★★★</span> <?php echo $mov_rating; ?>/10</p>
                                        <?php endif; ?>
                                        
                                        <?php if($mov_duration || $mov_year): ?>
                                            <p>
                                                <strong style="color: #e50914;">Details:</strong> 
                                                <?php if($mov_year) echo "Released <strong>" . esc_html($mov_year) . "</strong>"; ?>
                                                <?php if($mov_duration) echo " • Duration: <strong>{$mov_duration} minutes</strong>"; ?>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <p><strong style="color: #e50914;">Genres:</strong> <?php echo get_the_term_list($movie_id, 'movie_genres', '', ', '); ?></p>
                                        
                                        <?php if($yt_url): ?>
                                            <a href="<?php echo esc_url($yt_url); ?>" target="_blank" class="btn btn-play" style="margin-top: 20px; display: inline-block;">▶ Watch Full Movie on YouTube</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>
                </div>
            <?php wp_reset_postdata(); else : ?>
                <div class="alert alert-info">No movies found.</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($){
    $('.filter-btn').click(function(){
        var genre = $(this).data('genre');
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
        
        if(genre === 'all'){
            $('.movie-item').fadeIn();
        } else {
            $('.movie-item').fadeOut();
            $('.movie-item[data-genres*="' + genre + '"]').fadeIn();
        }
    });
});
</script>

<?php get_footer(); ?>