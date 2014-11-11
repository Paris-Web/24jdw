<?php
	get_header();
	if (have_posts()) {
		while (have_posts()) :
			the_post();
?>
		<div class="post">
			<?php if(is_page()) : ?>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<?php else: ?>
			<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php endif; ?>
			<?php if(!is_page()) : ?>
			<p class="post-meta">par <?php the_author(); ?> <time>le <?php the_time('l j F Y') ?></time></p>
			<?php endif; ?>
			<div class="entry">
				<?php if((is_page('merci') && jdw_has_made_gift()) || !is_page('merci')) : ?>
				<?php the_content('<span class="more">Lire la suite</span>', '', ''); ?>
				<?php endif; ?>
			</div>
		</div>
<?php
		endwhile;
	}
?>
	</div>
	<?php get_template_part('donation'); ?>
	<div class="wrap">
<?php get_footer(); ?>