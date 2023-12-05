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

/*
 * Disable Emojis
 * What a load of crap introduced in WordPress 4.2.
 *
 * Original code from Ryan Hellyer and the Disable Emojis plugin.
 * @see https://geek.hellyer.kiwi/plugins/disable-emojis/
 */
function jdw_disable_emojis() {
	remove_action('wp_head', 'print_emoji_detection_script', 7);
	remove_action('admin_print_scripts', 'print_emoji_detection_script');
	remove_action('wp_print_styles', 'print_emoji_styles');
	remove_action('admin_print_styles', 'print_emoji_styles');
	remove_filter('the_content_feed', 'wp_staticize_emoji');
	remove_filter('comment_text_rss', 'wp_staticize_emoji');
	remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
add_action('init', 'jdw_disable_emojis');


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


function jdw_remove_wptypography_inline_styles() {
	wp_style_is('wp-typography-custom', 'enqueued')
	&& wp_style_add_data('wp-typography-custom', 'after', '');
}
add_action('wp_print_styles', 'jdw_remove_wptypography_inline_styles');
?>
