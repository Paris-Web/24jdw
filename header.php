<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<title><?php jdw_title(); ?></title>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
	<link rel="alternate" type="application/rss+xml" title="Le flux RSS de <?php bloginfo('name'); ?>" href="<?php bloginfo('rss2_url'); ?>" />
	<meta name="viewport" content="initial-scale=1.0" />
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
		<div class="header header-main">
			<div class="wrap">
				<h1 class="logo"><a href="<?php bloginfo('home'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/header/logo.png" width="234" height="88" alt="24 jours de web" title="" /></a></h1>
				<p class="baseline"><?php bloginfo('description'); ?></p>
				<a href="<?php bloginfo('home'); ?>"><img class="santa" src="<?php bloginfo('template_url'); ?>/images/header/santa.png" width="370" height="255" alt="" title="" /></a>
			</div>
		</div>
		<?php else : ?>
		<div class="header header-back">
			<div class="wrap">
				<a href="<?php bloginfo('home'); ?>" class="logo-link"><?php bloginfo('name'); ?></a>
				<?php if(get_comments_number() > 0): ?>
				<a href="#commentaires" class="comments-link" onClick="_gaq.push(['_trackEvent', 'Anchor Link', 'Commentaires', '<?php echo addslashes(get_the_title()); ?>']);">Commentaires</a>
				<?php endif; ?>
			</div>
		</div>	
		<?php endif; ?>
		<div class="page wrap">