<ol class="calendar">
	<?php
		$number_of_posts = 0;

		$year = jdw_get_the_year();

		// @fixme ne pas commiter !!
		query_posts('category_name=articles&posts_per_page=28&monthnum=11&order=asc&year='.$year);
		while(have_posts()) {
			the_post();
			$day = get_the_date('d');
	?>
	<li class="day">
		<a class="day-link" href="<?php the_permalink(); ?>">
			<span class="day-number"><?php echo $day; ?></span>
			<span class="day-title"><?php the_title(); ?></span>
			<span class="day-author">par <?php the_author(); ?></span>
		</a>
	</li>
	<?php
			$number_of_posts++;
		}
		for($i=$number_of_posts+1; $i <= 24; $i++) {
			$day = $i;
			if($day < 10) {
				$day = '0'.$day;
			}
	?>
	<li class="day-off">
		<span class="day-off-cell"><span class="day-off-number"><?php echo $day; ?></span></span>
	</li>
	<?php
		}
		wp_reset_query();
	?>
</ol>
