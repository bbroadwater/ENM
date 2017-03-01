<?php
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php printf ( __( 'This post is password protected. Enter the password to view comments.' , THEME_NAME ));?></p>
	<?php
		return;
	}
	$post_type = get_post_type();
	
	add_action('comment_form_top', 'OT_fields_rules' );
?>
<?php //You can start editing here. ?>
		<?php if (comments_open()) : ?>
			<!-- BEGIN .panel -->
			<div class="panel">
		<?php endif; ?>
			<?php if ( have_comments() && comments_open()) : ?>
				<div class="p-title">
					<h2><?php _e("Comments", THEME_NAME);?></h2>
				</div>
			<?php else: ?>
				<div class="p-title">
					<h2><?php _e("Write a Comment", THEME_NAME);?></h2>
				</div>
			<?php endif; ?>

			<?php if ( have_comments()) : ?>
				<div class="comments-block">
					<ol id="comments">
						<?php wp_list_comments('type=comment&callback=orangethemes_comment'); ?>
					</ol>
					
					<div class="pagination"><?php paginate_comments_links(array('prev_text' => '<i class="fa fa-caret-left"></i>','next_text' => '<i class="fa fa-caret-right"></i>')); ?></div>
				<!-- END .comments-block -->
				</div>
			<?php endif; ?>
			<?php if (!have_comments() && comments_open()) : ?>

			<?php endif; ?>





		<?php if ( comments_open() ) : ?>
			<?php if ( get_option('comment_registration') && !is_user_logged_in() ) : ?>
				<p class="registered-user-restriction"><?php printf ( __( 'Only <a href="%1$s"> registered </a> users can comment.', THEME_NAME ), wp_login_url( get_permalink() ));?> </p>
			<?php else : ?>
				<?php if(have_comments()) { ?>
					<h3><?php _e("Write a Comment", THEME_NAME);?></h3>
				<?php } ?>
				<!-- BEGIN .writecomment -->
				<div id="writecomment">
					<a href="#" name="respond"></a>
					<?php 
						$defaults = array(
							'comment_field'       	=> '<p class="contact-form-message"><label for="c_message">'.__("Comment", THEME_NAME).'<span class="required">*</span></label><textarea name="comment" id="comment" placeholder="'.__("Your message..",THEME_NAME).'"></textarea></p>',
							'comment_notes_before' 	=> '',
							'comment_notes_after'  	=> '',
							'id_form'              	=> '',
							'id_submit'            	=> 'submit',
							'title_reply'          => '',
							'title_reply_to'       => '',
							'cancel_reply_link'    	=> '',
							'label_submit'         	=> ''.__( 'Post a Comment', THEME_NAME ).'',
						);
						comment_form($defaults);			
					?>


				<!-- END #writecomment -->
				</div>

			<?php endif; // if you delete this the sky will fall on your head ?>

		<?php endif; ?>

		<?php if (comments_open()) : ?>
			<!-- END .panel  -->
			</div>
		<?php endif; ?>		
