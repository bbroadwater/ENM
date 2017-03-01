<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	$page_layout = get_option(THEME_NAME."_page_layout");

	//logo settings
	$logo = get_option(THEME_NAME.'_logo');	

		//search
	$search = get_option(THEME_NAME."_search");
	

?>		
		<!-- BEGIN .boxed -->
		<div class="boxed<?php echo $page_layout=="boxed" ? " active" : false; ?>">
			
			<!-- BEGIN .header -->
			<header class="header">
				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					<div class="header-block">
						<div class="header-logo">
							<?php if($logo) { ?>
								<img src="<?php echo $logo;?>" alt="<?php bloginfo('name'); ?>" />
							<?php } else { ?>
								<h1><?php bloginfo('name'); ?></h1>
							<?php } ?>
						</div>
							<div class="header-banner">
								<?php if(get_field('top_banner_url')) { ?><a class="plink" target="_blank" href="<?php the_field('top_banner_url'); ?>" ><?php } else { ?><a target="_blank" href="<?php the_field('top_banner_url_forced'); ?>"> <?php } ?><?php if(get_field('top_banner_img')) { ?>
                    <img src="<?php the_field('top_banner_img'); ?>" alt="" width="100%" />
                 <?php } ?>   
        </a>					
							</div>
					</div>
					
				<!-- END .wrapper -->
				</div>
			<!-- END .header -->
			</header>

<?php wp_reset_query(); ?>


