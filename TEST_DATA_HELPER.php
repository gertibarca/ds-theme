<?php
/**
 * TEMPORARY TEST DATA FOR MOVIES
 * 
 * Add this code to functions.php temporarily to create test movies
 * with placeholder images and data so you can see the design working.
 * 
 * Copy code below and paste in a code snippet plugin or add to functions.php
 */

// Create test movies with sample data
function ds_create_test_movies() {
    // Only run once
    if (get_option('ds_test_movies_created')) {
        return;
    }

    $test_movies = array(
        array(
            'title'       => 'Avatar: The Way of Water',
            'excerpt'     => 'Join the Sully family as they explore the stunning underwater world of Pandora in this epic sci-fi adventure.',
            'content'     => 'A continuation of the story that began in Avatar, followers now learn of Jake Sully\'s life as an Navi and his family.',
            'imdb'        => '7.3',
            'badge'       => '4K Ultra HD',
            'year'        => '2022',
            'duration'    => '192',
            'genres'      => array('Science Fiction', 'Fantasy', 'Adventure'),
        ),
        array(
            'title'       => 'The Shawshank Redemption',
            'excerpt'     => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
            'content'     => 'Framed in the 1940s for the double murder of his wife and lover, Andy Dufresne is sent to Shawshank Penitentiary.',
            'imdb'        => '9.3',
            'badge'       => 'Award-Winner',
            'year'        => '1994',
            'duration'    => '142',
            'genres'      => array('Drama'),
        ),
        array(
            'title'       => 'Inception',
            'excerpt'     => 'A skilled thief who steals corporate secrets through dream-sharing technology is given the inverse task of planting an idea.',
            'content'     => 'Cobb, a skilled thief who specializes in extraction, is offered a chance to regain his old life as payment for a seemingly impossible task.',
            'imdb'        => '8.8',
            'badge'       => 'Oscar Nominated',
            'year'        => '2010',
            'duration'    => '148',
            'genres'      => array('Science Fiction', 'Thriller'),
        ),
        array(
            'title'       => 'The Dark Knight',
            'excerpt'     => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest tests.',
            'content'     => 'Batman must face off against the Joker, a criminal mastermind who wants to plunge Gotham into anarchy and chaos.',
            'imdb'        => '9.0',
            'badge'       => 'Trending',
            'year'        => '2008',
            'duration'    => '152',
            'genres'      => array('Action', 'Crime', 'Drama'),
        ),
        array(
            'title'       => 'Interstellar',
            'excerpt'     => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
            'content'     => 'A team of explorers travel through a wormhole near Saturn in search of a new home for humanity.',
            'imdb'        => '8.6',
            'badge'       => 'New Release',
            'year'        => '2014',
            'duration'    => '169',
            'genres'      => array('Adventure', 'Drama', 'Science Fiction'),
        ),
        array(
            'title'       => 'Pulp Fiction',
            'excerpt'     => 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.',
            'content'     => 'The stories of various Los Angeles criminals intertwine in four tales of violence and redemption.',
            'imdb'        => '8.9',
            'badge'       => 'Cult Classic',
            'year'        => '1994',
            'duration'    => '154',
            'genres'      => array('Crime', 'Drama'),
        ),
    );

    // Create placeholder image URL (1px blue gif as fallback)
    $placeholder = 'data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==';

    foreach ($test_movies as $movie) {
        // Create the post
        $post_id = wp_insert_post(array(
            'post_title'   => $movie['title'],
            'post_content' => $movie['content'],
            'post_excerpt' => $movie['excerpt'],
            'post_status'  => 'publish',
            'post_type'    => 'movies',
        ));

        if ($post_id) {
            // Add custom fields
            update_post_meta($post_id, '_movie_imdb_rating', $movie['imdb']);
            update_post_meta($post_id, '_movie_badge', $movie['badge']);
            update_post_meta($post_id, '_movie_year', $movie['year']);
            update_post_meta($post_id, '_movie_duration', $movie['duration']);

            // Add placeholder featured image (you'll need to upload real ones)
            // For now, set a blank featured image reference
            
            // Add genres
            wp_set_post_terms($post_id, $movie['genres'], 'movie_genres', false);
        }
    }

    // Mark as created so it doesn't run again
    update_option('ds_test_movies_created', true);
}

// Uncomment the line below to create test movies
// add_action('init', 'ds_create_test_movies');

?>
