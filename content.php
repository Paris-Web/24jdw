<article class="post">
	<header class="post-header">
		<?php if( is_page() || is_single() ) : ?>
		<h1 class="post-title"><?php the_title(); ?></h1>
		<?php else: ?>
		<h2 class="post-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
		<?php endif; ?>
		<div class="post-aside post-aside--start">
			<p class="post-metas">
				<span class="post-meta post-meta--author"><?php the_author(); ?></span>
				<time class="post-meta post-meta--date" datetime="<?php the_time('c'); ?>"><?php the_time('j F Y') ?></time>
				<span class="post-meta post-meta--length"><span aria-label="Temps de lecture&nbsp;: environ">~</span>&nbsp;<?php jdw_the_reading_time(); ?> minutes</span>
			</p>
		</div>
		<div class="post-aside post-aside--end">
			<p class="post-meta post-meta--share">Partager&nbsp;: <a class="post-share-link post-share-link--facebook" href="https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" title="Partager cet article sur Facebook" onClick="_gaq.push(['_trackEvent', 'Partage', 'Partager sur Facebook', '<?php echo esc_attr(get_the_title()); ?>']);">Facebook</a><a class="post-share-link post-share-link--twitter" href="http://www.twitter.com/home?status=<?php echo esc_attr(get_the_title().' '.get_permalink().' (via @24joursdeweb)'); ?>" title="Partager cet article sur Twitter" onClick="_gaq.push(['_trackEvent', 'Partage', 'Partager sur Twitter', '<?php echo esc_attr(get_the_title()); ?>']);">Twitter</a></p>
			<?php if(get_comments_number() > 0): ?>
			<p class="post-meta post-meta--comments">
				<a class="post-comments-link" href="#commentaires" onClick="_gaq.push(['_trackEvent', 'Anchor Link', 'Commentaires', '<?php esc_attr(get_the_title()); ?>']);"><u>Commentaires</u> (<?php echo get_comments_number(); ?>)</a>
			</p>
			<?php endif; ?>
		</div>
	</header>
	<div class="post-entry">
		<?php
			if ( is_search() || is_archive() ) {
				the_excerpt();
			} else {
				the_content('<span class="post-more">Lire la suite</span>', '', '');
			}
		?>
	</div>
	<?php if( is_single() && has_category('articles')) : ?>
	<footer class="post-footer">
		<div class="post-author">
			<div class="post-author-avatar">
				<?php
					echo get_avatar(get_the_author_meta('email'), 150, get_the_author_meta('jdwavatar'), get_the_author());
					jdw_multi_author_avatar();
				?>
			</div>
			<div class="post-author-text">
				<div class="post-author-text-content">
					<h2 class="post-author-title">&Agrave; propos de <?php the_author(); ?></h2>
					<p class="post-author-description"><?php the_author_meta('description'); ?></p>
				</div>
			</div>
		</div>
	</footer>
	<?php endif; ?>
</article>
<?php if(has_category('articles')) : ?>
	<div class="posts-nav">
		<?php
			jdw_previous_post_link();
			jdw_next_post_link();
		?>
	</div>
	<?php comments_template(); ?>
<?php endif; ?>