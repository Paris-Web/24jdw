		</main>
		<?php
			if(!is_single()) {
				//get_template_part('donation');
			}

			$logo_path = '/images/footer/logo.png';
			
			if($year == 2021) {
				$logo_path = '/images/header/2021/logo-alt.svg';
			}
		?>
		<footer class="footer">
			<div class="footer-content">
				<div class="footer-column footer-column--logo">
					<a href="<?php bloginfo('home'); ?>" class="footer-logo">
						<img class="footer-logo-img" src="<?php bloginfo('template_url'); echo $logo_path; ?>" alt="<?php echo get_bloginfo('name') ?>" />
					</a>
				</div>
				<div class="footer-column footer-column--text">
					<p class="footer-baseline"><b>24 jours de web</b>, le calendrier de l&rsquo;avent des gens qui font le web d&rsquo;après.</p>
					<p>2012-<?php echo date("Y"); ?>, tous droits r&eacute;serv&eacute;s.</p>
					<?php jdw_the_illustrator(); ?>
				</div>
				<div class="footer-column footer-column--links">
					<ul class="footer-links">
						<li><a href="<?php bloginfo('url'); ?>/a-propos/">&Agrave; Propos</a></li>
						<li><a href="<?php bloginfo('url'); ?>/mentions-legales/">Mentions l&eacute;gales</a></li>
						<li><a href="<?php bloginfo('url'); ?>/remerciements/">Remerciements</a></li>
						<li><a href="https://github.com/kloh-fr/24jdw/issues">Signaler un probl&egrave;me</a></li>
						<li class="footer-link--twitter"><a href="https://www.twitter.com/24joursdeweb">@24joursdeweb sur Twitter</a></li>
					</ul>
				</div>
				<div class="footer-archives">
					<strong class="footer-archives-title">24 jours d&rsquo;archives</strong>
					<ul class="footer-archives-links">
						<li><a href="<?php bloginfo('url'); ?>/2021/">&Eacute;dition 2021</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2020/">&Eacute;dition 2020</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2019/">&Eacute;dition 2019</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2018/">&Eacute;dition 2018</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2017/">&Eacute;dition 2017</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2016/">#nowwwel 2016</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2015/">&Eacute;dition 2015</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2014/">&Eacute;dition 2014</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2013/">&Eacute;dition 2013</a></li>
						<li><a href="<?php bloginfo('url'); ?>/2012/">&Eacute;dition 2012</a></li>
					</ul>
				</div>
			</div>
		</footer>
	</div>
	<?php if(is_active_sidebar('jdw-footer-sidebar')): ?>
		<?php dynamic_sidebar('jdw-footer-sidebar'); ?>
	<?php endif; ?>
	<?php wp_footer(); ?>
</body>
</html>
