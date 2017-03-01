<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
	wp_reset_query();

	global $query_string;
	$query_vars = explode('&',$query_string);
									
	foreach($query_vars as $key) {
		if(strpos($key,'page=') !== false) {
			$i = substr($key,8,12);
			break;
		}
	}
	
	if(!isset($i)) {
		$i = 1;
	}

	$galleryImages = get_post_meta ( $post->ID, THEME_NAME."_gallery_images", true ); 
	$imageIDs = explode(",",$galleryImages);
	$count = count($imageIDs);

	//main image
	$file = wp_get_attachment_url($imageIDs[$i-1]);
	$image = get_post_thumb(false, 1200, 0, false, $file);	

?>
<?php get_template_part(THEME_LOOP."loop-start"); ?>
	<?php get_template_part(THEME_SINGLE."page-header"); ?>
		<?php get_template_part(THEME_SINGLE."page-title"); ?>
		<?php if (have_posts()): ?>
			<div class="photo-gallery-single photo-gallery-full ot-slide-item" id="<?php echo $post->ID;?>">
				<span class="next-image" data-next="<?php echo $i+1;?>"></span>
				<div class="paragraph-row">
					<div class="column10">
						<div class="gallery-photo">
							<a href="javascript:void(0);" class="gallery-alt-left prev" rel="<?php if($i>1) { echo $i-1; } else { echo $i-1; } ?>">
								<i class="fa fa-angle-left"></i>
							</a>
							<a href="javascript:void(0);" class="gallery-alt-right next" rel="<?php if($i<$count) { echo $i+1; } else { echo $i; } ?>">
								<i class="fa fa-angle-right"></i>
							</a>
							<div class="gallery-inner">
								<div class="the-image loading waiter">
									<img class="image-big-gallery ot-gallery-image" data-id="<?php echo $i;?>" style="display:none;" src="<?php echo $image['src'];?>" alt="<?php the_title();?>" />
								</div>
							</div>
						</div>
					</div>
					<div class="column2">
						<div class="gallery-thumbnail-list">
							<div class="gallery-inner-layer">
								<div class="the-thumbs">
				            		<?php 
					            		$c=1;
					            		foreach($imageIDs as $id) { 
					            			if($id) {
						            			$file = wp_get_attachment_url($id);
						            			$image = get_post_thumb(false, 84, 84, false, $file);
					            	?>
										<a href="javascript:;" rel="<?php echo $c;?>" class="gal-thumbs g-thumb<?php if($c==$i) { ?> active<?php } ?>" data-nr="<?php echo $c;?>">
											<img src="<?php echo $image['src'];?>" alt="<?php the_title();?>"/>
										</a>
						                <?php $c++; ?>
					               	 	<?php } ?>
					                <?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="gallery-description">
					<h3><?php the_title();?></h3>
					<?php 
						if (get_the_content() != "") { 				
							add_filter('the_content','remove_images');
							add_filter('the_content','remove_objects');
							the_content();
						} 
					?>	
				</div>
			</div>
			
		<?php else: ?>
			<p><?php  _e('Sorry, no posts matched your criteria.' , THEME_NAME ); ?></p>
		<?php endif; ?>
	<?php get_template_part(THEME_SINGLE."page-footer"); ?>
<?php get_template_part(THEME_LOOP."loop","end"); ?>
<?php get_footer(); ?>