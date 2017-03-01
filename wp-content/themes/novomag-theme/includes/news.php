<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();
?>
<?php get_template_part(THEME_LOOP."loop-start"); ?>
	<?php get_template_part(THEME_SINGLE."page-header"); ?>
		<?php get_template_part(THEME_SINGLE."page-title"); ?>
		<?php $counter = 1;?>
		<?php get_template_part(THEME_SINGLE."blog-start"); ?>
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php get_template_part(THEME_LOOP."post"); ?>
			<?php $counter++; ?>
			<?php endwhile; else: ?>
				<?php get_template_part(THEME_LOOP."no-post"); ?>
			<?php endif; ?>
		<?php get_template_part(THEME_SINGLE."blog-end"); ?>
		<?php customized_nav_btns($paged, $wp_query->max_num_pages); ?>
	<?php get_template_part(THEME_SINGLE."page-footer"); ?>
<?php get_template_part(THEME_LOOP."loop-end"); ?>
