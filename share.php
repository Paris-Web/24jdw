<?php if(!is_home() && !is_page('merci')): ?>
	<?php if(!is_page() && has_category('articles')) : ?>
	<p>
		Vous pouvez partager cet article sur <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" title="Partager cet article sur Facebook" onClick="_gaq.push(['_trackEvent', 'Partage', 'Partager sur Facebook', '<?php echo addslashes(get_the_title()); ?>']);">Facebook</a>, <a href="http://www.twitter.com/home?status=<?php echo urlencode(html_entity_decode(get_the_title()).' '.get_permalink().' (via @24joursdeweb)'); ?>" title="Partager cet article sur Twitter" onClick="_gaq.push(['_trackEvent', 'Partage', 'Partager sur Twitter', '<?php echo addslashes(get_the_title()); ?>']);">Twitter</a> ou <a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" title="Partager cet article sur Google+" onClick="_gaq.push(['_trackEvent', 'Partage', 'Partager sur Google+', '<?php echo addslashes(get_the_title()); ?>']);">Google+</a>.
	</p>
	<?php elseif(!jdw_has_made_gift()): ?>
	<p>
		Si vous aimez ce projet, aidez-nous en faisant un don pour <a href="<?php bloginfo('url'); ?>/2013/association-handiparentalite/">l'association Handiparentalit&eacute;</a>.
	</p>	
	<?php endif; ?>
<?php endif; ?>