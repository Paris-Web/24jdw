<?php
include_once('functions-wp-crap.php');

/**
 * Ajoute les styles du thème
 */
function jdw_theme_styles() {
	wp_register_style(
		'styles',
		get_bloginfo('stylesheet_url'),
		array(),
		'10.0.0',
		'all'
	);
	
	wp_enqueue_style('styles');
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
			'prismCSS',
			get_stylesheet_directory_uri().'/css/prism.css',
			array(),
			'1.25.0.20211204',
			'all'
		);

		wp_register_script(
			'prismJS',
			get_stylesheet_directory_uri().'/js/prism.js',
			array(),
			'1.25.0.20211204',
			false
		);

		wp_enqueue_style('prismCSS');
		wp_enqueue_script('prismJS');
	}
}
add_action('wp_enqueue_scripts', 'jdw_add_prism');

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
function jdw_the_logo() {
	$year = jdw_get_the_year();

	if($year == 2012 || $year == 2016) {
		$year = 2017;
	}

	$extension = '.png';

	if($year >= 2018) {
		$extension = '.svg';
	}

	$filename = 'logo';

	if(is_singular() && $year == 2021) {
		$filename = 'logo-alt';
	}

	$logo = '<img src="'.get_bloginfo('template_url').'/images/header/'.$year.'/'.$filename.$extension.'" width="160" height="60" alt="'.get_bloginfo('name').'" title="" />';

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

	if($year == '2022') {
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
	return 2022;
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
?>
