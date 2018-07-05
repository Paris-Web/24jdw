<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php jdw_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="Le flux RSS de <?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="apple-mobile-web-app-title" content="24j de web" />
	<?php if(is_single() || is_page()) : ?>
	<meta property="og:title" content="<?php the_title(); ?>" />
	<meta property="og:description" content="<?php bloginfo('name'); ?> : <?php bloginfo('description'); ?>" />
	<?php endif; ?>
	<meta property="og:image" content="<?php bloginfo('template_url'); ?>/images/og.jpg" />
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="site">
		<?php if((is_home() && !is_paged()) || (is_year() && get_the_time('Y') != 2016)) : ?>
		<header class="hero">
			<div class="hero-content">
				<h1 class="hero-h1"><a href="<?php bloginfo('home'); ?>" class="hero-logo"><?php jdw_the_logo(); ?></a></h1>
				<p class="hero-baseline"><?php bloginfo('description'); ?></p>
			</div>
		</header>
		<?php else: ?>
		<header class="header">
			<div class="header-content">
				<a href="<?php bloginfo('home'); ?>" class="header-logo"><?php jdw_the_logo(); ?></a>
				<a href="<?php bloginfo('url'); ?>/<?php jdw_the_year(); ?>/" class="header-archive" aria-label="Retour &agrave; l'&eacute;dition <?php jdw_the_year(); ?>"><span class="header-archive-year"><?php jdw_the_year(); ?></span></a>
			</div>
		</header>
		<?php endif; ?>
		<main role="main" class="main">