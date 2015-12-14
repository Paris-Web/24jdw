<?php get_header(); ?>
<?php if(is_year()): ?>
	<h1 class="archive-title">&Eacute;dition <?php the_time('Y'); ?></h1>
<?php endif; ?>
<?php
	if(is_year() && get_the_time('Y') == '2012') {
		get_template_part('calendar-2012');
	}
	else {
		get_template_part('calendar');
	}
?>
</div>
<?php get_template_part('donation'); ?>
<div class="wrap">
<?php get_footer(); ?>