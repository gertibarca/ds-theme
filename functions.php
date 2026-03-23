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


// Create Widget Class
class Foo_Widget extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'foo_widget',                 // Widget ID
            'A Foo Widget',               // Widget Name
            array(
                'description' => 'Simple Hello World widget'
            )
        );
    }

    // Frontend output
    public function widget( $args, $instance ) {

        echo $args['before_widget'];

        echo '<p>Gerti</p>';

        echo $args['after_widget'];
    }

    // Widget form (Admin area)
    public function form( $instance ) {
        echo '<p>No options yet.</p>';
    }

    // Save widget options
    public function update( $new_instance, $old_instance ) {
        return $new_instance;
    }
}

// Register Widget
function register_foo_widget() {
    register_widget( 'Foo_Widget' );
}
add_action( 'widgets_init', 'register_foo_widget' );


// 4. Register Custom Post Type: Movies
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
        'menu_icon'          => 'dashicons-video-alt2', // Movie icon
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'show_in_rest'       => true, // Gutenberg support
    );

    register_post_type( 'movies', $args );
}
add_action( 'init', 'ds_register_movies_cpt' );


// 5. Shortcode to display Movies
function ds_movies_list_shortcode($atts) {
    $atts = shortcode_atts(array(
        'posts_per_page' => 5,
    ), $atts, 'movies_list');

    $query = new WP_Query(array(
        'post_type' => 'movies',
        'posts_per_page' => $atts['posts_per_page'],
    ));

    $output = '<div class="movies-list row">';
    if($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="col-md-4 mb-4 movie-item">';
            if(has_post_thumbnail()) {
                $output .= '<div class="movie-thumb mb-2">' . get_the_post_thumbnail(get_the_ID(), 'medium', array('class'=>'img-fluid rounded')) . '</div>';
            }
            $output .= '<h3 class="movie-title"><a href="'. get_permalink() .'">'. get_the_title() .'</a></h3>';
            $output .= '<div class="movie-excerpt">'. get_the_excerpt() .'</div>';
            $output .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>No movies found.</p>';
    }
    $output .= '</div>';

    return $output;
}
add_shortcode('movies_list', 'ds_movies_list_shortcode');