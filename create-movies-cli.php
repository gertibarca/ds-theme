<?php
// Auto-create sample movies with images and videos
define('WP_USE_THEMES', false);
require('wp-load.php');

if (!function_exists('wp_insert_post')) {
    die('WordPress functions not loaded');
}

// Sample movies with images and videos
$sample_movies = array(
    array('title' => 'Inception', 'excerpt' => 'A skilled thief navigates dreams to plant ideas. A mind-bending sci-fi masterpiece.', 'genres' => array('Sci-Fi', 'Thriller', 'Action'), 'rating' => 8.8, 'badge' => 'Masterpiece', 'image_url' => 'https://images.unsplash.com/photo-1574375927938-d5a98e8ffe85?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/BigBuckBunny.mp4'),
    array('title' => 'The Shawshank Redemption', 'excerpt' => 'Two imprisoned men bond over a long period, finding redemption through acts of common decency.', 'genres' => array('Drama', 'Crime'), 'rating' => 9.3, 'badge' => 'Classic', 'image_url' => 'https://images.unsplash.com/photo-1533613220915-121e16073d3b?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ElephantsDream.mp4'),
    array('title' => 'The Dark Knight', 'excerpt' => 'Batman faces a clown-masked criminal mastermind in an explosive battle for Gotham.', 'genres' => array('Action', 'Crime', 'Drama'), 'rating' => 9.0, 'badge' => 'Trending', 'image_url' => 'https://images.unsplash.com/photo-1516876437184-593fda40c7ce?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerBlazes.mp4'),
    array('title' => 'Pulp Fiction', 'excerpt' => 'Multiple interconnected stories of crime, violence, and redemption in Los Angeles.', 'genres' => array('Crime', 'Drama'), 'rating' => 8.9, 'badge' => 'Cult Classic', 'image_url' => 'https://images.unsplash.com/photo-1547873799-f1d6808e8a11?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerEscapes.mp4'),
    array('title' => 'Interstellar', 'excerpt' => 'A team of explorers travel through a wormhole in space to save humanity.', 'genres' => array('Sci-Fi', 'Drama', 'Adventure'), 'rating' => 8.6, 'badge' => 'Epic', 'image_url' => 'https://images.unsplash.com/photo-1516846573888-558881c922e0?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerFun.mp4'),
    array('title' => 'The Matrix', 'excerpt' => 'A computer programmer discovers the reality he knows is a simulation.', 'genres' => array('Sci-Fi', 'Action'), 'rating' => 8.7, 'badge' => 'Iconic', 'image_url' => 'https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerJoyrides.mp4'),
    array('title' => 'Forrest Gump', 'excerpt' => 'A simple man becomes an inadvertent influencer and witness to defining historical events.', 'genres' => array('Drama', 'Romance'), 'rating' => 8.8, 'badge' => 'Feel-Good', 'image_url' => 'https://images.unsplash.com/photo-1483706543466-f82db2ac9d4b?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/Sintel.mp4'),
    array('title' => 'Gladiator', 'excerpt' => 'A former Roman General seeks revenge against the emperor who murdered his family.', 'genres' => array('Action', 'Drama', 'History'), 'rating' => 8.5, 'badge' => 'Award Winner', 'image_url' => 'https://images.unsplash.com/photo-1534695905606-82fa17e5aaae?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/TearsOfSteel.mp4'),
    array('title' => 'The Prestige', 'excerpt' => 'Two stage magicians engage in a battle to create the ultimate illusion.', 'genres' => array('Mystery', 'Thriller', 'Drama'), 'rating' => 8.5, 'badge' => 'Clever Plot', 'image_url' => 'https://images.unsplash.com/photo-1516846573888-558881c922e0?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/BigBuckBunny.mp4'),
    array('title' => 'Parasite', 'excerpt' => 'A poor family schemes to become employed by a wealthy household.', 'genres' => array('Drama', 'Thriller'), 'rating' => 8.6, 'badge' => 'Palme d\'Or', 'image_url' => 'https://images.unsplash.com/photo-1513741550867-28d24a3bb6cb?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ElephantsDream.mp4'),
    array('title' => 'Dune', 'excerpt' => 'A young man must prevent a terrible future only he can foresee on a hostile desert planet.', 'genres' => array('Sci-Fi', 'Adventure', 'Action'), 'rating' => 8.0, 'badge' => '4K Ultra HD', 'image_url' => 'https://images.unsplash.com/photo-1518676590629-3dcbd9c5a5c9?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerBlazes.mp4'),
    array('title' => 'Oppenheimer', 'excerpt' => 'The story of American scientist J. Robert Oppenheimer and the creation of the atomic bomb.', 'genres' => array('Biography', 'Drama', 'History'), 'rating' => 8.4, 'badge' => '2024 Best', 'image_url' => 'https://images.unsplash.com/photo-1569191318165-e33ffc3b4caf?w=400&h=600&fit=crop', 'trailer_url' => 'https://commondatastorage.googleapis.com/gtv-videos-library/sample/ForBiggerEscapes.mp4'),
);

$created = 0;
$skipped = 0;

echo "\n";
echo "================================================\n";
echo "🎬 Creating Sample Movies with Images & Videos\n";
echo "================================================\n\n";

foreach ($sample_movies as $movie) {
    // Check if exists
    $existing = get_posts(array('post_type' => 'movies', 'title' => $movie['title']));
    
    if (!empty($existing)) {
        echo "⏭️  SKIPPED: {$movie['title']} (already exists)\n";
        $skipped++;
        continue;
    }
    
    // Create post
    $post_id = wp_insert_post(array(
        'post_title' => $movie['title'],
        'post_content' => $movie['excerpt'],
        'post_excerpt' => $movie['excerpt'],
        'post_type' => 'movies',
        'post_status' => 'publish',
    ));
    
    if (!is_wp_error($post_id)) {
        // Add metadata
        update_post_meta($post_id, '_movie_imdb_rating', $movie['rating']);
        update_post_meta($post_id, '_movie_badge', $movie['badge']);
        update_post_meta($post_id, '_movie_trailer_video', $movie['trailer_url']);
        
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
        
        // Download image
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $tmp = download_url($movie['image_url']);
        if (!is_wp_error($tmp)) {
            $file_array = array('name' => basename($movie['image_url']), 'tmp_name' => $tmp);
            $id = media_handle_sideload($file_array, $post_id);
            if (!is_wp_error($id)) {
                set_post_thumbnail($post_id, $id);
                echo "✅ CREATED: {$movie['title']} (ID: $post_id, Image: ✓, Trailer: ✓)\n";
            } else {
                @unlink($tmp);
                echo "✅ CREATED: {$movie['title']} (ID: $post_id, Trailer: ✓)\n";
            }
        } else {
            echo "✅ CREATED: {$movie['title']} (ID: $post_id, Trailer: ✓)\n";
        }
        
        $created++;
    } else {
        echo "❌ ERROR: {$movie['title']}\n";
    }
}

echo "\n";
echo "================================================\n";
echo "✅ SETUP COMPLETE!\n";
echo "================================================\n";
echo "📊 Created: $created movies\n";
echo "⏭️  Skipped: $skipped movies (already existed)\n";
echo "📷 Images: Downloaded from Unsplash\n";
echo "🎥 Videos: Added trailer previews\n";
echo "\n🎬 Visit your Movies page to see them!\n";
echo "================================================\n\n";
?>
