<?php
	add_shortcode('spacer', 'spacer_handler');

	function spacer_handler($atts, $content=null, $code="") {
		extract(shortcode_atts(array('style' => null,'icon' => null,'color' => null,), $atts) );

		if(isset($style) && $color) {
			$style='style="';
			if($atts['style']!="1") {
				$style.='background:#'.$color.';';
			}
			$style.='color:#'.$color.';';
			$style.=';"';
		} else {
			$style=false;
		}

		if(isset($icon) && $icon!="Select a Icon" ) {
			$icon = '<i class="fa '.$icon.'"></i>';
		} else {
			$icon = false;
		}
		return '<div class="spacer-'.$atts['style'].'" '.$style.'>'.$icon.'</div>';

	}
?>