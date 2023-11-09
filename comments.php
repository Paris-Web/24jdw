<?php
global $user_ID;
global $id;
?>
<div class="comments" id="commentaires">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'Un commentaire sur cet article', '%1$s commentaires sur cet article', get_comments_number()),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		<ol class="comments-list">
			<?php // @todo Utiliser wp_list_comments() ?
			foreach ($comments as $comment) : ?>
				<li class="comment-item" id="comment-<?php comment_ID() ?>">
					<div class="comment-avatar" aria-hidden="true"><span><?php jdw_comment_author_initial(get_comment_author()) ?></span></div>
					<div class="comment-body">
						<p class="comment-meta"><strong class="comment-author"><?php comment_author_link() ?></strong>, le <span class="comment-date"><?php comment_date('l j F Y') ?> à <?php comment_time('H:i') ?></span></p>
						<div class="comment-entry">
							<?php comment_text() ?>
						</div>
						<?php if ($comment->comment_approved == '0') : ?>
						<p class="comment-moderation">Votre commentaire est en attente de mod&eacute;ration.</p>
						<?php endif; ?>
						<div class="comment-reply">
							<?php comment_reply_link('', get_comment_ID()); ?>
						</div>
						<?php edit_comment_link('&Eacute;diter'); ?>
					</div>
				</li>
			  <?php
			endforeach; ?>
		</ol>
	<?php endif; ?>
	<?php // @todo Utiliser comment_form() ?
	if ( $post->comment_status == 'open' ) : ?>
	<div class="comments-publish">
		<h2 class="comments-title">Laisser un commentaire </h2>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="comment-form">
			<?php if ( $user_ID ) : ?>
			<p class="user">Connect&eacute; en tant que <strong><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a></strong>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Se d&eacute;connecter du site.">Se d&eacute;connecter&nbsp;&raquo;</a></p>
			<?php else : ?>
				<div class="comment-field comment-field--row">
					<label class="comment-label" for="comment-author">Nom&nbsp;:</label>
					<input class="comment-textbox" type="text" name="author" id="comment-author" value="<?php echo $comment_author; ?>" size="22" required="required" />
				</div>
				<div class="comment-field comment-field--row">
					<label class="comment-label" for="comment-email">E-mail&nbsp;:</label>
					<input class="comment-textbox" type="email" name="email" id="comment-email" value="<?php echo $comment_author_email; ?>" size="22" required="required" />
				</div>
				<div class="comment-field comment-field--row">
					<label class="comment-label" for="comment-url">Site web <em>(facultatif)</em>&nbsp;:</label>
					<input class="comment-textbox" type="url" name="url" id="comment-url" value="<?php echo $comment_author_url; ?>" size="22" />
				</div>
			<?php endif; ?>
			<div class="comment-field comment-field--column">
				<label class="comment-label" for="comment">Votre commentaire&nbsp;:</label>
				<textarea class="comment-textarea" name="comment" id="comment" cols="80" rows="5" required="required"></textarea>
			</div>
			<div class="comment-actions">
				<input class="comment-button" name="submit" type="submit" id="submit" value="Poster mon commentaire" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
			</div>
			<?php do_action('comment_form', $post->ID); ?>
		</form>
		<p class="comment-warning">Les commentaires sont mod&eacute;r&eacute;s manuellement. Merci de respecter&nbsp;: la personne qui a &eacute;crit l'article, les autres participant(e)s &agrave; la discussion, et la langue fran&ccedil;aise. Vous pouvez <a href="<?php the_permalink(); ?>feed">suivre les r&eacute;ponses par flux RSS</a>.</p>
	</div>
	<?php endif; ?>
</div>
