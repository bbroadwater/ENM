<?php
	add_shortcode('blockquote', 'blockquote_handler');

	function blockquote_handler($atts, $content=null, $code="") {


		$return=  '<blockquote class="style-'.$atts['style'].'">';
			$return.=  wpautop($content);
		$return.=  '</blockquote>';


		return $return;
	}
?>
