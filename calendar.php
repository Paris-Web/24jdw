<ol class="calendar">
	<?php 
		global $jdw_current_edition;
		$number_of_posts = 0;
		$year = $jdw_current_edition;
		if(is_year())
			$year = get_the_time('Y');
		query_posts('category_name=articles&posts_per_page=28&monthnum=12&order=asc&year='.$year);
		while(have_posts())
		{	
			the_post();
			$day = get_the_date('d');
	?><li class="calendar-day">
				<div class="calendar-day-frame">
					<div class="calendar-day-frame-content">
						<a class="calendar-day-link" href="<?php the_permalink(); ?>">
							<span class="calendar-day-number"><?php echo $day; ?></span>
							<span class="calendar-day-title"><?php the_title(); ?></span> 
							<span class="calendar-day-author">par <?php the_author(); ?></span>
						</a>
					</div>
				</div>
			</li><?php
			$number_of_posts++;
		}
		for($i=$number_of_posts+1; $i <= 24; $i++)
		{
			$day = $i;
			if($day < 10)
				$day = '0'.$day;
	?><li class="calendar-day calendar-day--off">
				<div class="calendar-day-frame">
					<div class="calendar-day-frame-content">
						<span class="calendar-day-number--off"><?php echo $day; ?></span>
					</div>
				</div>
			</li><?php
		}
		wp_reset_query();
	?>
</ol>