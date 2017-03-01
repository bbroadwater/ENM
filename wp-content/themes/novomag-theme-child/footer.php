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

						<img src="//amplifypixel.outbrain.com/pixel?mid=005f324c653c3865081e766c42290775cb">

						<p class="left"><?php echo stripslashes($copyRight);?> </p>
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

<!-- Activity name for this tag: KCO_SS_Email Lead_6.19.14_X195Q646 -->
<!-- URL of the webpage where the tag will be placed: http://research.economyandmarkets.com/X195Q646 -->
<script type='text/javascript'>
var axel = Math.random()+"";
var a = axel * 10000000000000;
document.write('<img src="http://pubads.g.doubleclick.net/activity;xsp=75864;ord='+ a +'?" width=1 height=1 border=0/>');
</script>
<noscript>
<img src="http://pubads.g.doubleclick.net/activity;xsp=75864;ord=1?" width=1 height=1 border=0/>
</noscript>
 
 
<!-- Activity name for this tag: KCO_SS_Email Lead_6.19.14_X195Q645 -->
<script type='text/javascript'>
var axel = Math.random()+"";
var a = axel * 10000000000000;
document.write('<img src="http://pubads.g.doubleclick.net/activity;xsp=75984;ord='+ a +'?" width=1 height=1 border=0/>');
</script>
<noscript>
<img src="http://pubads.g.doubleclick.net/activity;xsp=75984;ord=1?" width=1 height=1 border=0/>
</noscript>

<script src="//platform.twitter.com/oct.js" type="text/javascript"></script>
<script type="text/javascript">
twttr.conversion.trackPid('l5n8l', { tw_sale_amount: 0, tw_order_quantity: 0 });</script>
<noscript>
<img height="1" width="1" style="display:none;" alt="" src="https://analytics.twitter.com/i/adsct?txn_id=l5n8l&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" />
<img height="1" width="1" style="display:none;" alt="" src="//t.co/i/adsct?txn_id=l5n8l&p_id=Twitter&tw_sale_amount=0&tw_order_quantity=0" /></noscript>

	<?php wp_footer(); ?>

	<!-- END body -->
    <!-- Piwik -->
<script type="text/javascript">
var _paq = _paq || [];
_paq.push(["setDocumentTitle", document.domain + "/" + document.title]);
_paq.push(['trackPageView']);
_paq.push(['enableLinkTracking']);
(function() {
var u="//analytics.pubsvs.com/";
_paq.push(['setTrackerUrl', u+'piwik.php']);
_paq.push(['setSiteId', 56]);
var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
})();
</script>
<noscript><p><img src="//analytics.pubsvs.com/piwik.php?idsite=56" style="border:0;" alt="" /></p></noscript>
<!-- End Piwik Code -->
<!-- START Bing Code -->
<script>(function(w,d,t,r,u){var f,n,i;w[u]=w[u]||[],f=function(){var o={ti:"5477362"};o.q=w[u],w[u]=new UET(o),w[u].push("pageLoad")},n=d.createElement(t),n.src=r,n.async=1,n.onload=n.onreadystatechange=function(){var s=this.readyState;s&&s!=="loaded"&&s!=="complete"||(f(),n.onload=n.onreadystatechange=null)},i=d.getElementsByTagName(t)[0],i.parentNode.insertBefore(n,i)})(window,document,"script","//bat.bing.com/bat.js","uetq");</script><noscript><img src="//bat.bing.com/action/0?ti=5477362&Ver=2" height="0" width="0" style="display:none; visibility: hidden;" /></noscript>
<!-- END bing code -->
	</body>
<!-- END html -->
</html>