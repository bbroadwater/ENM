<?php
/*
Template Name: Drag & Drop Page Builder Full Width
*/	
?>
<?php get_header(); ?>
<?php

	wp_reset_query();
	global $post;
	

	//blocks
	$homepage_layout_order = get_option(THEME_NAME."_homepage_layout_order_".$post->ID);

	//main slider
	$mainSlider = get_post_meta ( OT_page_id(), "_".THEME_NAME."_main_slider", true ); 

?>

<?php get_template_part(THEME_LOOP."loop-start"); ?>
	<?php if($mainSlider=="on") { ?>
		<?php
			$args=array(
				'posts_per_page' => 4,
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
		<!-- BEGIN .panel -->
		<div class="panel">
			<div class="slider">
				<div class="slider-image">
					<?php $i=0;?>
					<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<a href="<?php the_permalink();?>"<?php if($i==0) { ?> class="active"<?php } ?>>
							<span class="slider-overlay">
								<strong><?php the_title();?></strong>
								<span>
									<?php 
										add_filter('excerpt_length', 'new_excerpt_length_10');
										the_excerpt();
									?>
								</span>
							</span>
							<?php 
								$sidebar = get_post_meta( OT_page_ID(), "_".THEME_NAME.'_sidebar_select', false );
								if($sidebar=="off") {
									$image = get_post_thumb($post->ID,748,327,THEME_NAME.'_homepage_image');  
								} else {
									$image = get_post_thumb($post->ID,520,327,THEME_NAME.'_homepage_image');  	
								}
								

							?>
							<img src="<?php echo $image['src'];?>" class="setborder" alt="<?php the_title();?>" />
						</a>
					<?php $i++; ?>
					<?php endwhile;?>
					<?php endif; ?>
				</div>
				<ul class="slider-navigation">
					<?php $i=0;?>
					<?php if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>
						<li<?php if($i==0) { ?> class="active"<?php } ?>>
							<a href="<?php the_permalink();?>" data-target="1">
								<strong><?php the_title();?></strong>
								<span>
									<?php 
										add_filter('excerpt_length', 'new_excerpt_length_20');
										the_excerpt();
									?>
								</span>
							</a>
						</li>
					<?php $i++; ?>
					<?php endwhile; else: ?>
						<li><?php  _e( 'No posts where found' , THEME_NAME);?></li>
					<?php endif; ?>
				</ul>
			</div>
		<!-- END .panel -->
		</div>
	<?php } ?>
	
	
	<?php
		$OT_builder = new OT_home_builder;  
		if(is_array($homepage_layout_order)) {
			foreach($homepage_layout_order as $blocks) { 
				$blockType = $blocks['type'];
				$blockId = $blocks['id'];
				$blockInputType = $blocks['inputType'];
				
				$block = $OT_builder->$blockType($blockType, $blockId,$blockInputType);
				get_template_part(THEME_HOME_BLOCKS.$block); 
			}
		}
	?> 
	
<?php wp_reset_query();?>
<?php if(get_the_content()) { ?>
		<div class="panel">
			<div class="shortcode-content">
				<?php the_content();?>
			</div>
		</div>
	<?php } ?>


<?php get_template_part(THEME_LOOP."loop-end-no-sidebar"); ?>



<?php
	$sliderAuto = get_post_meta ( OT_page_id(), "_".THEME_NAME."_slider_auto", true ); 
	$sliderTime = get_post_meta ( OT_page_id(), "_".THEME_NAME."_slider_time", true ); 

	if($sliderAuto=="on") {
		$sliderAuto = "true";
	} else {
		$sliderAuto = "false";
	}
?>

<script>
	var _otSliderAuto = <?php echo $sliderAuto;?>;
	<?php if($sliderTime) { ?>
		var _otSliderTime = <?php echo $sliderTime;?>;
	<?php } ?>
	
	var _otSliderTime = (!_otSliderTime)?4:_otSliderTime;
	var _otSliderCurrentPage = 0;

	function themesAutoLoad() {
		var thenextpage = (jQuery(".slider > .slider-navigation > li.active").next().index() == "-1")?0:jQuery(".slider > .slider-navigation > li.active").next().index();
		setTimeout(function() {
			if(_otSliderAuto){
				themesLoadPage(thenextpage);
				themesAutoLoad();
			}
		}, 1000*_otSliderTime);
	}

	function themesCancelLoad() {
		_otSliderAuto = false;
	}

	function themesLoadPage(num) {
		jQuery(".slider > .slider-image > a").eq(num).addClass("active").siblings(".active").removeClass("active");
		jQuery(".slider > .slider-navigation > li").eq(num).addClass("active").siblings(".active").removeClass("active");
		_otSliderCurrentPage = num+1;
	}

</script>

<?php get_footer();?>