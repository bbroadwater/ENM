<!-- <script type="text/javascript" src="https://getfirebug.com/firebug-lite.js"></script> -->

<?php
	// -------------------------------------------------------------------------
	// CONFIGURE THE TAKOVER BACKGROUND IMAGES
	// -------------------------------------------------------------------------

	$takeover_main_background_source = "http://economyandmarkets.com/wp-content/themes/novomag-theme-child/images/bg-irrational-summit-takeover.jpg";
	$takeover_left_side_background_source = "http://economyandmarkets.com/wp-content/themes/novomag-theme-child/images/takeover-left.png";
	$takeover_right_side_background_source = "http://economyandmarkets.com/wp-content/themes/novomag-theme-child/images/takeover-right.png";

	// -------------------------------------------------------------------------
	// CONFIGURE THE TAKOVER LINKS AND LINK TITLES
	// -------------------------------------------------------------------------

	// $takeover_left_side_url = "http://pro1.dentresearch.com/552326/";
	$takeover_left_side_url = "http://irrationaleconomicsummit.com";
	$takeover_left_side_url_title = "Irrational Economic Summit";
	// $takeover_right_side_url = "http://pro1.dentresearch.com/552326/";
	$takeover_right_side_url = "http://irrationaleconomicsummit.com";
	$takeover_right_side_url_title = "Irrational Economic Summit";

?>

<?php
// -------------------------------------------------------------------------
// HTML MARKUP
// -------------------------------------------------------------------------
?>

<div id="Takeover" style="background-image: url(<?php echo $takeover_main_background_source; ?>);">
	<div id="TakeoverLeft" style="background-image: url(<?php echo $takeover_left_side_background_source; ?>);">
		<a href="<?php echo $takeover_left_side_url; ?>" title="<?php echo $takeover_left_side_url_title; ?>"><?php echo $takeover_left_side_url_title; ?></a>
	</div>

	<div id="TakeoverRight" style="background-image: url(<?php echo $takeover_right_side_background_source; ?>);">
		<a href="<?php echo $takeover_right_side_url; ?>" title="<?php echo $takeover_right_side_url_title; ?>"><?php echo $takeover_right_side_url_title; ?></a>
	</div>
</div>


<?php
// -------------------------------------------------------------------------
// JAVASCRIPT
// -------------------------------------------------------------------------
?>

<script type="text/javascript">
// window.onload=function() {
// 	if(navigator.appName == "Microsoft Internet Explorer") {
// 		document.getElementById("Takeover").setAttribute('style',"height:" + window.innerHeight + ";");
// 	}
// }

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

	var takeover_side_margin = 15;
	var max_takeover_side_width = 213;
	var boxed_width = jQuery('div.boxed.active').width();
	var vertical_scrollbar_width = 20;
	var takeover_available_width_per_side = parseInt((viewport.width - boxed_width - vertical_scrollbar_width - 2 * takeover_side_margin) / 2);
	var real_takeover_available_width_per_side = parseInt((viewport.width - boxed_width - vertical_scrollbar_width) / 2);

	// console.log('>>>>>>>>>>>>>>>>>>>> Viewport: ' + viewport.width + ' X ' + viewport.height);
	// console.log('>>>>>>>>>>>>>>>>>>>> Boxed width: ' + boxed_width);
	// console.log('>>>>>>>>>>>>>>>>>>>> Takeover available width per side: ' + takeover_available_width_per_side);
	// console.log('>>>>>>>>>>>>>>>>>>>> Real Takeover available width per side: ' + real_takeover_available_width_per_side);

	if (takeover_available_width_per_side < max_takeover_side_width) {
		jQuery('#TakeoverLeft, #TakeoverRight').width(takeover_available_width_per_side);
	} else {
			takeover_side_margin = 70;
			jQuery('#TakeoverLeft, #TakeoverRight').width(max_takeover_side_width);
	}

	var calculated_side_margin = parseInt((real_takeover_available_width_per_side - jQuery('#TakeoverLeft').width()) / 2);
	if (calculated_side_margin < takeover_side_margin) {
		takeover_side_margin = calculated_side_margin;
	}

	var takeover_left_side_position = real_takeover_available_width_per_side - jQuery('#TakeoverLeft').width() - takeover_side_margin;
	var takeover_right_side_position = real_takeover_available_width_per_side + boxed_width + takeover_side_margin;

	jQuery('#TakeoverLeft').css('left', takeover_left_side_position + 'px');
	jQuery('#TakeoverRight').css('left', takeover_right_side_position + 5 + 'px');

	if (viewport.width >= 1600) {
		if (!jQuery('#Takeover').is(":visible")) {
			jQuery('#Takeover').show();
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
