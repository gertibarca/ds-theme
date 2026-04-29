<?php
// Generate and attach placeholder images for all movies
define('WP_USE_THEMES', false);
require('wp-load.php');

echo "\n";
echo "================================================\n";
echo "🎨 Creating Poster Images for All Movies\n";
echo "================================================\n\n";

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Movie poster data
$movie_colors = array(
    'Inception' => '#667eea',
    'The Shawshank Redemption' => '#f093fb',
    'The Dark Knight' => '#4a5568',
    'Pulp Fiction' => '#ed64a6',
    'Interstellar' => '#2d3748',
    'The Matrix' => '#48bb78',
    'Forrest Gump' => '#9f7aea',
    'Gladiator' => '#c05621',
    'The Prestige' => '#2c5282',
    'Parasite' => '#1a202c',
    'Dune' => '#d69e2e',
    'Oppenheimer' => '#e53e3e',
);

$with_images = 0;

// Get all movies
$all_movies = get_posts(array('post_type' => 'movies', 'posts_per_page' => -1, 'post_status' => 'publish'));

echo "Found " . count($all_movies) . " total movies\n\n";

foreach ($all_movies as $movie) {
    $has_thumbnail = has_post_thumbnail($movie->ID);
    
    if ($has_thumbnail) {
        echo "✅ {$movie->post_title} (already has image)\n";
        $with_images++;
        continue;
    }
    
    // Get color for this movie
    $color = isset($movie_colors[$movie->post_title]) ? $movie_colors[$movie->post_title] : '#667eea';
    
    // Create placeholder via online service
    $width = 400;
    $height = 600;
    $text = urlencode(substr($movie->post_title, 0, 20));
    $color_clean = ltrim($color, '#');
    
    // Use placeholder.com which is reliable
    $image_url = "https://via.placeholder.com/{$width}x{$height}/{$color_clean}/ffffff?text=" . urlencode($movie->post_title);
    
    // Download with extended timeout
    $response = wp_safe_remote_get($image_url, array('timeout' => 60, 'sslverify' => false));
    
    if (is_wp_error($response)) {
        echo "⚠️  {$movie->post_title} (couldn't create poster)\n";
        continue;
    }
    
    $body = wp_remote_retrieve_body($response);
    if (empty($body)) {
        echo "⚠️  {$movie->post_title} (empty image data)\n";
        continue;
    }
    
    // Save temp file
    $upload_dir = wp_upload_dir();
    $temp_file = $upload_dir['basedir'] . '/temp-' . md5($movie->post_title) . '.jpg';
    
    $result = file_put_contents($temp_file, $body);
    if ($result === false) {
        echo "⚠️  {$movie->post_title} (file write failed)\n";
        continue;
    }
    
    // Create attachment
    $attachment = array(
        'guid' => $upload_dir['baseurl'] . '/' . basename($temp_file),
        'post_mime_type' => 'image/jpeg',
        'post_title' => $movie->post_title . ' Poster',
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $temp_file, $movie->ID);
    
    if (!is_wp_error($attach_id) && $attach_id > 0) {
        // Generate metadata
        $attach_data = wp_generate_attachment_metadata($attach_id, $temp_file);
        if (!is_wp_error($attach_data)) {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }
        
        // Set as featured image
        set_post_thumbnail($movie->ID, $attach_id);
        echo "✅ {$movie->post_title} (poster created & attached)\n";
        $with_images++;
    } else {
        echo "⚠️  {$movie->post_title} (attachment failed)\n";
    }
}

echo "\n";
echo "================================================\n";
echo "✅ POSTER IMAGES COMPLETE!\n";
echo "================================================\n";
echo "📊 Movies with posters: " . $with_images . " / " . count($all_movies) . "\n";
echo "\n🎬 Your movies page is READY!\n";
echo "================================================\n\n";
?>
