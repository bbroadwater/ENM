<?php 
    if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    $OT_builder = new OT_home_builder; 
    //get block data
    $data = $OT_builder->get_data(); 
    //set query
    $my_query = $data[0]; 
    //extract array data
    extract($data[1]); 

    $postDate = get_option(THEME_NAME."_post_date");
    $postComments = get_option(THEME_NAME."_post_comment");
    $postAuthor = get_option(THEME_NAME."_post_author");
?>
    <!-- BEGIN .panel-split -->
    <div class="panel-split">
    <?php
       for($i=0; $i<=1; $i++) {
    ?>
        <?php if($i==0) { ?>
        <div class="left-side">
        <?php } else { ?>
        <div class="right-side">
        <?php } ?>
            <!-- BEGIN .panel -->
            <div class="panel">
                <?php if($title[$i]) { ?>
                <div class="p-title">
                    <h2 style="background-color: <?php echo $pageColor[$i];?>;"><?php echo $title[$i];?></h2>
                </div>

                <?php } ?>
                <div class="article-list">
                    <?php if ($my_query[$i]->have_posts()) : $my_query[$i]->the_post(); ?>
                    <?php  
    
                        if(get_post_meta( $my_query[$i]->post->ID, "_".THEME_NAME."_post_style", true ) == "light") {
                            $class= " light";
                        } else {
                            $class= false;
                        }
                    ?>
                    <div class="item main-artice<?php echo $class;?>">
                        <div class="item-header">
                            <a href="<?php the_permalink();?>">
                                <?php echo ot_image_html($my_query[$i]->post->ID,541,311,"item-photo"); ?>
                            </a>
                            <div class="article-slide">
                                <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                <a href="<?php the_permalink();?>" class="info-line">
                                    <?php if($postDate=="on") { ?>
                                        <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php the_time(get_option('date_format'));?></span>
                                    <?php } ?>
                                    <?php if($postAuthor=="on") { ?>
                                        <span><i class="fa fa-user"></i>&nbsp;&nbsp;<?php _e("by", THEME_NAME); echo " ".get_the_author();?></span>
                                    <?php } ?>
                                    <?php if ( comments_open() && $postComments=="on") { ?>
                                        <span><i class="fa fa-comment-o"></i>&nbsp;&nbsp;<?php comments_number(__("0 Comments", THEME_NAME),__("1 Comment", THEME_NAME),__("% Comments", THEME_NAME)); ?></span>
                                    <?php } ?>
                                </a>
                            </div>
                        </div>
                        <div class="item-content">
                            <?php 
                                add_filter('excerpt_length', 'new_excerpt_length_20');
                                the_excerpt();
                                remove_filter('excerpt_length', 'new_excerpt_length_20');
                            ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if ($my_query[$i]->have_posts()) : while ($my_query[$i]->have_posts()) : $my_query[$i]->the_post(); ?>
                    <?php $image = get_post_thumb($my_query[$i]->post->ID,0,0); ?>
                    <div class="item<?php if($image["show"]==false) { ?> no-image<?php } ?>">
                        <?php if($image["show"]!=false) { ?>
                            <a href="<?php the_permalink();?>">
                                 <?php echo ot_image_html($my_query[$i]->post->ID,60,60,"item-photo"); ?>
                            </a>
                        <?php } ?>
                        <div class="item-content">
                            <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                            <?php if($postDate=="on") { ?>
                                <span><i class="fa fa-clock-o"></i>&nbsp;&nbsp;<?php the_time(get_option('date_format'));?></span>
                            <?php } ?>
                            <?php if ( comments_open() && $postComments=="on") { ?>
                                <a href="<?php the_permalink();?>#comments"><span><i class="fa fa-comment-o"></i>&nbsp;&nbsp;<?php comments_number(__("0 Comments", THEME_NAME),__("1 Comment", THEME_NAME),__("% Comments", THEME_NAME)); ?></span></a>
                            <?php } ?>
                            
                        </div>
                    </div>

                    <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            <!-- END .panel -->
            </div>

        </div>


    <?php } ?>
</div>