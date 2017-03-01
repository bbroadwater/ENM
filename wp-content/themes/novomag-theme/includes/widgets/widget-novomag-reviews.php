<?php
add_action('widgets_init', create_function('', 'return register_widget("OT_reviews");'));

class OT_reviews extends WP_Widget {
	function OT_reviews() {
		 parent::__construct(false, $name = THEME_FULL_NAME.' '.__("Reviews", THEME_NAME));	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __("Reviews", THEME_NAME),
			'count' => '3',
			'cat' => '',
			'type' => 'latest',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
		$cat = esc_attr($instance['cat']);
		$count = esc_attr($instance['count']);
		$type = esc_attr($instance['type']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php printf ( __( 'Title:' , THEME_NAME )); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php printf ( __( 'Category:' , THEME_NAME ));?>
			<?php
			$args = array(
				'type'                     => 'post',
				'child_of'                 => 0,
				'orderby'                  => 'name',
				'order'                    => 'ASC',
				'hide_empty'               => 1,
				'hierarchical'             => 1,
				'taxonomy'                 => 'category');
				$args = get_categories( $args ); 
			?> 	
			<select name="<?php echo $this->get_field_name('cat'); ?>" style="width: 100%; clear: both; margin: 0;">
				<option value=""><?php _e("Latest News", THEME_NAME);?></option>
				<?php foreach($args as $ar) { ?>
					<option value="<?php echo $ar->term_id; ?>" <?php if($ar->term_id==$cat)  {echo 'selected="selected"';} ?>><?php echo $ar->cat_name; ?></option>
				<?php } ?>
			</select>
			
			</label></p>
			<p><label for="<?php echo $this->get_field_id('type'); ?>"><?php printf ( __( 'Type:' , THEME_NAME ));?>
				<select name="<?php echo $this->get_field_name('type'); ?>" style="width: 100%; clear: both; margin: 0;">
					<option value="latest"><?php _e("Latest Reviews", THEME_NAME);?></option>
					<option value="top"><?php _e("Top Reviews", THEME_NAME);?></option>
				</select>
			
			</label></p>
			<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php printf ( __( 'Post count:' , THEME_NAME ));?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>

		
        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['count'] = strip_tags($new_instance['count']);
		$instance['type'] = strip_tags($new_instance['type']);

		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		$cat = $instance['cat'];
		$type = $instance['type'];

		if($type=="top") {
			$args = array(
				'post_type' => "post",
				'cat' => $cat,
				'showposts' => $count,
				'ignore_sticky_posts' => "1",
				'order' => 'DESC',
				'orderby'	=> 'meta_value_num',
				'meta_key'	=> "_".THEME_NAME.'_ratings_average'
			);
		} else {
			$args = array(
				'post_type' => "post",
				'cat' => $cat,
				'order' => 'DESC',
				'showposts' => $count,
				'ignore_sticky_posts' => "1",
				'meta_query' => array(
				    array(
				        'key' => "_".THEME_NAME.'_ratings_average',
				        'value'   => '0',
				        'compare' => '>='
				    )
				)
			);	
		}


		$the_query = new WP_Query($args);
		$counter = 1;
		
		$totalCount = $the_query->found_posts;
		
		$blogID = get_option('page_for_posts');
		

		$postDate = get_option(THEME_NAME."_post_date");
		$postComments = get_option(THEME_NAME."_post_comment");
?>		
	<?php echo $before_widget; ?>
		<?php if($title) echo $before_title.$title.$after_title; ?>
			<div class="review-list">
				<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
					<?php 
						$image = get_post_thumb($the_query->post->ID,0,0); 
						$averageRate = ot_avarage_rating($the_query->post->ID);
							if($averageRate) {
					?>
							<!-- BEGIN .item -->
							<div class="item<?php if($image['show']!=true) { ?> no-image<?php } ?>">
								<?php if($image['show']==true) { ?>
									<a href="<?php the_permalink();?>">
										<?php echo ot_image_html($the_query->post->ID,60,60,"item-photo"); ?>
									</a>
								<?php } ?>
								<div class="item-content">
									<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
									<span class="review-rating" itemprop="ratingValue"><?php echo $averageRate[1];?></span>
								</div>
							<!-- END .item -->
							</div>
						<?php } ?>
					<?php endwhile; else: ?>
						<p><?php  _e( 'No posts where found' , THEME_NAME);?></p>
				<?php endif; ?>
			</div>
	<?php echo $after_widget; ?>
		
	
      <?php
	}
}
?>
