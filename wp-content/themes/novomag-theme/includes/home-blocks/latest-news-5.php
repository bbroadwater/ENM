<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $OT_builder = new OT_home_builder; 
    //get block data
    $data = $OT_builder->get_data(); 
    //set query
    $my_query = $data[0]; 
    //extract array data
    extract($data[1]); 
    //large sidebar
    $sidebar = get_post_meta ( OT_page_ID(), "_".THEME_NAME."_sidebar_select", true ); 
?>

    <!-- BEGIN .panel -->
    <div class="panel">
        <?php if($title) { ?>
            <div class="p-title">
                <h2 style="background-color: <?php echo esc_attr($pageColor);?>;"><?php echo esc_html($title);?></h2>
                <?php if($link) { ?>
                    <a href="<?php echo esc_url($link);?>" class="upper-title"><?php _e("Read More", THEME_NAME);?></a>
                <?php } ?>
            </div>
        <?php } ?>
        <!-- START .blog-lis-->
        <div class="blog-list style-<?php echo $blogStyle;?>">
            <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <?php 
                    $width = 677;
                    $height = 316;
                    $image = get_post_thumb($my_query->post->ID,$width,$height); 

                    if(get_option(THEME_NAME."_show_first_thumb") != "on" || $image['show']!=true) {
                        $class = " image-no";
                    } else {
                        $class = false;
                    }
                    
                    if(get_post_meta( $my_query->post->ID, "_".THEME_NAME."_post_style", true ) == "light") {
                        $class.= " light";
                    } else {
                        $class.= false;
                    }


                    $postDate = get_option(THEME_NAME."_post_date");
                    $postComments = get_option(THEME_NAME."_post_comment");
                    //categories
                    $categories = get_the_category($my_query->post->ID);
                    $catCount = count($categories);
                    //select a random category id
                    $catid = rand(0,$catCount-1);
                    $titleColor = ot_title_color($categories[$catid]->term_id, "category", false);
                ?>

                <div <?php post_class("item".$class); ?>>
                    <?php if($class!=" image-no") { ?>
                        <div class="item-header">
                            <?php
                                if(get_option(THEME_NAME."_show_first_thumb") == "on" && $image['show']==true) {
                            ?>
                                <a href="<?php the_permalink();?>" class="item-photo">
                                    <?php echo ot_image_html($my_query->post->ID,$width,$height); ?>
                                </a>
                            <?php } ?>
                            <?php if($blogStyle=="2") { ?>
                                <h3>
                                    <a href="<?php the_permalink();?>"><?php the_title();?></a>
                                </h3>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if($blogStyle=="2" && $class==" image-no") { ?>
                        <h3>
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                        </h3>
                    <?php } ?>
                    <div class="item-content">
                        <?php 
                            if($blogStyle=="1") {
                                $postCategories = wp_get_post_categories( $my_query->post->ID );
                                $catCount = count($postCategories);
                                $i=1;
                                foreach($postCategories as $c){
                                    $cat = get_category( $c );
                                    $link = get_category_link($cat->term_id);
                                ?>
                                    <a href="<?php echo $link;?>" class="category-link" style="color: <?php ot_title_color($cat->term_id, "category");?>">
                                        <strong><?php echo $cat->name;?></strong>
                                    </a>
                                <?php
                                    $i++;
                                }
                            }
                        ?>
                        <?php if($blogStyle=="1") { ?>
                        <h3>
                            <a href="<?php the_permalink();?>"><?php the_title();?></a>
                        </h3>
                        <?php } ?>
                        <?php 
                            if($blogStyle=="1") {
                                if($sidebar!="off") {
                                    add_filter('excerpt_length', 'new_excerpt_length_30');
                                } else {
                                    add_filter('excerpt_length', 'new_excerpt_length_80');  
                                }
                            } else {
                                if($sidebar!="off") {
                                    add_filter('excerpt_length', 'new_excerpt_length_20');
                                } else {
                                    add_filter('excerpt_length', 'new_excerpt_length_40');  
                                }
                            }
                            the_excerpt();
                        ?>
                    </div>
                    <div class="item-footer">
                        <span class="foot-categories">
                            <?php 
                                if($blogStyle=="2") {
                                    $postCategories = wp_get_post_categories( $my_query->post->ID );
                                    $catCount = count($postCategories);
                                    $i=1;
                                    foreach($postCategories as $c){
                                        $cat = get_category( $c );
                                        $link = get_category_link($cat->term_id);
                                    ?>
                                        <a href="<?php echo $link;?>" class="category-link" style="color: <?php ot_title_color($cat->term_id, "category");?>">
                                            <strong><?php echo $cat->name;?></strong>
                                        </a>
                                    <?php
                                        $i++;
                                    }
                                }
                            ?>
                        </span>
                        <span class="right">
                            <?php if($postDate=="on") { ?>
                                <a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>">
                                    <i class="fa fa-clock-o"></i><?php the_time(get_option('date_format'));?>
                                </a>
                            <?php } ?>
                            <?php if ( comments_open() && $postComments=="on") { ?>
                                <a href="<?php the_permalink();?>#comments">
                                    <i class="fa fa-comment"></i> <?php comments_number("0","1","%"); ?>
                                </a>
                            <?php } ?>
                        </span>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    <!-- END .panel -->
    </div>