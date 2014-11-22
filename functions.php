<?php

global $jdw_current_edition;
$jdw_current_edition = "2013";

/**
 * Personnalisation de WordPress
 * Ajoute des choses, en supporte d'autres
 */
// Supprime differentes balises meta
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rel_prev');

// Supprime jQuery si on n'est pas dans l'admin
if(!is_admin())
	wp_deregister_script('jquery');

// Active le support des styles de l'éditeur dans l'admin
add_editor_style();

// Supprime la balise meta generator
function jdw_remove_generator() {
	return '';
}
add_filter('the_generator', 'jdw_remove_generator');

// Supprime les styles du widget des commentaires récents
function jdw_remove_recent_comments_style() {
	add_filter('show_recent_comments_widget_style', '__return_false');
}
add_action('widgets_init', 'jdw_remove_recent_comments_style');

// Active le support d'une sidebar
if(function_exists('register_sidebar'))
	register_sidebar();

// Supprime le support des apostrophes courbes
// (parce que le résultat est atroce dans les extraits de code)
remove_filter('the_title', 'wptexturize');
remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');

// Ajoute le support d'iframe dans le contenu d'articles
function jdw_add_iframe($initArray) {
	$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width|seamless]";
	return $initArray;
}
add_filter('tiny_mce_before_init', 'jdw_add_iframe');

// Active le support d'un menu dans le footer
function jdw_register_my_menu() {
	register_nav_menu('footer-menu',__('Liens du footer'));
}
add_action('init', 'jdw_register_my_menu');

// Affiche uniquement les articles des 24 jours dans le flux RSS
function jdw_filter_posts_from_RSS($query) {
	if ($query->is_feed) {
		$query->set('cat','1');
	}
	return $query;
}
add_filter('pre_get_posts','jdw_filter_posts_from_RSS');

/**
 * Support de vieux navigateurs sans flex-wrap
 */
function jdw_add_legacy_support() {
	if((is_home() && !is_paged()) || is_year()) {
?>
	<script type="text/javascript">
		(function(d){
			var s = d.style;
			if(!(('flexWrap' in s) || ('WebkitFlexWrap' in s) || ('MozFlexWrap' in s) || ('msFlexWrap' in s))) {
				d.className = 'no-flexwrap';
			}
		})(document.documentElement);
	</script>
<?php
	}
}
add_action('wp_footer', 'jdw_add_legacy_support');

/**
 * Affichage du <title> de la page.
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
 * Vérifie si un utilisateur a fait un don.
 *
 * @see jdwgift_has_made_gift() dans le plugin 24jdwgift
 */
function jdw_has_made_gift() {
	if(function_exists('jdwgift_has_made_gift')) {
		return jdwgift_has_made_gift();
	}
	return false;
}

/**
 * Affiche un lien vers articles précédents.
 */
function jdw_previous_post_link() {
	$current_day = get_the_time('d');
	if($current_day > 1) {
		$current_year = get_the_time('Y');
		$day = mktime(0, 0, 0, 12, $current_day - 1, $current_year);
		$link_text = '<span class="posts-nav-date">le '.date_i18n('l j F Y', $day).'</span>';
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
		$current_year = get_the_time('Y');
		$day = mktime(0, 0, 0, 12, $current_day + 1, $current_year);
		$link_text = '<span class="posts-nav-date">le '.date_i18n('l j F Y', $day).'</span>';
		$link_text .= '<span class="posts-nav-title">%title</span>';
		next_post_link('<span class="posts-nav-link posts-nav-next">%link</span>', $link_text, TRUE);
	}
}
?>