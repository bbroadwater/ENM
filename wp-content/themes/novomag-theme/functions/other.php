<?php

/* -------------------------------------------------------------------------*
 * 								CONTENT WIDTH								*
 * -------------------------------------------------------------------------*/
 
 if ( ! isset( $content_width ) ) 
    $content_width = 900;


/* -------------------------------------------------------------------------*
 * 							CATEGORIE CUSTOM COLOR							*
 * -------------------------------------------------------------------------*/	


	$config = array(
	   'pages' => array('category',OT_POST_GALLERY.'-cat'),                    // taxonomy name, accept categories, post_tag and custom taxonomies
	   'context' => 'normal',                           // where the meta box appear: normal (default), advanced, side; optional
	   'fields' => array(),                             // list of meta fields (can be added by field arrays)
	   'local_images' => false,                         // Use local or hosted images (meta box images for add/remove)
	   'use_with_theme' => true                        	//change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);




	$sidebar_names = get_option( THEME_NAME."_sidebar_names" );
	$sidebar_names = explode( "|*|", $sidebar_names );
	$sidebars = array();
	$sidebars['default'] = 'Default';
	$sidebars['off'] = 'Off';

	if(!empty($sidebar_names)) {
		foreach ($sidebar_names as $sidebar) {
			if($sidebar!="") {
				$sidebars[strtolower($sidebar)] = $sidebar;
			}
		}
	}	

	$sidebarSmall = array();
	$sidebarSmall['off'] = 'Disabled';
	$sidebarSmall['default'] = 'Default';

	if(!empty($sidebar_names)) {
		foreach ($sidebar_names as $sidebar) {
			if($sidebar!="") {
				$sidebarSmall[strtolower($sidebar)] = $sidebar;
			}
		}
	}



	$my_meta = new Tax_Meta_Class($config);
	$my_meta->addColor(THEME_NAME.'_title_color',array('name'=> 'Categoy Color'));
	$my_meta->addSelect(THEME_NAME.'_breaking_slider',array('off'=>'Off','on'=>'On'),array('name'=> __('Category Breaking News Slider ','tax-meta'), 'std'=> array('off')));
	$my_meta->addSelect(THEME_NAME.'_sidebar_position',array('right'=>'Right','left'=>'Left'),array('name'=> __('Main Sidebar Position ','tax-meta'), 'std'=> array('right')));
	$my_meta->addSelect(THEME_NAME.'_sidebar_select', $sidebars ,array('name'=> __('Main Sidebar','tax-meta'), 'std'=> array('default')));
	if(!isset($_GET["taxonomy"]) || $_GET["taxonomy"] == "category") {
		$my_meta->addSelect(THEME_NAME.'_blog_style',array('1'=>__('Style 1', THEME_NAME),'2'=>__('Style 2', THEME_NAME)),array('name'=> __('Category Style ','category'), 'std'=> array('1')));		
	}
	
	$my_meta->Finish();




	


/* -------------------------------------------------------------------------*
 * 					GET META VALUE OUTSIDE THE LOOP							*
 * -------------------------------------------------------------------------*/
 
 function ot_meta($id,$value) {
	$meta = get_post_meta($id, $value, true);
	return $meta;
}


/* -------------------------------------------------------------------------*
 * 								GET IMAGE HTML								*
 * -------------------------------------------------------------------------*/
 
 function ot_image_html($id, $width=0, $height=0, $class=false) {
 	$image = get_post_thumb($id,$width,$height);
 	if($class) {
 		$class = ' class="'.$class.'"';
 	} else {
 		$class = false;
 	}
	$return = '<img'.$class.' src="'.$image["src"].'" alt="'.get_the_title($id).'" />';
	return $return;
}

/* -------------------------------------------------------------------------*
 * 								GET IMAGE HTML								*
 * -------------------------------------------------------------------------*/
 
 function ot_updated_tag_html() {
 	if (get_the_modified_time() != get_the_time() && get_option(THEME_NAME."_updated_tag")=="on") {
 		echo '<span class="tag" title="'.__("Last Update: ", THEME_NAME).get_the_modified_time("H:i, j.M Y").'">'.__("Updated", THEME_NAME).'</span>';	
 	}
}


/* -------------------------------------------------------------------------*
 * 							OT GET SIDEBAR SIDE								*
 * -------------------------------------------------------------------------*/
 
function ot_get_sidebar($id) {

	//sidebars defauult option
	$sidebarPosition = get_option ( THEME_NAME."_sidebar_position" ); 
	//sidebars singlepost/page option
	$sidebarPositionCustom = get_post_meta ( $id, "_".THEME_NAME."_sidebar_position", true ); 

	//left side sidebar
	if( ($sidebarPosition == "left" || ( $sidebarPosition == "custom" &&  $sidebarPositionCustom == "left"))) { 
		get_template_part(THEME_INCLUDES."sidebar");
	}

	//right side sidebar
	if( ($sidebarPosition == "right" || ( $sidebarPosition == "custom" &&  $sidebarPositionCustom == "right") || ( $sidebarPosition == "custom" && !$sidebarPositionCustom ))) { 
		get_template_part(THEME_INCLUDES."sidebar");
	}

}


/* -------------------------------------------------------------------------*
 * 							AVARAGE POST RATING							*
 * -------------------------------------------------------------------------*/
 
function ot_avarage_rating($id) {
 	$ratings = get_post_meta( $id, "_".THEME_NAME."_ratings", true );
	$totalRate = array();
	$rating = explode(";", $ratings);

	foreach($rating as $rate) { 
		$ratingValues = explode(":", $rate);
		if(isset($ratingValues[1])){
			$ratingPrecentage = (str_replace(",",".",$ratingValues[1]))*20;
			$totalRate[] = $ratingPrecentage;
		}
		
	} 

	if(!empty($totalRate)) {
		$rateCount = count($totalRate);	
		$total = 0;
		foreach ($totalRate as $val) {
			$total = $total + $val;
		}

		$avaragePrecentage = round($total/$rateCount,2);
		$avarageRate = round((($total/$rateCount)/20),1);

		return array($avaragePrecentage,$avarageRate);

	} else {
		return false;
	}

}

/* -------------------------------------------------------------------------*
 * 								GET TITLE COLOR								*
 * -------------------------------------------------------------------------*/
 
function ot_title_color($id, $type="category", $echo=true) {
 	if($type == "category" && $id!="popular" && $id!="latest") {
		$my_meta = new Tax_Meta_Class('');
		$titleColor = $my_meta->get_tax_meta($id, THEME_NAME.'_title_color');
		$my_meta->Finish();
	} else if ($type=="page") {
		$titleColor = "#".ot_meta($id, "_".THEME_NAME."_title_color"); 
	} else if ($id=="popular") {
		$titleColor = "#".get_option(THEME_NAME."_popular_post_color");
	} else if ($id=="latest") {
		$titleColor = "#".get_option(THEME_NAME."_latest_post_color");
	}

	
	if(!isset($titleColor) || $titleColor=="" || $titleColor=="#") $titleColor = "#".get_option(THEME_NAME."_default_cat_color");
	
	if($echo!=false) {
		echo $titleColor;
	} else {
		return $titleColor;
	}
}

/* -------------------------------------------------------------------------*
 * 								GET OPTION									*
 * -------------------------------------------------------------------------*/
 
function ot_get_option($id, $type, $echo=false) {
	$my_meta = new Tax_Meta_Class('');
	$value = $my_meta->get_tax_meta($id, THEME_NAME.'_'.$type);
	$my_meta->Finish();

	if($echo!=false) {
		echo $value;
	} else {
		return $value;
	}
}

/* -------------------------------------------------------------------------*
 * 							CHECK WOOCOMMERCE								*
 * -------------------------------------------------------------------------*/
 
function ot_is_woocommerce_activated() {
	if ( class_exists( 'woocommerce' ) ) { return true; } else { return false; }
}


/* -------------------------------------------------------------------------*
 * 							MAIN NAV MENU WALKER							*
 * -------------------------------------------------------------------------*/

class OT_Walker extends Walker_Nav_Menu {
	public static $count = 0;
	public static $parent_menu_type = 0;

    public static function plus_one() {
		return ++self::$count;
	}
    public static function count() {
		return self::$count;
	}
    public static function reset_count($val) {
		self::$count = $val;
	}

    public static function set_menu_type($val) {
		self::$parent_menu_type = $val;
	}
    public static function menu_type() {
		return self::$parent_menu_type;
	}

    function start_lvl( &$output, $depth = 0, $args = array()) {
		$indent = str_repeat("\t", $depth);
		$output .= "\n$indent<ul class=\"sub-menu\">\n";
	}

    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $wp_query, $ot_menu_catID;
		$my_meta = new Tax_Meta_Class('');
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        if($depth==0) {
        	$this->set_menu_type($item->menu_type);
        	$parent_menu_type = $this->menu_type();
        } else {
       		$parent_menu_type = $this->menu_type();
        }

        if($item->menu_type=="2" && $depth==0) {
        	$this->reset_count(0);
        	$OTclass = "mega-menu-full ";
        } else {
        	$OTclass = "normal-drop ";
        }

        if(!$item->description) {
        	$OTclass .= " menu-single ";
        }


        $class_names = $value = '';

		if($depth==2) {
			$count = $this->plus_one();
		} else {
			$count = $this->count();
		}

		if($count==1 && $depth==2) {
			$megaClass = " color-light";
		} else {
			$megaClass = false;
		}

		$postDate = get_option(THEME_NAME."_post_date");
		$postComments = get_option(THEME_NAME."_post_comment");
		$postAuthor = get_option(THEME_NAME."_post_author");

		//mega menu block 1
		if(($parent_menu_type=="2") && ($depth==2 || $depth==3)) {

	        
	        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

	        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
	        $class_names = ' class="'. esc_attr( $class_names ).$megaClass.'"';
	        
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"'.$value . $class_names .'>';	
			//mega menu 1st block
			$item_output = $args->before;
			if($count==1 && $depth==3) {

		        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';


		        
		        $item_output .= '<a'. $attributes .'>';

		        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				
		        $item_output .= '</a>';
		       

			}

	        //mega menu block 2
	        if($count==2 && $depth==3) {

			        if($item->object=="category"){
			        	$postArgs=array(
							'cat'=> $item->object_id,
							'posts_per_page'=> 1,
							'ignore_sticky_posts' => true
						);
						$the_query = new WP_Query($postArgs);
						
							if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
							if(get_post_meta( $the_query->post->ID, "_".THEME_NAME."_post_style", true ) == "light") {
								$class = " light";
							} else {
								$class = false;
							}
							$item_output .= '<div class="menu-content featured-post'.$class.'">';
								$item_output .='<div class="item-photo">';
									$item_output .='<a href="'.get_permalink().'">'.ot_image_html($the_query->post->ID,325,176).'</a>';
									$item_output .='<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
								$item_output .='</div>';
								$item_output .='<div class="item-content">';
									$item_output .='<p>'.WordLimiter(get_the_excerpt(), 15).'</p>';
									$item_output .='<div class="article-icons">';
										if($postDate=="on") {
											$item_output .='<span class="article-icon">'.get_the_time(get_option('date_format')).'</span>';
										}
										if ( comments_open() && $postComments=="on") {
											$item_output .='<a href="'.get_comments_link().'" class="article-icon">'.ot_get_comments_number($the_query->post->ID).'</a>';
										}
										if($postAuthor=="on") {
											$user_ID = get_the_author_meta('ID');
											$user_info = get_userdata($user_ID);
											$item_output .='<a href="'.get_author_posts_url($user_ID, $user_info->user_login ).'" class="article-icon">'.get_the_author_meta('display_name',$user_ID).'</a>';
										}
									$item_output .='</div>';
								$item_output .='</div>';
							$item_output .= '</div>';
							endwhile; else:
								$item_output .='<div class="menu-content featured-post"><p>'.__( 'No posts where found' , THEME_NAME).'</p></div>';
							endif;
		
					} else {
						$item_output .='<div class="menu-content featured-post"><p>'.__("Please Insert A category", THEME_NAME).'</p></div>';
					}
				
			}

	        //mega menu block 3
	        if($count==3 && $depth==3) {
	        	
		        $item_output .= '<div class="menu-content article-list">';


		        if($item->object=="category"){
		        	$postArgs=array(
						'cat'=> $item->object_id,
						'posts_per_page'=> 4,
						'ignore_sticky_posts' => true
					);
					$the_query = new WP_Query($postArgs);
					
						if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post();
							$item_output .='<div class="item">';
								$item_output .='<a href="'.get_permalink().'">'.ot_image_html($the_query->post->ID,60,60, 'item-photo').'</a>';
								$item_output .='<div class="item-content">';
									$item_output .='<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
									if($postDate=="on") {
										$item_output .='<span class="article-icon">'.get_the_time(get_option('date_format')).'</span>';
									}
									if ( comments_open() && $postComments=="on") {
										$item_output .='<a href="'.get_comments_link().'" ><span>'.ot_get_comments_number($the_query->post->ID).'</span></a>';
									}
								$item_output .='</div>';
							$item_output .='</div>';
						endwhile; else:
							$item_output .='<div class="item"><p>'.__( 'No posts where found' , THEME_NAME).'</p></div>';
						endif;

				} else {
					$item_output .='<div class="item">'.__("Please Insert A category", THEME_NAME).'</div>';
				}
				$item_output .= '</div>';
				
			}	
 			$item_output .= $args->after;
 		//mega menu 2
		} else {
			//default menu
	        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

		        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		        $class_names = ' class="'.$OTclass. esc_attr( $class_names ).'"';
		        
		        if($depth==0) {

			        if($item->object=="category") {
						$titleColor = $my_meta->get_tax_meta($item->object_id, THEME_NAME.'_title_color');
					}
					if($item->object=="page") {
						$titleColor = "#".ot_meta($item->object_id, "_".THEME_NAME."_title_color"); 	
					}

					if(!isset($titleColor) || $titleColor=="#") $titleColor = "#".get_option(THEME_NAME."_default_cat_color"); 
					
					if(isset($titleColor) && $item->color=="yes") {
						$style=' style="border-bottom: 3px solid '.$titleColor.'; "'; 
					} else { 
						$style = false;
					}
					
				} else { 
					$style = false;
				}
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"'.$value . $class_names .'>';	
				

			if($parent_menu_type!="2" || $depth!=1) {
		        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		        $attributes .= $style;

		        //$attributes .= ' data-id="'. esc_attr( $item->object_id        ) .'"';
		        //$attributes .= ' data-slug="'. esc_attr(  basename(get_permalink($item->object_id )) ) .'"';

		        $item_output = $args->before;
		        $item_output .= '<a'. $attributes .'>';

			    if(isset($item->classes[4]) && in_array("ot-dropdown", $item->classes)) {
			      $item_output .= '<span>';
			    } 	

		        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				

	 
			   if(isset($item->classes[4]) && in_array("ot-dropdown", $item->classes)) {
			      $item_output .= '</span>';
			    } 	

		        $item_output .= '</a>';
	        	$item_output .= $args->after;
	        } else {
	        	$item_output= false;
	        }
       
        }
       

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		$my_meta->Finish();


    }
	
	function end_el( &$output, $item, $depth = 0, $args = array() ) {
		$output .= "</li>\n";
	}
}

/* -------------------------------------------------------------------------*
 * 								TOP NAV MENU WALKER							*
 * -------------------------------------------------------------------------*/

class OT_Walker_Top extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {
        global $wp_query;
		$my_meta = new Tax_Meta_Class('');
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        
        if($depth==0) {
		    if(empty($item->description)) {
		      	$class = ' single';
		    } else {
		    	$class = false;
		    }	
        } else {
        	$class = false;
        }

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names.$class ).'"';

		
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"'. $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        //$attributes .= ' data-id="'. esc_attr( $item->object_id        ) .'"';
        //$attributes .= ' data-slug="'. esc_attr(  basename(get_permalink($item->object_id )) ) .'"';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
       // if($depth==0) {
		    if(isset($item->classes[4]) && in_array("ot-dropdown", $item->classes)) {
		      $item_output .= '<span>';
		    } 	
        //}
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

       // if($depth==0 && $item->description ) {
       	//	$item_output .= '<i>'.$item->description.'</i>';
       	//}
        //if($depth==0) {
		   if(isset($item->classes[4]) && in_array("ot-dropdown", $item->classes)) {
		      $item_output .= '</span>';
		    } 	
        //}
        $item_output .= '</a>';

        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		$my_meta->Finish();



    }
}
add_filter( 'wp_nav_menu_objects', 'add_menu_parent_class' );
function add_menu_parent_class( $items ) {
	
	$parents = array();
	foreach ( $items as $item ) {
		if ( $item->menu_item_parent && $item->menu_item_parent > 0 ) {
			$parents[] = $item->menu_item_parent;
		}
	}
	
	foreach ( $items as $item ) {
		if ( in_array( $item->ID, $parents ) ) {
			$item->classes[] = 'ot-dropdown'; 
		}
	}
	
	return $items;    
}


function remove_br($subject) {
	$subject = str_replace("<br/>", " ", $subject );
	$subject = str_replace("<br>", " ", $subject );
	$subject = str_replace("<br />", " ", $subject );
	return $subject;
}

function get_query_string_paged() {
	global $query_string;
	$pos = strpos($query_string,"paged=");
	if($pos !== false ) {
		$sub = substr($query_string,$pos);
		$posand = strpos($sub,"&");
		if ($posand == 0) {$paged = substr($sub,6);}
		else { $paged = substr($sub,6,$posand-6);}
		return $paged;
	}
	return 0;
}


function get_gallery_page() {
	$pages = get_pages();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-gallery.php") {
			return $p->ID;
		}
	}
	return false;
}

function get_shop_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-shop.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;
}

function get_home_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-homepage.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;

}
function get_menu_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-menucard.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;

}
function get_events_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-events.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;

}

function get_archive_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-archive.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;

}

function get_fullwidth_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-full-width.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;

}
function get_map_page() {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-sitemap.php") {
			$pageID[]=$p->ID;
		}
	}
	return $pageID;

}

function ot_get_page($name, $type="array") {
	$pages = get_pages();
	$pageID = array();
	foreach($pages as $p) {
		$meta = get_post_custom_values("_wp_page_template",$p->ID);
		if($meta[0] == "template-".$name.".php" || strpos($meta[0],"template-".$name.".php") !== false) {
			$pageID[]=$p->ID;
		}
	}
	if($type=="array") {
		return $pageID;	
	} else {
		return $pageID[0];	
	}



}

function ot_get_page_array($array) {
	$pages = get_pages();
	$pageID = array();
	foreach($array as $name) {
		foreach($pages as $p) {
			$meta = get_post_custom_values("_wp_page_template",$p->ID);
			if($meta[0] == "template-".$name.".php" || strpos($meta[0],"template-".$name.".php") !== false) {
				$pageID[]=$p->ID;
			}
		}
	}
	return $pageID;	
}


/* -------------------------------------------------------------------------*
 * 								Awesome Icons								*
 * -------------------------------------------------------------------------*/

function ot_awesome_icons(){
	$icons = array(
              	'Select a Icon','fa-glass',
				'fa-music',
				'fa-search',
				'fa-envelope-o',
				'fa-heart',
				'fa-star',
				'fa-star-o',
				'fa-user',
				'fa-film',
				'fa-th-large',
				'fa-th',
				'fa-th-list',
				'fa-check',
				'fa-times',
				'fa-search-plus',
				'fa-search-minus',
				'fa-power-off',
				'fa-signal',
				'fa-cog',
				'fa-trash-o',
				'fa-home',
				'fa-file-o',
				'fa-clock-o',
				'fa-road',
				'fa-download',
				'fa-arrow-circle-o-down',
				'fa-arrow-circle-o-up',
				'fa-inbox',
				'fa-play-circle-o',
				'fa-repeat',
				'fa-refresh',
				'fa-list-alt',
				'fa-lock',
				'fa-flag',
				'fa-headphones',
				'fa-volume-off',
				'fa-volume-down',
				'fa-volume-up',
				'fa-qrcode',
				'fa-barcode',
				'fa-tag',
				'fa-tags',
				'fa-book',
				'fa-bookmark',
				'fa-print',
				'fa-camera',
				'fa-font',
				'fa-bold',
				'fa-italic',
				'fa-text-height',
				'fa-text-width',
				'fa-align-left',
				'fa-align-center',
				'fa-align-right',
				'fa-align-justify',
				'fa-list',
				'fa-outdent',
				'fa-indent',
				'fa-video-camera',
				'fa-picture-o',
				'fa-pencil',
				'fa-map-marker',
				'fa-adjust',
				'fa-tint',
				'fa-pencil-square-o',
				'fa-share-square-o',
				'fa-check-square-o',
				'fa-arrows',
				'fa-step-backward',
				'fa-fast-backward',
				'fa-backward',
				'fa-play',
				'fa-pause',
				'fa-stop',
				'fa-forward',
				'fa-fast-forward',
				'fa-step-forward',
				'fa-eject',
				'fa-chevron-left',
				'fa-chevron-right',
				'fa-plus-circle',
				'fa-minus-circle',
				'fa-times-circle',
				'fa-check-circle',
				'fa-question-circle',
				'fa-info-circle',
				'fa-crosshairs',
				'fa-times-circle-o',
				'fa-check-circle-o',
				'fa-ban',
				'fa-arrow-left',
				'fa-arrow-right',
				'fa-arrow-up',
				'fa-arrow-down',
				'fa-share',
				'fa-expand',
				'fa-compress',
				'fa-plus',
				'fa-minus',
				'fa-asterisk',
				'fa-exclamation-circle',
				'fa-gift',
				'fa-leaf',
				'fa-fire',
				'fa-eye',
				'fa-eye-slash',
				'fa-exclamation-triangle',
				'fa-plane',
				'fa-calendar',
				'fa-random',
				'fa-comment',
				'fa-magnet',
				'fa-chevron-up',
				'fa-chevron-down',
				'fa-retweet',
				'fa-shopping-cart',
				'fa-folder',
				'fa-folder-open',
				'fa-arrows-v',
				'fa-arrows-h',
				'fa-bar-chart-o',
				'fa-twitter-square',
				'fa-facebook-square',
				'fa-camera-retro',
				'fa-key',
				'fa-cogs',
				'fa-comments',
				'fa-thumbs-o-up',
				'fa-thumbs-o-down',
				'fa-star-half',
				'fa-heart-o',
				'fa-sign-out',
				'fa-linkedin-square',
				'fa-thumb-tack',
				'fa-external-link',
				'fa-sign-in',
				'fa-trophy',
				'fa-github-square',
				'fa-upload',
				'fa-lemon-o',
				'fa-phone',
				'fa-square-o',
				'fa-bookmark-o',
				'fa-phone-square',
				'fa-twitter',
				'fa-facebook',
				'fa-github',
				'fa-unlock',
				'fa-credit-card',
				'fa-rss',
				'fa-hdd-o',
				'fa-bullhorn',
				'fa-bell',
				'fa-certificate',
				'fa-hand-o-right',
				'fa-hand-o-left',
				'fa-hand-o-up',
				'fa-hand-o-down',
				'fa-arrow-circle-left',
				'fa-arrow-circle-right',
				'fa-arrow-circle-up',
				'fa-arrow-circle-down',
				'fa-globe',
				'fa-wrench',
				'fa-tasks',
				'fa-filter',
				'fa-briefcase',
				'fa-arrows-alt',
				'fa-users',
				'fa-link',
				'fa-cloud',
				'fa-flask',
				'fa-scissors',
				'fa-files-o',
				'fa-paperclip',
				'fa-floppy-o',
				'fa-square',
				'fa-bars',
				'fa-list-ul',
				'fa-list-ol',
				'fa-strikethrough',
				'fa-underline',
				'fa-table',
				'fa-magic',
				'fa-truck',
				'fa-pinterest',
				'fa-pinterest-square',
				'fa-google-plus-square',
				'fa-google-plus',
				'fa-money',
				'fa-caret-down',
				'fa-caret-up',
				'fa-caret-left',
				'fa-caret-right',
				'fa-columns',
				'fa-sort',
				'fa-sort-asc',
				'fa-sort-desc',
				'fa-envelope',
				'fa-linkedin',
				'fa-undo',
				'fa-gavel',
				'fa-tachometer',
				'fa-comment-o',
				'fa-comments-o',
				'fa-bolt',
				'fa-sitemap',
				'fa-umbrella',
				'fa-clipboard',
				'fa-lightbulb-o',
				'fa-exchange',
				'fa-cloud-download',
				'fa-cloud-upload',
				'fa-user-md',
				'fa-stethoscope',
				'fa-suitcase',
				'fa-bell-o',
				'fa-coffee',
				'fa-cutlery',
				'fa-file-text-o',
				'fa-building-o',
				'fa-hospital-o',
				'fa-ambulance',
				'fa-medkit',
				'fa-fighter-jet',
				'fa-beer',
				'fa-h-square',
				'fa-plus-square',
				'fa-angle-double-left',
				'fa-angle-double-right',
				'fa-angle-double-up',
				'fa-angle-double-down',
				'fa-angle-left',
				'fa-angle-right',
				'fa-angle-up',
				'fa-angle-down',
				'fa-desktop',
				'fa-laptop',
				'fa-tablet',
				'fa-mobile',
				'fa-circle-o',
				'fa-quote-left',
				'fa-quote-right',
				'fa-spinner',
				'fa-circle',
				'fa-reply',
				'fa-github-alt',
				'fa-folder-o',
				'fa-folder-open-o',
				'fa-smile-o',
				'fa-frown-o',
				'fa-meh-o',
				'fa-gamepad',
				'fa-keyboard-o',
				'fa-flag-o',
				'fa-flag-checkered',
				'fa-terminal',
				'fa-code',
				'fa-reply-all',
				'fa-mail-reply-all',
				'fa-star-half-o',
				'fa-location-arrow',
				'fa-crop',
				'fa-code-fork',
				'fa-chain-broken',
				'fa-question',
				'fa-info',
				'fa-exclamation',
				'fa-superscript',
				'fa-subscript',
				'fa-eraser',
				'fa-puzzle-piece',
				'fa-microphone',
				'fa-microphone-slash',
				'fa-shield',
				'fa-calendar-o',
				'fa-fire-extinguisher',
				'fa-rocket',
				'fa-maxcdn',
				'fa-chevron-circle-left',
				'fa-chevron-circle-right',
				'fa-chevron-circle-up',
				'fa-chevron-circle-down',
				'fa-html5',
				'fa-css3',
				'fa-anchor',
				'fa-unlock-alt',
				'fa-bullseye',
				'fa-ellipsis-h',
				'fa-ellipsis-v',
				'fa-rss-square',
				'fa-play-circle',
				'fa-ticket',
				'fa-minus-square',
				'fa-minus-square-o',
				'fa-level-up',
				'fa-level-down',
				'fa-check-square',
				'fa-pencil-square',
				'fa-external-link-square',
				'fa-share-square',
				'fa-compass',
				'fa-caret-square-o-down',
				'fa-caret-square-o-up',
				'fa-caret-square-o-right',
				'fa-eur',
				'fa-gbp',
				'fa-usd',
				'fa-inr',
				'fa-jpy',
				'fa-rub',
				'fa-krw',
				'fa-btc',
				'fa-file',
				'fa-file-text',
				'fa-sort-alpha-asc',
				'fa-sort-alpha-desc',
				'fa-sort-amount-asc',
				'fa-sort-amount-desc',
				'fa-sort-numeric-asc',
				'fa-sort-numeric-desc',
				'fa-thumbs-up',
				'fa-thumbs-down',
				'fa-youtube-square',
				'fa-youtube',
				'fa-xing',
				'fa-xing-square',
				'fa-youtube-play',
				'fa-dropbox',
				'fa-stack-overflow',
				'fa-instagram',
				'fa-flickr',
				'fa-adn',
				'fa-bitbucket',
				'fa-bitbucket-square',
				'fa-tumblr',
				'fa-tumblr-square',
				'fa-long-arrow-down',
				'fa-long-arrow-up',
				'fa-long-arrow-left',
				'fa-long-arrow-right',
				'fa-apple',
				'fa-windows',
				'fa-android',
				'fa-linux',
				'fa-dribbble',
				'fa-skype',
				'fa-foursquare',
				'fa-trello',
				'fa-female',
				'fa-male',
				'fa-gittip',
				'fa-sun-o',
				'fa-moon-o',
				'fa-archive',
				'fa-bug',
				'fa-vk',
				'fa-weibo',
				'fa-renren',
				'fa-pagelines',
				'fa-stack-exchange',
				'fa-arrow-circle-o-right',
				'fa-arrow-circle-o-left',
				'fa-caret-square-o-left',
				'fa-dot-circle-o',
				'fa-wheelchair',
				'fa-vimeo-square',
				'fa-try',
				'fa-plus-square-o'
    );

	return $icons;
}


/* -------------------------------------------------------------------------*
 * 							GALLERY IMAGE SELECT							*
 * -------------------------------------------------------------------------*/
 
function ot_gallery_image_select($id, $value) {
	global $post_id,$post;
	if(!$post_id) {
		$post_id = $post->ID;
	}
	?>
	<div id="ot_images_container">
		<ul class="ot_gallery_images">
			<?php
				if ( $value ) {
					$product_image_gallery = $value;
				} else {
					// Backwards compat
					$attachment_ids = get_posts( 'post_parent=' . $post_id . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_value=0' );
					$attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
					$product_image_gallery = implode( ',', $attachment_ids );
				}

				$attachments = array_filter( explode( ',', $product_image_gallery ) );

				if ( $attachments )
					foreach ( $attachments as $attachment_id ) {
						echo '<li class="image" data-attachment_id="' . $attachment_id . '">
							' . wp_get_attachment_image( $attachment_id, array(80,80) ) . '
							<ul class="actions">
								<li><a href="#" class="delete" title="' . __( 'Delete image', THEME_NAME ) . '">' . __( 'Delete', THEME_NAME ) . '</a></li>
							</ul>
						</li>';
					}
			?>
		</ul>

		<input type="hidden" id="<?php echo $id;?>" name="<?php echo $id;?>" value="<?php echo esc_attr( $product_image_gallery ); ?>" />

	</div>
	<p class="add_product_images hide-if-no-js">
		<a href="#"><?php _e( 'Add images', THEME_NAME ); ?></a>
	</p>
	<script type="text/javascript">
		jQuery(document).ready(function($){

			// Uploading files
			var product_gallery_frame;
			var $image_gallery_ids = $('#<?php echo $id;?>');
			var $df_gallery_images = $('#ot_images_container ul.ot_gallery_images');

			jQuery('.add_product_images').on( 'click', 'a', function( event ) {

				var $el = $(this);
				var attachment_ids = $image_gallery_ids.val();

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( product_gallery_frame ) {
					product_gallery_frame.open();
					return;
				}

				// Create the media frame.
				product_gallery_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title: '<?php _e( 'Add Images to Product Gallery', THEME_NAME ); ?>',
					button: {
						text: '<?php _e( 'Add to gallery', THEME_NAME ); ?>',
					},
					multiple: true
				});

				// When an image is selected, run a callback.
				product_gallery_frame.on( 'select', function() {

					var selection = product_gallery_frame.state().get('selection');

					selection.map( function( attachment ) {

						attachment = attachment.toJSON();

						if ( attachment.id ) {
							attachment_ids = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;

							$df_gallery_images.append('\
								<li class="image" data-attachment_id="' + attachment.id + '">\
									<img src="' + attachment.url + '" width="80" height="80"/>\
									<ul class="actions">\
										<li><a href="#" class="delete" title="<?php _e( 'Delete image', THEME_NAME ); ?>"><?php _e( 'Delete', THEME_NAME ); ?></a></li>\
									</ul>\
								</li>');
						}

					} );

					$image_gallery_ids.val( attachment_ids );
				});

				// Finally, open the modal.
				product_gallery_frame.open();
			});

			// Image ordering
			$df_gallery_images.sortable({
				items: 'li.image',
				cursor: 'move',
				scrollSensitivity:40,
				forcePlaceholderSize: true,
				forceHelperSize: false,
				helper: 'clone',
				opacity: 0.65,
				placeholder: 'wc-metabox-sortable-placeholder',
				start:function(event,ui){
					ui.item.css('background-color','#f6f6f6');
				},
				stop:function(event,ui){
					ui.item.removeAttr('style');
				},
				update: function(event, ui) {
					var attachment_ids = '';

					$('#ot_images_container ul li.image').css('cursor','default').each(function() {
						var attachment_id = jQuery(this).attr( 'data-attachment_id' );
						attachment_ids = attachment_ids + attachment_id + ',';
					});

					$image_gallery_ids.val( attachment_ids );
				}
			});

			// Remove images
			$('#ot_images_container').on( 'click', 'a.delete', function() {

				$(this).closest('li.image').remove();

				var attachment_ids = '';

				$('#ot_images_container ul li.image').css('cursor','default').each(function() {
					var attachment_id = jQuery(this).attr( 'data-attachment_id' );
					attachment_ids = attachment_ids + attachment_id + ',';
				});

				$image_gallery_ids.val( attachment_ids );

				return false;
			} );

		});
	</script>
	<?php

}

/* -------------------------------------------------------------------------*
 * 								WIDGET COUNTER								*
 * -------------------------------------------------------------------------*/
 
function widget_first_last_classes($params) {

	global $my_widget_num; // Global a counter array
	$this_id = $params[0]['id']; // Get the id for the current sidebar we're processing
	$arr_registered_widgets = wp_get_sidebars_widgets(); // Get an array of ALL registered widgets	

	if(!$my_widget_num) {// If the counter array doesn't exist, create it
		$my_widget_num = array();
	}

	if(!isset($arr_registered_widgets[$this_id]) || !is_array($arr_registered_widgets[$this_id])) { // Check if the current sidebar has no widgets
		return $params; // No widgets in this sidebar... bail early.
	}

	if(isset($my_widget_num[$this_id])) { // See if the counter array has an entry for this sidebar
		$my_widget_num[$this_id] ++;
	} else { // If not, create it starting with 1
		$my_widget_num[$this_id] = 1;
	}

	$class = 'class="widget-' . $my_widget_num[$this_id] . ' '; // Add a widget number class for additional styling options

	if($my_widget_num[$this_id] == 1) { // If this is the first widget
		$class .= 'first ';
	} elseif($my_widget_num[$this_id] == count($arr_registered_widgets[$this_id])) { // If this is the last widget
		$class .= 'last ';
	}

	$params[0]['before_widget'] = str_replace('class="', $class, $params[0]['before_widget']); // Insert our new classes into "before widget"

	return $params;

}

function orange_themes_follow() {
		echo "<!-- BEGIN .follow -->";
		echo "<div class=\"follow\">";
			echo "<p>Follow Orange Themes</p>";
			echo "<a href=\"http://themeforest.net/user/orange-themes?ref=orange-themes\" class=\"themeforest\" target=\"blank\">Theme Forest</a>";
			echo "<a href=\"http://twitter.com/#!/orangethemes\" class=\"twitter\" target=\"blank\">Twitter</a>";
			echo "<a href=\"http://www.orange-themes.com/\" class=\"orangethemes\" target=\"blank\">Orange-Themes.com</a>";
		echo "<!-- END .follow -->";
		echo "</div>";
	}	
	
function orange_themes_info_message($content) {
	?>
	<a href="javascript:{}" class="help"><img src="<?php echo THEME_IMAGE_CPANEL_URL; ?>ico-help-1.png" /></a>
	<i class="popup-help popup-help-hidden trans-1">
		<a href="javascript:{}" class="close"></a>
		<?php echo $content; ?>
	</i>
	<?php
}
	
$uploadsdir=wp_upload_dir();
define("THEME_UPLOADS_URL", $uploadsdir['url']);





/* -------------------------------------------------------------------------*
 * 							GRAVATAR SETTUP									*
 * -------------------------------------------------------------------------*/
 
function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
	$url = 'http://www.gravatar.com/avatar/';
	$url .= md5(strtolower(trim($email)));
	$url .= "?s=$s&d=$d&r=$r";
	if ( $img ) {
		$url = '<img src="' . $url . '"';
		foreach ( $atts as $key => $val )
			$url .= ' ' . $key . '="' . $val . '"';
		$url .= ' />';
	}
	return $url;
}


/* -------------------------------------------------------------------------*
 * 							WEATHER FORECAST								*
 * -------------------------------------------------------------------------*/
 
function OT_weather_forecast($ip) {
	$locationType = get_option(THEME_NAME."_weather_location_type");
	if($locationType == "custom") {
		$whitelist = array();
	} else {
		$whitelist = array('localhost', '127.0.0.1');
	}

	$weather_api = get_option(THEME_NAME."_weather_api");
	$weather_api_key_type = get_option(THEME_NAME."_weather_api_key_type");
	if($weather_api) {
		if(!in_array($_SERVER['HTTP_HOST'], $whitelist)){
			if($locationType == "custom") {
				$result = true;
			} else {
				$url = "http://www.geoplugin.net/json.gp?ip=".$ip;
				$result = json_response($url);
			}

			if($result!=false) {
				if($locationType == "custom") {
					$city = false;
					$country = false;
					$weatherResult = get_transient('weather_result_'.urlencode($ip));
				} else {
					$city = $result->geoplugin_city;
					$country = $result->geoplugin_countryName;
					$weatherResult = get_transient('weather_result_'.urlencode($city).'_'.urlencode($country));
				}

				
				if($weatherResult==false) {
					$temperature = get_option(THEME_NAME."_temperature");
					

					if($city) {
						if($weather_api_key_type=="premium") {
							$url = "http://api.worldweatheronline.com/premium/v1/weather.ashx?key=".$weather_api."&q=".urlencode($city).",".urlencode($country)."&num_of_days=1&includeLocation=yes&date=today&format=json";
						} else {
							$url = "http://api.worldweatheronline.com/free/v1/weather.ashx?key=".$weather_api."&q=".urlencode($city).",".urlencode($country)."&num_of_days=1&includeLocation=yes&date=today&format=json";
						}				
						$result = json_response($url);
					} else {
						if($weather_api_key_type=="premium") {
							$url = "http://api.worldweatheronline.com/premium/v1/weather.ashx?key=".$weather_api."&q=".$ip."&num_of_days=1&includeLocation=yes&date=today&format=json";
						} else {
							$url = "http://api.worldweatheronline.com/free/v1/weather.ashx?key=".$weather_api."&q=".$ip."&num_of_days=1&includeLocation=yes&date=today&format=json";
						}
						$result = json_response($url);
					}
				
					if($result!=false) {
						$weather = array();

			
						$weather['temp_F'] = $result->data->current_condition[0]->temp_F;	
						$weather['temp_C'] = $result->data->current_condition[0]->temp_C;
						
						// add + before 
						$weather['temp_F'] = intval($weather['temp_F']);
						if($weather['temp_F']>0) {
							$weather['temp_F'] = "+".$weather['temp_F'];
						} else {
							$weather['temp_F'];
						}				

						// add + before 
						$weather['temp_C'] = intval($weather['temp_C']);
						if($weather['temp_C']>0) {
							$weather['temp_C'] = "+".$weather['temp_C'];
						} else {
							$weather['temp_C'];
						}

						$weather['temp_F'] = $weather['temp_F'].'&deg;F';
						$weather['temp_C'] = $weather['temp_C'].'&deg;C';

						$weatherCode = $result->data->current_condition[0]->weatherCode;
						$weather['city'] = $result->data->nearest_area[0]->areaName[0]->value;
						$weather['country'] = $result->data->nearest_area[0]->country[0]->value;
						$weather['weatherDesc'] = $result->data->weather[0]->weatherDesc[0]->value;


						switch ($weatherCode) {
							case '395':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Moderate or heavy snow in area with thunder', THEME_NAME);
								break;
							case '392':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Patchy light snow in area with thunder', THEME_NAME);
								break;
							case '371':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Moderate or heavy snow showers', THEME_NAME);
								break;
							case '368':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Light snow showers', THEME_NAME);
								break;
							case '350':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Ice pellets', THEME_NAME);
								break;
							case '338':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Heavy snow', THEME_NAME);
								break;
							case '335':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Patchy heavy snow', THEME_NAME);
								break;
							case '332':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Moderate snow', THEME_NAME);
								break;
							case '329':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Patchy moderate snow', THEME_NAME);
								break;
							case '326':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Light snow', THEME_NAME);
								break;
							case '323':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Patchy light snow', THEME_NAME);
								break;
							case '320':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Moderate or heavy sleet', THEME_NAME);
								break;
							case '317':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Light sleet', THEME_NAME);
								break;
							case '284':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Heavy freezing drizzle', THEME_NAME);
								break;
							case '281':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Freezing drizzle', THEME_NAME);
								break;
							case '266':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Light drizzle', THEME_NAME);
								break;
							case '263':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Patchy light drizzle', THEME_NAME);
								break;
							case '230':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Blizzard', THEME_NAME);
								break;
							case '227':
								$weather['image'] = "weather-snow";
								$weather['weatherDesc'] = __('Blowing snow', THEME_NAME);
								break;
							case '389':
								$weather['image'] = "weather-thunder";
								$weather['weatherDesc'] = __('Moderate or heavy rain in area with thunder', THEME_NAME);
								break;
							case '386':
								$weather['image'] = "weather-thunder";
								$weather['weatherDesc'] = __('Patchy light rain in area with thunder', THEME_NAME);
								break;
							case '200':
								$weather['image'] = "weather-thunder";
								$weather['weatherDesc'] = __('Thundery outbreaks in nearby', THEME_NAME);
								break;
							case '377':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Moderate or heavy showers of ice pellets', THEME_NAME);
								break;
							case '374':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Light showers of ice pellets', THEME_NAME);
								break;
							case '365':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Moderate or heavy sleet showers', THEME_NAME);
								break;
							case '362':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Light sleet showers', THEME_NAME);
								break;
							case '359':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Torrential rain shower', THEME_NAME);
								break;
							case '356':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Moderate or heavy rain shower', THEME_NAME);
								break;
							case '353':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Light rain shower', THEME_NAME);
								break;
							case '314':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Moderate or Heavy freezing rain', THEME_NAME);
								break;
							case '311':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Light freezing rain', THEME_NAME);
								break;
							case '308':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Heavy rain', THEME_NAME);
								break;
							case '305':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Heavy rain at times', THEME_NAME);
								break;
							case '302':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Moderate rain', THEME_NAME);
								break;
							case '299':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Moderate rain at times', THEME_NAME);
								break;
							case '296':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Light rain', THEME_NAME);
								break;
							case '293':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Patchy light rain', THEME_NAME);
								break;
							case '185':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Patchy freezing drizzle nearby', THEME_NAME);
								break;
							case '179':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Patchy snow nearby', THEME_NAME);
								break;
							case '176':
								$weather['image'] = "weather-rain";
								$weather['weatherDesc'] = __('Patchy rain nearby', THEME_NAME);
								break;
							case '260':
								$weather['image'] = "weather-cloudy";
								$weather['weatherDesc'] = __('Freezing fog', THEME_NAME);
								break;
							case '248':
								$weather['image'] = "weather-cloudy";
								$weather['weatherDesc'] = __('Fog', THEME_NAME);
								break;
							case '143':
								$weather['image'] = "weather-cloudy";
								$weather['weatherDesc'] = __('Mist', THEME_NAME);
								break;
							case '122':
								$weather['image'] = "weather-cloudy";
								$weather['weatherDesc'] = __('Overcast', THEME_NAME);
								break;
							case '119':
								$weather['image'] = "weather-cloudy";
								$weather['weatherDesc'] = __('Cloudy', THEME_NAME);
								break;
							case '116':
								$weather['image'] = "weather-clouds";
								$weather['weatherDesc'] = __('Partly Cloudy', THEME_NAME);
								break;
							case '113':
								$weather['image'] = "weather-sun";
								$weather['weatherDesc'] = __('Sunny', THEME_NAME);
								break;
							case '182':
								$weather['image'] = "weather-sleet";
								$weather['weatherDesc'] = __('Patchy sleet nearby', THEME_NAME);
								break;
							default:
								$weather['image'] = "weather-default";
								$weather['weatherDesc'] = __('Can\'t get any data.', THEME_NAME);
								break;
						}

						//set wp cache
						if($locationType == "custom") {
							set_transient('weather_result_'.urlencode($ip), $weather, 3600 );
						} else {
							set_transient( 'weather_result_'.urlencode($city).'_'.urlencode($country), $weather, 3600 );
						}
						
					} else {
						$weather['error'] = __("Something went wrong with the connection!",THEME_NAME);
					}
				} else {
					//get wp cache
					if($locationType == "custom") {
						$weather = get_transient('weather_result_'.urlencode($ip));
					} else {
						$weather = get_transient('weather_result_'.urlencode($city).'_'.urlencode($country));
					}

				}
			} else {
				$weather['error'] = __("Something went wrong with the connection!",THEME_NAME);
			}
		} else {
			$weather['error'] = __("This option doesn't work on localhost!",THEME_NAME);
		}
	} else {

		$weather['error'] = __("Please set up your API key!",THEME_NAME);

	}
	return $weather;
}

/* -------------------------------------------------------------------------*
 * 								GOOGLE + BUTTON								*
 * -------------------------------------------------------------------------*/
 
function OT_plusones($url) {
	if($url) {
	  	$curl = curl_init();
	  	curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
	  	curl_setopt($curl, CURLOPT_POST, 1);
	  	curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
	  	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	  	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
	  	$curl_results = curl_exec ($curl);
	  	curl_close ($curl);
	  	$json = json_decode($curl_results, true);
	  	return intval( $json[0]['result']['metadata']['globalCounts']['count'] );
	} else {
		return 0;
	}
}
/* -------------------------------------------------------------------------*
 * 								NEWS PAGE TITLE								*
 * -------------------------------------------------------------------------*/
 
function ot_page_title() {
	$post_type = get_post_type();
	//check if bbpress
	if (function_exists("is_bbpress") && is_bbpress()) {
		$OTbbpress = true;
	} else {
		$OTbbpress = false;
	}

	if(!is_archive() && !is_category() && !is_search() && $post_type!=OT_POST_GALLERY) {
		$title = get_the_title(OT_page_id());
	} else if(is_single() && $post_type==OT_POST_GALLERY) {
		$galID = ot_get_page("gallery");
		$title = get_the_title($galID[0]);
	}  else if(is_search()) {
		$title = __("Search Results for", THEME_NAME)." \"".remove_html($_GET['s'])."\"";
	} else if(is_category()) {
		$category = get_category( get_query_var( 'cat' ) );
		$cat_id = $category->cat_ID;
		$catName = get_category($cat_id )->name;
		$title = $catName;
	} else if (is_author()) {
		$curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
		$title = __("Posts From", THEME_NAME). " ".$curauth->display_name;
	} else if(is_tag()) {
		$category = single_tag_title('',false);
		$title =  __("Tag", THEME_NAME)." \"".$category."\"";
	} else if(is_tax()) {
		$category = single_tag_title('',false);
		$title = $category;
	} else if(is_archive()) {
		if(ot_is_woocommerce_activated() == true && woocommerce_get_page_id('shop') == get_the_ID() || $OTbbpress==true) {
			$title = get_the_title(get_the_ID());
		} else {
			$title = __("Archive", THEME_NAME);	
		}
	}else {
		$title = get_the_title(OT_page_id());
	}
	echo $title;
}

/* -------------------------------------------------------------------------*
 * 							CONTENT CLASS							*
 * -------------------------------------------------------------------------*/
 
function OT_content_class($id) {
	wp_reset_query();
	if(is_category()) {
		$catId = get_cat_id( single_cat_title("",false) );
		$sidebarPosition = get_option ( THEME_NAME."_sidebar_position" ); 
		$sidebarPositionCustom = ot_get_option ( $catId, "sidebar_position"); 
	} else {
		$sidebarPosition = get_option ( THEME_NAME."_sidebar_position" ); 
		$sidebarPositionCustom = get_post_meta ( $id, "_".THEME_NAME."_sidebar_position", true ); 
	}
	
	if( $sidebarPosition == "left" || ( $sidebarPosition == "custom" && $sidebarPositionCustom == "left") ) { 
		$contentClass = "right";
	} else if( $sidebarPosition == "right" || ( $sidebarPosition == "custom" && $sidebarPositionCustom == "right") ) { 
		$contentClass = "left";
	} else if ( $sidebarPosition == "custom" && !$sidebarPositionCustom ) { 
		$contentClass = "left";
	} else {
		$contentClass = "left";
	}
	echo $contentClass;
}
/* -------------------------------------------------------------------------*
 * 								SIDEBAR CLASS								*
 * -------------------------------------------------------------------------*/
 
function OT_sidebarClass($id){
	wp_reset_query();
	if(is_category()) {
		$catId = get_cat_id( single_cat_title("",false) );
		$sidebarPosition = get_option ( THEME_NAME."_sidebar_position" ); 
		$sidebarPositionCustom = ot_get_option ( $catId, "sidebar_position"); 
	} else {
		$sidebarPosition = get_option ( THEME_NAME."_sidebar_position" ); 
		$sidebarPositionCustom = get_post_meta ( $id, "_".THEME_NAME."_sidebar_position", true ); 
	}
	if($sidebarPosition=="left" || ( $sidebarPosition == "custom" &&  $sidebarPositionCustom == "left") ) { $sidebarClass = 'left'; } else { $sidebarClass = 'right'; } 
    echo $sidebarClass;
}

/* -------------------------------------------------------------------------*
 * 							GET PAGE ID										*
 * -------------------------------------------------------------------------*/
 
function OT_page_id() {
	$page_id = get_queried_object_id();

	if(isset($page_id) && $page_id!=0) {
		return $page_id;	
	} elseif(ot_is_woocommerce_activated() == true) {
		return woocommerce_get_page_id('shop');
	}

}

/* -------------------------------------------------------------------------*
 * 							UPDATE POST VIEW COUNT							*
 * -------------------------------------------------------------------------*/
 
function OT_setPostViews() {
	global $post;
	if(is_single() && isset($post)) {
		$postID = $post->ID;
		$count_key = "_".THEME_NAME.'_post_views_count';
		$count = get_post_meta($postID, $count_key, true);
		
		if ( !current_user_can( 'manage_options' ) && !isset($_COOKIE[THEME_NAME."_post_views_count_".$postID])) {
			if ( $count=='' ) {
				delete_post_meta($postID, $count_key);
				add_post_meta($postID, $count_key, '0');
			} else {
				$count++;
				update_post_meta($postID, $count_key, $count, $count-1);
			}
			
			setcookie(THEME_NAME."_post_views_count_".$postID, "1", time()+2678400); 
		}

	}
}

/* -------------------------------------------------------------------------*
 * 							GET POST VIEW COUNT								*
 * -------------------------------------------------------------------------*/
 
function OT_getPostViews($postID){
    $count_key = "_".THEME_NAME.'_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
   
   if( $count=='' ){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
	
    return $count;
}


/* -------------------------------------------------------------------------*
 * 								POST TYPE								*
 * -------------------------------------------------------------------------*/
 
	function OT_post_type($post_type) {
		switch ($post_type) {
			case "blog":
				$post_type="post";
				break;
			case "gallery":
				$post_type="gallery";
				break;
			case "all":
				$post_type=array("post","gallery");
				break;
			default:
				$post_type="post";
		}
		return $post_type;
	}

/* -------------------------------------------------------------------------*
 * 						 CUSTOM GET COMMENTS								*
 * -------------------------------------------------------------------------*/
 
	function ot_get_comments_number($id) {
		$num_comments = get_comments_number($id); // get_comments_number returns only a numeric value

		if ( $num_comments == 0 ) {
			$comments = __('No Comments', THEME_NAME);
		} elseif ( $num_comments > 1 ) {
			$comments = $num_comments . __(' Comments', THEME_NAME);
		} else {
			$comments = __('1 Comment', THEME_NAME);
		}
		return $comments;
	}

 /* -------------------------------------------------------------------------*
 * 						ADD CUSTOM TEXT FORMATTING BUTTONS					*
 * -------------------------------------------------------------------------*/
global $orangethemes_buttons;
$orangethemes_buttons=array("orangethemesbutton", "orangethemesspacer", "orangethemesquote", "|",
			 "orangethemeslists", "|","orangethemesvideo" ,"orangethemesmarker","orangethemestabs","orangethemessocial", "|",
			 "orangethemesgallery", "orangethemescaption", "|", "orangethemesparagraph", "orangethemesparagraph2", "orangethemesparagraph5", "orangethemesparagraph3", "orangethemesparagraph4", "orangethemesalert", "orangethemesaccordion", "orangethemestoggles", "|","orangethemesbreak");

function add_orangethemes_buttons() {
   if ( get_user_option('rich_editing') == 'true') {
     add_filter('mce_external_plugins', 'add_orangethemes_btn_tinymce_plugin');
     add_filter('mce_buttons_3', 'register_orangethemes_buttons');
   }
}

function register_orangethemes_buttons($buttons) {
	global $orangethemes_buttons;
		
   array_push($buttons, implode(",",$orangethemes_buttons));
   return $buttons;
}

function add_orangethemes_btn_tinymce_plugin($plugin_array) {
	global $orangethemes_buttons;
	
	foreach($orangethemes_buttons as $btn){
		$plugin_array[$btn] = THEME_ADMIN_URL.'buttons-formatting/editor-plugin.js';
	}
	return $plugin_array;

}
 
 
 /* ------------------------------------------------------------------------*
 * 							OTHER THEMES									*
 * -------------------------------------------------------------------------*/
 
 function other_themes () {
?>
		<!-- BEGIN more-orange-themes -->
		<div class="more-orange-themes">

			<div class="header">
				<img src="<?php echo THEME_IMAGE_MTHEMES_URL; ?>title-more-themes.png" alt="" width="447" height="23" />
				<p>
					<a href="http://www.themeforest.net/user/orange-themes/portfolio?ref=orange-themes" class="btn-1" target="_blank"><span><u class="themeforest">Check our portfolio at themeforest.net</u></span></a>
					<a href="http://www.twitter.com/#!/orangethemes" class="btn-1" target="_blank"><span><u class="twitter">Follow us on twitter</u></span></a>
					<a href="http://www.orange-themes.com" class="btn-1" target="_blank"><span><u class="orangethemes">Orange-themes.com</u></span></a>
				</p>
			</div>

			<?php 
				$xml = theme_get_latest_theme_version(THEME_NOTIFIER_CACHE_INTERVAL); 
				foreach ( $xml->item as $entry ) {
				$title = explode("Private: ", $entry->title);
			?>
			
			<!-- BEGIN .item -->
			<div class="item">
				<div class="image">
					<a href="<?php echo $entry->purchase; ?>"><img src="<?php echo $entry->image; ?>" /></a>
				</div>
				<div class="text">
					<h2><a href="<?php echo $entry->purchase; ?>"><?php echo $title[1]; ?></a></h2>
					<p><?php echo $entry->content; ?></p>
					<p class="link"><a href="<?php echo $entry->demo; ?>" target="_blank">Demo website</a></p>
					<p class="link"><a href="<?php echo $entry->purchase; ?>" target="_blank">Purchase at ThemeForest.net</a></p>
					<?php if ( $entry->html ) { ?>
						<p class="link"><a href="<?php echo $entry->html; ?>" target="_blank">HTML version</a></p>
					<?php } ?>
				</div>
			<!-- END .item -->
			</div>
			<?php } ?> 
			
		<!-- END more-orange-themes -->
		</div>
<?php
	
}

/* -------------------------------------------------------------------------*
 * 							COUNT ATTACHMENTS								*
 * -------------------------------------------------------------------------*/
 
function OT_attachment_count($post_id = false) {
	global $post;
    //Get all attachments
    $attachments = get_posts( array(
        'post_type' => 'attachment',
        'posts_per_page' => -1
    ) );

    $att_count = 0;
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            // Check for the post type based on individual attachment's parent
            if ( OT_POST_GALLERY == get_post_type($attachment->post_parent) && $post_id == $attachment->post_parent ) {
                $att_count = $att_count + 1;
            } else if (OT_POST_GALLERY == get_post_type($attachment->post_parent) && $post_id == false) {
				$att_count = $att_count + 1;
			}
        }
    }
	 return $att_count;
}

/* -------------------------------------------------------------------------*
 * 							CATEGORY ORDER								*
 * -------------------------------------------------------------------------*/
 
	function ot_category_order($order,$array) {
		if($order) {
		
			$order_array = explode(",", $order);
			$i=0;
		
			foreach($order_array as $id){
				foreach($array as $n => $category){
					if(is_object($category) && $category->term_id == $id){
						$array[$n]->order = $i;
						$i++;
					}
				}
							
				foreach($array as $n => $category){
					if(is_object($category) && !isset($category->order)){
						$array[$n]->order = 99999;
					}
				}
			}
					
			usort($array, THEME_NAME."_category_order_compare");
					
		}

		return $array;
		
	}
/* -------------------------------------------------------------------------*
 * 							GALLERY IMAGE COUNT								*
 * -------------------------------------------------------------------------*/
 
function OT_image_count($post_id = false) {
    //Get all images
   	$galleryImages = get_post_meta ( $post_id, THEME_NAME."_gallery_images", true ); 
   	$imageIDs = explode(",",$galleryImages);
   	$att_count = count(array_filter($imageIDs));

	return $att_count;
}

/* -------------------------------------------------------------------------*
 * 							CHECK PAGE TEMPLATE								*
 * -------------------------------------------------------------------------*/
 
function is_pagetemplate_active($pagetemplate = '') {
	global $wpdb;
	$sql = "select meta_key from $wpdb->postmeta where meta_key like '_wp_page_template' and meta_value like '" . $pagetemplate . "'";
	$result = $wpdb->query($sql);
	if ($result) {
		return TRUE;
	} else {
		return FALSE;
	}
}
/* -------------------------------------------------------------------------*
 * 								HEX -> RGB								*
 * -------------------------------------------------------------------------*/
 
function OTHexToRGB($hex) {
		$hex = ereg_replace("#", "", $hex);
		$color = array();
 
		if(strlen($hex) == 3) {
			$color['r'] = hexdec(substr($hex, 0, 1) . $r);
			$color['g'] = hexdec(substr($hex, 1, 1) . $g);
			$color['b'] = hexdec(substr($hex, 2, 1) . $b);
		}
		else if(strlen($hex) == 6) {
			$color['r'] = hexdec(substr($hex, 0, 2));
			$color['g'] = hexdec(substr($hex, 2, 2));
			$color['b'] = hexdec(substr($hex, 4, 2));
		}
 
		return $color;
}

/* -------------------------------------------------------------------------*
 * 							PRASE SHORTCODE									*
 * -------------------------------------------------------------------------*/
 
function parse_shortcode_content( $content ) {

   /* Parse nested shortcodes and add formatting. */
    $content = trim( do_shortcode( shortcode_unautop( $content ) ) );

    /* Remove '' from the start of the string. */
    if ( substr( $content, 0, 4 ) == '' )
        $content = substr( $content, 4 );

    /* Remove '' from the end of the string. */
    if ( substr( $content, -3, 3 ) == '' )
        $content = substr( $content, 0, -3 );

    /* Remove any instances of ''. */
    $content = str_replace( array( '<p></p>' ), '', $content );
    $content = str_replace( array( '<p>  </p>' ), '', $content );

    return $content;
}

/* -------------------------------------------------------------------------*
 * 								GET GOOGLE FONTS							*
 * -------------------------------------------------------------------------*/
 
function OT_get_google_fonts($sort = "alpha") {

	$font_list = get_option(THEME_NAME."_google_font_list");
	$font_list_time = get_option(THEME_NAME."_google_font_list_update");
	$now = time();
	$interval = 41600;
	
	if($font_list) {
		$font_list = $font_list;
	} else if(!$font_list || (( $now - $font_list_time ) > $interval)) {
		$url = "https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyCpatq_HIaUbw1XUxVAellP4M1Uoa6oibU&sort=" . $sort;
		$result = json_response( $url );
		if($result!=false) {
			$font_list = array();
			foreach ( $result->items as $font ) {

				$font_list[] .= $font->family;
				
			}
		update_option(THEME_NAME."_google_font_list",$font_list);
		update_option(THEME_NAME."_google_font_list_update",time());
		} else {
			$font_list = false;
		}

	} else {
		$font_list = false;
	}
		
	return $font_list;
	
}
/* -------------------------------------------------------------------------*
 * 								JSON RESPONSE								*
 * -------------------------------------------------------------------------*/
 
if ( ! function_exists( 'json_response' ) )	{

	function json_response( $url )	{
			$args = array(
				 'timeout' => '10',
				 'redirection' => '10',
				 'sslverify' => false // for localhost
			);
			
			# Parse the given url
			$raw = wp_remote_get( $url, $args );
			if (!is_wp_error($raw)) {	
				$decoded = json_decode( $raw['body'] );
				return $decoded;
			} else {

				//return $url;	
				return false;	
			}

	}

}
/* -------------------------------------------------------------------------*
 * 								USER COMMENT COUNT							*
 * -------------------------------------------------------------------------*/
 
function OT_user_comment_count( $user_id )	{
	global $wpdb;
	$where = 'WHERE comment_approved = 1 AND user_id = ' . $user_id ;
	$comment_count = $wpdb->get_var(
		"SELECT COUNT( * ) AS total
			FROM {$wpdb->comments}
			{$where}
		");

	return $comment_count;
}

/* -------------------------------------------------------------------------*
 * 								MENU NAME									*
 * -------------------------------------------------------------------------*/
 
function OT_et_theme_menu_name( $theme_location ) {
	if( ! $theme_location ) return false;
 
	$theme_locations = get_nav_menu_locations();
	if( ! isset( $theme_locations[$theme_location] ) ) return false;
 
	$menu_obj = get_term( $theme_locations[$theme_location], 'nav_menu' );
	if( ! $menu_obj ) $menu_obj = false;
	if( ! isset( $menu_obj->name ) ) return false;
 
	return $menu_obj->name;
}



/* -------------------------------------------------------------------------*
 * 							GET AMIN PAGE TYPE								*
 * -------------------------------------------------------------------------*/

function ot_get_current_post_type() {
  	global $post, $typenow, $current_screen;
	
  	//we have a post so we can just get the post type from that
  	if ( $post && $post->post_type )
    	return $post->post_type;
    
  	//check the global $typenow - set in admin.php
  	elseif( $typenow )
    	return $typenow;
    
  	//check the global $current_screen object - set in sceen.php
  	elseif( $current_screen && $current_screen->post_type )
    	return $current_screen->post_type;
  
 	 //lastly check the post_type querystring
  	elseif( isset( $_REQUEST['post_type'] ) )
    	return sanitize_key( $_REQUEST['post_type'] );

	elseif (get_post_type(isset($_REQUEST['post'])))
        return get_post_type($_REQUEST['post']);

  	//we do not know the post type!
  	return null;
}

/* -------------------------------------------------------------------------*
 * 							CHECK AMIN PAGE TYPE								*
 * -------------------------------------------------------------------------*/

function ot_page_type_check($value) {
	global $post_id;
	if(isset($value) && in_array(ot_get_current_post_type(), $value) && !in_array('!blog', $value)) {
		return true;
	} elseif (isset($value) && in_array(ot_get_current_post_type(), $value) && !in_array('blog', $value) && (in_array('!blog', $value) && $post_id != get_option('page_for_posts'))) {
		return true;
	} elseif (isset($value) && in_array('blog', $value) && $post_id == get_option('page_for_posts') && !in_array('!blog', $value)) {
		return true;
	}  elseif (isset($value) && in_array('blog', $value) && $post_id != get_option('page_for_posts') || in_array('!blog', $value) && $post_id != get_option('page_for_posts')) {
		return false;
	} elseif (isset($value) && in_array('!blog', $value) && $post_id == get_option('page_for_posts')) {
		return false;
	} elseif (isset($value) && in_array($post_id,ot_get_page_array($value))) {
		return true;
	} else {
		return false;
	}
}
/* -------------------------------------------------------------------------*
 * 							CHECK AMIN PAGE TEMPLATE						*
 * -------------------------------------------------------------------------*/

function ot_template_check($value) {
	global $post_id;
	if (!empty($value) && in_array($post_id,ot_get_page_array($value))) {
		return true;
	} else {
		return false;
	}
}
/* -------------------------------------------------------------------------*
 * 								OPTION COMPARE								*
 * -------------------------------------------------------------------------*/

function ot_option_compare($value, $valueSingle) {
	if($value == "show" || ($value=="custom" && $valueSingle=="show") || ($value=="custom" && !$valueSingle)) {
		return true;
	} else {
		return false;
	}
}

/* -------------------------------------------------------------------------*
 * 								SUBMENU										*
 * -------------------------------------------------------------------------*/
function OT_submenu() {
	$subCats = array();
	$menu = false;
	
	if(is_category()) {
		$currentCategory = get_category( get_query_var( 'cat' ) );
		$currentID = $currentCategory->cat_ID;

		if(isset($currentCategory)) {
			
			if(isset($currentCategory->category_parent) && $currentCategory->category_parent!=0) {
				$catID = $currentCategory->category_parent;
			} else {
				$catID = $currentID;
			}
	
			$cats = get_categories(array('child_of' => $catID, 'hide_empty' => 0));												
			foreach ($cats as $cat) {
				$subCats[] = array(
					'url'		=> get_category_link( $cat->cat_ID ),
					'name'		=> $cat->name
				);
			}
		}
	} else if (is_single()) {
		$thisCategory = get_the_category();
		for($i=0; $i<=5; $i++) {
			if (!isset($thisCategory[$i]->category_parent)) break;
			if(isset($thisCategory[$i]->category_parent) && $thisCategory[$i]->category_parent!=0) {
				$catID[] = $thisCategory[$i]->category_parent;
			} else {
				$catID[] = $thisCategory[$i]->term_id;
			}
									
			$cats = get_categories(array('child_of' => $catID[$i], 'hide_empty' => 0));						
									
			foreach ($cats as $cat) {
				$subCats[] = array(
					'url'		=> get_category_link( $cat->cat_ID ),
					'name'		=> $cat->name
				);
			}

			$subCats = array_unique($subCats);
		}
	
	}
	

			
	if(!empty($subCats)) {
		$menu.= '<ul class="secondary-menu">';
		$c=1;
		foreach($subCats as $subCat) {
			$menu.= '<li><a href="'.$subCat['url'].'">'.$subCat['name'].'</a></li>';
			$c++;
			
			if($c>=6) {
				break; 
			}
		}
		$menu.= '</ul>';
	}
	
	echo $menu;
}

/* -------------------------------------------------------------------------*
 * 							COMMENT FORMATION								*
 * -------------------------------------------------------------------------*/

function orangethemes_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	if(!ot_get_avatar_url(get_avatar( $comment, 60))) {
		$comentClass = "noavatar";
	} else {
		$comentClass = false;	
	}


   ?>
	
	<li <?php comment_class($comentClass); ?> id="li-comment-<?php comment_ID(); ?>">

		<div class="commment-content" id="comment-<?php comment_ID() ?>">
			<div class="comment-block">
				<?php if(ot_get_avatar_url(get_avatar( $comment, 48))) { ?>
					<a href="<?php if(get_comment_author_url()) { echo get_comment_author_url();} else { echo "#"; } ?>" class="user-avatar">
						<img src="<?php echo ot_get_avatar_url(get_avatar( $comment, 48));?>" alt="<?php echo get_comment_author();?>" title="<?php echo get_comment_author();?>" />
					</a>
				<?php } ?>
				<div class="comment-text">
					<strong class="user-nick left">
						<a href="<?php if(get_comment_author_url()) { echo get_comment_author_url();} else { echo "#"; } ?>"><?php echo get_comment_author();?></a>
						<?php if($comment->user_id == get_the_author_meta('ID')) { ?>
							<span class="user-author"><?php _e("Author", THEME_NAME);?></span>
						<?php } ?>
					</strong>
					<span class="time-stamp left"><?php printf(__(' %1$s, %2$s', THEME_NAME), get_comment_date("j F, Y"), get_comment_time("H:i"));?></span>
					<div class="comment-content">
						<?php comment_text(); ?>
						<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<i class="fa fa-reply left"></i>'.( __( 'Reply this comment' , THEME_NAME ))))) ?>
					</div>
				</div>
				<div class="clear-float"></div>
			</div>
		</div>

<?php
       }
	
   
add_action('init', 'add_orangethemes_buttons');


add_filter('dynamic_sidebar_params','widget_first_last_classes');
add_theme_support('automatic-feed-links' ); 
add_filter('wp', 'OT_setPostViews');


?>