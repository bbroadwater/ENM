<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$image = get_post_thumb($post->ID,0,0); 

	
	if(get_option(THEME_NAME."_show_first_thumb") != "on" || $image['show']!=true) {
		$class = " image-no";
	} else {
		$class = false;
	}
	
	if(get_post_meta( $post->ID, "_".THEME_NAME."_post_style", true ) == "light") {
		$class.= " light";
	} else {
		$class.= false;
	}

	$postDate = get_option(THEME_NAME."_post_date");
	$postComments = get_option(THEME_NAME."_post_comment");
	$postAuthor = get_option(THEME_NAME."_post_author");


	//get blog style
	$blogStyle = get_post_meta( OT_page_id(), "_".THEME_NAME."_blog_style", true ); 

	if(is_category()) {
		$catId = get_cat_id( single_cat_title("",false) );
		$blogStyle = ot_get_option ( $catId, "blog_style"); 
	}
	if(!$blogStyle) $blogStyle=1;//if the blog style isn't set, set it to 1


	//large sidebar
	$sidebar = get_post_meta ( OT_page_ID(), "_".THEME_NAME."_sidebar_select", true ); 
			
	if(is_category()) {
		$sidebar = ot_get_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
	}
?>
	<div <?php post_class("item".$class); ?>>
		<?php if($class!=" image-no") { ?>
			<div class="item-header">
				<?php get_template_part(THEME_LOOP."image"); ?>
				<?php if($blogStyle=="2") { ?>
					<h3>
						<a href="<?php the_permalink();?>"><?php the_title();?></a>
					</h3>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if($blogStyle=="2" && $class==" image-no") { ?>
			<h3>
				<a href="<?php the_permalink();?>"><?php the_title();?></a>
			</h3>
		<?php } ?>
		<div class="item-content">
			<?php 
				if($blogStyle=="1") {
					$postCategories = wp_get_post_categories( $post->ID );
					$catCount = count($postCategories);
					$i=1;
					foreach($postCategories as $c){
						$cat = get_category( $c );
						$link = get_category_link($cat->term_id);
					?>
						<a href="<?php echo $link;?>" class="category-link" style="color: <?php ot_title_color($cat->term_id, "category");?>">
							<strong><?php echo $cat->name;?></strong>
						</a>
					<?php
						$i++;
					}
				}
			?>
			<?php if($blogStyle=="1") { ?>
			<h3>
				<a href="<?php the_permalink();?>"><?php the_title();?></a>
			</h3>
			<?php } ?>
			<?php 
				if($blogStyle=="1") {
					if($sidebar!="off") {
						add_filter('excerpt_length', 'new_excerpt_length_30');
					} else {
						add_filter('excerpt_length', 'new_excerpt_length_80');	
					}
				} else {
					if($sidebar!="off") {
						add_filter('excerpt_length', 'new_excerpt_length_20');
					} else {
						add_filter('excerpt_length', 'new_excerpt_length_40');	
					}
				}
				the_excerpt();
			?>
		</div>
		<div class="item-footer">
			<span class="foot-categories">
				<?php 
					if($blogStyle=="2") {
						$postCategories = wp_get_post_categories( $post->ID );
						$catCount = count($postCategories);
						$i=1;
						foreach($postCategories as $c){
							$cat = get_category( $c );
							$link = get_category_link($cat->term_id);
						?>
							<a href="<?php echo $link;?>" class="category-link" style="color: <?php ot_title_color($cat->term_id, "category");?>">
								<strong><?php echo $cat->name;?></strong>
							</a>
						<?php
							$i++;
						}
					}
				?>
			</span>
			<span class="right">
				<?php if($postDate=="on") { ?>
					<a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>">
						<i class="fa fa-clock-o"></i><?php the_time(get_option('date_format'));?>
					</a>
				<?php } ?>
				<?php if ( comments_open() && $postComments=="on") { ?>
					<a href="<?php the_permalink();?>#comments">
						<i class="fa fa-comment"></i> <?php comments_number("0","1","%"); ?>
					</a>
				<?php } ?>
			</span>
		</div>
	</div>