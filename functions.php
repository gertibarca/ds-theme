<?php
// 1. Theme setup
function dstheme_setup() { 
    add_theme_support( 'post-thumbnails' ); 
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video' ) ); 
    add_theme_support( 'title-tag' );
    
    // Add custom image sizes
    add_image_size( 'movie-poster', 220, 330, true );
    add_image_size( 'movie-hero', 1920, 1080, true );
    add_image_size( 'movie-card', 400, 600, true );
} 
add_action( 'after_setup_theme', 'dstheme_setup' ); 

// 2. Load Styles and Scripts
function dstheme_assets() { 
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3', 'all' ); 

    wp_enqueue_style( 'ds-style', get_stylesheet_uri(), array('bootstrap-css'), '1.0', 'all' ); 

    wp_enqueue_style( 'slider-style', get_template_directory_uri() . '/css/slider.css', array('bootstrap-css'), '1.0', 'all' ); 

    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true );

    wp_enqueue_script( 'customjs', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'bootstrap-js' ), '1.0', true );

    wp_enqueue_script( 'advancedjs', get_template_directory_uri() . '/js/advanced.js', array( 'jquery' ), '1.0', true );

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

    $genres = get_terms(array(
        'taxonomy'   => 'movie_genres',
        'hide_empty' => true,
    ));

    $output = '<div class="movie-filters mb-4">';
    $output .= '<button class="btn btn-primary me-2 filter-btn" data-genre="all">All</button>';
    if(!empty($genres) && !is_wp_error($genres)) {
        foreach($genres as $genre) {
            $output .= '<button class="btn btn-secondary me-2 filter-btn" data-genre="'. $genre->slug .'">'. $genre->name .'</button>';
        }
    }
    $output .= '</div>';

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

// 8. Force display all movies without pagination
function ds_movies_archive_query( $query ) {
    if ( !is_admin() && $query->is_main_query() && is_post_type_archive( 'movies' ) ) {
        $query->set( 'posts_per_page', -1 );
        $query->set( 'paged', 1 );
    }
    return $query;
}
add_action( 'pre_get_posts', 'ds_movies_archive_query' );

// 9. Add Movie YouTube URL & Rating Metabox
function ds_add_movie_metabox() {
    add_meta_box(
        'movie_details',
        'Movie Details',
        'ds_movie_metabox_callback',
        'movies',
        'normal',
        'high'
    );
}
add_action( 'add_meta_boxes', 'ds_add_movie_metabox' );

function ds_movie_metabox_callback( $post ) {
    wp_nonce_field( 'ds_movie_metabox_nonce', 'ds_movie_nonce' );
    
    $youtube_url = get_post_meta( $post->ID, '_movie_youtube_url', true );
    $rating = get_post_meta( $post->ID, '_movie_rating', true );
    $duration = get_post_meta( $post->ID, '_movie_duration', true );
    $year = get_post_meta( $post->ID, '_movie_year', true );
    $trailer_video = get_post_meta( $post->ID, '_movie_trailer_video', true );
    $imdb_rating = get_post_meta( $post->ID, '_movie_imdb_rating', true );
    $badge = get_post_meta( $post->ID, '_movie_badge', true );
    ?>
    <div style="padding: 20px 0;">
        <div style="margin-bottom: 20px;">
            <label for="movie_youtube_url" style="display: block; margin-bottom: 8px; font-weight: 600;">YouTube Video URL:</label>
            <input type="url" id="movie_youtube_url" name="movie_youtube_url" value="<?php echo esc_attr( $youtube_url ); ?>" 
                   placeholder="https://www.youtube.com/watch?v=..." style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            <small style="color: #666; display: block; margin-top: 5px;">Full YouTube URL for main video</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="movie_trailer_video" style="display: block; margin-bottom: 8px; font-weight: 600;">Trailer Video URL (MP4):</label>
            <input type="url" id="movie_trailer_video" name="movie_trailer_video" value="<?php echo esc_attr( $trailer_video ); ?>" 
                   placeholder="https://example.com/trailer.mp4" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            <small style="color: #666; display: block; margin-top: 5px;">Video file URL for hover effect (MP4 recommended)</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="movie_imdb_rating" style="display: block; margin-bottom: 8px; font-weight: 600;">IMDb Rating (0-10):</label>
            <input type="number" id="movie_imdb_rating" name="movie_imdb_rating" value="<?php echo esc_attr( $imdb_rating ); ?>" 
                   min="0" max="10" step="0.1" placeholder="8.5" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="movie_badge" style="display: block; margin-bottom: 8px; font-weight: 600;">Badge Text (e.g., "Trending", "4K Ultra HD"):</label>
            <input type="text" id="movie_badge" name="movie_badge" value="<?php echo esc_attr( $badge ); ?>" 
                   placeholder="Trending" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
            <small style="color: #666; display: block; margin-top: 5px;">Leave empty for no badge</small>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="movie_rating" style="display: block; margin-bottom: 8px; font-weight: 600;">Rating (0-10):</label>
            <input type="number" id="movie_rating" name="movie_rating" value="<?php echo esc_attr( $rating ); ?>" 
                   min="0" max="10" step="0.1" placeholder="8.5" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="movie_duration" style="display: block; margin-bottom: 8px; font-weight: 600;">Duration (minutes):</label>
            <input type="number" id="movie_duration" name="movie_duration" value="<?php echo esc_attr( $duration ); ?>" 
                   placeholder="120" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="movie_year" style="display: block; margin-bottom: 8px; font-weight: 600;">Release Year:</label>
            <input type="number" id="movie_year" name="movie_year" value="<?php echo esc_attr( $year ); ?>" 
                   placeholder="2024" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
    </div>
    <?php
}

function ds_save_movie_metabox( $post_id ) {
    if ( ! isset( $_POST['ds_movie_nonce'] ) || ! wp_verify_nonce( $_POST['ds_movie_nonce'], 'ds_movie_metabox_nonce' ) ) {
        return;
    }

    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['movie_youtube_url'] ) ) {
        update_post_meta( $post_id, '_movie_youtube_url', esc_url( $_POST['movie_youtube_url'] ) );
    }

    if ( isset( $_POST['movie_rating'] ) ) {
        update_post_meta( $post_id, '_movie_rating', sanitize_text_field( $_POST['movie_rating'] ) );
    }

    if ( isset( $_POST['movie_duration'] ) ) {
        update_post_meta( $post_id, '_movie_duration', sanitize_text_field( $_POST['movie_duration'] ) );
    }

    if ( isset( $_POST['movie_year'] ) ) {
        update_post_meta( $post_id, '_movie_year', sanitize_text_field( $_POST['movie_year'] ) );
    }

    if ( isset( $_POST['movie_trailer_video'] ) ) {
        update_post_meta( $post_id, '_movie_trailer_video', esc_url( $_POST['movie_trailer_video'] ) );
    }

    if ( isset( $_POST['movie_imdb_rating'] ) ) {
        update_post_meta( $post_id, '_movie_imdb_rating', sanitize_text_field( $_POST['movie_imdb_rating'] ) );
    }

    if ( isset( $_POST['movie_badge'] ) ) {
        update_post_meta( $post_id, '_movie_badge', sanitize_text_field( $_POST['movie_badge'] ) );
    }
}
add_action( 'save_post', 'ds_save_movie_metabox' );

// 10. Get YouTube embed URL
function ds_get_youtube_embed_url( $url ) {
    if ( empty( $url ) ) return false;
    
    $pattern = '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([\w-]+)/';
    if ( preg_match( $pattern, $url, $matches ) ) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }
    return false;
}
?>