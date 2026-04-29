<?php
// Remove all featured images from movies
define('WP_USE_THEMES', false);
require('wp-load.php');

echo "\n";
echo "================================================\n";
echo "🗑️  Removing All Movie Poster Images\n";
echo "================================================\n\n";

$all_movies = get_posts(array('post_type' => 'movies', 'posts_per_page' => -1, 'post_status' => 'publish'));

$removed = 0;
$already_empty = 0;

foreach ($all_movies as $movie) {
    $thumbnail_id = get_post_thumbnail_id($movie->ID);
    
    if ($thumbnail_id) {
        // Remove featured image
        delete_post_thumbnail($movie->ID);
        
        // Optionally delete the attachment entirely
        wp_delete_attachment($thumbnail_id, true);
        
        echo "✅ Removed image from: {$movie->post_title}\n";
        $removed++;
    } else {
        echo "⏭️  No image: {$movie->post_title}\n";
        $already_empty++;
    }
}

echo "\n";
echo "================================================\n";
echo "✅ REMOVAL COMPLETE!\n";
echo "================================================\n";
echo "🗑️  Removed: $removed images\n";
echo "⏭️  Already empty: $already_empty\n";
echo "\n📷 You can now add your own images via:\n";
echo "   WordPress Admin → Movies → Edit Movie\n";
echo "   → Featured Image → Upload\n";
echo "================================================\n\n";
?>
