<?php if(is_home()): ?>
<div class="nowwwel-message">
	<div class="nowwwel-note">
		<p>Il n'y a <strong>pas de 24 jours de web</strong> cette ann&eacute;e ! Mais plein de gens biens vont &eacute;crire des articles tout au long du mois de d&eacute;cembre et les partager avec le hastag #nowwwel.</p>
		<p class="nowwwel-links"><a href="http://www.hteumeuleu.fr/en-decembre-ecrivez-partagez-hashtag-nowwwel/">Découvrir l'initiative #nowwwel</a> <a href="https://www.twitter.com/search?f=tweets&vertical=default&q=%23nowwwel" class="nowwwel-button">Suivre le hashtag #nowwwel</a></p>
	</div>
</div>
<style>
	.header { margin-top:-2em; }
	.nowwwel-message { position:relative; padding:1em; background:#000; }
	.nowwwel-message:after { content:''; display:block; z-index:1; position:absolute; left:0; right:0; bottom:-110px; height:150px; background:linear-gradient(to top, rgba(0,0,0,0), rgba(0,0,0,1)) }
	.nowwwel-note { color:#000; font:1em/1.5 sans-serif; transform:rotate(-1deg); box-shadow: 0 0 5px rgba(0,0,0,0.25); position: relative; z-index: 2; margin-bottom: -4em; padding: 2em; max-width:600px; margin:0 auto; background: #fff; }
	.nowwwel-note p:first-child { margin-bottom:1.5em; }
	.nowwwel-button { font-weight:bold; background:yellow; }
	.nowwwel-links { text-align:center; }
	.nowwwel-links a { display:inline-block; padding:0.5em 1em; text-decoration:none; }
</style>
<?php endif; ?>