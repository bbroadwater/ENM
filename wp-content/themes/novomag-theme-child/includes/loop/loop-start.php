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



?>
	<!-- BEGIN .content -->
	<section class="content<?php if($sidebar!="off") echo" has-sidebar";?>">


		<!-- BEGIN .wrapper -->
		<div class="wrapper">
			
			<div class="main-content <?php if($sidebar!="off") OT_content_class(ot_page_id());?>">

<?php get_template_part(THEME_SLIDERS."breaking-news"); ?>




<?php wp_reset_query();  ?>