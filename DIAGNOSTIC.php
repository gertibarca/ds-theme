<?php
/**
 * Diagnostic Test
 * 
 * Add this temporarily to functions.php:
 * require_once 'DIAGNOSTIC.php';
 * 
 * Then visit any page and you'll see debug info at the bottom
 */

// Check what template is being used
error_log('=== WORDPRESS TEMPLATE DIAGNOSTICS ===');
error_log('Is Post Type Archive (movies)? ' . (is_post_type_archive('movies') ? 'YES' : 'NO'));
error_log('Is Archive? ' . (is_archive() ? 'YES' : 'NO'));
error_log('Current Post Type: ' . get_post_type());

// List all PHP files in theme
$files = glob(get_template_directory() . '/*.php');
error_log('PHP Files Found: ' . count($files));
foreach ($files as $file) {
    error_log('  - ' . basename($file));
}

// Check if archive-movies.php exists
$archive_file = get_template_directory() . '/archive-movies.php';
error_log('archive-movies.php exists? ' . (file_exists($archive_file) ? 'YES' : 'NO'));

if (is_post_type_archive('movies')) {
    error_log('>>> YOU ARE ON MOVIES ARCHIVE PAGE <<<');
    error_log('archive-movies.php should load');
}
?>
