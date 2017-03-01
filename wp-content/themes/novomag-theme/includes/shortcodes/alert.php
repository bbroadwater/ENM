<?php
add_shortcode('alert', 'alert_handler');

function alert_handler($atts, $content=null, $code="") {
	extract(shortcode_atts(array('color' => null), $atts) );

		

	return '<div class="coloralert" style="background-color:#'.$color.';">
				<p>'.do_shortcode($content).'</p>
				<a href="#close-alert"><i class="fa fa-plus"></i></a>
			</div>';

}

?>
