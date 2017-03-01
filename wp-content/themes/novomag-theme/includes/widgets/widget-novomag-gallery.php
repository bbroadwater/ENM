<?php
add_action('widgets_init', create_function('', 'return register_widget("OT_gallery");'));

class OT_gallery extends WP_Widget {
	function OT_gallery() {
		 parent::__construct(false, $name = THEME_FULL_NAME.' '.__("Latest Gallery", THEME_NAME));	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __("Latest Gallery", THEME_NAME),
			'count' => '3',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
		//$count = esc_attr($instance['count']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php  printf ( __( 'Title:' , THEME_NAME )); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<!--<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php  printf ( __( 'Item shown:' , THEME_NAME ));?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>-->

        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['color'] = strip_tags($new_instance['color']);
		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		//$count = $instance['count'];
		$counter=1;
		//if(!$count) $count=3;

		$my_query = new WP_Query(array('post_type' => OT_POST_GALLERY, 'showposts' => 1));  

	
		$totalCount = $my_query->found_posts;
        ?>
        <?php echo $before_widget; ?>
			<?php if($title) echo $before_title.$title.$after_title; ?>
			<div class="w-gallery">
				<a href="<?php echo get_page_link(ot_get_page("gallery", false))?>" class="upper-title"><?php _e("More Galleries", THEME_NAME);?><i class="fa fa-caret-right"></i></a>
				<?php if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
					<div class="w-photos">
						<a href="#" class="gallery-link-left"><i class="fa fa-chevron-left"></i></a>
						<a href="#" class="gallery-link-right"><i class="fa fa-chevron-right"></i></a>
						<?php
							global $post;
							$g = $my_query->post->ID;
							$gallery_style = get_post_meta ( $g, "_".THEME_NAME."_gallery_style", true );
							$galleryImages = get_post_meta ( $g, THEME_NAME."_gallery_images", true ); 
							$imageIDs = explode(",",$galleryImages);
						?>
						<div class="photo-images" rel="gallery-<?php echo $g;?>">
							<?php
								$c=1;
			            		foreach($imageIDs as $imgID) { 
			            			
			            			if($imgID) {
				            			$file = wp_get_attachment_url($imgID);
				            			$image = get_post_thumb(false, 350, 200, false, $file);
									?>
										<a href="<?php the_permalink();?>?page=<?php echo $c;?>" class="<?php if($gallery_style=="lightbox") { echo ' light-show '; } ?>" data-id="gallery-<?php echo $g;?>">
											<img src="<?php echo $image['src'];?>" data-id="<?php echo $c;?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" />
										</a>
									<?php 
									//if($c==8) break;	
									$c++;
									} 
								} 
							?>
						</div>
					</div>
				<?php $counter++; ?>
				<?php endwhile; ?>
				<?php endif; ?>	
			</div>
		<?php echo $after_widget; ?>	
        <?php
	}
}
?>
