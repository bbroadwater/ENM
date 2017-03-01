<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();
	$post_type = get_post_type();
?>
	<!-- BEGIN .content -->
	<section class="content<?php echo" has-sidebar";?>">


		<!-- BEGIN .wrapper -->
		<div class="wrapper">
			
			<div class="main-content <?php OT_content_class(ot_page_id());?>">

<?php get_template_part(THEME_SLIDERS."breaking-news"); ?>




<?php wp_reset_query();  ?>