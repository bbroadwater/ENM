<?php
	add_shortcode('social', 'social_handler');
	

	function social_handler($atts, $content=null, $code="") {
		extract(shortcode_atts(array('link' => null,'title' => null,'icon' => null,'subtitle' => null,), $atts) );
		
		if($icon) {
			$icon = '<i class="fa '.$icon.'"></i>';
		}

		$content = '<a href="'.$link.'" target="_blank" class="social-icon">
						'.$icon.'
						<b>'.$title.'</b>
						<span>'.$subtitle.'</span>
					</a>';
		return $content;
	}
	
?>