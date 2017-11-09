<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title>24 jours de web</title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="Le flux RSS de <?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-title" content="24j de web" />
	<?php if(is_single() || is_page()) : ?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:description" content="<?php bloginfo('name'); ?> : <?php bloginfo('description'); ?>" />
	<?php endif; ?>
	<link href="https://fonts.googleapis.com/css?family=Raleway:400,700,900" rel="stylesheet" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div id="site">