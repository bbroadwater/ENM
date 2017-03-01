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
				<?php
					if ( function_exists( 'register_nav_menus' )) {
						$walker = new OT_Walker_Top;
						$args = array(
							'container' => '',
							'theme_location' => 'top-menu',
							'items_wrap' => '<ul class="le-first">%3$s</ul>',
							'depth' => 3,
							"echo" => false,
							"walker" => $walker
						);
									
									
						if(has_nav_menu('top-menu')) {
				?>
					<div class="header-topmenu">
						
						<!-- BEGIN .wrapper -->
						<div class="wrapper">
							<?php 
								if(has_nav_menu('top-menu')) { 
									echo wp_nav_menu($args); 
								} 
							?>
						<!-- END .wrapper -->
						</div>

					</div>
				<?php 					
						}		

					}	

				?>

				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					
					<div class="header-block">
						<div class="header-logo">
							<?php if($logo) { ?>
								<a href="<?php echo home_url(); ?>"><img src="<?php echo $logo;?>" alt="<?php bloginfo('name'); ?>" /></a>
							<?php } else { ?>
								<h1><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
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

				<nav class="main-menu">
					
					<!-- BEGIN .wrapper -->
					<div class="wrapper">
						
						<?php	
			
							wp_reset_query();
							if ( function_exists( 'register_nav_menus' )) {
								$walker = new OT_Walker;

								$args = array(
									'container' => '',
									'theme_location' => 'main-menu',
									'items_wrap' => '<ul class="menu %2$s" rel="'.__("Main Menu", THEME_NAME).'">%3$s</ul>',
									'depth' =>  4,
									"echo" => false,
									'walker' => $walker
								);
											
											
								if(has_nav_menu('main-menu')) {
									echo wp_nav_menu($args);		
								} else {
									echo "<ul class=\"menu\" rel=\"".__("Main Menu", THEME_NAME)."\"><li class=\"navi-none\"><a href=\"".admin_url("nav-menus.php") ."\">Please set up ".THEME_FULL_NAME." menu!</a></li></ul>";
								}		

							}
						?>
						<?php if($search=="on") { ?>
							<div class="search-block">
								<form method="get" action="<?php echo home_url(); ?>" name="searchform">
									<input type="text" class="search-value" value=""  name="s" id="s"/>
									<input type="submit" class="search-button" value="&#xf002;" />
								</form>
							</div>
						<?php } ?>
					<!-- END .wrapper -->
					</div>

				</nav>


			<!-- END .header -->
			</header>

<?php wp_reset_query(); ?>


