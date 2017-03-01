<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	get_header();
	wp_reset_query();

	if (is_pagetemplate_active("template-contact.php")) {
		$contactPages = ot_get_page("contact");
		if($contactPages[0]) {
			$contactUrl = get_page_link($contactPages[0]);
		}
	} else {
		$contactUrl = "#";
	}
?>
<!-- BEGIN .content -->
			<section class="content">
					
				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					
					<div class="main-content">

						<!-- BEGIN .panel -->
						<div class="panel">
							<div class="p-title">
								<h2><?php _e("Error 404",THEME_NAME);?></h2>
							</div>
							<a href="<?php echo home_url(); ?>" class="upper-title"><?php _e("Back To Homepage",THEME_NAME);?><i class="fa fa-home"></i></a>
							<div class="big-message-block">
								<h1><?php _e("Error 404",THEME_NAME);?></h1>
								<h3><?php _e("Page Not Found",THEME_NAME);?></h3>
								<p><?php printf ( __( 'No worries, page just doesn\'t exist.<br/>Please navigate to <a href="%1$s"><strong>homepage</strong></a> or any other existing page.', THEME_NAME ),home_url() );?></p>
							</div>
						<!-- END .panel -->
						</div>

					</div>
					
				<!-- END .wrapper -->
				</div>
				
			<!-- BEGIN .content -->
			</section>


<?php get_footer(); ?>