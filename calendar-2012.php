<ol class="calendar--2012">
	<?php
		$number_of_posts = 0;

		$year = jdw_get_the_year();

		query_posts('category_name=articles&posts_per_page=28&monthnum=12&order=asc&year='.$year);
		while(have_posts()) {
			the_post();
			$day = get_the_date('d');
	?>
	<li class="calendar-day--2012">
		<a class="calendar-day-link--2012 calendar-day-<?php echo $day; ?>" href="<?php the_permalink(); ?>" title="<?php the_title(); ?> par <?php the_author(); ?>"><?php echo $day; ?></a>
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
	<li class="calendar-day--2012">
		<span class="calendar-day-off--2012"><?php echo $day; ?></span>
	</li>
	<?php
		}
		wp_reset_query();
	?>
</ol>
<ol class="posts-list--2012" reversed>
	<?php 
		query_posts('category_name=articles&posts_per_page=28&monthnum=12&year='.$year);
		while(have_posts())
		{
			the_post();
			echo '<li class="list-post--2012"><a class="list-post-link--2012" href="'.get_permalink().'"><span class="list-post-day--2012">'.get_the_date('d').'.</span> <span class="list-post-title--2012">'.get_the_title().' <span class="list-post-author--2012">par '.get_the_author().'</span></span></a></li>';
		}
	?>
</ol>