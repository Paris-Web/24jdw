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
	<meta property="og:image" content="<?php bloginfo('template_url'); ?>/images/metaog.jpg" />
	<?php wp_head() ?>
</head>
<body <?php body_class(); ?>>
	<div id="site">
		<?php if((is_home() && !is_paged()) || is_year()) : ?>
		<?php the_date('Y'); ?>
		<div class="header header--<?php jdw_the_year(); ?>">
			<div class="wrap">
				<h1 class="logo"><a href="<?php bloginfo('home'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/header/2014/logo.png" width="160" height="60" alt="24 jours de web" title="" /></a></h1>
				<p class="baseline"><?php bloginfo('description'); ?></p>
			</div>
		</div>
		<?php else : ?>
		<div class="header header--back">
			<div class="wrap">
				<a href="<?php bloginfo('home'); ?>" class="logo-link" title="Retour &agrave; l'accueil"><?php bloginfo('name'); ?></a>
				<?php if(get_comments_number() > 0): ?>
				<a href="#commentaires" class="comments-link" onClick="_gaq.push(['_trackEvent', 'Anchor Link', 'Commentaires', '<?php esc_attr(get_the_title()); ?>']);">Commentaires</a>
				<?php endif; ?>
			</div>
		</div>
		<?php endif; ?>
		<div class="page wrap">