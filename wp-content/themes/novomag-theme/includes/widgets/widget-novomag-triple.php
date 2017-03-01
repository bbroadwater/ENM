<?php
add_action('widgets_init', create_function('', 'return register_widget("OT_triple");'));

class OT_triple extends WP_Widget {
	function OT_triple() {
		 parent::__construct(false, $name = THEME_FULL_NAME.' Triple Box');	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'count_p' => '3',
			'count_r' => '3',
			'count_c' => '3',
			'cat_p' => '',
			'cat_r' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$count_p = esc_attr($instance['count_p']);
		$cat_p = esc_attr($instance['cat_p']);
		$count_r = esc_attr($instance['count_r']);
		$cat_r = esc_attr($instance['cat_r']);
		$count_c = esc_attr($instance['count_c']);
        ?>
			
			<p><label for="<?php echo $this->get_field_id('count_p'); ?>"><?php printf ( __( 'Popular Post Count:' , THEME_NAME ));?> <input class="widefat" id="<?php echo $this->get_field_id('count_p'); ?>" name="<?php echo $this->get_field_name('count_p'); ?>" type="text" value="<?php echo $count_p; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('cat_p'); ?>"><?php printf ( __( 'Popular Post Category:' , THEME_NAME ));?>
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
			<select name="<?php echo $this->get_field_name('cat_p'); ?>" style="width: 100%; clear: both; margin: 0;">
				<option value=""><?php _e("Latest News", THEME_NAME);?></option>
				<?php foreach($args as $ar) { ?>
					<option value="<?php echo $ar->term_id; ?>" <?php if($ar->term_id==$cat_p)  {echo 'selected="selected"';} ?>><?php echo $ar->cat_name; ?></option>
				<?php } ?>
			</select>
			
			</label></p>
			<p><label for="<?php echo $this->get_field_id('count_r'); ?>"><?php printf ( __( 'Recent Post Count:' , THEME_NAME ));?> <input class="widefat" id="<?php echo $this->get_field_id('count_r'); ?>" name="<?php echo $this->get_field_name('count_r'); ?>" type="text" value="<?php echo $count_r; ?>" /></label></p>
			<p><label for="<?php echo $this->get_field_id('cat_r'); ?>"><?php printf ( __( 'Recent Post Category:' , THEME_NAME ));?>
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
			<select name="<?php echo $this->get_field_name('cat_r'); ?>" style="width: 100%; clear: both; margin: 0;">
				<option value=""><?php _e("Latest News", THEME_NAME);?></option>
				<?php foreach($args as $ar) { ?>
					<option value="<?php echo $ar->term_id; ?>" <?php if($ar->term_id==$cat_r)  {echo 'selected="selected"';} ?>><?php echo $ar->cat_name; ?></option>
				<?php } ?>
			</select>
			
			</label></p>
			<p><label for="<?php echo $this->get_field_id('count_c'); ?>"><?php printf ( __( 'Comment Count:' , THEME_NAME ));?> <input class="widefat" id="<?php echo $this->get_field_id('count_c'); ?>" name="<?php echo $this->get_field_name('count_c'); ?>" type="text" value="<?php echo $count_c; ?>" /></label></p>

		
        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['count_p'] = strip_tags($new_instance['count_p']);
		$instance['count_r'] = strip_tags($new_instance['count_r']);
		$instance['count_c'] = strip_tags($new_instance['count_c']);
		$instance['cat_p'] = strip_tags($new_instance['cat_p']);
		$instance['cat_r'] = strip_tags($new_instance['cat_r']);

		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
		$count_p = $instance['count_p'];
		$count_r = $instance['count_r'];
		$count_c = $instance['count_c'];
		$cat_r = $instance['cat_r'];
		$cat_p = $instance['cat_p'];

	
		if(!$count_p) $count_p = 4;
		if(!$count_r) $count_r = 4;
		if(!$count_c) $count_c = 4;
		$widget_id = $args['widget_id'];
		
		if($cat_r) {
			$link = get_category_link( $cat_r );
		} else {
			$blogID = get_option('page_for_posts');
			$link = get_page_link($blogID);
		}

		$postDate = get_option(THEME_NAME."_post_date");
		$postComments = get_option(THEME_NAME."_post_comment");
?>		
	<?php echo $before_widget; ?>
		<div class="w-title tab-a">
			<h3><?php _e("Popular", THEME_NAME);?></h3><h3><?php _e("Recent", THEME_NAME);?></h3><h3><?php _e("Comments", THEME_NAME);?></h3>
		</div>
		<div class="tab-d">
			<?php 
				$args_p = array(
					'posts_per_page' => $count_p,
					'order' => 'DESC',
					'cat' => $cat_r,
					'orderby'	=> 'meta_value_num',
					'meta_key'	=> "_".THEME_NAME.'_post_views_count',
					'post_type'=> 'post',
					'ignore_sticky_posts' => true
				); 

				$args_r = array(
					'cat'=> $cat_r,
					'posts_per_page'=> $count_r,
					'ignore_sticky_posts' => true
				);

				$args_c=	array(
					'status' => 'approve', 
					'order' => 'DESC',
					'number' => $count_c
				);
			?>
				<!-- First Tab -->
				<div class="article-list">
				<?php
					//set popular post query
					$the_query = new WP_Query($args_p); 
					if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); 

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
				<!-- First Tab -->
				<div class="article-list">
				<?php
					//set recent post query
					$the_query = new WP_Query($args_r); 
					if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); 

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
					<div class="more-button">
						<a href="<?php echo $link;?>"><?php _e("More Articles", THEME_NAME);?></a>
					</div>
				</div>

				<div class="comments-list">
					<?php				
						$comments = get_comments($args_c);
						$totalCount = count($comments);
						$counter = 1;
									
						foreach($comments as $comment) {
							if($comment->user_id && $comment->user_id!="0") {
								$authorName = get_the_author_meta('display_name',$comment->user_id );
							} else {
								$authorName = $comment->comment_author;
							}	
					 ?>			
						<div class="item">
							<img src="<?php echo ot_get_avatar_url(get_avatar( $comment, 60));?>" alt="<?php echo $authorName; ?>" class="item-photo" />
							<div class="item-content">
								<h3><?php echo $authorName; ?></h3>
								<p><?php echo WordLimiter(get_comment_excerpt($comment->comment_ID),10);?></p>
								<span><a href="<?php echo get_comment_link($comment);?>"><?php _e("View Comment", THEME_NAME);?></a></span>
								<span><?php echo date(get_option('date_format'),strtotime($comment->comment_date));?></span>
							</div>
						</div>

					<?php } ?>

				</div>
		</div>

	<?php echo $after_widget; ?>
		
	
      <?php
	}
}
?>
