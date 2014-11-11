<div class="comments" id="commentaires">
	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'Un commentaire sur &ldquo;%2$s&rdquo;', '%1$s commentaires sur &ldquo;%2$s&rdquo;', get_comments_number()),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>
		<ol class="comments-list">
			<?php foreach ($comments as $comment) : ?>
				<?php 
					if($oddcomment) {
						$commentclass .= " alt-comment"; 
					}
				?>
				<li class="comment<?php if($commentclass != '') echo $commentclass; ?>" id="comment-<?php comment_ID() ?>">
					<?php echo get_avatar($comment, 64); ?>
					<p class="comment-meta"><strong class="comment-author"><?php comment_author_link() ?></strong>, le <span class="date"><?php comment_date('l j F Y') ?> à <?php comment_time('H:i') ?></span></p>
					<?php if ($comment->comment_approved == '0') : ?>
					<em class="moderation">Votre commentaire est en attente de mod&eacute;ration. C'est triste mais c'est comme &ccedil;a. </em>
					<?php endif; ?>
					<div class="comment-entry">
						<?php comment_text() ?>
					</div>
					<div class="reply">
						<?php comment_reply_link('', get_comment_ID()); ?>
					</div>
					<?php edit_comment_link('&Eacute;diter'); ?>
				</li>
			  <?php 
				$oddcomment = !$oddcomment;
			endforeach; ?>
		</ol>
	<?php endif; ?>		
		
	<?php if ('open' == $post->comment_status) : ?>
		<h2 class="comments-title">Laisser un commentaire </h2>
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post" class="comment-form">
		
			<?php if ( $user_ID ) : ?>
			
			<p class="user">Connect&eacute; en tant que <strong><a href="<?php echo get_option('siteurl'); ?>/wp-admin/profile.php"><?php echo $user_identity; ?></a></strong>. <a href="<?php echo get_option('siteurl'); ?>/wp-login.php?action=logout" title="Se d&eacute;connecter du site.">Se d&eacute;connecter  &raquo;</a></p>
			
			<?php else : ?>
			
				<div class="comment-field">
					<label for="comment-author">Nom</label>
					<input class="comment-textbox" type="text" name="author" id="comment-author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" required="required" />
				</div>
					
				<div class="comment-field">
					<label for="comment-email">E-mail</label>
					<input class="comment-textbox" type="email" name="email" id="comment-email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" required="required" />
				</div>
					
				<div class="comment-field">
					<label for="comment-url">Site web <em>(facultatif)</em></label>
					<input class="comment-textbox" type="url" name="url" id="comment-url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
				</div>
				
			<?php endif; ?>
			<div class="comment-field">
				<label for="comment">Votre commentaire</label>
				<textarea class="comment-textbox" name="comment" id="comment" cols="80" rows="5" tabindex="4" required="required"></textarea>
				<small class="comment-warning">Les commentaires sont mod&eacute;r&eacute;s manuellement. Merci de respecter l'auteur de l'article, les autres participants &agrave; la discussion, et la langue fran&ccedil;aise. Vous pouvez <a href="<?php the_permalink(); ?>feed">suivre les réponses par flux RSS</a>.</small>
			</div>
			
			<p><input class="comment-button" name="submit" type="submit" id="submit" tabindex="5" value="Ajouter ce commentaire" />
				<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" /></p>
				
			<?php do_action('comment_form', $post->ID); ?>
		</form>
	<?php endif; ?>
</div>