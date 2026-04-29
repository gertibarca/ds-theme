<?php
// Generate poster images locally using PHP GD Library
define('WP_USE_THEMES', false);
require('wp-load.php');

echo "\n";
echo "================================================\n";
echo "🎨 Generating Poster Images Locally\n";
echo "================================================\n\n";

// Check if GD is available
if (!extension_loaded('gd')) {
    die("❌ ERROR: GD library not available\n");
}

require_once(ABSPATH . 'wp-admin/includes/media.php');
require_once(ABSPATH . 'wp-admin/includes/file.php');
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Movie colors and styles
$movie_styles = array(
    'Inception' => array('color' => '#667eea', 'icon' => '💭'),
    'The Shawshank Redemption' => array('color' => '#f093fb', 'icon' => '🔗'),
    'The Dark Knight' => array('color' => '#2d3748', 'icon' => '🦇'),
    'Pulp Fiction' => array('color' => '#ed64a6', 'icon' => '🔫'),
    'Interstellar' => array('color' => '#2d3748', 'icon' => '🚀'),
    'The Matrix' => array('color' => '#48bb78', 'icon' => '💊'),
    'Forrest Gump' => array('color' => '#9f7aea', 'icon' => '🏃'),
    'Gladiator' => array('color' => '#c05621', 'icon' => '⚔️'),
    'The Prestige' => array('color' => '#2c5282', 'icon' => '🎩'),
    'Parasite' => array('color' => '#1a202c', 'icon' => '🏠'),
    'Dune' => array('color' => '#d69e2e', 'icon' => '🏜️'),
    'Oppenheimer' => array('color' => '#e53e3e', 'icon' => '💣'),
);

$with_images = 0;

// Get all movies
$all_movies = get_posts(array('post_type' => 'movies', 'posts_per_page' => -1, 'post_status' => 'publish'));

echo "Found " . count($all_movies) . " movies\n";
echo "Using GD Library for image generation\n\n";

foreach ($all_movies as $movie) {
    $has_thumbnail = has_post_thumbnail($movie->ID);
    
    if ($has_thumbnail) {
        echo "✅ {$movie->post_title} (already has image)\n";
        $with_images++;
        continue;
    }
    
    // Get style
    $style = isset($movie_styles[$movie->post_title]) ? $movie_styles[$movie->post_title] : array('color' => '#667eea', 'icon' => '🎬');
    $color_hex = $style['color'];
    
    // Convert hex to RGB
    $color_hex = ltrim($color_hex, '#');
    $r = hexdec(substr($color_hex, 0, 2));
    $g = hexdec(substr($color_hex, 2, 2));
    $b = hexdec(substr($color_hex, 4, 2));
    
    // Create image
    $width = 400;
    $height = 600;
    $img = imagecreatetruecolor($width, $height);
    
    // Create gradient background
    $color1 = imagecolorallocate($img, $r, $g, $b);
    $color2 = imagecolorallocate($img, max(0, $r - 40), max(0, $g - 40), max(0, $b - 40));
    
    // Fill with gradient
    for ($i = 0; $i < $height; $i++) {
        $percent = $i / $height;
        $cr = intval($r + ($r - 40 - $r) * $percent);
        $cg = intval($g + ($g - 40 - $g) * $percent);
        $cb = intval($b + ($b - 40 - $b) * $percent);
        $color = imagecolorallocate($img, $cr, $cg, $cb);
        imageline($img, 0, $i, $width, $i, $color);
    }
    
    // Add text
    $white = imagecolorallocate($img, 255, 255, 255);
    $gray = imagecolorallocate($img, 200, 200, 200);
    
    // Title (wrapped)
    $title = $movie->post_title;
    $font_size = 5;
    $font = 5;
    $text_y = 250;
    $text_color = $white;
    
    // Simple center text
    $text_width = strlen($title) * imagefontwidth($font);
    $text_x = ($width - $text_width) / 2;
    
    imagestring($img, $font, $text_x, $text_y, $title, $text_color);
    
    // Add "MOVIE POSTER" text at bottom
    $footer = "MOVIE POSTER";
    $footer_width = strlen($footer) * imagefontwidth(2);
    $footer_x = ($width - $footer_width) / 2;
    imagestring($img, 2, $footer_x, 550, $footer, $gray);
    
    // Save to file
    $upload_dir = wp_upload_dir();
    $filename = 'poster-' . md5($movie->post_title) . '.jpg';
    $filepath = $upload_dir['basedir'] . '/' . $filename;
    
    // Ensure directory exists
    wp_mkdir_p($upload_dir['basedir']);
    
    // Save image
    $result = imagejpeg($img, $filepath, 85);
    imagedestroy($img);
    
    if (!$result) {
        echo "⚠️  {$movie->post_title} (image generation failed)\n";
        continue;
    }
    
    // Create attachment
    $attachment = array(
        'guid' => $upload_dir['baseurl'] . '/' . $filename,
        'post_mime_type' => 'image/jpeg',
        'post_title' => $movie->post_title . ' Poster',
        'post_content' => '',
        'post_status' => 'inherit'
    );
    
    $attach_id = wp_insert_attachment($attachment, $filepath, $movie->ID);
    
    if (!is_wp_error($attach_id) && $attach_id > 0) {
        // Generate metadata
        $attach_data = wp_generate_attachment_metadata($attach_id, $filepath);
        if (!is_wp_error($attach_data)) {
            wp_update_attachment_metadata($attach_id, $attach_data);
        }
        
        // Set as featured image
        set_post_thumbnail($movie->ID, $attach_id);
        echo "✅ {$movie->post_title}\n";
        $with_images++;
    } else {
        echo "⚠️  {$movie->post_title} (attachment failed)\n";
    }
}

echo "\n";
echo "================================================\n";
echo "✅ POSTER GENERATION COMPLETE!\n";
echo "================================================\n";
echo "📊 Movies with posters: " . $with_images . " / " . count($all_movies) . "\n";
echo "\n✨ Your page is READY TO VIEW!\n";
echo "================================================\n\n";
?>
