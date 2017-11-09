<?php
include_once('functions-wp-crap.php');

function jdw_section_shortcode( $atts, $content = null ) {
	return '<div class="section">' . $content . '</div>';
}
add_shortcode( 'section', 'jdw_section_shortcode' );
?>