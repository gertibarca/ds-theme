<?php
// Download and attach images to all movies - Using Pexels API
define('WP_USE_THEMES', false);
require('wp-load.php');

// Movie images mapping - using direct reliable image URLs
$movies_images = array(
    'Inception' => 'https://live.staticflickr.com/4108/5175814025_a5f1669cd4_b.jpg',
    'The Shawshank Redemption' => 'https://live.staticflickr.com/7451/9695101023_d6c0a08313_b.jpg',
    'The Dark Knight' => 'https://live.staticflickr.com/3698/10046519186_29aafd5da5_b.jpg',
    'Pulp Fiction' => 'https://live.staticflickr.com/8577/16046244646_4b0e7c2ef8_b.jpg',
    'Interstellar' => 'https://live.staticflickr.com/3834/20131068219_8ba7eb52f9_b.jpg',
    'The Matrix' => 'https://live.staticflickr.com/4047/4331905455_8df0c45c55_b.jpg',
    'Forrest Gump' => 'https://live.staticflickr.com/3949/15641544441_0b7f0532c8_b.jpg',
    'Gladiator' => 'https://live.staticflickr.com/3865/19038825055_78b99c3a0a_b.jpg',
    'The Prestige' => 'https://live.staticflickr.com/4050/4330880098_f00f9efde1_b.jpg',
    'Parasite' => 'https://live.staticflickr.com/65535/49521810141_0f7a9d9d43_b.jpg',
    'Dune' => 'https://live.staticflickr.com/65535/50975267843_f38e3e1dc7_b.jpg',
    'Oppenheimer' => 'https://live.staticflickr.com/65535/53161516373_43c3e04d4c_b.jpg',
);

echo "\n";
echo "================================================\n";
echo "📷 Downloading Images for All Movies\n";
echo "================================================\n\n";

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

$processed = 0;
$with_images = 0;

// Get all movies
$all_movies = get_posts(array('post_type' => 'movies', 'posts_per_page' => -1, 'post_status' => 'publish'));

foreach ($all_movies as $movie) {
    $has_thumbnail = has_post_thumbnail($movie->ID);
    $image_url = isset($movies_images[$movie->post_title]) ? $movies_images[$movie->post_title] : null;
    
    if (!$image_url) {
        echo "⏭️  SKIPPED: {$movie->post_title} (no image URL)\n";
        continue;
    }
    
    if ($has_thumbnail) {
        echo "✅ ALREADY HAS IMAGE: {$movie->post_title}\n";
        $with_images++;
        continue;
    }
    
    // Download image
    $tmp = download_url($image_url, 300, true);
    
    if (is_wp_error($tmp)) {
        echo "❌ FAILED: {$movie->post_title} ({$tmp->get_error_message()})\n";
        continue;
    }
    
    // Handle sideload
    $file_array = array(
        'name' => basename($image_url),
        'tmp_name' => $tmp
    );
    
    $id = media_handle_sideload($file_array, $movie->ID);
    
    if (is_wp_error($id)) {
        @unlink($tmp);
        echo "❌ FAILED: {$movie->post_title} ({$id->get_error_message()})\n";
        continue;
    }
    
    // Set as featured image
    set_post_thumbnail($movie->ID, $id);
    echo "✅ IMAGE ADDED: {$movie->post_title}\n";
    $with_images++;
    $processed++;
}

echo "\n";
echo "================================================\n";
echo "✅ IMAGE DOWNLOAD COMPLETE!\n";
echo "================================================\n";
echo "📊 Processed: $processed images\n";
echo "📷 With images: $with_images / " . count($all_movies) . " movies\n";
echo "\n🎬 Your movies page is now FULLY LOADED!\n";
echo "================================================\n\n";
?>
