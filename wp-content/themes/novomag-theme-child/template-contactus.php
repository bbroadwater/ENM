<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Template Name: Contact Us Page
*/	
?>
<?php get_header(); ?>
<?php 
	wp_reset_query();
	$mail_to = get_post_meta ( $post->ID, "_".THEME_NAME."_contact_mail", true ); 
	$map = get_post_meta ( $post->ID,  "_".THEME_NAME."_map", true ); 

?>
<?php get_template_part(THEME_LOOP."loop-start"); ?>
	<?php if($mail_to) { ?>
		<?php if (have_posts()) :  ?>
			<?php get_template_part(THEME_SINGLE."page-header"); ?>
				<?php get_template_part(THEME_SINGLE."page-title"); ?>
                <?php the_content();?>
                
                <!-- BEGIN .panel -->
			<div class="panel">
				
				<div class="shortcode-content">
					
					<!-- BEGIN .writecomment -->
				  <div class="writecomment">

						<div class="coloralert contact-success-block" style="display:none; background: #68a117;">
							<p><?php _e("Success!",THEME_NAME);?></p>
							<a href="#close-alert"><i class="fa fa-plus"></i></a>
						</div>


						<form id="writecomment" name="writecomment" class="contact-form" action="/email/">
							<input type="hidden"  name="form_type" value="contact" />
							<input type="hidden"  name="post_id" value="<?php echo $post->ID;?>" />

							<p class="contact-form-user">
								<!-- <label for="c_name"><?php _e("First Name", THEME_NAME);?><span class="required">*</span></label> -->
								<input type="text" name="firstname" id="firstnamet" placeholder="<?php _e("First Name", THEME_NAME);?>" title="<?php _e("Firs Name", THEME_NAME);?>" />
								<span class="error-msg" id="contact-name-error" style="display:none;"><i class="fa fa-minus-circle"></i><font class="ot-error-text"></font></span>
							</p>
							
							<p class="contact-form-website">
								<!-- <label for="c_website">Last Name</label> -->
								<input type="text" placeholder="<?php _e("Last Name", THEME_NAME);?>" name="lastname" id="lastname" title="<?php _e("Last Name", THEME_NAME);?>" />
							</p>
                            
                            <p class="contact-form-email">
								<!-- <label for="c_name"><?php _e("emailaddress", THEME_NAME);?><span class="required">*</span></label> -->								<input type="text" name="email" id="contact-mail-input" placeholder="<?php _e("E-mail Address", THEME_NAME);?>" title="<?php _e("E-mail", THEME_NAME);?>" />

								<span class="error-msg" id="contact-mail-error" style="display:none;"><i class="fa fa-minus-circle"></i><font class="ot-error-text"></font></span>
							</p>
							<p class="contact-form-message">
								<!-- <label for="c_name"><?php _e("Your message", THEME_NAME);?><span class="required">*</span></label>-->
								<textarea name="message" placeholder="<?php _e("Your message", THEME_NAME);?>" id="contact-message-input"></textarea>
								<span class="error-msg" id="contact-message-error" style="display:none;"><i class="fa fa-minus-circle"></i><font class="ot-error-text"></font></span>
							</p>
							<p class="form-submit">
								<input name="submit" type="submit" class="styled-button" id="contact-submit" value="<?php printf ( __( 'Send a Message' , THEME_NAME ));?>" />
							</p>
						</form>
					<!-- END #writecomment -->
					</div>

				</div>
			<!-- END .panel -->
                
				<div class="shortcode-content">
                	<div class="panel">
                	<div class="p-title">
                		<h2>Our Location</h2></div>
                        </div>
					<?php if($map) { ?>
						<div class="google-maps">
							<iframe src="<?php echo $map;?>&amp;iwloc=A&amp;output=embed" width="100%" height="400" frameborder="0" style="border:0"></iframe>
						</div>
					<?php } ?>
					
				</div>
			<?php get_template_part(THEME_SINGLE."page-footer"); ?>	
			
			</div>

		<?php else: ?>
			<p><?php printf ( __('Sorry, no posts matched your criteria.' , THEME_NAME )); ?></p>
		<?php endif; ?>
	<?php } else { echo "<span style=\"color:#000; font-size:14pt;\">You need to set up Your contact mail!</span>"; } ?>
<?php get_template_part(THEME_LOOP."loop","end"); ?>
<?php get_footer(); ?>