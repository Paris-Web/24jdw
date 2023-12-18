<?php get_header(); ?>
<div class="post">
	<h1 class="post-title">Oups&nbsp;!</h1>
	<div class="entry">
		<p>
			Il n’y a que 24 jours dans un calendrier de l’avent. Et la page <code><?php echo $_SERVER['REQUEST_URI'] ?></code> n’en fait pas partie.
		</p>
		<p>
			Vous êtes cordialement invité à <a href="<?php bloginfo('url'); ?>">revenir à la page d’accueil</a>.
		</p>
	</div>
</div>
<?php get_footer(); ?>
