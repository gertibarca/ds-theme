<?php get_header(); ?>

<div class="container mt-5">

    <h1>All Movies</h1>

    <?php
    // 1. Get all genres for buttons
    $genres = get_terms(array(
        'taxonomy' => 'movie_genres',
        'hide_empty' => true,
    ));

    // 2. Current selected genre from URL ?genre=slug
    $current_genre = isset($_GET['genre']) ? sanitize_text_field($_GET['genre']) : 'all';

    // 3. Display buttons
    echo '<div class="mb-4">';
    echo '<a href="' . get_post_type_archive_link('movies') . '" class="btn ' . ($current_genre=='all'?'btn-primary':'btn-secondary') . ' me-2">All</a>';
    if(!empty($genres) && !is_wp_error($genres)){
        foreach($genres as $genre){
            $active = ($current_genre == $genre->slug) ? 'btn-primary' : 'btn-secondary';
            echo '<a href="' . add_query_arg('genre', $genre->slug, get_post_type_archive_link('movies')) . '" class="btn ' . $active . ' me-2">'. $genre->name .'</a>';
        }
    }
    echo '</div>';

    // 4. Query movies
    $args = array(
        'post_type' => 'movies',
        'posts_per_page' => -1,
    );

    if($current_genre != 'all'){
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'movie_genres',
                'field' => 'slug',
                'terms' => $current_genre,
            )
        );
    }

    $query = new WP_Query($args);

    if($query->have_posts()){
        echo '<div class="row">';
        while($query->have_posts()){
            $query->the_post();
            echo '<div class="col-md-4 mb-4">';
            if(has_post_thumbnail()){
                echo '<div class="mb-2">' . get_the_post_thumbnail(get_the_ID(), 'medium', array('class'=>'img-fluid rounded')) . '</div>';
            }
            echo '<h3><a href="'. get_permalink() .'">'. get_the_title() .'</a></h3>';
            echo '<div>'. get_the_excerpt() .'</div>';
            echo '<p><strong>Genres:</strong> ' . get_the_term_list(get_the_ID(), 'movie_genres', '', ', ') . '</p>';
            echo '<p><strong>Tags:</strong> ' . get_the_term_list(get_the_ID(), 'post_tag', '', ', ') . '</p>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No movies found.</p>';
    }
    ?>

</div>

<?php get_footer(); ?>