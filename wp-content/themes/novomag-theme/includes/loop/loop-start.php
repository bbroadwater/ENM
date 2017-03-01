<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();
	$post_type = get_post_type();

	//large sidebar
	$sidebar = get_post_meta ( OT_page_ID(), "_".THEME_NAME."_sidebar_select", true ); 

	if(is_category()) {
		$catID = get_cat_id( single_cat_title("",false) );
		//large sidebar
		$sidebar = ot_get_option ( $catID, "sidebar_select", false ); 
	} elseif(is_tax()){
		$sidebar = ot_get_option ( get_queried_object()->term_id, "sidebar_select", false );
	}
	//main slider
	$mainSlider = get_post_meta ( OT_page_id(), "_".THEME_NAME."_main_slider", true ); 
	$sliderStyle = get_post_meta ( OT_page_id(), "_".THEME_NAME."_slider_style", true ); 

	//slide counter
	$counter = 1;
	$totalCounter = 1;


?>
	<!-- BEGIN .content -->
	<section class="content<?php if($sidebar!="off") echo" has-sidebar";?>">
		<!-- BEGIN .wrapper -->
		<div class="wrapper">
			<?php get_template_part(THEME_SLIDERS."breaking-news"); ?>
	<?php if($mainSlider=="on") { ?>
		<?php
			$args=array(
				'posts_per_page' => 6,
				'order'	=> 'DESC',
				'orderby'	=> 'date',
				'meta_key'	=> "_".THEME_NAME.'_main_slider_post',
				'meta_value'	=> 'on',
				'post_type'	=> 'post',
				'ignore_sticky_posts '	=> 1,
				'post_status '	=> 'publish'
			);
			$the_query = new WP_Query($args);
		?>
		<?php if($sliderStyle==2) { ?>
			<!-- BEGIN .ot-slider -->
			<div class="ot-slider">

				<!-- BEGIN .ot-slide -->
				<div class="ot-slide">
					<?php if ( $the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<?php 
						switch ($counter) {
							case 1:
								$class = "first";
								$width = "598";
								$height = "407";
								break;
							case 2:
								$class = "second";
								$width = "296";
								$height = "407";
								break;
							case 3:
								$class = "second";
								$width = "296";
								$height = "407";
								break;
							default:
								$class = false;
								$width = "0";
								$height = "0";
								break;
						}
						$image = get_post_thumb($the_query->post->ID,$width,$height,THEME_NAME.'_homepage_image');  
						
						//categories
						$categories = get_the_category($the_query->post->ID);
                        $catCount = count($categories);
                        //select a random category id
                        $id = rand(0,$catCount-1);
						$titleColor = ot_title_color($categories[$id]->term_id, "category", false);
						$ratingsAverage = ot_avarage_rating( $the_query->post->ID); 
					?>
						<div class="ot-slider-layer <?php echo $class;?>">
							<a href="<?php the_permalink();?>" class="overset-image">
								<?php if($ratingsAverage) { ?>
									<span class="slider-rating">
										<span class="slider-star-num"><?php echo $ratingsAverage[1];?></span>
										<span class="ot-star-rating">
											<span style="width: <?php echo $ratingsAverage[0];?>%;" class=""><strong class="rating"><?php echo $ratingsAverage[1];?></strong> out of 5</span>
											<strong><?php _e("Rating: ", THEME_NAME);?> <?php echo $ratingsAverage[1];?> <?php _e("out of 5", THEME_NAME);?></strong>
										</span>
									</span>
								<?php } ?>
								<span class="content-bottom">
									<span class="categories">
										<span style="background-color: <?php echo $titleColor;?>;" class="category-tag"><?php echo get_cat_name($categories[$id]->term_id);?></span>
										<span class="timeago"><?php echo human_time_diff( get_the_time('U'), current_time('timestamp') ) .__(' ago', THEME_NAME); ?></span>
									</span>
									<strong><?php the_title();?></strong>
								</span>
								<img src="<?php echo $image['src'];?>" alt="<?php the_title();?>" />
							</a>
						</div>

						<?php if($counter==3 && $the_query->post_count != $totalCounter) { ?>
							<!-- END .ot-slide -->
							</div>
							<!-- BEGIN .ot-slide -->
							<div class="ot-slide">
							<?php $counter = 0; ?>
						<?php } ?>

						<?php 
							$counter++; 
							$totalCounter++; 
						?>
					<?php endwhile; else: ?>
						<p><?php  esc_html_e('No posts where found', THEME_NAME); ?></p>
					<?php endif; ?>
				<!-- END .ot-slide -->
				</div>
			<!-- END .ot-slider -->
			</div>
		<?php } ?>
	<?php } ?>
		</div>
		<!-- BEGIN .wrapper -->
		<div class="wrapper">

			<div class="main-content <?php if($sidebar!="off") OT_content_class(ot_page_id());?>">






<?php wp_reset_query();  ?>