<?php get_header(); ?>

<?php 
$movie_id = get_the_ID();
$youtube_url = get_post_meta($movie_id, '_movie_youtube_url', true);
$rating = get_post_meta($movie_id, '_movie_rating', true);
$duration = get_post_meta($movie_id, '_movie_duration', true);
$year = get_post_meta($movie_id, '_movie_year', true);
$embed_url = $youtube_url ? ds_get_youtube_embed_url($youtube_url) : false;
?>

<div class="single-movie-container">
    <div class="container-fluid" style="max-width: 1400px; margin: 0 auto; padding: 20px;">
        
        <!-- Back Button -->
        <div style="margin-top: 80px; margin-bottom: 30px;">
            <a href="<?php echo home_url('/'); ?>" class="btn" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); padding: 10px 20px; border-radius: 8px; text-decoration: none; color: #fff; display: inline-flex; align-items: center; gap: 8px; transition: all 0.3s ease;">
                ← Back to Home
            </a>
        </div>

        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- YouTube Video Section -->
                <?php if($embed_url): ?>
                    <div class="youtube-container" style="margin-bottom: 40px; border-radius: 12px; overflow: hidden; box-shadow: 0 16px 48px rgba(229, 9, 20, 0.3);">
                        <iframe 
                            width="100%" 
                            height="600" 
                            src="<?php echo esc_url($embed_url); ?>" 
                            title="<?php the_title(); ?>" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen
                            style="border-radius: 12px;">
                        </iframe>
                    </div>
                <?php elseif(has_post_thumbnail()): ?>
                    <div style="margin-bottom: 40px; border-radius: 12px; overflow: hidden; box-shadow: 0 16px 48px rgba(229, 9, 20, 0.3);">
                        <?php the_post_thumbnail('large', array('style' => 'width: 100%; height: auto; display: block; border-radius: 12px;')); ?>
                    </div>
                <?php endif; ?>

                <!-- Movie Title & Meta -->
                <div style="margin-bottom: 30px; padding: 30px; background: rgba(30,30,30,0.8); border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                    <h1 style="font-size: 42px; font-weight: 800; margin-bottom: 15px;">
                        <?php the_title(); ?>
                    </h1>

                    <!-- Metadata Row -->
                    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px; font-size: 16px; color: rgba(255,255,255,0.8);">
                        <?php if($year): ?>
                            <div>
                                <strong style="color: #e50914;">Year:</strong> <?php echo esc_html($year); ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if($duration): ?>
                            <div>
                                <strong style="color: #e50914;">Duration:</strong> <?php echo esc_html($duration); ?> minutes
                            </div>
                        <?php endif; ?>

                        <?php if($rating): ?>
                            <div>
                                <strong style="color: #e50914;">Rating:</strong> 
                                <span class="stars" style="color: #ffc107; font-size: 16px;">★★★★★</span>
                                <?php echo esc_html($rating); ?>/10
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Genres -->
                    <?php if(get_the_term_list($movie_id, 'movie_genres', '', ', ')): ?>
                        <div style="margin-bottom: 20px;">
                            <strong style="color: #e50914;">Genres:</strong>
                            <div style="margin-top: 8px; display: flex; gap: 8px; flex-wrap: wrap;">
                                <?php 
                                $genres = get_the_terms($movie_id, 'movie_genres');
                                if($genres && !is_wp_error($genres)):
                                    foreach($genres as $genre):
                                        echo '<span style="background: rgba(229, 9, 20, 0.2); border: 1px solid #e50914; color: #e50914; padding: 6px 14px; border-radius: 20px; font-size: 14px; font-weight: 600;">' . esc_html($genre->name) . '</span>';
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Tags -->
                    <?php if(get_the_tag_list('', ', ')): ?>
                        <div>
                            <strong style="color: #e50914;">Tags:</strong>
                            <div style="margin-top: 8px;">
                                <?php echo get_the_tag_list('<span style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.8); padding: 6px 12px; border-radius: 6px; font-size: 13px; margin-right: 8px; display: inline-block;">', '</span><span style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: rgba(255,255,255,0.8); padding: 6px 12px; border-radius: 6px; font-size: 13px; margin-right: 8px; display: inline-block;">', '</span>'); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Movie Description -->
                <div style="padding: 30px; background: rgba(30,30,30,0.8); border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px); margin-bottom: 30px;">
                    <h2 style="font-size: 24px; font-weight: 700; margin-bottom: 15px; color: #fff;">Plot</h2>
                    <div style="font-size: 16px; line-height: 1.8; color: rgba(255,255,255,0.85);">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- CTA Button -->
                <?php if($youtube_url): ?>
                    <div style="text-align: center; margin-bottom: 30px;">
                        <a href="<?php echo esc_url($youtube_url); ?>" target="_blank" class="btn btn-play" style="padding: 16px 40px; font-size: 18px; text-transform: uppercase; letter-spacing: 1px;">
                            ▶ Watch Full Movie on YouTube
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Quick Info Box -->
                <div style="background: linear-gradient(135deg, rgba(229, 9, 20, 0.2), rgba(255, 107, 107, 0.1)); border: 1px solid rgba(229, 9, 20, 0.3); border-radius: 12px; padding: 25px; margin-bottom: 30px; backdrop-filter: blur(10px);">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #fff;">Quick Info</h3>
                    
                    <div style="margin-bottom: 15px;">
                        <strong style="color: #e50914; display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Release Year</strong>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85);"><?php echo $year ? esc_html($year) : 'Not specified'; ?></span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <strong style="color: #e50914; display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Duration</strong>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85);"><?php echo $duration ? esc_html($duration) . ' minutes' : 'Not specified'; ?></span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <strong style="color: #e50914; display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Rating</strong>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85);">
                            <span class="stars" style="color: #ffc107;">★★★★★</span> 
                            <?php echo $rating ? esc_html($rating) . '/10' : 'Not rated'; ?>
                        </span>
                    </div>

                    <div style="margin-bottom: 15px;">
                        <strong style="color: #e50914; display: block; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Primary Genre</strong>
                        <span style="font-size: 16px; color: rgba(255,255,255,0.85);">
                            <?php 
                            $genre = get_the_terms($movie_id, 'movie_genres');
                            echo !is_wp_error($genre) && !empty($genre) ? esc_html($genre[0]->name) : 'Not specified';
                            ?>
                        </span>
                    </div>
                </div>

                <!-- Featured Image as Poster -->
                <?php if(has_post_thumbnail()): ?>
                    <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 12px 36px rgba(229, 9, 20, 0.3); margin-bottom: 30px;">
                        <?php the_post_thumbnail('medium', array('style' => 'width: 100%; height: auto; display: block; border-radius: 12px;')); ?>
                    </div>
                <?php endif; ?>

                <!-- Related Movies -->
                <?php 
                $related_args = array(
                    'post_type' => 'movies',
                    'posts_per_page' => 4,
                    'post__not_in' => array($movie_id),
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'movie_genres',
                            'field' => 'term_id',
                            'terms' => wp_get_post_terms($movie_id, 'movie_genres', array('fields' => 'ids')),
                        )
                    )
                );

                $related_query = new WP_Query($related_args);
                
                if($related_query->have_posts()): ?>
                    <div style="background: rgba(30,30,30,0.8); border-radius: 12px; padding: 25px; border: 1px solid rgba(255,255,255,0.1); backdrop-filter: blur(10px);">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #fff;">Related Movies</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <?php while($related_query->have_posts()): $related_query->the_post(); ?>
                                <div style="display: flex; gap: 12px; cursor: pointer; padding: 12px; border-radius: 8px; transition: all 0.3s ease; background: rgba(255,255,255,0.05);" onmouseover="this.style.background='rgba(229, 9, 20, 0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                                    <?php if(has_post_thumbnail()): ?>
                                        <div style="width: 50px; height: 75px; border-radius: 6px; overflow: hidden; flex-shrink: 0;">
                                            <?php the_post_thumbnail('thumbnail', array('style' => 'width: 100%; height: 100%; object-fit: cover;')); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div style="flex: 1;">
                                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: #fff; font-weight: 600; display: block; margin-bottom: 4px;">
                                            <?php the_title(); ?>
                                        </a>
                                        <small style="color: rgba(255,255,255,0.6);">
                                            <?php echo wp_trim_words(get_the_excerpt(), 8); ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php wp_reset_postdata(); 
                endif; ?>
            </div>
        </div>

    </div>
</div>

<style>
    .single-movie-container {
        min-height: 100vh;
        background: linear-gradient(135deg, #0f0f0f 0%, #1a1a2e 100%);
    }

    .youtube-container iframe {
        aspect-ratio: 16/9;
    }

    @media (max-width: 768px) {
        .single-movie-container {
            padding: 0;
        }
    }
</style>

<?php get_footer(); ?>