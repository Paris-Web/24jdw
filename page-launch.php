<?php
/*
	Template Name: Lancement 2012
*/
?>
<!doctype html>
<html>
	<head> 
		<title>24 jours de web</title>	
		<meta charset="UTF-8" />
		<meta name="viewport" content="initial-scale=1.0;" />
		<meta name="apple-mobile-web-app-title" content="24j de web" />
		<style type="text/css">
			body { color:#333; font:18px/1.5em Georgia, serif; }
			#site { margin:0 auto; width:660px; text-align:justify; }
			h1 { margin:1em 0 0.5em; font-size:48px; text-align:center;}
			h2 { margin:1.5em 0 1em; font-size:28px; text-align:left; }
			a { color: #333; }
				a:visited { color:#520076; }
			.author, .footer { margin:0 0 1.2em; color:#999; text-align:center; }
				.author a { color:#999; text-decoration:none; }
			.tldr { padding:5px 10px; margin:0 -10px; color:#00529B; text-align:left; background:#BDE5F8; border:1px solid #00529B; border-radius:5px; }
				.tldr a { color:#00529B; }
			.footer { margin:2em 0; }	
			@media screen and (max-width:700px) {
				#site { width:auto; padding:0 20px; }
				h1 { white-space:nowrap; font-size:32px; line-height:48px; }
			}
		</style>
	</head>
	<body>
		<div id="site">
			<h1 class="title">24 jours de web</h1>
			<p class="author">par Rémi (<a href="http://www.twitter.com/HTeuMeuLeu">@HTeuMeuLeu</a>)</p>
			<?php
				if(have_posts()) {
					the_post();
					the_content();
				}
			?>
			<p class="footer"><a href="/">www.24joursdeweb.fr</a></p>
		</div>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-4722865-4']);
			_gaq.push(['_trackPageview']);
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
	</body>
</html>