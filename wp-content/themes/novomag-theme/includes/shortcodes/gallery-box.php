<?php
add_shortcode('ot-gallery', 'gallery_handler');
function gallery_handler($atts, $content=null, $code="") {
	if(isset($atts['url'])) {
		if(substr($atts['url'],-1) == '/') {
			$atts['url'] = substr($atts['url'],0,-1);
		}
		$vars = explode('/',$atts['url']);
		$slug = $vars[count($vars)-1];
		$page = get_page_by_path($slug,'OBJECT','gallery');
		if(is_object($page)) {
			$id = $page->ID;
			if(is_numeric($id)) {
				$gallery_style = get_post_meta ( $id, THEME_NAME."_gallery_style", true );
				$galleryImages = get_post_meta ( $id, THEME_NAME."_gallery_images", true ); 
				$imageIDs = explode(",",$galleryImages);
				$count = count($imageIDs);
				if($gallery_style=="lightbox") { $classL = 'light-show '; } else { $classL = false; }

				$content.=	'<div class="gallery-preview">';
					$content.=	'<div class="preview-thumbs">';
	            		$counter=1;
	            		foreach($imageIDs as $imgID) { 
	            			if ($counter==8) break;
	            			if($imgID) {
		            			$file = wp_get_attachment_url($imgID);
		            			if($counter==1) {
		            				$image = get_post_thumb(false, 198, 139, false, $file);
		            			} else {
		            				$image = get_post_thumb(false, 70, 69, false, $file);
		            			}
		            			
								if($counter==1) { $class=' featured-photo'; } else { $class=false; }				
								$content.=	'<a href="'.$atts['url'].'?page='.$counter.'" class="'.$classL.$class.'" data-id="gallery-'.$id.'">
													<img src="'.$image['src'].'" alt="'.$page->post_title.'" title="'.$page->post_title.'" data-id="'.$counter.'" class="'.$class.'"/>
											</a>';
									
								$counter++;
							}
						} 

						$content.=	'</div>'; 
						$content.=	'<div class="preview-desc">
										<h3><a href="" class="'.$classL.'" data-id="gallery-'.$id.'">'.$page->post_title.'</a></h3>';
											
								if($page->post_excerpt) { 
									$content.=	'<p>'.$page->post_excerpt.'</p>'; 
								} else {
									$content.=	'<p>'.WordLimiter($page->post_content, 15).'</p>'; 
								}
						$content.=	'</div>'; 
						$content.=	'<div class="preview-options">'; 
							$content.=	'<a href="'.$atts['url'].'" class="'.$classL.'" data-id="gallery-'.$id.'"><i class="fa fa-angle-double-left"></i> '.__("View gallery", THEME_NAME).'</a>'; 
							$content.=	'<a href="'.$atts['url'].'" class="right"><i class="fa fa-camera"></i>'.OT_image_count($id).' '.__("Photos", THEME_NAME).'</a>'; 
						$content.=	'</div>';
					$content.=	'</div>';

			} else {
				$content.= "Incorrect URL attribute defined";
			}
		} else {
			$content.= "Incorrect URL attribute defined";
		}
		
	} else {
		$content.= "No url attribute defined!";
	
	}
	return $content;
}


?>
