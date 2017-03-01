<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();
	$post_type = get_post_type();

	//large sidebar
	$sidebar = get_post_meta ( OT_page_ID(), "_".THEME_NAME."_sidebar_select", true ); 
			
	if(is_category()) {
		$sidebar = ot_get_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
	}

?>
			</div>

			
		<!-- END .wrapper -->
		</div>
		
	<!-- BEGIN .content -->
	</section>


				