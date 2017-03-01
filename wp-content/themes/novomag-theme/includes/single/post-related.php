<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	$postComments = get_option(THEME_NAME."_post_comment");
	$postDate = get_option(THEME_NAME."_post_date");
	
	//similar news
	$similarPosts = get_option(THEME_NAME."_similar_posts");
	$similarPostsSingle = get_post_meta( $post->ID, "_".THEME_NAME."_similar_posts", true ); 

	if(ot_option_compare($similarPosts,$similarPostsSingle)==true) {
	
		wp_reset_query();
		$categories = get_the_category($post->ID);
		
		if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;

			$args=array(
				'category__in' => $category_ids,
				'post__not_in' => array($post->ID),
				'showposts'=>8,
				'ignore_sticky_posts'=>1,
				'orderby' => 'rand'
			);

			$my_query = new wp_query($args);
			$postCount = $my_query->post_count;
			$counter = 1;
?>
	<!-- BEGIN .panel -->
	<div class="panel">
		<div class="p-title">
			<h2><?php _e("Related Articles", THEME_NAME);?></h2>
		</div>
		<div class="video-carousel">
			<a href="#" class="carousel-left"><i class="fa fa-chevron-left"></i></a>
			<a href="#" class="carousel-right"><i class="fa fa-chevron-right"></i></a>
			<!-- BEGIN .inner-carousel -->
			<div class="inner-carousel">
				<?php									
					if( $my_query->have_posts() ) {
						while ($my_query->have_posts()) {
							$my_query->the_post();
		                    //get all post categories
		                    $categories = get_the_category($my_query->post->ID);
		                    $catCount = count($categories);
		                    //select a random category id
		                    $id = rand(0,$catCount-1);
		                    //cat id
		                    $catId = $categories[$id]->term_id
				?>
					<div class="item">
						<a href="<?php the_permalink();?>">
							<?php echo ot_image_html($post->ID,248,165,"item-photo"); ?>
						</a>
						<h3>
							<a href="<?php the_permalink();?>"><?php the_title();?></a>
						</h3>
					</div>
				<?php } ?>
			<?php } ?>
			<!-- END .inner-carousel -->
			</div>
		</div>
	<!-- END .panel -->
	</div>
	<?php } ?>
<?php } ?>
<?php wp_reset_query();  ?>