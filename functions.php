<?php
// 1. Theme setup
function dstheme_setup() { 
    add_theme_support( 'post-thumbnails' ); 
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video' ) ); 
    add_theme_support( 'title-tag' ); 
} 
add_action( 'after_setup_theme', 'dstheme_setup' ); 

// 2. Load Styles and Scripts
function dstheme_assets() { 
    wp_enqueue_style( 'bootstrap-css',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        array(),
        '5.3.3',
        'all'
    ); 

    wp_enqueue_style( 'ds-style',
        get_stylesheet_uri(),
        array('bootstrap-css'),
        '1.0',
        'all'
    ); 

    wp_enqueue_style( 'slider-style',
        get_template_directory_uri() . '/css/slider.css',
        array('bootstrap-css'),
        '1.0',
        'all'
    ); 

    wp_enqueue_script( 'bootstrap-js',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        array(),
        '5.3.3',
        true
    );

    wp_enqueue_script( 'customjs',
        get_template_directory_uri() . '/js/custom.js',
        array( 'jquery', 'bootstrap-js' ),
        '1.0',
        true
    ); 

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
        wp_enqueue_script( 'comment-reply' ); 
    } 
} 
add_action( 'wp_enqueue_scripts', 'dstheme_assets' );

// 3. Sidebar
function themename_widgets_init() {
    register_sidebar( array(
        'name'          => 'Primary Sidebar',
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
}
add_action( 'widgets_init', 'themename_widgets_init' );

// 4. Simple Widget
class Foo_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'foo_widget',                 
            'A Foo Widget',               
            array('description' => 'Simple Hello World widget')
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        echo '<p>Gerti</p>';
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        echo '<p>No options yet.</p>';
    }

    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );

// 5. Register Custom Post Type: Movies with Tags
function ds_register_movies_cpt() {

    $labels = array(
        'name'                  => _x( 'Movies', 'Post Type General Name', 'ds-theme' ),
        'singular_name'         => _x( 'Movie', 'Post Type Singular Name', 'ds-theme' ),
        'menu_name'             => __( 'Movies', 'ds-theme' ),
        'name_admin_bar'        => __( 'Movie', 'ds-theme' ),
        'add_new'               => __( 'Add New', 'ds-theme' ),
        'add_new_item'          => __( 'Add New Movie', 'ds-theme' ),
        'edit_item'             => __( 'Edit Movie', 'ds-theme' ),
        'new_item'              => __( 'New Movie', 'ds-theme' ),
        'view_item'             => __( 'View Movie', 'ds-theme' ),
        'search_items'          => __( 'Search Movies', 'ds-theme' ),
        'not_found'             => __( 'No movies found', 'ds-theme' ),
        'not_found_in_trash'    => __( 'No movies found in Trash', 'ds-theme' ),
        'all_items'             => __( 'All Movies', 'ds-theme' ),
        'archives'              => __( 'Movie Archives', 'ds-theme' ),
        'insert_into_item'      => __( 'Insert into movie', 'ds-theme' ),
        'uploaded_to_this_item' => __( 'Uploaded to this movie', 'ds-theme' ),
        'filter_items_list'     => __( 'Filter movies list', 'ds-theme' ),
        'items_list_navigation' => __( 'Movies list navigation', 'ds-theme' ),
        'items_list'            => __( 'Movies list', 'ds-theme' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'movies' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt2',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'         => array( 'post_tag' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'movies', $args );
    register_taxonomy_for_object_type( 'post_tag', 'movies' );
}
add_action( 'init', 'ds_register_movies_cpt' );

// 6. Register Custom Taxonomy: Movie Genres
function register_taxonomy_movie_genres() {
    $labels = array(
        'name'              => _x( 'Genres', 'taxonomy general name', 'ds-theme' ),
        'singular_name'     => _x( 'Genre', 'taxonomy singular name', 'ds-theme' ),
        'search_items'      => __( 'Search Genres', 'ds-theme' ),
        'all_items'         => __( 'All Genres', 'ds-theme' ),
        'parent_item'       => __( 'Parent Genre', 'ds-theme' ),
        'parent_item_colon' => __( 'Parent Genre:', 'ds-theme' ),
        'edit_item'         => __( 'Edit Genre', 'ds-theme' ),
        'update_item'       => __( 'Update Genre', 'ds-theme' ),
        'add_new_item'      => __( 'Add New Genre', 'ds-theme' ),
        'new_item_name'     => __( 'New Genre Name', 'ds-theme' ),
        'menu_name'         => __( 'Genres', 'ds-theme' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'movie-genre' ),
        'show_in_rest'      => true,
    );

    register_taxonomy( 'movie_genres', array( 'movies' ), $args );
}
add_action( 'init', 'register_taxonomy_movie_genres' );

// 7. Shortcode: Movies list with front-end genre buttons
function ds_movies_with_genre_buttons_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => -1,
    ), $atts, 'movies_genre_buttons');

    // Get all genres
    $genres = get_terms(array(
        'taxonomy' => 'movie_genres',
        'hide_empty' => true,
    ));

    // Buttons
    $output = '<div class="movie-filters mb-4">';
    $output .= '<button class="btn btn-primary me-2 filter-btn" data-genre="all">All</button>';
    if(!empty($genres) && !is_wp_error($genres)) {
        foreach($genres as $genre) {
            $output .= '<button class="btn btn-secondary me-2 filter-btn" data-genre="'. $genre->slug .'">'. $genre->name .'</button>';
        }
    }
    $output .= '</div>';

    // Movies container
    $query = new WP_Query(array(
        'post_type' => 'movies',
        'posts_per_page' => $atts['posts_per_page'],
    ));

    $output .= '<div class="movies-list row">';
    if($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();
            $post_genres = wp_get_post_terms(get_the_ID(), 'movie_genres', array('fields'=>'slugs'));
            $genre_classes = implode(' ', $post_genres);

            $output .= '<div class="col-md-4 mb-4 movie-item '. esc_attr($genre_classes) .'">';
            if(has_post_thumbnail()) {
                $output .= '<div class="movie-thumb mb-2">' . get_the_post_thumbnail(get_the_ID(), 'medium', array('class'=>'img-fluid rounded')) . '</div>';
            }
            $output .= '<h3 class="movie-title"><a href="'. get_permalink() .'">'. get_the_title() .'</a></h3>';
            $output .= '<div class="movie-excerpt">'. get_the_excerpt() .'</div>';
            $output .= '<p class="movie-genres"><strong>Genres:</strong> ' . get_the_term_list(get_the_ID(), 'movie_genres', '', ', ') . '</p>';
            $output .= '<p class="movie-tags"><strong>Tags:</strong> ' . get_the_term_list(get_the_ID(), 'post_tag', '', ', ') . '</p>';
            $output .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No movies found.</p>';
    }
    $output .= '</div>';

    // JS for button filter
    $output .= '<script>
    jQuery(document).ready(function($){
        $(".filter-btn").click(function(){
            var genre = $(this).data("genre");
            if(genre === "all"){
                $(".movies-list .movie-item").show();
            } else {
                $(".movies-list .movie-item").hide();
                $(".movies-list .movie-item."+genre).show();
            }
        });
    });
    </script>';

    return $output;
}
add_shortcode('movies_genre_buttons', 'ds_movies_with_genre_buttons_shortcode');

function add_movie_rating_meta_box() {
    add_meta_box(
        'movie_rating',
        'Movie Rating',
        'movie_rating_callback',
        'movies'
    );
}
add_action('add_meta_boxes', 'add_movie_rating_meta_box');

function movie_rating_callback($post) {
    $value = get_post_meta($post->ID, 'rating', true);
    echo '<input type="number" step="0.1" min="0" max="10" name="rating" value="'.esc_attr($value).'" />';
}

function save_movie_rating($post_id) {
    if(isset($_POST['rating'])) {
        update_post_meta($post_id, 'rating', sanitize_text_field($_POST['rating']));
    }
}
add_action('save_post', 'save_movie_rating');
function ds_insert_sample_movies() {

    // Kontrollo nëse jemi në admin dhe nuk janë futur më parë
    if ( !is_admin() ) return;

    $movies = array(
        array(
            'title' => 'Inception',
            'content' => 'A thief who steals corporate secrets through the use of dream-sharing technology.',
            'genres' => array('sci-fi','thriller'),
            'rating' => 8.8,
            'tags' => array('dream','heist')
        ),
        array(
            'title' => 'The Dark Knight',
            'content' => 'Batman faces the Joker in Gotham City.',
            'genres' => array('action','drama'),
            'rating' => 9.0,
            'tags' => array('batman','joker')
        ),
        array(
            'title' => 'Interstellar',
            'content' => 'A team of explorers travel through a wormhole in space.',
            'genres' => array('sci-fi','adventure'),
            'rating' => 8.6,
            'tags' => array('space','time')
        ),
        array(
            'title' => 'The Matrix',
            'content' => 'A hacker discovers reality is a simulated world.',
            'genres' => array('sci-fi','action'),
            'rating' => 8.7,
            'tags' => array('simulation','hacker')
        ),
        array(
            'title' => 'Avengers: Endgame',
            'content' => 'The Avengers assemble to undo Thanos\' actions.',
            'genres' => array('action','adventure'),
            'rating' => 8.4,
            'tags' => array('marvel','superheroes')
        ),
        array(
            'title' => 'Gladiator',
            'content' => 'A former Roman General seeks revenge against the emperor.',
            'genres' => array('action','drama'),
            'rating' => 8.5,
            'tags' => array('rome','revenge')
        ),
        array(
            'title' => 'Titanic',
            'content' => 'A love story unfolds aboard the doomed RMS Titanic.',
            'genres' => array('romance','drama'),
            'rating' => 7.8,
            'tags' => array('ship','love')
        ),
        array(
            'title' => 'Jurassic Park',
            'content' => 'Dinosaurs are brought back to life in a theme park.',
            'genres' => array('adventure','sci-fi'),
            'rating' => 8.1,
            'tags' => array('dinosaurs','park')
        ),
        array(
            'title' => 'The Lord of the Rings: The Fellowship of the Ring',
            'content' => 'A hobbit embarks on a quest to destroy a powerful ring.',
            'genres' => array('fantasy','adventure'),
            'rating' => 8.8,
            'tags' => array('ring','middle-earth')
        ),
        array(
            'title' => 'Star Wars: Episode IV – A New Hope',
            'content' => 'Luke Skywalker begins his journey to become a Jedi.',
            'genres' => array('sci-fi','adventure'),
            'rating' => 8.6,
            'tags' => array('star wars','jedi')
        ),
    );

    foreach($movies as $movie){

        // Kontrollo nëse filmi ekziston tashmë (prevent duplicates)
        $existing = get_page_by_title($movie['title'], OBJECT, 'movies');
        if($existing) continue;

        $post_id = wp_insert_post(array(
            'post_title' => $movie['title'],
            'post_content' => $movie['content'],
            'post_status' => 'publish',
            'post_type' => 'movies',
        ));

        if($post_id){
            // Set rating meta
            update_post_meta($post_id, 'rating', $movie['rating']);

            // Set genres
            wp_set_object_terms($post_id, $movie['genres'], 'movie_genres');

            // Set tags
            wp_set_post_tags($post_id, $movie['tags']);
        }
    }
}
// Vetëm admin: do funksionojë kur hysh në admin
add_action('admin_init', 'ds_insert_sample_movies');
// Shortcode: show all movies on one page
function ds_show_all_movies_shortcode() {

    $args = array(
        'post_type'      => 'movies',
        'posts_per_page' => -1, // shfaq të gjithë
        'orderby'        => 'date',
        'order'          => 'DESC'
    );

    $query = new WP_Query($args);

    $output = '<div class="row g-4">';

    if($query->have_posts()){
        while($query->have_posts()){
            $query->the_post();

            $genres = get_the_term_list(get_the_ID(), 'movie_genres', '', ', ', '');
            $tags = get_the_term_list(get_the_ID(), 'post_tag', '', ', ', '');

            $output .= '<div class="col-md-4">';
            $output .= '<div class="card movie-card h-100 shadow-sm">';
            
            if(has_post_thumbnail()){
                $output .= get_the_post_thumbnail(get_the_ID(), 'medium', array('class'=>'card-img-top img-fluid'));
            }

            $output .= '<div class="card-body">';
            $output .= '<h5 class="card-title">'.get_the_title().'</h5>';
            $output .= '<p class="card-text">'.get_the_excerpt().'</p>';
            if($genres) $output .= '<p><strong>Genres:</strong> '.$genres.'</p>';
            if($tags) $output .= '<p><strong>Tags:</strong> '.$tags.'</p>';
            $output .= '</div>';

            $rating = get_post_meta(get_the_ID(), 'rating', true);
            if($rating) $output .= '<div class="card-footer text-muted">⭐ '.$rating.'/10</div>';

            $output .= '</div>'; // close card
            $output .= '</div>'; // close col
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No movies found.</p>';
    }

    $output .= '</div>'; // close row

    return $output;
}
add_shortcode('all_movies', 'ds_show_all_movies_shortcode');
// Override Movies archive layout (show all together)
function ds_custom_movies_archive($template) {
    if (is_post_type_archive('movies')) {
        add_action('the_content', 'ds_replace_archive_content');
    }
    return $template;
}
add_filter('template_include', 'ds_custom_movies_archive');

function ds_replace_archive_content($content) {

    if (!is_post_type_archive('movies')) return $content;

    $query = new WP_Query(array(
        'post_type' => 'movies',
        'posts_per_page' => -1
    ));

    ob_start();

    echo '<div class="container"><div class="row g-4">';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            echo '<div class="col-md-4">';
            echo '<div class="card movie-card h-100">';

            if (has_post_thumbnail()) {
                the_post_thumbnail('medium', ['class'=>'card-img-top']);
            }

            echo '<div class="card-body">';
            echo '<h5>'. get_the_title() .'</h5>';
            echo '<p>'. get_the_excerpt() .'</p>';

            $rating = get_post_meta(get_the_ID(), 'rating', true);
            if ($rating) {
                echo '<p>⭐ '.$rating.'/10</p>';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        wp_reset_postdata();
    } else {
        echo '<p>No movies found.</p>';
    }

    echo '</div></div>';

    return ob_get_clean();
}
// Make Movies show on homepage
function ds_homepage_show_movies($query) {
    if (!is_admin() && $query->is_main_query() && is_home()) {
        $query->set('post_type', 'movies');
        $query->set('posts_per_page', -1);
    }
}
add_action('pre_get_posts', 'ds_homepage_show_movies');
function add_movie_trailer_meta_box() {
    add_meta_box(
        'movie_trailer',
        'Movie Trailer (YouTube URL)',
        'movie_trailer_callback',
        'movies'
    );
}
add_action('add_meta_boxes', 'add_movie_trailer_meta_box');

function movie_trailer_callback($post) {
    $value = get_post_meta($post->ID, 'trailer_url', true);
    echo '<input type="text" style="width:100%" name="trailer_url" value="'.esc_attr($value).'" placeholder="https://youtube.com/...">';
}

function save_movie_trailer($post_id) {
    if(isset($_POST['trailer_url'])) {
        update_post_meta($post_id, 'trailer_url', esc_url($_POST['trailer_url']));
    }
}
add_action('save_post', 'save_movie_trailer');
?>