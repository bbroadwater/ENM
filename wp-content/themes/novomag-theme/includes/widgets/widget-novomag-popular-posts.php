<?php
add_action('widgets_init', create_function('', 'return register_widget("OT_popular_posts");'));

class OT_popular_posts extends WP_Widget {
	function OT_popular_posts() {
		 parent::__construct(false, $name = THEME_FULL_NAME.' '.__("Popular Posts", THEME_NAME));	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => __("Popular Posts", THEME_NAME),
			'count' => '3',
			'cat' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr($instance['title']);
		$cat = esc_attr($instance['cat']);
		$count = esc_attr($instance['count']);
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
			
			<p><label for="<?php echo $this->get_field_id('count'); ?>"><?php printf ( __( 'Post count:' , THEME_NAME ));?> <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" type="text" value="<?php echo $count; ?>" /></label></p>

		
        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['count'] = strip_tags($new_instance['count']);

		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
		$count = $instance['count'];
		$cat = $instance['cat'];


		$args=array(
			'posts_per_page' => $count,
			'order' => 'DESC',
			'cat' => $cat,
			'orderby'	=> 'meta_value_num',
			'meta_key'	=> "_".THEME_NAME.'_post_views_count',
			'post_type'=> 'post',
			'ignore_sticky_posts' => true
		);

		$the_query = new WP_Query($args);
		$counter = 1;
		
		$totalCount = $the_query->found_posts;
		
		$blogID = get_option('page_for_posts');
		

		$postDate = get_option(THEME_NAME."_post_date");
		$postComments = get_option(THEME_NAME."_post_comment");
?>		
	<?php echo $before_widget; ?>
		<?php if($title) echo $before_title.$title.$after_title; ?>
			<div class="article-list">
				<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
					<?php 
						$image = get_post_thumb($the_query->post->ID,0,0); 
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
								<?php if($postDate=="on") { ?>
									<!--<a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>">-->
										<span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php the_time(get_option('date_format'));?></span>
									<!--</a>-->
								<?php } ?>	
								<?php if ( comments_open() && $postComments=="on") { ?>
									<a href="<?php the_permalink();?>#comments">
										<span>
											<i class="fa fa-comment-o"></i>&nbsp;&nbsp;<?php comments_number(__("0 Comments", THEME_NAME),__("1 Comment", THEME_NAME),__("% Comments", THEME_NAME)); ?>
										</span>
									</a>
								<?php } ?>
								<?php 
									//add_filter('excerpt_length', 'new_excerpt_length_7');
									//the_excerpt();
								?>
							</div>
						<!-- END .item -->
						</div>
					<?php endwhile; else: ?>
						<p><?php  _e( 'No posts where found' , THEME_NAME);?></p>
				<?php endif; ?>
			</div>
	<?php echo $after_widget; ?>
		
	
      <?php
	}
}
?>
