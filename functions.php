<?php
include_once('functions-wp-crap.php');

/**
 * Ajoute les styles du thème
 */
function jdw_theme_styles() {
	$year = jdw_get_the_year();

	wp_register_style(
		'styles',
		get_bloginfo('stylesheet_url'),
		array(),
		'11.0.0',
		'all'
	);

	wp_register_style(
		'year',
		get_stylesheet_directory_uri().'/css/' . $year . '.css',
		array('styles'),
		'11.0.0',
		'all'
	);

	wp_enqueue_style('styles');
	wp_enqueue_style('year');
}
add_action( 'wp_enqueue_scripts', 'jdw_theme_styles' );

/**
 * Ajoute le support d'iframe dans le contenu d'articles
 */
function jdw_add_iframe($initArray) {
	$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width|seamless]";
	return $initArray;
}
add_filter('tiny_mce_before_init', 'jdw_add_iframe');

/**
 * Personnalise l’éditeur classique en restreignant les options disponibles
 */
function jdw_wysiwyg( $boutons ) {
	$boutons['block_formats'] = 'Paragraphe=p;Titre 2=h2;Titre 3=h3;Titre 4=h4;Titre 5=h5;Titre 6=h6;Pre=pre';
	$boutons['toolbar1'] = 'undo,redo,formatselect,bold,italic,sub,sup,strikethrough,|,bullist,numlist,blockquote,cite,tinymce_abbr_class,|,outdent,indent,|,link,unlink,|,|,juizlangattr,juizhreflangattr,|,|,charmap,|,paste_as_text,removeformat,|,wp_fullscreen';
	$boutons['toolbar2'] = '';
	$boutons['paste_as_text'] = true;
	return $boutons;
}
add_filter( 'tiny_mce_before_init', 'jdw_wysiwyg' );

/**
 * Ajoute le support de gist via oEmbed
 *
 * @see http://blackhillswebworks.com/2013/08/03/embed-gists-on-your-wordpress-blog-without-a-plugin/
 */
wp_embed_register_handler('gist', '/https?:\/\/gist\.github\.com\/([a-z0-9]+)(\?file=.*)?/i', 'jdw_embed_handler_gist');

function jdw_embed_handler_gist($matches, $attr, $url, $rawattr) {
	$embed = sprintf(
			'<script src="https://gist.github.com/%1$s.js%2$s"></script>',
			esc_attr($matches[1]),
			esc_attr($matches[2])
			);
	return apply_filters('embed_gist', $embed, $matches, $attr, $url, $rawattr);
}

/**
 * Ajoute la coloration syntaxique avec Prism.js
 *
 * @see http://prismjs.com/
 */
function jdw_add_prism() {
	if(is_single() || is_page()) {
		wp_register_style(
			'prism',
			get_stylesheet_directory_uri().'/css/vendors/prism.css',
			array(),
			'1.25.0.20211204',
			'all'
		);

		wp_register_script(
			'prism',
			get_stylesheet_directory_uri().'/js/prism.js',
			array(),
			'1.25.0.20211204',
			false
		);

		wp_enqueue_style('prism');
		wp_enqueue_script('prism');
	}
}
add_action('wp_enqueue_scripts', 'jdw_add_prism');

/**
 * Ajoute la gestion des onglets ARIA
 * pour l'article d'Emmanuelle Aboaf en 2022
 *
 * @see https://developer.mozilla.org/en-US/docs/Web/Accessibility/ARIA/Roles/tab_role
 */
function jdw_add_tabs() {
	global $post_id;
	if(
		is_single()
		&& '73' === get_post_field( 'post_author', $post_id )
		&& '2022' === get_the_time( 'Y', $post_id )
	){
		wp_register_style(
			'tabs',
			get_stylesheet_directory_uri().'/css/tabs.css',
			array(),
			'1.0.3',
			'all'
		);

		wp_register_script(
			'tabs',
			get_stylesheet_directory_uri().'/js/tabs.js',
			array(),
			'1.0.3',
			false
		);

		wp_enqueue_style('tabs');
		wp_enqueue_script('tabs');
	}
}
add_action('wp_enqueue_scripts', 'jdw_add_tabs');

/**
 * Affiche uniquement les articles des 24 jours dans le flux RSS
 */
function jdw_filter_posts_from_RSS($query) {
	if ($query->is_feed) {
		$query->set('cat','1');
	}
	return $query;
}
add_filter('pre_get_posts','jdw_filter_posts_from_RSS');

/**
 * Ajoute une classe spécifique avec l'année en page d'archive, et le slug pour une page.
 */
function jdw_add_body_class($classes) {
	$year = jdw_get_the_year();
	$classes[] = 'edition--'.$year;
	if(is_year() || is_home()) {
		$classes[] = 'home--'.$year;
		if($year < 2017) {
			$classes[] = 'home--old';
		} else {
			$classes[] = 'home--new';
		}
	}
	else if(is_page()) {
		global $post;
		$classes[] = 'page--'.$post->post_name;
	}
	return $classes;
}
add_filter('body_class', 'jdw_add_body_class');

/**
 * Shortcode de section
 * (Ex: [section]…[/section])
 */
function jdw_section_shortcode( $atts, $content = null ) {
	return '<div class="section">' . $content . '</div>';
}
add_shortcode( 'section', 'jdw_section_shortcode' );

/**
 * Affichage du <title> de la page.
 *
 * @see wp_title()
 * https://developer.wordpress.org/reference/functions/wp_title/
 */
function jdw_title() {
	if(is_home()) {
		echo get_bloginfo('name').' : '.get_bloginfo('description');
	}
	else {
		if(is_year())
			echo "&Eacute;dition ";
		wp_title('-', true, 'right');
		bloginfo('name');
	}
}

/**
 * Estimation du temps de lecture
 */
function jdw_get_reading_time() {
	global $post;
	$post_id = $post->ID;
	$transient_name = 'jdw_reading_time_'.$post_id;
	$estimated_reading_time = get_transient( $transient_name );
	if( empty( $estimated_reading_time ) ) {
		$words_per_minute = 200;
		$estimated_reading_time = jdw_get_post_reading_time( $post_id, $words_per_minute );
		set_transient( $transient_name, $estimated_reading_time, DAY_IN_SECONDS);
	}
	return $estimated_reading_time;
}

function jdw_the_reading_time() {
	$unit = 'minute';
	$time = jdw_get_reading_time();
	if($time > 1) {
		$unit .= 's';
	}
	echo $time.' '.$unit;
}

/**
 * Calcul de l'estimation du temps de lecture
 *
 * @see http://www.wpexplorer.com/reading-duration-wordpress-shortcode/
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

/**
 * Affiche le logo correspondant à l'année en cours.
 *
 */
function jdw_the_logo($in_footer = false) {
	$year = jdw_get_the_year();

	if($year == 2012 || $year == 2016) {
		$year = 2017;
	}

	$logo = '<img src="'.get_bloginfo('template_url').'/images/header/'.$year.'/logo.png" width="160" height="60" alt="'.get_bloginfo('name').'">';

	if ($year >= 2017 || $in_footer) {
		$logo = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 324.2 121.4" width="192" height="72" role="img" aria-label="' . get_bloginfo('name') . '"' . ($in_footer ? ' class="footer-logo-img"' : '') . '>
				<g fill="var(--24, #26271f)">
					<path d="m147 56.8 10.9-8.6-.9-12.1-2.7-10.1v-5.6l-.9-5.6.9-4.7 2-4.5 1.8-.8 1.5-1.2 6.3-.9h22.2l10.7-.9h50l14.9-.9 6.2-.9h12.2l6.4 1 11.6-.1h5.4l2 .7 3.4.2 7.3 6.5 3.4 5.6 1.8 4.5-.1 2.8 1 2.8v11.2l-.9 6.5-3.5 9.3-7.1 7.7-9.8 4.5-2.5.2-2 .8-6.2.9H287l-5.3 1-5.3 1-7.9-.1-6.4.9h-62.4l-8.7.1-4.5-.9-3.5-1-3.6-.7-1.8-.2-2-.7-7.8-1.1-3.6-.2-4.5-.7-3.5-1-7 2.4m-92.9-50c.3.3 2.1 1.1 2.5 1.6.4 1.1-.4 1.7.3 2.8.2.6 2.3 2.6 2.5 3.4 1.7 6.1 1.6 12.6 1.8 17.3.3 8.2 1 13-1 18.5-.2.7-1.7 1.5-2.1 2-4.4 9.4-9.3 18.6-16 25.7-1.7 1.8-3.9 2.2-5.5 4.2-.7.9-.5 3-1.1 3.8 10-.1 20.5-2.2 31.9-3.4l2.7 25.5c-8.1 2.2-14.7 1.6-22.4 1.4-3.4 0-7.5 1.6-9.5 2-4.9 1-12 .3-15.7.7-5.7.6-13.1 2.2-19.3 2.1-2.3-22 2.1-36.4 12.4-45.6 1.5-1.2 2.9-1 4.3-2.3 2.6-2.3 4.5-6.6 7.3-9s5.2-3.4 7.6-6.3c2.3-3.2 4-6.8 4.8-10.6.4-2.2-.8-2.4.4-3.7 0 0-1.8-5.8-2.2-6.2-.8-1.2-2.1-.8-3.1-1.7-.7-.3-1.9-2.3-2.5-2.4-6.4-1.5-14.5 6-17 9.1-1.1 1.3-1.9 5.2-3.1 6l-1.5.2c-2.7-2.5-5.3-4.2-8.2-6.6-4-3-6-5.5-3.4-10.7C6.6 21.1 19 9.3 32.1 6.4c11.9-2.6 18 1.8 24.2 7.5z"/>
					<path d="M152.5 70.1c-10 1.1-16.7-.7-24.5 2.6.1 5.6 1.4 13.2 1.5 20 0 .3-.1.7 0 1-.1 4-.6 11.3-.5 15.6-6.8-.4-13.5 1.3-19.9 3.1-.6-5.4-1.4-10.9-2.1-16.3-1-7-2-13.7-2.4-19.1-9.1-.3-20.6 1.3-30.6 2.3-.7-6.5-2.6-16.6-1.5-21.8.8-3.9 6.9-12.2 8.8-15.7 2-3.7 2.7-7.7 4.7-11.6.8-1.2 2.7-2.6 3.3-4 .8-1.6.3-3.2 1-4.7.9-1.8 3-3.1 4-5.1 1.1-2.1 2.9-8.1 4.2-9.5l.6-1.1c2.8-1.6 7.2-.3 10.4-1.1.4 0 4.6-2.3 5-2.3 3.8-.9 8-.9 11.9-1.3 1 9.6 1.9 18.8 2.3 29.2.2 4.1.6 11.7 1.2 17.4 5.9 1.2 15 .2 20.9-.4.8 7.9 1.8 16 1.7 22.8zm-36.6-33.8c-.9-4.5-1.3-8.3-1.9-11.7-.5.1-2.6.6-3.1.3-4.5 3.6-6.1 8.7-8.2 14.6-5.1 14.3 7.8 8.9 14.9 5.7-1-.4.4-3.7.3-3.7-.6-.2-2-4.8-2-5.2z"/>
				</g>
				<path fill="var(--jours, #f8f9eb)" d="M188.4 25.4c1.1 3.9.9 15.6-.4 21.7-.1 1.3-.6 2.5-1.4 3.6-.2.2-.6.1-.9.3-.2.2-.4.9-.6.9-3.6 1.4-9.9-.5-11.7-1.8-1.1-.8-2-1.8-2.7-3-.7-1.1-1.2-2.3-1.6-3.5-.3-1.1-.4-2.2-.3-3.4.2-.2.6-1.1.9-1.2 1.2-.4 2.4-.7 3.7-.9.5.9 1.6 3.4 2.4 4 1.9 1.2 4.4.7 5.7-1.2.2-.4.4-.8.5-1.2.2-2.5.3-4.9.3-7.4.1-2.3 0-4.5-.3-6.8h-8.4c.3-2.4.4-4.9.3-7.4 3.4.2 8.2 1 12 .3l.9-.6c.6-.1.9.5 1.2.6 2.6.3 5-.3 7.4.3v6.1c-2.3-.1-4.7.1-7 .6zm30.7 22.1c-1.5 2.2-3.8 3.7-6.3 4.5-3.9.9-5.4-.3-7.7-1.5-1.7-.8-3.2-1.8-4.6-2.9-.4-.3-.7-.7-.9-1.1-2-2.9-4.2-10.2-3.4-15.7l.6-.9c.3-1.7.6-2.8.9-4 .3-.9 0-1.4.3-2.2.6-1 1.3-1.9 2.2-2.8 1.4-2 2.6-4.2 5.5-4.6 4.3-.6 9.9.8 11.7 2.8 3.8 4 5.2 20.4 2.5 27.1-.3.4-.6.9-.8 1.3zm-5.8-21.4c-1.1-1.2-2.7-1.8-4.3-1.5-2.9.3-5.5 4.5-5.8 7.4-.2 1.8.4 3.8.6 5.3.1.5-.2 1.3 0 1.8.4 1.2 2.3 2.1 3.7 2.8.7.6 1.6.9 2.5.9.5-.3 1.1-.6 1.6-.9.9-.3 1.8-.8 2.5-1.5 2-3 1.3-11.6-.8-14.3zm39-1.1c-.1.7-.1 1.3-.1 2-.1 4 .2 7.6-.5 11.5-.2.7-.4 1.5-.8 2.2-.2.4-.3.8-.4 1.3-.4 1.9-.4 3.1-1.2 4.6-.2.3-.5.7-.7 1-.8 1.1-1.7 2.1-2.7 3-2.2 1.5-10.4 2.5-13.3 1.3-1.8-1-3.3-2.5-4.4-4.3-.6-.9-1-1.8-1.4-2.8v-1.3c-.2-.8-.4-1.7-.7-2.8-.4-1.6-.9-3.3-1.2-4.6-.3-3-.3-6.1.1-9.1.3-3.4.8-6.9.8-10.3 2.2.2 4.3.3 6.5.3-.5 3.3-.7 6.7-.6 10 .2 3.3.9 6.6 2.1 9.7.3.8.1 1.7.6 2.2 1.2.8 2.6 1.2 4 1.2.2 0 .8-.3.6-.3 1.2-.5 2.4-.7 3.1-1.5 1.6-2 2.4-6.5 2.9-11.2.3-3.4.4-6.8.4-9.4 2.6-.3 4.2-.4 6.8-.6.1.7.6 2.2.6 2.8.2 1.5-.4 3.7-.5 5.1zm29 25c-1.7-.3-6.1.1-7.4-.6v-.6c-.2-.8-2-1.8-2.4-2.5-1.8-2.4-3.4-4.9-5.2-7.3-.1-.2-.2-.3-.3-.4-1 .4-1.5.2-1.9.4s-.4.5-.6 1.4c-.5 3-.3 6.9-.3 10.1-2.3.3-4.5.4-6.8.3 0-3.8.3-8.1.5-11.9 0-.6.1-1.1.1-1.7.1-2.1-.4-3.5-.3-5.9.2-2 .2-4.1.3-6.1.1-4.6 0-9.2 0-13.8.8-.1 2.2-.3 2.5-.3 3-.2 10.8.3 13.2 1.6 2.9 1.4 6.1 7.4 6.1 12.6 0 1.3-.2 2.5-.6 3.7-.5 1.5-3.4 4.3-4.6 5.2l-1.5.7c-.2.5.2 1 0 1.5.7.9 1.4 1.7 2.2 2.6.9 1 1.9 2.2 2.7 3.3s1.3 2.5 2.2 3.7c.6.8 2.3 1.9 2.4 3 .1.8-.4.5-.3 1zm-16.4-32.6c-.2.2-1 .4-1.2.6v6.4c0-.2-.4.3-.3.7 0 .1 0 .2.1.3 0 .5.2 1.4.3 2.2.4-.1.8-.1 1.2 0 1.3-.5 4-1.1 5.3-1.8l.3-.3c.4-.5.7-1 .9-1.5 1.9-4.5-2.8-6.1-6.6-6.6zm41.6 30.4c0 .1-.1.2-.2.4-1 1.3-2 2.5-3.2 3.7-1.7.9-4.8.4-6.8.3-1 .1-2.1.1-3.1 0-1.8-.3-5.4-2.3-7.9-3.9-.9-.6-1.7-1.2-2.5-1.9.2-.5-.2-1 0-1.5.8-1 1.6-1.9 2.5-2.8.5-.8 1-1.7 1.5-2.5.3.2.6-.1.9 0 .2.1.4.8.6.9 1.9 1.2 4 2.1 6.1 2.4 0 0 1.3.1.9 0 1.9-.9 3.8-1 2.8-4-.3-.8-1.1-1.3-1.5-1.8-.7-1.2-1.5-2.3-2.4-3.4h-.6c-.4-.2-.9-1.3-1.3-1.5-3-2.6-6.4-4.4-5.8-9.9.5-4.4 1.9-6.5 5.5-7.7l1-.6c.9-.1 1.8-.1 2.8 0 2.8.4 5.4 1.4 7.7 3 .4.3 1 .9 1.5 1.3-.1.3.2.9 0 1.2 0 .2-1.9 3-2.1 3.1v.3c-.3.1-.8-.2-.9 0-.9-.5-2.2-2-3.4-2.2-3.7-.4-4.9 3.3-3.1 5.9.8 1.2 2.6 1.8 3.7 2.8 4 3.4 10.1 8.8 7.7 16.6-.3.7 0 1.1-.4 1.8z"/>
				<path fill="var(--de-web, #e1362c)" d="M163.5 84.4c.3.2.6.2.9.4 2.1 1.9 3 5.8 2.3 9.8h.2c-.3 1.5-.3 3.3-.8 4.6-.7 1.2-1.7 2.3-2.9 3.1-2.7 1.5-5.9.6-9.6.4.3-4.2.7-8 .9-11.3 0-.9-.3-2.2-.2-3.3.2-1.8.7-4 .8-6.3 4 .8 5.5.6 8.4 2.6zm-4.8 3.9c-.5 1.4-.2 3-.5 4.6-.1.9-.4 2-.6 3.2.2 0 .4.4.5.4.7 0 1.5-.2 2.1-.5.7 0 1.4-.2 2-.5 2.1-1.2 1.8-5.4.2-6.7-.9-.7-2-1.1-3.2-1.2 0 .3-.5.6-.5.7zm22.6 16.1c-3.9-.2-8.8.1-12.2-.9l.2-2.9c.4-5.5.9-11 1.4-16.2 0-.4.1-2.3.1-2.3 3.8.7 7.9.3 11.7 1.1v.4c.2 1.3.2 2.6 0 3.8-.4 0-1 .1-1.2.1-.4 0-.8-.1-1.1-.3-1.7-.1-3.5-.2-5.2-.1l-.2.6c-.1 1.1-.1 2.2 0 3.2 1.4.3 3 .5 4.6.7.1 1 .1 2.1 0 3.1-1.5 0-3.6.2-5 .3-.1 1.3-.1 2.6 0 3.8 2.1.4 5.1.6 7.4 1v1.5c-.3 1.1-.4 2-.5 3.1zm56.6-26c-.4 2.5-.9 5-1.6 7.4 0 .1 0 .2-.1.3-.6 2-2 4.3-2.7 6.2-.6 1.5-.4 2.2-1 3.8-1.6 4.3-3.5 8.3-5.2 12.8-.5 1.3-.9 2.6-1.4 3.9-2.2.4-4.4.5-6.6.3-.8-1.6-1.4-3.2-2-4.8-1.1-3.2-2.1-6.5-3.4-9.5-.7.1-1.4-.3-2.1-.1-1 .2-2.8 5-4.3 9-.8 2.3-1.5 4.4-1.8 5.3-1.9.1-3.7.1-5.6 0-.5-1.8-1-3.8-1.4-5.9-.6-2.9-1.1-5.9-1.6-8.7-.8-5.2-1.7-10-2.5-14.9-.3-2.6-.8-5.2-1-7.9-.1-.8-.2-1.5-.2-2.3 3.1 0 6.3.2 9.4.6.1.8.3 1.5.4 2.4.4 2.5.7 5.2 1.1 7.9.4 3.3 1 6.6 1.8 9.9 1-.3 1.8.2 2.5-.2l2.7-4.4c.9-1.5 1.3-3.1 2.1-4.8 0 0 1.6.1 1 .4l.7.4c.9 1.5 1.1 3.4 1.8 5 .3.8 1.4 1.7 1.5 2.6 0 .2-.1.9-.1 1.1.2.4.8.3 1 .8.6-.4.6-.1 1.4-.2.5-1.4 1.6-5.3 3-9.3.9-2.8 1.9-5.6 2.8-7.6.7-1.7 1.3-2.8 1.7-2.9 3-.8 8.1.7 10.1 1.3-.1.6-.3 1.3-.4 2.1zm23.3 38.2c-7.1-.4-16 .1-22.3-1.7l.3-5.3c.7-10 1.7-20 2.5-29.5l.3-4.2c6.9 1.2 14.4.6 21.2 2v.7c.5 1.7.1 4.8 0 7-.8 0-1.9.3-2.2.2-.7-.1-1.4-.2-2-.5-3.1-.3-6.3-.3-9.4-.2l-.4 1c-.1 2-.1 3.9 0 5.9 2.6.5 5.4.9 8.3 1.2.1 1.9.1 3.7 0 5.6-2.8.1-6.6.3-9.2.5-.2 2.3-.2 4.7 0 7 3.9.7 9.4 1 13.5 1.9v2.8c-.1 1.9-.3 3.5-.6 5.6zm30-1.4c-.3.2-4.1 2.8-4.4 2.9-1.5.5-3.7.1-5.6 0-5-.1-10.1-.6-15-1.6-.2-1.5-.2-3.2-.2-4.9 0-2.2.2-4.4.5-6.6.1-.3.8-2.2.8-2.4.5-2.7-.1-5 .1-7.4.5-5.5 1.5-12.6 1.8-18.1 7.6.5 18.1.8 19.2 6.8 0 .8 0 1.6-.1 2.4.2 2.6.2 6.3-1.2 8.3-.4.7-2.2 1.2-2.6 2-.1.4.2.7-.1 1 1.9.6 5.1 1.6 6.5 2.8.3.3 0 .6.3 1.1s1.1.7 1.3 1.2c.9 2 .4 7.3-.5 10.4 0 .8-.4 1.5-.8 2.1zm-7.8-10.3c-.2-.1-.4-.9-.6-1.1-.9-.8-1.8-.7-3.1-1.2-.8-.4-2.4-1.4-3.8-1.3-3.4.3-2.4 6.8-2.4 9.7 1.6.3 3.3.4 4.9.3 2.5-.3 7.5-2.4 5.6-6.3l-.6-.1zm-4.6-21.7c-.6-.3-1.1-.6-1.7-.8-3.5-.1-3.3 5-3 8.2.3.1 1.2.2 1.4.5 1.9-.2 3.9-.7 5.7-1.4.6-.3.8-1.1 1.2-1.7 2-3.5-.5-3.9-3.6-4.8z"/>
			</svg>';
	}

	echo $logo;
}

/**
 * Affiche le nom de l'illustrateur·trice de l'année en cours.
 *
 * @see jdw_the_illustrator_name()
 */
function jdw_the_illustrator() {
	if(jdw_get_the_year() <= jdw_get_the_edition()) {
?>
	<p>
		Illustration <?php jdw_the_year(); ?> par <?php echo jdw_the_illustrator_name(); ?>.
	</p>
<?php
	}
}

/**
 * Affiche le nom de l'illustrateur·trice de l'année en cours.
 */
function jdw_the_illustrator_name() {
	$year = jdw_get_the_year();

    if($year == '2023') {
        echo '<a href="https://sophie-rocher.com/">Sophie Rocher</a>';
    } elseif($year == '2022') {
		echo '<a href="https://shop.cecillie.fr/">C&eacute;cile Ricordeau</a>';
	} elseif($year == '2021') {
		echo '<a href="https://sara-h.ch/">Sara Hernandez</a>';
	} elseif($year == '2020') {
		echo '<a href="https://www.instagram.com/maela_cosson/">Ma&euml;la Cosson</a>';
	} elseif($year == '2019') {
		echo '<a href="https://www.redisdead.net/">Laurence Vagner</a>';
	} elseif($year == '2018') {
		echo '<a href="https://www.cabaroc.com/">Jean-Philippe Cabaroc</a>';
	} elseif($year == '2017') {
		echo '<a href="https://www.stpo.fr/">Christophe Andrieu</a>';
	} elseif($year == '2015') {
		echo '<a href="https://www.reuno.net/">Renaud Foresti&eacute;</a>';
	} elseif($year == '2014') {
		echo '<a href="http://www.mickaelmerley.com/">Micka&euml;l Merley</a>';
	} elseif($year == '2013') {
		echo '<a href="https://www.behance.net/gwenoledeschamps">Gw&eacute;nol&eacute; Deschamps</a>';
	} elseif($year == '2012') {
		echo '<a href="https://www.charleslp.com/">Charles Le Pr&eacute;vost</a>';
	}
}

/**
 * Affiche un lien vers articles précédents.
 */
function jdw_previous_post_link() {
	$current_day = get_the_time('d');
	if($current_day > 1) {
		$link_text = '<span class="posts-nav-date">Article pr&eacute;c&eacute;dent&nbsp;:</span>';
		$link_text .= '<span class="posts-nav-title">%title</span>';
		previous_post_link('<span class="posts-nav-link posts-nav-previous">%link</span>', $link_text, TRUE);
	}
}

/**
 * Affiche un lien vers articles suivants.
 */
function jdw_next_post_link() {
	$current_day = get_the_time('d');
	if($current_day < 24) {
		$link_text = '<span class="posts-nav-date">Article suivant&nbsp;:</span>';
		$link_text .= '<span class="posts-nav-title">%title</span>';
		next_post_link('<span class="posts-nav-link posts-nav-next">%link</span>', $link_text, TRUE);
	}
}

/**
 * Récupère l'édition en cours
 */
function jdw_get_the_edition() {
	return 2023;
}

/**
 * Récupère l'année en cours
 */
function jdw_get_the_year() {
	if(is_year() || is_single() || is_archive()) {
		return get_the_time('Y');
	}
	else {
		return jdw_get_the_edition();
	}
}

/**
 * Affiche l'année en cours.
 *
 * @see jdw_get_the_year()
 */
function jdw_the_year() {
	echo jdw_get_the_year();
}

/**
 * Affiche la première lettre du nom de l'auteur(trice) d'un commentaire
 *
 */
function jdw_comment_author_initial($author_name) {
	echo substr($author_name, 0, 1);
}

/**
 * Gestion des avatars multi auteurs.
 * ATTENTION C'EST SUPER DÉGUEULASSE !
 * (Un jour, je ferais mieux que ça. Un jour.)
 */
function jdw_multi_author_avatar() {
	if(is_single('859')) {
		echo '<img alt="Philippe Roser" src="http://media.24joursdeweb.fr/2014/12/philippe.jpg" class="avatar avatar-64 photo" height="64" width="64" />';
	}
	elseif(is_single('878')) {
		echo '<img alt="Matthieu Bu&eacute;" src="http://media.24joursdeweb.fr/2014/12/matthieu.jpg" class="avatar avatar-64 photo" height="64" width="64" />';
	}
	elseif(is_single('919')) {
		echo '<img alt="Juliette Frank de Cuzey" src="http://media.24joursdeweb.fr/2014/12/juliette.jpg" class="avatar avatar-64 photo" height="64" width="64" />';
	}
	elseif(is_single('931')) {
		echo '<img alt="Goulven Champenois" src="http://media.24joursdeweb.fr/2014/12/goulven.jpg" class="avatar avatar-64 photo" height="64" width="64" />';
	}
	elseif(is_single('3300')) {
		echo '<img alt="Nina (LaPalice)" src="https://media.24joursdeweb.fr/2019/12/nina.jpg" class="avatar avatar-64 photo" height="64" width="64" />';
	}
}

/**
 * Ajoute des sidebars administrables
 */
add_action('widgets_init', 'jdw_widgets_init');
function jdw_widgets_init() {
	register_sidebar(array(
		'name' => 'Footer Sidebar',
		'id' => 'jdw-footer-sidebar',
		'description' => 'Des widgets générés après le footer. Utile pour des scripts tiers par exemple.',
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<!--',
		'after_title'   => '-->'
	));
}

/**
 * Masque certaines metabox pour les auteurices
 */
function jdw_remove_meta_boxes() {
	$user = wp_get_current_user();
	if ( array_intersect( ['author', 'contributor'], $user->roles ) ) {
		remove_meta_box( 'postexcerpt', 'post', 'normal' );
		remove_meta_box( 'postcustom', 'post', 'normal' );
		remove_meta_box( 'trackbacksdiv', 'post', 'normal' );
		remove_meta_box( 'commentstatusdiv', 'post', 'normal' );
		remove_meta_box( 'commentsdiv', 'post', 'normal' );
		remove_meta_box( 'juizl-hreflang', 'post', 'normal' );
		remove_meta_box( 'rocket_post_exclude', 'post', 'side' );
	}
}
add_action('admin_head','jdw_remove_meta_boxes');

function jdw_remove_dashboard_meta_boxes() {
	remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  // Incoming Links
	remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  // Quick Press
	remove_meta_box('dashboard_primary', 'dashboard', 'side');   // WordPress blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');   // Other WordPress News
}
add_action('wp_dashboard_setup','jdw_remove_dashboard_meta_boxes');


/**
 * PErmettre aux contributeurs d’ajouter des fichiers
 */
function jdw_allow_contributor_uploads() {
	if (current_user_can('contributor') && !current_user_can('upload_files')) {
		$contributor = get_role('contributor');
		$contributor->add_cap('upload_files');
	}
}

add_action('admin_head', 'jdw_allow_contributor_uploads');



/**
 * Empêche WordPress d’envoyer un mail pour chaque création de compte
 */
function jdw_disable_new_user_notifications() {
	// Débranche l’action standard de WordPress
	remove_action( 'register_new_user', 'wp_send_new_user_notifications' );
	remove_action( 'edit_user_created_user', 'wp_send_new_user_notifications', 10, 2 );

	// Brancher notre propre fonction
	add_action( 'register_new_user', 'jdw_send_new_user_notifications' );
	add_action( 'edit_user_created_user', 'jdw_send_new_user_notifications', 10, 2 );
}
function jdw_send_new_user_notifications( $user_id, $notify = 'user' ) {
	if ( empty($notify) || $notify == 'admin' ) {
		return;
	} elseif( $notify == 'both' ) {
		// Envoyer seulement aux utilisateurs
		$notify = 'user';
	}
	wp_send_new_user_notifications( $user_id, $notify );
}
add_action( 'init', 'jdw_disable_new_user_notifications' );
?>
