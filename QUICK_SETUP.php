<?php
/**
 * QUICK SETUP - Create Sample Movies with Images & Videos
 * 
 * Instructions:
 * 1. Save this file in your theme folder
 * 2. Visit: http://yoursite.com/wp-content/themes/ds-theme/QUICK_SETUP.php
 * 3. Follow the instructions on screen
 */

// Load WordPress
$wp_path = dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/wp-load.php';
if (!file_exists($wp_path)) {
    die('WordPress not found. Please ensure this file is in the theme folder.');
}
require_once($wp_path);

// Security check - only admins
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_die('You do not have permission to run this setup. Please log in as an administrator.');
}

// Check if we should run setup
$action = isset($_POST['action']) ? sanitize_text_field($_POST['action']) : '';

if ($action === 'create_movies') {
    // Create sample movies
    $sample_movies = array(
        array(
            'title' => 'Inception',
            'excerpt' => 'A skilled thief navigates dreams to plant ideas. A mind-bending sci-fi masterpiece.',
            'genres' => array('Sci-Fi', 'Thriller', 'Action'),
            'rating' => 8.8,
            'badge' => 'Masterpiece',
            'image_url' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/BigBuckBunny.mp4',
        ),
        array(
            'title' => 'The Shawshank Redemption',
            'excerpt' => 'Two imprisoned men bond over a long period, finding redemption through acts of common decency.',
            'genres' => array('Drama', 'Crime'),
            'rating' => 9.3,
            'badge' => 'Classic',
            'image_url' => 'https://images.unsplash.com/photo-1533613220915-121e16073d3b?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ElephantsDream.mp4',
        ),
        array(
            'title' => 'The Dark Knight',
            'excerpt' => 'Batman faces a clown-masked criminal mastermind in an explosive battle for Gotham.',
            'genres' => array('Action', 'Crime', 'Drama'),
            'rating' => 9.0,
            'badge' => 'Trending',
            'image_url' => 'https://images.unsplash.com/photo-1516876437184-593fda40c7ce?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerBlazes.mp4',
        ),
        array(
            'title' => 'Pulp Fiction',
            'excerpt' => 'Multiple interconnected stories of crime, violence, and redemption in Los Angeles.',
            'genres' => array('Crime', 'Drama'),
            'rating' => 8.9,
            'badge' => 'Cult Classic',
            'image_url' => 'https://images.unsplash.com/photo-1547873799-f1d6808e8a11?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerEscapes.mp4',
        ),
        array(
            'title' => 'Interstellar',
            'excerpt' => 'A team of explorers travel through a wormhole in space to save humanity.',
            'genres' => array('Sci-Fi', 'Drama', 'Adventure'),
            'rating' => 8.6,
            'badge' => 'Epic',
            'image_url' => 'https://images.unsplash.com/photo-1516846573888-558881c922e0?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerFun.mp4',
        ),
        array(
            'title' => 'The Matrix',
            'excerpt' => 'A computer programmer discovers the reality he knows is a simulation.',
            'genres' => array('Sci-Fi', 'Action'),
            'rating' => 8.7,
            'badge' => 'Iconic',
            'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerJoyrides.mp4',
        ),
        array(
            'title' => 'Forrest Gump',
            'excerpt' => 'A simple man becomes an inadvertent influencer and witness to defining historical events.',
            'genres' => array('Drama', 'Romance'),
            'rating' => 8.8,
            'badge' => 'Feel-Good',
            'image_url' => 'https://images.unsplash.com/photo-1483706543466-f82db2ac9d4b?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/Sintel.mp4',
        ),
        array(
            'title' => 'Gladiator',
            'excerpt' => 'A former Roman General seeks revenge against the emperor who murdered his family.',
            'genres' => array('Action', 'Drama', 'History'),
            'rating' => 8.5,
            'badge' => 'Award Winner',
            'image_url' => 'https://images.unsplash.com/photo-1534695905606-82fa17e5aaae?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/TearsOfSteel.mp4',
        ),
        array(
            'title' => 'The Prestige',
            'excerpt' => 'Two stage magicians engage in a battle to create the ultimate illusion.',
            'genres' => array('Mystery', 'Thriller', 'Drama'),
            'rating' => 8.5,
            'badge' => 'Clever Plot',
            'image_url' => 'https://images.unsplash.com/photo-1516846573888-558881c922e0?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/BigBuckBunny.mp4',
        ),
        array(
            'title' => 'Parasite',
            'excerpt' => 'A poor family schemes to become employed by a wealthy household.',
            'genres' => array('Drama', 'Thriller'),
            'rating' => 8.6,
            'badge' => 'Palme d\'Or',
            'image_url' => 'https://images.unsplash.com/photo-1513741550867-28d24a3bb6cb?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ElephantsDream.mp4',
        ),
        array(
            'title' => 'Dune',
            'excerpt' => 'A young man must prevent a terrible future only he can foresee on a hostile desert planet.',
            'genres' => array('Sci-Fi', 'Adventure', 'Action'),
            'rating' => 8.0,
            'badge' => '4K Ultra HD',
            'image_url' => 'https://images.unsplash.com/photo-1518676590629-3dcbd9c5a5c9?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerBlazes.mp4',
        ),
        array(
            'title' => 'Oppenheimer',
            'excerpt' => 'The story of American scientist J. Robert Oppenheimer and the creation of the atomic bomb.',
            'genres' => array('Biography', 'Drama', 'History'),
            'rating' => 8.4,
            'badge' => '2024 Best',
            'image_url' => 'https://images.unsplash.com/photo-1569191318165-e33ffc3b4caf?w=400&h=600&fit=crop',
            'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerEscapes.mp4',
        ),
    );

    $created_count = 0;
    $skipped_count = 0;
    
    foreach ($sample_movies as $movie) {
        // Check if movie already exists
        $existing = get_posts(array(
            'post_type' => 'movies',
            'title' => $movie['title'],
        ));
        
        if (!empty($existing)) {
            $skipped_count++;
            continue;
        }
        
        // Create the movie post
        $post_id = wp_insert_post(array(
            'post_title' => $movie['title'],
            'post_content' => $movie['excerpt'],
            'post_excerpt' => $movie['excerpt'],
            'post_type' => 'movies',
            'post_status' => 'publish',
        ));
        
        if (!is_wp_error($post_id)) {
            // Set custom fields
            update_post_meta($post_id, '_movie_imdb_rating', $movie['rating']);
            update_post_meta($post_id, '_movie_badge', $movie['badge']);
            update_post_meta($post_id, '_movie_trailer_video', $movie['trailer_url']);
            
            // Download and set featured image
            ds_quick_setup_set_thumbnail($post_id, $movie['image_url']);
            
            // Set genres
            if (!empty($movie['genres'])) {
                $genre_ids = array();
                foreach ($movie['genres'] as $genre_name) {
                    $term = get_term_by('name', $genre_name, 'movie_genres');
                    if (!$term) {
                        $term = wp_insert_term($genre_name, 'movie_genres');
                    }
                    if (!is_wp_error($term)) {
                        $genre_ids[] = is_array($term) ? $term['term_id'] : $term->term_id;
                    }
                }
                wp_set_post_terms($post_id, $genre_ids, 'movie_genres');
            }
            
            $created_count++;
        }
    }
    
    $success = true;
} else {
    $created_count = 0;
    $skipped_count = 0;
    $success = false;
}

/**
 * Helper function to download image and set as featured image
 */
function ds_quick_setup_set_thumbnail($post_id, $image_url) {
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    
    // Download the image
    $tmp = download_url($image_url);
    
    if (!is_wp_error($tmp)) {
        $file_array = array(
            'name' => basename($image_url),
            'tmp_name' => $tmp
        );
        
        $id = media_handle_sideload($file_array, $post_id);
        
        if (!is_wp_error($id)) {
            set_post_thumbnail($post_id, $id);
        } else {
            @unlink($tmp);
        }
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>DS Theme - Quick Setup</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f1f1f1;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h1 {
            color: #e50914;
            margin: 0 0 10px 0;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
        .info-box {
            background: #f8f9fa;
            border-left: 4px solid #e50914;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .button {
            background: #e50914;
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background 0.2s;
        }
        .button:hover {
            background: #b20710;
        }
        .button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }
        .success-box {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .warning-box {
            background: #fff3cd;
            border: 1px solid #ffeeba;
            color: #856404;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin: 20px 0;
        }
        .stat {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            text-align: center;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #e50914;
        }
        .stat-label {
            color: #666;
            font-size: 14px;
        }
        form {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎬 DS Theme - Quick Setup</h1>
        
        <?php if ($success): ?>
            <div class="success-box">
                <strong>✅ SUCCESS!</strong> Movies created successfully!
            </div>
            
            <div class="stats">
                <div class="stat">
                    <div class="stat-number"><?php echo $created_count; ?></div>
                    <div class="stat-label">Movies Created</div>
                </div>
                <div class="stat">
                    <div class="stat-number"><?php echo $skipped_count; ?></div>
                    <div class="stat-label">Already Existed</div>
                </div>
            </div>
            
            <div class="info-box">
                <strong>What was added:</strong>
                <ul>
                    <li><?php echo $created_count; ?> movie posts with titles and descriptions</li>
                    <li>HD poster images (from Unsplash)</li>
                    <li>Trailer videos with hover preview</li>
                    <li>IMDb ratings (8.0 - 9.3)</li>
                    <li>Movie genres and categories</li>
                    <li>Special badges (Trending, Classic, Epic, etc.)</li>
                </ul>
            </div>
            
            <p style="text-align: center; margin-top: 30px;">
                <a href="<?php echo admin_url('edit.php?post_type=movies'); ?>" style="background: #e50914; color: white; padding: 12px 30px; border-radius: 4px; text-decoration: none; display: inline-block; font-weight: 600;">
                    👉 View Movies in Admin
                </a>
            </p>
            
            <p style="text-align: center; margin-top: 20px;">
                <a href="<?php echo home_url('/'); ?>/movies/" style="color: #e50914; text-decoration: none; font-weight: 600;">
                    👉 View Movies Page
                </a>
            </p>
            
        <?php else: ?>
            <div class="warning-box">
                ⚠️ This will create 12 sample movies with HD images and trailer videos
            </div>
            
            <p>Click the button below to automatically:</p>
            <ul>
                <li>✅ Create 12 movie posts</li>
                <li>✅ Download HD poster images from Unsplash</li>
                <li>✅ Add trailer videos (Google Video Library)</li>
                <li>✅ Set ratings, badges, and genres</li>
                <li>✅ Configure everything for your movies page</li>
            </ul>
            
            <div class="info-box">
                <strong>Note:</strong> This may take 30-60 seconds as it downloads images. Please wait and don't close this page.
            </div>
            
            <form method="POST">
                <input type="hidden" name="action" value="create_movies">
                <button type="submit" class="button">Create Sample Movies Now →</button>
            </form>
        <?php endif; ?>
        
        <hr style="margin: 30px 0; border: none; border-top: 1px solid #eee;">
        
        <p style="text-align: center; color: #999; font-size: 14px;">
            Created: April 29, 2026 | DS Theme Setup Script
        </p>
    </div>
</body>
</html>
