<?php if(!jdw_has_made_gift() && !is_page('merci')) : ?>
<div class="donation" id="don">
	<div class="wrap">
		<?php get_template_part('share'); ?>
		<div class="gift box">
			<h3 class="box-title"><span onclick="formPaypal.submit()">Faites un don</span> pour soutenir l'association Handiparentalit&eacute;&nbsp;!</h3>
			<div class="gift-button">
				<?php get_template_part('paypal-button'); ?>
			</div>
		</div>
		<div class="description">
			<p>
				<a href="<?php bloginfo('url'); ?>/2013/association-handiparentalite/">L'association Handiparentalit&eacute;</a> a pour objet d'aider les parents ou futur-parents en situation de handicap, et de faire reconna&icirc;tre le statut de parent handicap&eacute; au niveau des institutions.
			</p>
			<p>
				Les fonds r&eacute;colt&eacute;s vont directement sur le compte PayPal de l'association. En cliquant sur le bouton &quot;Faire un don" ci-dessus, vous allez &ecirc;tre redirigé vers PayPal. Vous n'&ecirc;tes pas oblig&eacute;s de cr&eacute;er un compte PayPal pour faire un don.
			</p>
		</div>
	</div>
</div>
<?php else : ?>
<div class="kthxbye">
	<div class="wrap">
		<?php get_template_part('share'); ?>
		<div class="thx box">
			<h3 class="box-title"><span>Merci beaucoup</span> pour votre générosité.</h3>
		</div>
		<p>Pour vous remercier, voici une photo de chaton.</p>
		<?php if(!is_page('merci')): ?>
		<p>Vous recevrez prochainement par e-mail les informations pour télécharger vos e-books.</p>
		<?php endif; ?>
		<?php jdw_the_kitten(); ?>
	</div>
</div>
<?php endif; ?>