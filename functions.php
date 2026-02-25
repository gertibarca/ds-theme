<?php 
// 1. Theme setup (Featured images, title tags, etc.)
function dstheme_setup() { 
    add_theme_support( 'post-thumbnails' ); 
    add_theme_support( 'post-formats', array( 'aside', 'image', 'video' ) ); 
    add_theme_support( 'title-tag' ); 
} 
add_action( 'after_setup_theme', 'dstheme_setup' ); 

// 2. Load all Styles and Scripts
function dstheme_assets() { 
    // Load Bootstrap CSS FIRST (Using the correct 5.3.3 version)
    wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3', 'all' ); 

    // Load your style.css NEXT
    wp_enqueue_style( 'ds-style', get_stylesheet_uri(), array('bootstrap-css'), '1.0', 'all' ); 

    // Load your slider.css
    wp_enqueue_style( 'slider-style', get_template_directory_uri() . '/css/slider.css', array('bootstrap-css'), '1.0', 'all' ); 

    // Load Bootstrap JS
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true );

    // Load your custom.js
    wp_enqueue_script( 'customjs', get_template_directory_uri() . '/js/custom.js', array( 'jquery', 'bootstrap-js' ), '1.0', true ); 

    // Comment reply script
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) { 
        wp_enqueue_script( 'comment-reply' ); 
    } 
} 
add_action( 'wp_enqueue_scripts', 'dstheme_assets' );