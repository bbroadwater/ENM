<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();

	//braking slider		
	$breakingSlider = get_post_meta( ot_page_id(), "_".THEME_NAME.'_breaking_slider', true );
	
	if(is_category()) {
		$breakingSliderCat = ot_get_option( get_cat_id( single_cat_title("",false) ), 'breaking_slider', false );
	}

	//post comments
	$postComments = get_option(THEME_NAME."_post_comment");


?>
<?php if((is_array($breakingSlider) && !empty($breakingSlider) && !in_array("slider_off",$breakingSlider)) || (is_category() && $breakingSliderCat=="on")) { ?>
	<?php
		if(is_category()) {
			$catId = get_cat_id( single_cat_title("",false) );
			$category_in = $catId;
		} else {
			$category_in = $breakingSlider;
		}

		$args=array(
			'category__in' => $category_in,
			'posts_per_page' => 6,
			'order'	=> 'DESC',
			'orderby'	=> 'date',
			'meta_key'	=> "_".THEME_NAME.'_breaking_post',
			'meta_value'	=> 'on',
			'post_type'	=> 'post',
			'ignore_sticky_posts '	=> 1,
			'post_status '	=> 'publish'
		);
		$the_query = new WP_Query($args);

	?>
				<!-- BEGIN .wrapper -->
				<div class="wrapper">

					<!-- BEGIN .breaking-news -->
					<div class="breaking-news">
						<div class="breaking-title">
							<h3><?php _e("Breaking News", THEME_NAME);?></h3>
							<i></i>
						</div>
						<div class="breaking-block">
							<ul>
								<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
								<li><h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4><i class="fa fa-exclamation"></i></li>
								<?php endwhile; else: ?>
									<li><?php  _e( 'No posts where found' , THEME_NAME);?></li>
								<?php endif; ?>

							</ul>
						</div>
					<!-- END .breaking-news -->
					</div>

				<!-- END .wrapper -->
				</div>

	<?php } ?>
<?php wp_reset_query();  ?>