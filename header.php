<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class() ?>>

<header class="ds-header">
    <div class="header-container">
        <div class="logo">
            <h1><?php bloginfo('name')?></h1>
        </div>
        <div class="header-right">
            <form method="get" action="<?php echo home_url('/'); ?>" class="search-box">
                <input type="text" name="s" placeholder="Search movies..." class="search-input">
                <button type="submit" class="search-btn">
                    <span>🔍</span>
                </button>
            </form>
        </div>
    </div>
</header>