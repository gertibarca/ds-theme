<?php
/**
 * CREATE MOVIES PAGE
 * 
 * Paste this code in WordPress Admin → Tools → Code Snippets → Add New
 * OR add temporarily to functions.php, then remove after running once
 */

// Create Movies page if it doesn't exist
function ds_create_movies_page() {
    // Check if page already exists
    $page = get_page_by_title('Movies');
    
    if (!$page) {
        $page_id = wp_insert_post(array(
            'post_title'    => 'All Movies',
            'post_content'  => 'Browse our collection of movies',
            'post_status'   => 'publish',
            'post_type'     => 'page',
            'post_author'   => 1,
        ));
        
        if ($page_id) {
            // Set the page template to page-movies.php
            update_post_meta($page_id, '_wp_page_template', 'page-movies.php');
            error_log('Movies page created! ID: ' . $page_id);
            return true;
        }
    }
    return false;
}

// Run this function once
if (!wp_next_scheduled('ds_create_movies_page_hook')) {
    wp_schedule_single_event(time(), 'ds_create_movies_page_hook');
}

add_action('ds_create_movies_page_hook', function() {
    ds_create_movies_page();
});

// Also run immediately
ds_create_movies_page();

?>
