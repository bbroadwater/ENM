<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//social share icons
	$shareAll = get_option(THEME_NAME."_share_all");
	$shareSingle = get_post_meta( $post->ID, "_".THEME_NAME."_share_single", true ); 
	$image = get_post_thumb($post->ID,0,0); 
?>

		<?php if(ot_option_compare($shareAll,$shareSingle)==true) { ?>
			<div class="social-buttons left">
				<a href="http://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>" data-url="<?php the_permalink();?>" class="social-thing facebook ot-share">
					<i class="fa fa-facebook"></i>

				</a>
				<a href="https://twitter.com/share?url=<?php the_permalink();?>&text=<?php the_title();?>" data-url="<?php the_permalink();?>" data-via="<?php echo get_option(THEME_NAME.'_twitter_name');?>" data-text="<?php the_title();?>" class="social-thing twitter ot-tweet">
					<i class="fa fa-twitter"></i>

				</a>
				<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php the_title();?>" data-url="<?php the_permalink();?>" class="social-thing linkedin ot-link">
					<i class="fa fa-linkedin"></i>

				</a>
				<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="social-thing google ot-pluss">
					<i class="fa fa-google-plus"></i>

				</a>
			</div>
		<?php } ?>
