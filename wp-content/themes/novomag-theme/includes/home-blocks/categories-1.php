<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $OT_builder = new OT_home_builder; 
    //get block data
    $data = $OT_builder->get_data(); 
    //extract array data
    extract($data[0]); 

    $postDate = get_option(THEME_NAME."_post_date");

   
?>
        <!-- BEGIN .panel-three-split -->
        <div class="panel-three-split panel">

        <?php 
            if(!empty($cat)) {
                foreach($cat as $category) { 
        ?>
            <?php 
                //set wp query
                $args = array(
                    'post_type' => "post",
                    'cat' => $category,
                    'showposts' => $count,
                    'ignore_sticky_posts' => "1"
                );
                $my_query = new WP_Query($args);
                $titleColor = ot_title_color($category, "category", false);
            ?>
                <!-- BEGIN .panel -->
                <div class="panel">
                    <div class="p-title">
                        <h2 style="background-color: <?php echo esc_attr($titleColor);?>;"><?php echo esc_html(get_cat_name($category));?></h2>
                    </div>
                    <div class="article-cat-list">
                        <?php if ($my_query->have_posts()) : $my_query->the_post(); ?>
                        <?php 
                            $image = get_post_thumb($my_query->post->ID,0,0);

                        ?>
                            <div class="item">
                                <div class="item-header">
                                    <?php if($postDate=="on") { ?>
                                        <span class="itemdate left"><?php the_time(get_option('date_format'));?></span>
                                    <?php } ?>
                                    <h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
                                    <?php if($image["show"]!=false) { ?>                            
                                        <a href="<?php the_permalink();?>" class="overset-image load-effect">
                                            <?php echo ot_image_html($my_query->post->ID,248,165,"item-photo"); ?>
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="item-content">
                                    <a href="<?php the_permalink();?>" class="novo-read-more"><?php _e("Read More", THEME_NAME);?><i class="fa fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                            <div class="item">
                                <div class="item-header">
                                    <?php if($postDate=="on") { ?>
                                        <span class="itemdate left"><?php the_time(get_option('date_format'));?></span>
                                    <?php } ?>
                                    <h6><a href="<?php the_permalink();?>"><?php the_title();?></a></h6>
                                </div>
                            </div>
                        <?php endwhile; ?>
                        <?php endif; ?>
                        <?php if(get_category_link( $category )){ ?>
                            <div class="item">
                                <div class="item-content">
                                    <a href="<?php echo esc_url(get_category_link( $category ));?>" class="button" style="background-color: <?php echo esc_attr($titleColor);?>;">
                                        <?php _e("More Articles", THEME_NAME);?>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                <!-- END .panel -->
                </div>
            <?php } ?>
        <?php } ?>
        </div>
