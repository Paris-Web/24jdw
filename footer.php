	</main>
	<footer class="footer" role="contentinfo">
		<div class="footer-content">
			<div class="footer-column footer-column--logo">
				<a href="<?php bloginfo('home'); ?>" class="footer-logo">
					<?php jdw_the_logo(true); ?>
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
					<li class="footer-link--socials footer-link--github">
						<a href="https://github.com/Paris-Web/24jdw/issues">
							<svg aria-hidden="true" width="20" height="20">
								<use href="<?php bloginfo('template_url') ?>/images/icon-socials.svg#github"></use>
							</svg>
							Signaler un problème
						</a>
					</li><li class="footer-link--socials">
						<a href="https://mamot.fr/@parisweb">
							<svg aria-hidden="true" width="32" height="32">
								<use href="<?php bloginfo('template_url') ?>/images/icon-socials.svg#mastodon"></use>
							</svg>
							@ParisWeb sur Mastodon
						</a>
					</li>
					<li class="footer-link--socials">
						<a href="https://www.facebook.com/ParisWeb">
							<svg aria-hidden="true" width="28" height="28">
								<use href="<?php bloginfo('template_url') ?>/images/icon-socials.svg#facebook"></use>
							</svg>
							@ParisWeb sur Facebook
						</a>
					</li>
					<li class="footer-link--socials">
						<a href="https://www.twitter.com/ParisWeb">
							<svg aria-hidden="true" width="28" height="28">
								<use href="<?php bloginfo('template_url') ?>/images/icon-socials.svg#twitter"></use>
							</svg>
							@ParisWeb sur Twitter
						</a>
					</li>
				</ul>
			</div>
			<div class="footer-archives">
				<strong class="footer-archives-title">24 jours d&rsquo;archives</strong>
				<ul class="footer-archives-links">
					<li><a href="<?php bloginfo('url'); ?>/2022/">&Eacute;dition 2022</a></li>
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
	<?php if(is_active_sidebar('jdw-footer-sidebar')): ?>
		<?php dynamic_sidebar('jdw-footer-sidebar'); ?>
	<?php endif; ?>
	<?php wp_footer(); ?>
</body>
</html>
