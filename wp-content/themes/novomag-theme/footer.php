<?php
	$logoFooter = get_option(THEME_NAME."_logo_footer");


	//copyright
	$copyRight = get_option(THEME_NAME."_copyright");

	// pop up banner
	$banner_type = get_option ( THEME_NAME."_banner_type" );
	
	$banner_fly_in = get_option ( THEME_NAME."_banner_fly_in" );
	$banner_fly_out = get_option ( THEME_NAME."_banner_fly_out" );
	$banner_start = get_option ( THEME_NAME."_banner_start" );
	$banner_close = get_option ( THEME_NAME."_banner_close" );
	$banner_overlay = get_option ( THEME_NAME."_banner_overlay" );
	$banner_views = get_option ( THEME_NAME."_banner_views" );
	$banner_timeout = get_option ( THEME_NAME."_banner_timeout" );
	
	$banner_text_image_img = get_option ( THEME_NAME."_banner_text_image_img" ) ;
	$banner_image = get_option ( THEME_NAME."_banner_image" );
	$banner_text = stripslashes ( get_option ( THEME_NAME."_banner_text" ) );
	
	if ( $banner_type == "image" ) {
	//Image Banner
		$cookie_name = substr ( md5 ( $banner_image ), 1,6 );
	} else if ( $banner_type == "text" ) { 
	//Text Banner
		$cookie_name = substr ( md5 ( $banner_text ), 1,6 );
	} else if ( $banner_type == "text_image" ) { 
	//Image And Text Banner
		$cookie_name = substr ( md5 ( $banner_text_image_img ), 1,6 );
	} else {
		$cookie_name = "popup";
	}

	if ( !$banner_start) {
		$banner_start = 0;
	}
	
	if ( !$banner_close) {
		$banner_close = 0;
	}
	
	if ( $banner_overlay == "on") {
		$banner_overlay = "true";
	} else {
		$banner_overlay = "false";
	}

	?>
			<!-- BEGIN .footer -->
			<footer class="footer">
				
				<!-- BEGIN .wrapper -->
				<div class="wrapper">
					
					<!-- BEGIN .footer-widgets -->
					<div class="footer-widgets">
						
						<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer') ) : ?>
						<?php endif; ?>

					<!-- END .footer-widgets -->
					</div>
					
				<!-- END .wrapper -->
				</div>

				<div class="footer-bottom">
					<!-- BEGIN .wrapper -->
					<div class="wrapper">

						<p class="left"><?php echo stripslashes($copyRight);?> <?php _e("Theme by", THEME_NAME);?> <a href="http://orange-themes.com" target="_blank">Orane-Themes.com</a>.</p>
						<?php
							if ( function_exists( 'register_nav_menus' )) {
								$args = array(
									'container' => '',
									'theme_location' => 'footer-menu',
									'items_wrap' => '<ul class="right">%3$s</ul>',
									'depth' => 1,
									"echo" => false,
								);
											
											
								if(has_nav_menu('footer-menu')) {
									echo wp_nav_menu($args);		
								}		

							}	

						?>

						<div class="clear-float"></div>
						
					<!-- END .wrapper -->
					</div>
				</div>
				
			<!-- END .footer -->
			</footer>
			
		<!-- END .boxed -->
		</div>



		<div class="lightbox">
			<div class="lightcontent-loading">
				<a href="#" onclick="javascript:lightboxclose();" class="light-close"><i class="fa fa-minus-square"></i>&nbsp;&nbsp;<?php _e("Close Window", THEME_NAME);?></a>
				<div class="loading-box">
					<h3><?php _e("Loading, Please Wait!", THEME_NAME);?></h3>
					<span><?php _e("This may take a second or two.", THEME_NAME);?></span>
					<span class="loading-image"><img src="<?php echo THEME_IMAGE_URL;?>loading.gif" title="<?php _e("Loading", THEME_NAME);?>" alt="<?php _e("Loading", THEME_NAME);?>" /></span>
				</div>
			</div>
			<div class="lightcontent"></div>
		</div>

<?php
	$sliderStyle = get_post_meta ( OT_page_id(), "_".THEME_NAME."_slider_style", true );
	$sliderAuto = get_post_meta ( OT_page_id(), "_".THEME_NAME."_slider_auto", true ); 
	$sliderTime = get_post_meta ( OT_page_id(), "_".THEME_NAME."_slider_time", true ); 
	//main slider
	$mainSlider = get_post_meta ( OT_page_id(), "_".THEME_NAME."_main_slider", true ); 
	 if($mainSlider=="on") {
		$args=array(
			'posts_per_page' => 6,
			'order'	=> 'DESC',
			'orderby'	=> 'date',
			'meta_key'	=> "_".THEME_NAME.'_main_slider_post',
			'meta_value'	=> 'on',
			'post_type'	=> 'post',
			'ignore_sticky_posts '	=> 1,
			'post_status '	=> 'publish'
		);
		$the_query = new WP_Query($args);


		$the_query = new WP_Query($args);
		$post_count = $the_query ->post_count;
	} else {
		$post_count = 0;
	}

	if($sliderAuto=="on") {
		$sliderAuto = "true";
	} else {
		$sliderAuto = "false";
	}
?>

<script>

	<?php if($sliderStyle==2) { ?>
		jQuery(document).ready(function() {
		    jQuery(".ot-slider").owlCarousel({
		     items : 1,
		     autoplay : true,
		     nav : true,
		     lazyload : false,
		     dots : true,
		     loop: true
		    });
		   });
		var _otSliderAuto = false;
		var _otSliderTime = false;
		var _otSliderTime = (!_otSliderTime)?4:_otSliderTime;
		var _otSliderCurrentPage = 0;
	<?php } else { ?>
		var _otSliderAuto = <?php echo $sliderAuto;?>;
		<?php if($sliderTime) { ?>
			var _otSliderTime = <?php echo $sliderTime;?>;
		<?php } ?>
		
		var _otSliderTime = (!_otSliderTime)?4:_otSliderTime;
		var _otSliderCurrentPage = 0;

		function themesAutoLoad() {
			var thenextpage = (jQuery(".slider > .slider-navigation > li.active").next().index() == "-1")?0:jQuery(".slider > .slider-navigation > li.active").next().index();
			setTimeout(function() {
				if(_otSliderAuto){
					themesLoadPage(thenextpage);
					themesAutoLoad();
				}
			}, 1000*_otSliderTime);
		}

		function themesCancelLoad() {
			_otSliderAuto = false;
		}

		function themesLoadPage(num) {
			jQuery(".slider > .slider-image > a").eq(num).addClass("active").siblings(".active").removeClass("active");
			jQuery(".slider > .slider-navigation > li").eq(num).addClass("active").siblings(".active").removeClass("active");
			_otSliderCurrentPage = num+1;
		}
	<?php } ?>
</script>
<?php
			//pop up banner
			if ( $banner_type != "off" ) {
		?>
		
		<script type="text/javascript">
		<!--
		
		jQuery(document).ready(function($){
			$('#popup_content').popup( {
				starttime 			 : <?php echo $banner_start; ?>,
				selfclose			 : <?php echo $banner_close; ?>,
				popup_div			 : 'popup',
				overlay_div	 		 : 'overlay',
				close_id			 : 'baner_close',
				overlay				 : <?php echo $banner_overlay; ?>,
				opacity_level		 : 0.7,
				overlay_cc			 : false,
				centered			 : true,
				top	 		   		 : 130,
				left	 			 : 130,
				setcookie 			 : true,
				cookie_name	 		 : '<?php echo $cookie_name;?>',
				cookie_timeout 	 	 : <?php echo $banner_timeout; ?>,
				cookie_views 		 : <?php echo $banner_views ; ?>,
				floating	 		 : true,
				floating_reaction	 : 700,
				floating_speed 		 : 12,
				<?php 
					if ( $banner_fly_in != "off") { 
						echo "fly_in : true,
						fly_from : '".$banner_fly_in."', "; 
					} else {
						echo "fly_in : false,";
					}
				?>
				<?php 
					if ( $banner_fly_out != "off") { 
						echo "fly_out : true,
						fly_to : '".$banner_fly_out."', "; 
					} else {
						echo "fly_out : false,";
					}
				?>
				popup_appear  		 : 'show',
				popup_appear_time 	 : 0,
				confirm_close	 	 : false,
				confirm_close_text 	 : 'Do you really want to close?'
			} );
		});
		-->
		</script>
		<?php } ?>

	<?php wp_footer(); ?>
	<!-- END body -->
	</body>
<!-- END html -->
</html>