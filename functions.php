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