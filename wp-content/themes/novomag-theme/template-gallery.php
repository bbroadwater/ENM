<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/* Template Name: Photo Gallery */
?>
<?php get_header(); ?>
<?php
	wp_reset_query();
	$paged = get_query_string_paged();
	$posts_per_page = get_option(THEME_NAME.'_gallery_items');

	if($posts_per_page == "") {
		$posts_per_page = get_option('posts_per_page');
	}
	
	$catSlug = $wp_query->queried_object->slug;
	if(!$catSlug) {
		$my_query = new WP_Query(
			array(
				'post_type' => OT_POST_GALLERY, 
				'posts_per_page' => $posts_per_page, 
				'paged'=>$paged
			)
		);  
	} else {
		$my_query = new WP_Query(
			array(
				'post_type' => OT_POST_GALLERY, 
				'posts_per_page' => $posts_per_page, 
				'paged'=>$paged,
				'tax_query' => array(
					array(
						'taxonomy' => OT_POST_GALLERY.'-cat',
						'field' => 'slug',
						'terms' => $catSlug
					)
				)
			)
		); 

	}
	$categories = get_terms( OT_POST_GALLERY.'-cat', 'orderby=name&hide_empty=0' );

?>
<?php get_template_part(THEME_LOOP."loop-start"); ?>
	<?php get_template_part(THEME_SINGLE."page-header"); ?>
		<?php get_template_part(THEME_SINGLE."page-title"); ?>
		<div class="gallery-categories">
			<a href="<?php echo get_page_link(ot_get_page("gallery", false));?>"<?php if(!$catSlug) { ?> class="active"<?php } ?>><?php _e("All Categories", THEME_NAME);?></a>
			<?php foreach ($categories as $category) { ?>
				<?php if(isset($category->term_id)) { ?>
					<a href="<?php echo get_term_link((int)$category->term_id,OT_POST_GALLERY.'-cat');?>" <?php if($catSlug==$category->slug) { ?> class="active"<?php } ?>><?php echo $category->name;?></a>
				<?php } ?>
			<?php } ?>
		</div>
		<div class="photo-gallery-blocks">
			<?php 
															
				$args = array(
					'post_type'     	=> OT_POST_GALLERY,
					'post_status'  	 	=> 'publish',
					'showposts' 		=> -1
				);

				$myposts = get_posts( $args );	
				$count_total = count($myposts);

				$counter=1;	
			?>

			<?php if ( $my_query->have_posts() ) : while ( $my_query->have_posts() ) : $my_query->the_post(); ?>
				<?php 
					$src = get_post_thumb($post->ID,384,245); 
				?>
				<?php 
					$term_list = wp_get_post_terms($post->ID, OT_POST_GALLERY.'-cat');
					$catCount=0;
					foreach($term_list as $term){
						$catCount++;
					}
					
					$randID = rand(0,$catCount-1);
				?>
				<?php $gallery_style = get_post_meta ( $post->ID, "_".THEME_NAME."_gallery_style", true ); ?>
					<!-- BEGIN .item -->
					<div class="item" data-id="gallery-<?php the_ID(); ?>">
						<div class="item-header">
							<a href="<?php the_permalink();?>" class="<?php if($gallery_style=="lightbox") { echo 'light-show '; } ?>" data-id="gallery-<?php the_ID(); ?>">
								<img src="<?php echo $src["src"]; ?>" alt="<?php the_title();?>" />
							</a>
						</div>
						<div class="item-content">
							<h3><a href="<?php the_permalink();?>" class="<?php if($gallery_style=="lightbox") { echo 'light-show '; } ?>" data-id="gallery-<?php the_ID(); ?>"><?php the_title();?></a></h3>
							<?php 
								add_filter('excerpt_length', 'new_excerpt_length_20');
								the_excerpt();
							?>
						</div>
					<!-- END .item -->
					</div>

			<?php 
				if ( $paged != 0 ) {
					$a = ($paged-1)*$posts_per_page;
				} else {		
					$a = 1;
				}
			?>
						
			<?php $counter++; ?>
			<?php endwhile; ?>
			<?php else : ?>
				<h2 class="title"><?php _e( 'No galleries were found' , THEME_NAME );?></h2>
			<?php endif; ?>
		</div>
		<?php customized_nav_btns($paged, $my_query->max_num_pages); ?>
	<?php get_template_part(THEME_SINGLE."page-footer"); ?>
<?php get_template_part(THEME_LOOP."loop-end"); ?>
<?php get_footer(); ?>