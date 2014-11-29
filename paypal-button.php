<form id="formPaypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">
	<input type="hidden" name="cmd" value="_s-xclick" />
	<input type="hidden" name="hosted_button_id" value="5543WCNTC45BL" />
	<?php 
		$page_type = 'Page';
		if(has_category('articles'))
			$page_type = 'Articles';
		else if(is_page('bundle'))
			$page_type = 'Bundle';
		else if(is_home())
			$page_type = 'Accueil';
		else if(is_year())
			$page_type = 'Calendrier';
	?>
	<input type="image" onClick="_gaq.push(['_trackEvent', '<?php echo esc_attr($page_type); ?>', 'Faire un don', '<?php echo esc_attr(get_the_title()); ?>']);" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_donateCC_LG.gif" style="border:0" name="submit" alt="PayPal" />
	<input type="hidden" name="lc" value="FR" />
	<input type="hidden" name="return" value="http://www.24joursdeweb.fr/merci/?ref=pp&t=<?php echo time(); ?>" />
	<input type="hidden" name="cbt" value="Retour sur 24 jours de web" />
	<input type="hidden" name="image_url" value="http://media.24joursdeweb.fr/2014/11/logo-24jdw-paypal-2014.png" />
	<input type="hidden" name="item_name" value="Don pour l'association Un Pas Vers La Vie (via 24 jours de web)" />
	<img alt="" src="https://www.paypalobjects.com/fr_FR/i/scr/pixel.gif" style="border:none; width:1px; height:1px;" />
</form>