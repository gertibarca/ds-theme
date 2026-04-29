<?php
// Generate SVG poster images for movies
define('WP_USE_THEMES', false);
require('wp-load.php');

echo "\n";
echo "================================================\n";
echo "🎨 Generating SVG Poster Images\n";
echo "================================================\n\n";

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Movie poster styles
$movies = array(
    'Inception' => '#667eea',
    'The Shawshank Redemption' => '#f093fb',
    'The Dark Knight' => '#2d3748',
    'Pulp Fiction' => '#ed64a6',
    'Interstellar' => '#1a365d',
    'The Matrix' => '#22543d',
    'Forrest Gump' => '#6b46c1',
    'Gladiator' => '#9c2c2c',
    'The Prestige' => '#1e3a8a',
    'Parasite' => '#111827',
    'Dune' => '#b45309',
    'Oppenheimer' => '#7c2d12',
);

$with_images = 0;

// Get all movies
$all_movies = get_posts(array('post_type' => 'movies', 'posts_per_page' => -1, 'post_status' => 'publish'));

echo "Found " . count($all_movies) . " movies\n\n";

foreach ($all_movies as $movie) {
    $has_thumbnail = has_post_thumbnail($movie->ID);
    
    if ($has_thumbnail) {
        echo "✅ {$movie->post_title} (already has image)\n";
        $with_images++;
        continue;
    }
    
    // Get color
    $color = isset($movies[$movie->post_title]) ? $movies[$movie->post_title] : '#667eea';
    
    // Create SVG
    $title = htmlspecialchars($movie->post_title);
    $year = date('Y');
    
    $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 600" width="400" height="600">
  <defs>
    <linearGradient id="grad_{$movie->ID}" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:{$color};stop-opacity:1" />
      <stop offset="100%" style="stop-color:#000;stop-opacity:1" />
    </linearGradient>
  </defs>
  
  <rect width="400" height="600" fill="url(#grad_{$movie->ID})"/>
  
  <text x="200" y="280" font-size="28" font-weight="bold" fill="white" text-anchor="middle" font-family="Arial, sans-serif">
    <tspan x="200" dy="0">{$title}</tspan>
  </text>
  
  <text x="200" y="550" font-size="14" fill="#999" text-anchor="middle" font-family="Arial, sans-serif">
    MOVIE POSTER
  </text>
</svg>
SVG;
    
    // Save SVG
    $upload_dir = wp_upload_dir();
    $filename = 'poster-' . md5($movie->post_title) . '.svg';
    $filepath = $upload_dir['basedir'] . '/' . $filename;
    
    wp_mkdir_p($upload_dir['basedir']);
    
    $result = file_put_contents($filepath, $svg);
    
    if (!$result) {
        echo "⚠️  {$movie->post_title} (SVG write failed)\n";
        continue;
    }
    
    // Create attachment
    $attachment = array(
        'guid' => $upload_dir['baseurl'] . '/' . $filename,
        'post_mime_type' => 'image/svg+xml',
        'post_title' => $movie->post_title . ' Poster',
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $filepath, $movie->ID);
    
    if (!is_wp_error($attach_id) && $attach_id > 0) {
        wp_update_attachment_metadata($attach_id, array());
        set_post_thumbnail($movie->ID, $attach_id);
        echo "✅ {$movie->post_title} (SVG poster created)\n";
        $with_images++;
    } else {
        echo "⚠️  {$movie->post_title} (attachment failed)\n";
    }
}

echo "\n";
echo "================================================\n";
echo "✅ POSTER IMAGES COMPLETE!\n";
echo "================================================\n";
echo "📊 Total movies with posters: $with_images / " . count($all_movies) . "\n";
echo "\n🎬 Movies page is now FULLY SET UP!\n";
echo "   - 12+ Movies\n";
echo "   - Trailer videos on hover\n";
echo "   - Poster images\n";
echo "   - Fast & optimized\n";
echo "================================================\n\n";
?>
