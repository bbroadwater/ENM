<?php
	add_shortcode('textmarker', 'textmarker_handler');

	function textmarker_handler($atts, $content=null, $code="") {

		return '<span class="marker" style="background-color:#'.$atts['color'].';">'.$content.'</span>';
	
	}
?>