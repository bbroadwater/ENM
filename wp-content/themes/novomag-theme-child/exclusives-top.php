<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$page_layout = get_option(THEME_NAME."_page_layout");

	//logo settings
	$logo = get_option(THEME_NAME.'_logo');	

		//search
	$search = get_option(THEME_NAME."_search");
	

?>		
			<!-- BEGIN .header -->
			<header class="header" style="background:url(/wp-content/uploads/2017/03/enm_gray.png) #333333 no-repeat center center;width:100%;height:129px">
			<!-- END .header -->
			</header>

		<!-- BEGIN .boxed -->
		<div class="boxed<?php echo $page_layout=="boxed" ? " active" : false; ?>">
<?php wp_reset_query(); ?>


