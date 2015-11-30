<?php 
	get_header(); 
	if (have_posts()) :
		the_post();
?>
		<div class="post">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<?php if(has_category('articles')) : ?>
			<p class="post-meta"><span class="post-meta-author">par <?php the_author(); ?></span> <span class="post-meta-date">le <?php the_time('l j F Y') ?></span></p>
			<?php endif; ?>
			<div class="entry">
				<?php the_content(); ?>
			</div>
		</div>
		<?php if(has_category('articles')) : ?>
		<div class="author">
			<span class="author-avatar">
				<?php
					echo get_avatar(get_the_author_meta('email'), 64, get_the_author_meta('jdwavatar'), get_the_author());
					jdw_multi_author_avatar();
				?>
			</span>
			<div class="author-text">
				<h3 class="author-title">&Agrave; propos de <?php the_author(); ?></h3>
				<p class="author-description"><?php the_author_meta('description'); ?></p>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<?php // get_template_part('donation'); ?>
	<div class="wrap">
		<?php if(has_category('articles')) : ?>
			<div class="posts-nav">
				<?php 
					jdw_previous_post_link();
					jdw_next_post_link();
				?>
			</div>
			<?php comments_template(); ?>
		<?php endif; ?>
<?php
	endif;
	get_footer();
?>