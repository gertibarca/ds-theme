<?php
/*
Template Name: Movie Design Page
*/
get_header();
?>

<style>
    /* Përmirësimi i trupit për dark mode */
    body { background-color: #0f0f0f; color: #fff; }

    /* HERO */
    .hero-section {
        background: linear-gradient(135deg, #111, #333), 
                    url('https://via.placeholder.com/1200x400') center/cover;
        color: #fff;
        padding: 100px 20px;
        border-radius: 24px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
    }

    /* BUTTONS */
    .filter-btn {
        border-radius: 50px;
        padding: 10px 25px;
        transition: 0.3s;
        border: 2px solid #333;
        font-weight: 500;
        margin: 5px;
    }

    .filter-btn:hover, .filter-btn.active {
        transform: translateY(-3px);
        background-color: #fff !important;
        color: #000 !important;
        border-color: #fff;
    }

    /* MOVIE CARD */
    .movie-card {
        background: #1c1c1c;
        border: none;
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        height: 100%;
    }

    .movie-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.4);
    }

    .movie-card img {
        height: 300px;
        object-fit: cover;
        transition: 0.5s;
    }

    .movie-card:hover img {
        transform: scale(1.05);
    }

    /* BADGES */
    .badge-custom {
        background: #e50914; /* Ngjyrë "Netflix Red" për zhanret */
        color: #fff;
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 0.75rem;
        margin-right: 5px;
    }

    .tag-custom {
        background: #333;
        color: #bbb;
        font-size: 0.7rem;
        margin-right: 4px;
    }

    .card-title a {
        color: #fff;
        transition: 0.3s;
    }

    .card-title a:hover {
        color: #e50914;
    }
</style>

<div class="container py-5">

    <div class="hero-section mb-5">
        <h1 class="display-4 fw-bold">🎬 Explore Movies</h1>
        <p class="lead text-light opacity-75">Discover, filter and enjoy your favorite movies</p>
    </div>

    <?php
    $genres = get_terms([
        'taxonomy' => 'movie_genres',
        'hide_empty' => true,
    ]);

    $current_genre = isset($_GET['genre']) ? sanitize_text_field($_GET['genre']) : 'all';
    ?>

    <div class="text-center mb-5">
        <a href="?genre=all" class="btn filter-btn <?php echo ($current_genre == 'all') ? 'btn-light active' : 'btn-outline-light'; ?>">All</a>

        <?php if (!empty($genres) && !is_wp_error($genres)): ?>
            <?php foreach($genres as $genre): ?>
                <a href="?genre=<?php echo esc_attr($genre->slug); ?>"
                   class="btn filter-btn <?php echo ($current_genre == $genre->slug) ? 'btn-light active' : 'btn-outline-light'; ?>">
                   <?php echo esc_html($genre->name); ?>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php
    $args = [
        'post_type' => 'movies',
        'posts_per_page' => 12, // Rekomandohet limit për shpejtësi
    ];

    if ($current_genre != 'all') {
        $args['tax_query'] = [
            [
                'taxonomy' => 'movie_genres',
                'field'    => 'slug',
                'terms'    => $current_genre,
            ]
        ];
    }

    $query = new WP_Query($args);
    ?>

    <div class="row g-4">
        <?php if($query->have_posts()): ?>
            <?php while($query->have_posts()): $query->the_post(); ?>

                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card movie-card h-100">
                        
                        <a href="<?php the_permalink(); ?>">
                            <?php if(has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large', ['class'=>'card-img-top w-100']); ?>
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x450?text=No+Image" class="w-100" alt="No Poster">
                            <?php endif; ?>
                        </a>

                        <div class="card-body d-flex flex-column">
                            <div class="mb-2">
                                <?php
                                $terms = get_the_terms(get_the_ID(), 'movie_genres');
                                if($terms && !is_wp_error($terms)){
                                    foreach($terms as $t){
                                        echo '<span class="badge badge-custom">'.esc_html($t->name).'</span>';
                                    }
                                }
                                ?>
                            </div>

                            <h5 class="card-title fw-bold">
                                <a href="<?php the_permalink(); ?>" class="text-decoration-none">
                                    <?php the_title(); ?>
                                </a>
                            </h5>

                            <p class="text-muted small">
                                <?php echo wp_trim_words(get_the_excerpt(), 10); ?>
                            </p>

                            <div class="mt-auto pt-2 border-top border-secondary">
                                <?php
                                $tags = get_the_terms(get_the_ID(), 'post_tag');
                                if($tags && !is_wp_error($tags)){
                                    foreach(array_slice($tags, 0, 3) as $tag){
                                        echo '<span class="badge tag-custom">#'.esc_html($tag->name).'</span>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; wp_reset_postdata(); ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h3 class="text-muted">Nuk u gjet asnjë film për këtë kategori.</h3>
            </div>
        <?php endif; ?>
    </div>
</div>
<a href="#" class="btn btn-outline-light add-to-list"
   data-id="<?php echo get_the_ID(); ?>"
   data-title="<?php the_title(); ?>">
   + Add to List
</a>

<?php get_footer(); ?>