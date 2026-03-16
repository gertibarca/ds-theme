<?php
/*
Template Name: Search Page
*/

?>

<?php get_header(); ?>

<div class="wrap">

    <div id="primary" class="content-area">
        <main id="main" class="sit-main">

            <h1>Search Posts</h1>

            <p>
                My site feautures articles about
                <a href="/category/wordpress/">Wordpress</a>,
                <a href="/category/web-design/">Web Design</a>,
                <a href="/category/website-development/">Development</a>,
                and <a href="/category/css/">Css</a>
            </p>

            <p> to search my website, please use the form below,</p>
            <?php get_search_form();?>

        </main>

    </div>

</div>

<?php get_footer();?>