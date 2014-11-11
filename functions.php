<?php

global $jdw_current_edition;
$jdw_current_edition = "2013";

// Customisation de WordPress ******************************
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'rel_prev');
remove_action('wp_head', 'aktt_head');
if(!is_admin()) {
	wp_deregister_script('jquery');
}
add_editor_style();

function jdw_remove_generator() {
	return '';
}
add_filter('the_generator', 'jdw_remove_generator');

function jdw_remove_recent_comments_style() {
	add_filter('show_recent_comments_widget_style', '__return_false');
}
add_action('widgets_init', 'jdw_remove_recent_comments_style');

if(function_exists('register_sidebar'))
	register_sidebar();

// Disable curly quotes
remove_filter('the_title', 'wptexturize');
remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');
remove_filter('the_excerpt', 'wptexturize');  

// Iframe
function jdw_add_iframe($initArray) {
	$initArray['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width|seamless]";
	return $initArray;
}

add_filter('tiny_mce_before_init', 'jdw_add_iframe');

// Fonctions utilitaires ***********************************
function jdw_title()
{
	if(is_home())
	{
		echo get_bloginfo('name').' : '.get_bloginfo('description');
	}
	else
	{
		if(is_year())
			echo "&Eacute;dition ";
		wp_title('-', true, 'right');
		bloginfo('name');
	}
}

// Don *****************************************************
function jdw_has_made_gift()
{
	if(function_exists('jdwgift_has_made_gift')) {
		return jdwgift_has_made_gift();
	}
	return false;
}

// Inclure uniquement les articles dans le flux RSS ********
function jdw_filter_tweets_from_RSS($query) {
	if ($query->is_feed) {
		$query->set('cat','1');
	}
	return $query;
}
add_filter('pre_get_posts','jdw_filter_tweets_from_RSS');


// Avatar de certains auteurs ******************************
function jdw_get_the_author_avatar($user_login) {
	$avatar_img = '';
	// 2012
	if($user_login == 'auteur-cleprevost')
		$avatar_img = 'http://media.24joursdeweb.fr/2012/12/charleslp.jpg';
	else if($user_login == 'auteur-kdubost')
		$avatar_img = 'http://media.24joursdeweb.fr/2012/12/kdubost.jpg'; 
	else if($user_login == 'auteur-ckeirua')
		$avatar_img = 'http://media.24joursdeweb.fr/2012/12/ckeirua.jpg'; 
	else if($user_login == 'auteur-ahaasser')
		$avatar_img = 'http://media.24joursdeweb.fr/2012/12/ahaasser.jpg'; 
	// 2013	
	else if($user_login == 'auteur-rbrasier')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/rbrasier.jpg'; 
	else if($user_login == 'auteur-jhenrotte')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/jhenrotte.jpg'; 
	else if($user_login == 'auteur-commitstrip')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/commitstrip.jpg'; 
	else if($user_login == 'auteur-jrivalan')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/jrivalan.jpg'; 
	else if($user_login == 'auteur-mcpaccard')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/mcpaccard.jpg'; 
	else if($user_login == 'auteur-drousset')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/drousset.jpg'; 
	else if($user_login == 'auteur-aleygues')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/aleygues.jpg'; 
	else if($user_login == 'auteur-ndeschamps')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/naomi.jpg'; 
	else if($user_login == 'auteur-bmenant')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/bmenant.jpg'; 
	else if($user_login == 'auteur-rgrumeau')
		$avatar_img = 'http://media.24joursdeweb.fr/2013/12/rgrumeau.jpg'; 
	return $avatar_img;
}

// Liens vers les articles précédents/suivants *************
function jdw_previous_post_link()
{	
	$current_day = get_the_time('d');
	if($current_day > 1)
	{
		$current_year = get_the_time('Y');
		$day = mktime(0, 0, 0, 12, $current_day - 1, $current_year);
		$link_text = '<span class="posts-nav-date">le '.date_i18n('l j F Y', $day).'</span>';
		$link_text .= '<span class="posts-nav-title">%title</span>';
		previous_post_link('<span class="posts-nav-link posts-nav-previous">%link</span>', $link_text, TRUE);
	}
}
function jdw_next_post_link()
{	
	$current_day = get_the_time('d');
	if($current_day < 24)
	{
		$current_year = get_the_time('Y');
		$day = mktime(0, 0, 0, 12, $current_day + 1, $current_year);
		$link_text = '<span class="posts-nav-date">le '.date_i18n('l j F Y', $day).'</span>';
		$link_text .= '<span class="posts-nav-title">%title</span>';
		next_post_link('<span class="posts-nav-link posts-nav-next">%link</span>', $link_text, TRUE);
	}
}

?>