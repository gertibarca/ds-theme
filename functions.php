<?php
// Enqueue theme styles and scripts
function dstheme_assets() {
    // Main stylesheet
    wp_enqueue_style(
        'ds-style',
        get_stylesheet_uri(),
        array(),
        '1.0',
        'all'
    );

    // Slider stylesheet
    wp_enqueue_style(
        'slider-style', 
        get_template_directory_uri() . '/css/slider.css',
        array(), 
        '1.0', 
        'all'
    );

    // Custom JS file
    wp_enqueue_script(
        'customjs',
        get_template_directory_uri() . '/js/custom.js',
        array('jquery'),
        '1.0',
        true
    );

    // Load comment-reply script only on singular pages with open comments
    if ( is_singular() && comments_open() && get_option('thread_comments') ) {
        wp_enqueue_script('comment-reply');
    }
}

// Hook into wp_enqueue_scripts
add_action('wp_enqueue_scripts', 'dstheme_assets');
