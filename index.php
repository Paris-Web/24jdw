<?php
	get_header();
	if (have_posts()) {
		while (have_posts()) :
			the_post();
?>
		<main class="post" role="main" tabindex="-1">
			<?php if(is_page() || is_single()) : ?>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<?php else: ?>
			<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
			<?php endif; ?>
			<?php if(!is_page()) : ?>
			<p class="post-metas">
				<span class="post-meta post-meta--author"><?php the_author(); ?></span>
				<time class="post-meta post-meta--date"><?php the_time('j F Y') ?></time>
				<span class="post-meta post-meta--length"><span aria-label="Temps de lecture&nbsp;: environ">~</span> <?php jdw_the_reading_duration(); ?> minutes</span>
			</p>
			<?php endif; ?>
			<div class="entry">
				<?php if((is_page('merci') && jdw_has_made_gift()) || !is_page('merci')) : ?>
				<?php the_content('<span class="more">Lire la suite</span>', '', ''); ?>
				<?php endif; ?>
			</div>
		</main>
<?php
		endwhile;
	}
?>
	</div>
	<?php
		if(!is_page('bundle')) {
			get_template_part('donation');
		}
	?>
	<div class="wrap">
<?php get_footer(); ?>