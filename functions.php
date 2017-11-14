<?php
include_once('functions-wp-crap.php');

/*
 * Shortcode de section
 * (Ex: [section]…[/section])
 */
function jdw_section_shortcode( $atts, $content = null ) {
	return '<div class="section">' . $content . '</div>';
}
add_shortcode( 'section', 'jdw_section_shortcode' );

/*
 * Reading duration
 * (Based on http://www.wpexplorer.com/reading-duration-wordpress-shortcode/)
 */
function jdw_get_reading_duration() {
	global $post;
	$post_id = $post->ID;
	$words_per_minute = 200;
	$estimated_reading_time = jdw_get_post_reading_time( $post_id, $words_per_minute );
	return $estimated_reading_time;
}

function jdw_the_reading_duration() {
	echo jdw_get_reading_duration();
}

/*
 * Get post reading time
 * (Based on http://www.wpexplorer.com/reading-duration-wordpress-shortcode/)
 */
function jdw_get_post_reading_time( $post_id, $words_per_minute ){

	// Get post's words
	$content     = get_the_content( $post_id );
	$count_words = str_word_count( strip_tags( $content ) );

	// Get Estimated time
	$minutes = floor( $count_words / $words_per_minute);

	// If less than a minute
	if( $minutes <= 1 ) {
		$estimated_time = 1;
	}

	// If more than a minute
	if( $minutes > 1 ) {
		$estimated_time = $minutes;
	}

	return $estimated_time;
}
?>