<?php

// set this to true if you want to add a takeover background
// ...and then confiure the background images for the takeover part in /includes/takeover.php
global $takeover_enabled;
$takeover_enabled = true;

function get_the_excerpt_max_charlength( $charlength, $post ) {

	$excerpt = get_the_excerpt( $post );
	$charlength++;
	$text = '';

	if ( mb_strlen( $excerpt ) > $charlength ) {
		$subex = mb_substr( $excerpt, 0, $charlength - 5 );
		$exwords = explode( ' ', $subex );
		$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$text .= mb_substr( $subex, 0, $excut );
		} else {
			$text .= $subex;
		}
		$text .= '…';
	} else {
		$text .= $excerpt;
	}

	return $text;
}

function ecom_get_recent_articles( $author ) {

	global $post;

	$query = new WP_Query(
		array(
			'posts_per_page' => 3,
			'author' => $post->post_author,
			'post__not_in' => array($post-ID),
			)
		);
	$posts = $query->get_posts();

	foreach ( $posts as $post ) {

		$cat = false;
		foreach( get_the_category($post->ID) as $category ) {
			$cat = $category;
			break;
		}

		$title = get_the_title ( $post );
		$date = get_the_date ( 'F j, Y', $post );
		$link = get_permalink ( $post );
		$image = get_the_post_thumbnail( $post );
		$category = $cat->name;
		$categoryUrl = get_term_link ( $cat );

		$html .= <<<HTML

   <div class="related-article">
	   <div class="thumbnail"><a href="$link">$image</a></div>
	   <div class="article-content">
	      <h3><a href="$link">$title</a></h3>
	      <div class="category-name">
	         <span class="blue-cat">
	         <a href="$categoryUrl"><i class="fa fa-folder-open"></i> $category</a>
	         </span>
	      </div>
	      <span class="article-date">
	      	<a href="$link" title="$title">$date</a>
	  	  </span>
	   </div>
	</div>

HTML;

	}

	if( $html ) {
		$ret_html = '<div class="ecom_recent_row"> <h2> Recent Articles by <span class="author-name">'.get_the_author_meta( 'display_name', $post->post_author ).'</span></h2> <div>';
		$ret_html .= $html;
		$ret_html .= '</div><div class="clear"></div></div>';
	}

	return $ret_html;

}

function ecom_add_recent_articles_section( $content ) {

    if ( is_single() && 'post' == get_post_type() ) {
        $content .= ecom_get_recent_articles( );
    }

    return $content;
}
add_filter( 'the_content', 'ecom_add_recent_articles_section' );


// GET RID OF ?ver ON THE END OF CSS/JS FILES
add_filter( 'style_loader_src', 'remove_cssjs_ver' );
add_filter( 'script_loader_src', 'remove_cssjs_ver' );

function remove_cssjs_ver( $url )
{
    return remove_query_arg( 'ver', $url );
}

/**
 * Add some custom elements for each post in the RSS feed
 */
add_action('rss2_item', 'add_my_rss_node');
function add_my_rss_node() {
	global $post;

	// add the featured image thumbnails to the feed
	if(has_post_thumbnail()):
		$post_image_data = get_post_thumb($post->ID, 218, 150);
		$post_image_url = $post_image_data['src'];
		echo("<image>{$post_image_url}</image>");
	endif;

	// add an  excerpt node to the feed
	$excerpt = get_the_excerpt();
	echo("<excerpt>{$excerpt}</excerpt>");
}
