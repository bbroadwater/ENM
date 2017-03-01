<!-- <script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script> -->

<?php
// -------------------------------------------------------------------------
// SET THE JQUERY SELECTOR FOR THE CONTENT AREA
// -------------------------------------------------------------------------?>

<script type="text/javascript">
	var contentAreaSelector = '.active.boxed';
</script>

<?php
	// -------------------------------------------------------------------------
	// CONFIGURE THE TAKOVER BACKGROUND IMAGES
	// -------------------------------------------------------------------------

	$takeover_main_background_source = null;
	//$takeover_left_side_background_source = "http://economyandmarkets.com/wp-content/themes/novomag-theme-child/images/revolt-2016-takeover-left.jpg";
	//$takeover_right_side_background_source = "http://economyandmarkets.com/wp-content/themes/novomag-theme-child/images/revolt-2016-takeover-right.jpg";

	// -------------------------------------------------------------------------
	// CONFIGURE THE TAKOVER LINKS AND LINK TITLES
	// -------------------------------------------------------------------------

	 $takeover_left_side_url = "https://research.economyandmarkets.com/X195SA08";
	//$takeover_left_side_url = "http://www.revolt2016.com";
	//$takeover_left_side_url_title = "Revolt 2016";
	 $takeover_right_side_url = "https://research.economyandmarkets.com/X195SA08";
	//$takeover_right_side_url = "http://www.revolt2016.com";
	//$takeover_right_side_url_title = "Revolt 2016";



?>

<?php
// -------------------------------------------------------------------------
// HTML MARKUP
// -------------------------------------------------------------------------
?>

<div id="Takeover" <?php if (!is_null($takeover_main_background_source)) : ?>style="background-image: url(<?php echo $takeover_main_background_source; ?>);"<?php endif; ?>>
	<div id="TakeoverLeft" style="background-image: url(<?php echo $takeover_left_side_background_source; ?>);">
		<a href="<?php echo $takeover_left_side_url; ?>" title="<?php echo $takeover_left_side_url_title; ?>" target="_blank"><?php echo $takeover_left_side_url_title; ?></a>
	</div>

	<div id="TakeoverRight" style="background-image: url(<?php echo $takeover_right_side_background_source; ?>);">
		<a href="<?php echo $takeover_right_side_url; ?>" title="<?php echo $takeover_right_side_url_title; ?>" target="_blank">><?php echo $takeover_right_side_url_title; ?></a>
	</div>
</div>


<?php
// -------------------------------------------------------------------------
// JAVASCRIPT
// -------------------------------------------------------------------------
?>

<script type="text/javascript">
	var onResizeTimeoutID;

	/*
	 * Get Viewport Dimensions
	 * returns object with viewport dimensions to match css in width and height properties
	 * ( source: http://andylangton.co.uk/blog/development/get-viewport-size-width-and-height-javascript )
	 */
	function updateViewportDimensions() {
		var w=window,d=document,e=d.documentElement,g=d.getElementsByTagName('body')[0],x=w.innerWidth||e.clientWidth||g.clientWidth,y=w.innerHeight||e.clientHeight||g.clientHeight;
		return { width:x,height:y };
	}

	// setting the viewport width
	var viewport = updateViewportDimensions();

	/*
	 * Add anything you want to do once the onResize event finished
	 *
	 * See a demo of this function here: http://jsfiddle.net/Zevan/c9UE5/1/
	 * Other ways to achieve this same functionality: http://bit.ly/1TAfyTr
	 */
	function doneResizing() {
		viewport = updateViewportDimensions();
		adjustTakeover();
	}

	/*
	 * Adjusts the visiblity of the takeover elements and the positions of the left/right sides of the takeover component
	 */
	function adjustTakeover() {
		if (viewport.width < 1600) {
			if (jQuery('#Takeover').is(":visible")) {
				jQuery('#Takeover').hide();
				return;
			}
		}

		var takeover_left_side_position = jQuery(contentAreaSelector).offset().left - 200;
		var takeover_right_side_position = jQuery(contentAreaSelector).width() + jQuery(contentAreaSelector).offset().left;

		jQuery('#TakeoverLeft, #TakeoverRight').css('backgroundSize','initial');

		jQuery('#TakeoverLeft').css('left', takeover_left_side_position + 'px');
		jQuery('#TakeoverRight').css('left', takeover_right_side_position + 'px');

		if (viewport.width >= 1600) {
			if (jQuery('#Takeover').is(":visible")) {
				jQuery('#Takeover').hide();
				return;
			}
		}
	}

	jQuery(function($) {
		adjustTakeover();

		// window resize
		$(window).resize(function() {
			clearTimeout(onResizeTimeoutID);
			onResizeTimeoutID = setTimeout(doneResizing, 150);
		});
	});
</script>
