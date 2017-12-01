<?php
	get_header();
	if(get_the_time('Y') == 2016) {
		get_template_part('message-nowwwel');
	} else {
		get_template_part('calendar');
	}
	get_footer();
?>