<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $OT_builder = new OT_home_builder; 
    //get block data
    $data = $OT_builder->get_data(); 
    //set query
    $my_query = $data[0]; 
    //extract array data
    extract($data[1]); 

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
        <div class="article-grid-list">
            <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <?php 
                    $image = get_post_thumb($my_query->post->ID,0,0); 
                    //categories
                    $categories = get_the_category($my_query->post->ID);
                    $catCount = count($categories);
                    //select a random category id
                    $catid = rand(0,$catCount-1);
                    $titleColor = ot_title_color($categories[$catid]->term_id, "category", false);
                ?>

                <div class="item">
                    <?php if($image["show"]!=false) { ?>                            
                        <div class="item-header">
                            <a href="<?php the_permalink();?>" class="overset-image load-effect">
                                <?php echo ot_image_html($my_query->post->ID,248,165,"item-photo"); ?>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="item-content">
                        <?php if($categories[$catid]->term_id) { ?>
                            <div class="post-category" style="color: <?php echo $titleColor;?>;">
                                <a href="<?php get_category_link( $categories[$catid]->term_id ); ?>"><?php echo get_cat_name($categories[$catid]->term_id);?></a>
                            </div>
                        <?php } ?>
                        <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                            <?php 
                                $average =  ot_avarage_rating($my_query->post->ID);
                                if($average) {
                            ?>
                                <div class="ot-star-rating">
                                    <span style="width:<?php echo $average[0];?>%">
                                        <strong class="rating"><?php echo $average[1];?></strong> 
                                        <?php _e("out of 5" , THEME_NAME);?>
                                    </span>
                                </div>
                            <?php 

                                }
                            ?>
                        <?php 
                            add_filter('excerpt_length', 'new_excerpt_length_20');
                            the_excerpt();
                            remove_filter('excerpt_length', 'new_excerpt_length_20');
                        ?>
                        <a href="<?php the_permalink();?>" class="novo-read-more"><?php _e("Read More", THEME_NAME);?><i class="fa fa-angle-double-right"></i></a>
                    </div>
                </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    <!-- END .panel -->
    </div>