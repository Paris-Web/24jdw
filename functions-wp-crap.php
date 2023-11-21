<?php
/*
 * WordPress Crap
 * Removes all the crap added by WordPress.
 */
// Remove various meta
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rel_prev');

// Remove jQuery if not in admin
if (!is_admin())
	wp_deregister_script('jquery');

// Remove generator meta
function jdw_remove_generator() {
	return '';
}
add_filter('the_generator', 'jdw_remove_generator');

// Remove styles from recent comments widget
function jdw_remove_recent_comments_style() {
	add_filter('show_recent_comments_widget_style', '__return_false');
}
add_action('widgets_init', 'jdw_remove_recent_comments_style');

// Enable support for a Sidebar
if(function_exists('register_sidebar'))
	register_sidebar();


/**
 * Remove empty paragraphs generated inside shortcodes
 *
 * @see https://stackoverflow.com/questions/13510131/remove-empty-p-tags-from-wordpress-shortcodes-via-a-php-functon
 */
remove_filter( 'the_content', 'wpautop' );
add_filter( 'the_content', 'wpautop', 99 );
add_filter( 'the_content', 'shortcode_unautop', 100 );

/**
 * Supprime les styles injectés pour Gutenberg
 */
function jdw_disable_gutenberg() {
	wp_dequeue_style('classic-theme-styles');
	wp_dequeue_style('global-styles');
	wp_dequeue_style('wp-block-library');
	wp_dequeue_style('wp-block-library-theme');
}
add_filter('wp_enqueue_scripts', 'jdw_disable_gutenberg', 100);
?>
