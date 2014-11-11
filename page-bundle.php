<?php
/*
	Template Name: Bundle 2013
*/
?><?php
	get_header();
	if (have_posts()) {
		the_post();
?>
	</div>
	<div class="bundle">
		<div class="wrap">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<img class="bundle-img" src="<?php bloginfo('template_url'); ?>/images/bundle/bundle.png" alt="Faites un don et recevez un lot d'e-books !" width="660" height="210" />
		</div>
	</div>	
	<div class="wrap">
		<div class="bundle-button">
			<?php get_template_part('paypal-button'); ?>
		</div>
		<div class="post">
			<div class="entry">
				<?php if((is_page('merci') && jdw_has_made_gift()) || !is_page('merci')) : ?>
				<?php the_content('<span class="more">Lire la suite</span>', '', ''); ?>
				<?php endif; ?>
			</div>
		</div>
		<?php get_template_part('bundle'); ?>
<?php
	}
	get_footer();
?>