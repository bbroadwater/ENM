<?php
		
	// about authors
	$aboutAuthor = get_option(THEME_NAME."_about_author");
	$aboutAuthorSingle = get_post_meta( $post->ID, "_".THEME_NAME."_about_author", true ); 
	
	// author id
	$user_ID = get_the_author_meta('ID');

	//social
	$pinterest = get_user_meta($user_ID, 'pinterest', true);
	$youtube = get_user_meta($user_ID, 'youtube', true);
	$twitter = get_user_meta($user_ID, 'twitter', true);
	$facebook = get_user_meta($user_ID, 'facebook', true);
	$google = get_user_meta($user_ID, 'googlepluss', true);
	$linkedin = get_user_meta($user_ID, 'linkedin', true);
?>

<?php if(ot_option_compare($aboutAuthor,$aboutAuthorSingle)==true) { ?>
	<!-- BEGIN .panel -->
	<div class="panel">
		<div class="p-title">
			<h2><?php _e("About Author", THEME_NAME);?></h2>
		</div>
		<div class="about-author">
			<div class="about-header">
				<a href="<?php $user_info = get_userdata($user_ID); echo get_author_posts_url($user_ID, $user_info->user_login ); ?>">
					<img src="<?php echo ot_get_avatar_url(get_avatar( get_the_author_meta('user_email',$user_ID), 100));?>" class="about-avatar" alt="<?php echo get_the_author_meta('display_name',$user_ID); ?>" />
				</a>
			</div>
			<div class="about-content">
				<div class="soc-buttons right">
					<?php if($facebook) { ?><a href="<?php echo $facebook;?>" target="_blank"><i class="fa fa-facebook"></i></a><?php } ?>
					<?php if($twitter) { ?><a href="<?php echo $twitter;?>" target="_blank"><i class="fa fa-twitter"></i></a><?php } ?>
					<?php if($youtube) { ?><a href="<?php echo $youtube;?>" target="_blank"><i class="fa fa-youtube"></i></a><?php } ?>
					<?php if($pinterest) { ?><a href="<?php echo $pinterest;?>" target="_blank"><i class="fa fa-pinterest"></i></a><?php } ?>
					<?php if($linkedin) { ?><a href="<?php echo $linkedin;?>" target="_blank"><i class="fa fa-linkedin"></i></a><?php } ?>
					<?php if($google) { ?><a href="<?php echo $google;?>" target="_blank" rel="author"><i class="fa fa-google-plus"></i></a><?php } ?>
				</div>
				<h3><a href="<?php $user_info = get_userdata($user_ID); echo get_author_posts_url($user_ID, $user_info->user_login ); ?>"><?php echo get_the_author_meta('display_name',$user_ID); ?></a></h3>
				<p>
					<span class="vcard author">
						<span class="fn">
							<?php echo get_the_author_meta('description'); ?>
						</span>
					</span>
				</p>
			</div>
			<div class="clear-float"></div>
		</div>
	<!-- END .panel -->
	</div>

<?php } ?>