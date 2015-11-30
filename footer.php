		</div>
		<div class="footer">
			<?php
				jdw_the_illustrator();
				wp_nav_menu(array(
					'theme_location' => 'footer-menu',
					'container' => 'false',
					'menu_class' => 'footer-links',
					'items_wrap' => '<ul class="%2$s">%3$s</ul>'
				));
			?>
		</div>
	</div>
	<?php wp_footer(); ?>
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-4722865-4']);
		_gaq.push(['_trackPageview']);
		_gaq.push(['_gat._anonymizeIp']);
		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</body>
</html>