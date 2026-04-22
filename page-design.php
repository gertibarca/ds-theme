<?php
/* Template Name: Movie Design Page */
get_header();
?>

<style>
.hero-section { background: linear-gradient(135deg, #000, #1c1c1c); color: #fff; padding: 80px 20px; border-radius: 20px; text-align: center; }
.filter-btn { border-radius: 50px; padding: 8px 18px; transition: 0.3s; }
.filter-btn:hover { transform: scale(1.05); }
.movie-card { border-radius: 20px; overflow: hidden; transition: 0.3s; }
.movie-card:hover { transform: translateY(-8px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }
.movie-card img { height: 250px; object-fit: cover; }
.badge-custom { background: #000; color: #fff; margin-right: 5px; }
</style>

<div class="container py-5">
    <div class="hero-section mb-5">
        <h1 class="fw-bold">🎬 Explore Movies</h1>
        <p class="text-light">Discover, filter and enjoy your favorite movies</p>
    </div>

    <?php
    $genres = get_terms([ 'taxonomy' => 'movie_genres', 'hide_empty' => true ]);
    $current_genre = isset($_GET['genre']) ? $_GET['genre'] : 'all';
    ?>

    <div class="text-center mb-5">
        <a href="?genre=all" class="btn filter-btn <?php echo ($current_genre=='all')?'btn-dark':'btn-outline-dark'; ?>">All</a>
        <?php foreach($genres as $genre): ?>
            <a href="?genre=<?php echo $genre->slug; ?>" class="btn filter-btn <?php echo ($current_genre==$genre->slug)?'btn-dark':'btn-outline-dark'; ?>">
              <?php echo $genre->name; ?>
            </a>
        <?php endforeach; ?>
    </div>

    <?php
    $args = [ 'post_type' => 'movies', 'posts_per_page' => -1 ];
    if($current_genre != 'all'){
        $args['tax_query'] = [ [ 'taxonomy' => 'movie_genres', 'field' => 'slug', 'terms' => $current_genre ] ];
    }
    $query = new WP_Query($args);
    ?>

    <div class="row g-4">
        <?php if($query->have_posts()): while($query->have_posts()): $query->the_post(); ?>
            <div class="col-md-4">
                <div class="card movie-card">
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('medium', ['class'=>'w-100']); ?>
                    <?php endif; ?>
                    <div class="p-3">
                        <h5><a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none"><?php the_title(); ?></a></h5>
                        <p class="text-muted small"><?php echo wp_trim_words(get_the_excerpt(), 12); ?></p>
                        <div class="mb-2">
                            <?php 
                            $terms = get_the_terms(get_the_ID(), 'movie_genres');
                            if($terms){ foreach($terms as $t){ echo '<span class="badge badge-custom">'.$t->name.'</span>'; } }
                            ?>
                        </div>
                        <div>
                            <?php 
                            $tags = get_the_terms(get_the_ID(), 'post_tag');
                            if($tags){ foreach($tags as $tag){ echo '<span class="badge bg-secondary">'.$tag->name.'</span> '; } }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(); else: ?>
           <p>No movies found.</p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>