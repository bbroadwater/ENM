<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/* -------------------------------------------------------------------------*
 * 								HOMEPAGE BUILDER							*
 * -------------------------------------------------------------------------*/
 
class OT_home_builder {

	private static $data;
	public static $counter = 1; 



	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST NEWS						*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block($blockType, $blockId,$blockInputType) {
		global $post;
		$title = $count = $cat = $offset = $pageColor = $link = $my_query = array();

		for($i=0; $i<=1; $i++) {
			$title[] = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$i."_".$blockId));
			$count[] = get_option(THEME_NAME."_".$blockType."_count_".$i."_".$blockId);
			$cat[] = get_option(THEME_NAME."_".$blockType."_cat_".$i."_".$blockId);
			$offset[] = get_option(THEME_NAME."_".$blockType."_offset_".$i."_".$blockId);


			if($cat[$i]) {
				$pageColor[] = ot_title_color($cat[$i], "category", false);
				$link[] = get_category_link($cat[$i]);
			} else {
				$pageColor[] = ot_title_color(get_option('page_for_posts'),'page', false);
				$link[] = get_page_link(get_option('page_for_posts'));
			}


			//set wp query
			$args = array(
				'post_type' => "post",
				'cat' => $cat[$i],
				'offset' =>$offset[$i],
				'showposts' => $count[$i],
				'ignore_sticky_posts' => "1"
			);

			$my_query[] = new WP_Query($args);
		}


		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'pageColor' =>$pageColor,
		);


		

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-1";
		return $block;

	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST NEWS STYLE 2					*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_1($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);

		if($cat) {
			$pageColor = ot_title_color($cat, "category", false);
			$link = get_category_link($cat);
		} else {
			$pageColor = ot_title_color(get_option('page_for_posts'),'page', false);
			$link = get_page_link(get_option('page_for_posts'));
		}

		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'pageColor' =>$pageColor,
		);

		//set wp query
		$args = array(
			'post_type' => "post",
			'cat' => $cat,
			'offset' =>$offset,
			'showposts' => $count,
			'ignore_sticky_posts' => "1"
		);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-2";
		return $block;

	}

	/* -------------------------------------------------------------------------*
	 * 						HOMEPAGE LATEST NEWS STYLE 3						*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_2($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
	
		if($cat) {
			$pageColor = ot_title_color($cat, "category", false);
			$link = get_category_link($cat);
		} else {
			$pageColor = ot_title_color(get_option('page_for_posts'),'page', false);
			$link = get_page_link(get_option('page_for_posts'));
		}


		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'link' =>$link,
			'pageColor' =>$pageColor,
		);


		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-3";
		return $block;

	}


	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST NEWS STYLE 3					*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_3($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);

	
		if(!$offset) {
			$offset = "0";
		}


		if($cat) {
			$pageColor = ot_title_color($cat, "category", false);
			$link = get_category_link($cat);
		} else {
			$pageColor = ot_title_color(get_option('page_for_posts'),'page', false);
			$link = get_page_link(get_option('page_for_posts'));
		}

		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'pageColor' =>$pageColor,
		);

		//set wp query
		$args = array(
			'post_type' => "post",
			'cat' => $cat,
			'offset' =>$offset,
			'showposts' => $count,
			'ignore_sticky_posts' => "1"
		);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-3";
		return $block;

	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST REWVIEWS						*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_4($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);
		$pageColor = get_option(THEME_NAME."_".$blockType."_color_".$blockId);
		$type = get_option(THEME_NAME."_".$blockType."_type_".$blockId);

		if(!$offset) {
			$offset = "0";
		}

		


		//set block attributes
		$attr = array(
			'title' =>$title,
			'cat' => $cat,
			'offset' =>$offset,
			'pageColor' =>$pageColor,
		);

		if($type=="top") {
			//set wp query
			$args = array(
				'post_type' => "post",
				'cat' => $cat,
				'showposts' => 3,
				'ignore_sticky_posts' => "1",
				'order' => 'DESC',
				'orderby'	=> 'meta_value_num',
				'meta_key'	=> "_".THEME_NAME.'_ratings_average',
				'offset' =>$offset
			);
		} else {
			//set wp query
			$args = array(
				'post_type' => "post",
				'cat' => $cat,
				'order' => 'DESC',
				'showposts' => 3,
				'ignore_sticky_posts' => "1",
				'meta_query' => array(
				    array(
				        'key' => "_".THEME_NAME.'_ratings_average',
				        'value'   => '0',
				        'compare' => '>='
				    )
				),
				'offset' =>$offset
			);	
		}

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "reviews";
		return $block;

	}


	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE POPULAR NEWS							*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_5($blockType, $blockId,$blockInputType) {
		global $post;
		$title = $count = $cat = $offset = $pageColor = $link = $my_query = array();

		for($i=0; $i<=1; $i++) {
			$title[] = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$i."_".$blockId));
			$count[] = get_option(THEME_NAME."_".$blockType."_count_".$i."_".$blockId);
			$cat[] = get_option(THEME_NAME."_".$blockType."_cat_".$i."_".$blockId);
			$offset[] = get_option(THEME_NAME."_".$blockType."_offset_".$i."_".$blockId);
			$pageColor[] = "#".get_option(THEME_NAME."_".$blockType."_color_".$i."_".$blockId);

			//set wp query
			$args = array(
				'showposts' => $count[$i],
				'order' => 'DESC',
				'cat' => $cat[$i],
				'offset' =>$offset[$i],
				'orderby'	=> 'meta_value_num',
				'meta_key'	=> "_".THEME_NAME.'_post_views_count',
				'post_type'=> 'post',
				'ignore_sticky_posts' => true
			);

			$my_query[] = new WP_Query($args);
		}

		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>false,
			'pageColor' => $pageColor,
		);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-1";
		return $block;
	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE POPULAR NEWS STYLE 2					*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_6($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);
		$pageColor = get_option(THEME_NAME."_".$blockType."_color_".$blockId);
	
		if(!$offset) {
			$offset = "0";
		}



		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>false,
			'pageColor' =>"#".$pageColor,
		);

		//set wp query
		$args=array(
			'showposts' => $count,
			'order' => 'DESC',
			'cat' => $cat,
			'offset' =>$offset,
			'orderby'	=> 'meta_value_num',
			'meta_key'	=> "_".THEME_NAME.'_post_views_count',
			'post_type'=> 'post',
			'ignore_sticky_posts' => true
		);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-2";
		return $block;

	}


	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE POPULAR NEWS STYLE 3					*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_7($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);
		$pageColor = get_option(THEME_NAME."_".$blockType."_color_".$blockId);

	
		if(!$offset) {
			$offset = "0";
		}


		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>false,
			'pageColor' =>"#".$pageColor,
		);

		//set wp query
		$args=array(
			'showposts' => $count,
			'order' => 'DESC',
			'cat' => $cat,
			'offset' =>$offset,
			'orderby'	=> 'meta_value_num',
			'meta_key'	=> "_".THEME_NAME.'_post_views_count',
			'post_type'=> 'post',
			'ignore_sticky_posts' => true
		);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-3";
		return $block;

	}


	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST NEWS STYLE 4					*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_8($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);

	
		if(!$offset) {
			$offset = "0";
		}


		if($cat) {
			$pageColor = ot_title_color($cat, "category", false);
			$link = get_category_link($cat);
		} else {
			$pageColor = ot_title_color(get_option('page_for_posts'),'page', false);
			$link = get_page_link(get_option('page_for_posts'));
		}

		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'pageColor' =>$pageColor,
		);

		//set wp query
		$args = array(
			'post_type' => "post",
			'cat' => $cat,
			'offset' =>$offset,
			'showposts' => $count,
			'ignore_sticky_posts' => "1"
		);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-4";
		return $block;

	}



	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE LATEST NEWS STYLE 5					*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_10($blockType, $blockId,$blockInputType) {
		global $post;
		$title = stripslashes(get_option(THEME_NAME."_".$blockType."_title_".$blockId));
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
		$offset = get_option(THEME_NAME."_".$blockType."_offset_".$blockId);
		$style = get_option(THEME_NAME."_".$blockType."_style_".$blockId);

	
		if(!$offset) {
			$offset = "0";
		}


		if($cat) {
			$pageColor = ot_title_color($cat, "category", false);
			$link = get_category_link($cat);
		} else {
			$pageColor = ot_title_color(get_option('page_for_posts'),'page', false);
			$link = get_page_link(get_option('page_for_posts'));
		}

		//set block attributes
		$attr = array(
			'title' =>$title,
			'count' =>$count,
			'cat' => $cat,
			'offset' =>$offset,
			'link' =>$link,
			'pageColor' =>$pageColor,
			'blogStyle' =>$style,
		);

		//set wp query
		$args = array(
			'post_type' => "post",
			'cat' => $cat,
			'offset' =>$offset,
			'showposts' => $count,
			'ignore_sticky_posts' => "1"
		);

		$my_query = new WP_Query($args);

		//add all data in array
		$data = array($my_query, $attr);

		//set data
		$this->set_data($data);
		$block = "latest-news-5";
		return $block;

	}
	/* -------------------------------------------------------------------------*
	 * 						HOMEPAGE CATEGORIES STYLE 1							*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_news_block_9($blockType, $blockId,$blockInputType) {
		global $post;
		$count = get_option(THEME_NAME."_".$blockType."_count_".$blockId);
		$cat = get_option(THEME_NAME."_".$blockType."_cat_".$blockId);
	

		//set block attributes
		$attr = array(
			'count' =>$count,
			'cat' => $cat,
		);


		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "categories-1";
		return $block;

	}

	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE HTML BLOCK								*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_html($blockType, $blockId,$blockInputType) {
		global $post;
		$code = get_option(THEME_NAME."_".$blockType."_".$blockId);
		//$title = get_option(THEME_NAME."_".$blockType."_title_".$blockId);

		
		//set block attributes
		$attr = array(
			'code' =>wpautop(stripslashes(do_shortcode($code))),
			//'title' =>stripslashes($title),
		);


		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "html";
		return $block;

	}
	/* -------------------------------------------------------------------------*
	 * 							HOMEPAGE BANNER BLOCK							*
	 * -------------------------------------------------------------------------*/
	 
	public function homepage_banner($blockType, $blockId,$blockInputType) {
		global $post;
		$code = get_option(THEME_NAME."_".$blockType."_".$blockId);

		
		//set block attributes
		$attr = array(
			'code' =>wpautop(stripslashes(do_shortcode($code)))
		);

		//add all data in array
		$data = array($attr);

		//set data
		$this->set_data($data);
		$block = "banner";
		return $block;

	}

	private static function set_data($data) {
		self::$data = $data;
	}

	public static function get_data() {
		return self::$data;
	}


} 
?>