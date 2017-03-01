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

    // author id
    $user_ID = get_the_author_meta('ID');

    if($cat) {
        //get subcategories
        $subCategories = get_categories(array('child_of'=>$cat));
    } else {
        $subCategories = null;
    }
?>
                        <!-- BEGIN .panel -->
                        <div class="panel<?php if(!empty($subCategories)) { ?> tabbed-panel<?php } ?>">
                             <?php if($title) { ?>
                                <div class="p-title">
                                    <h2 style="background-color: <?php echo $pageColor;?>;"><?php echo $title;?></h2>
                                </div>
                            <?php } ?>
                            <?php
                                if(!empty($subCategories)) {
                            ?>
                            <div class="upper-title tabs">
                                <a href="#" class="active"><?php _e("All", THEME_NAME);?></a>
                                <?php foreach($subCategories as $key => $subCategory) { ?>
                                    <a href="#"><?php echo $subCategory->name;?></a>
                                <?php } ?>
                            </div>
                            <?php } elseif($link) { ?>
                                <a href="<?php echo $link;?>" class="upper-title"><?php _e("Read More", THEME_NAME);?><i class="fa fa-caret-right"></i></a>
                            <?php } ?>
                            <div<?php if(!empty($subCategories)) { ?> class="tab-content"<?php } ?>>
                                <div class="panel-split">
                                    <div class="left-side">
                                        <div class="article-list">
                                            <?php if ($my_query->have_posts()) : $my_query->the_post(); ?>
                                            <?php  
                            
                                                if(get_post_meta( $my_query->post->ID, "_".THEME_NAME."_post_style", true ) == "light") {
                                                    $class= " light";
                                                } else {
                                                    $class= false;
                                                }
                                            ?>
                                            <div class="item main-artice<?php echo $class;?>">
                                                <div class="item-header">
                                                    <a href="<?php the_permalink();?>">
                                                        <?php echo ot_image_html($my_query->post->ID,541,311,"item-photo"); ?>
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
                                        </div>
                                    </div>
                                    <div class="right-side">
                                        <div class="article-list">
                                            <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                                 <?php $image = get_post_thumb($my_query->post->ID,0,0); ?>
                                                <div class="item">
                                                    <?php if($image["show"]!=false) { ?>
                                                        <a href="<?php the_permalink();?>">
                                                             <?php echo ot_image_html($my_query->post->ID,60,60,"item-photo"); ?>
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
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($subCategories)) { ?>
                                <?php foreach ($subCategories as $subCategorie) { ?>
                                    <?php
                                        $subCategorieID = $subCategorie->term_id;
                                        //set wp query
                                        $args = array(
                                            'post_type' => "post",
                                            'cat' => $subCategorieID,
                                            'offset' =>$offset,
                                            'showposts' => $count,
                                            'ignore_sticky_posts' => "1"
                                        );
                                        $my_query = new WP_Query($args);
                                    ?>
                                    <div class="tab-content">
                                        <div class="panel-split">
                                            <div class="left-side">
                                                <div class="article-list">
                                                    <?php if ($my_query->have_posts()) : $my_query->the_post(); ?>
                                                    <?php  
                                    
                                                        if(get_post_meta( $my_query->post->ID, "_".THEME_NAME."_post_style", true ) == "light") {
                                                            $class= " light";
                                                        } else {
                                                            $class= false;
                                                        }
                                                    ?>
                                                    <div class="item main-artice<?php echo $class;?>">
                                                        <div class="item-header">
                                                            <a href="<?php the_permalink();?>">
                                                                <?php echo ot_image_html($my_query->post->ID,541,311,"item-photo"); ?>
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
                                                </div>
                                            </div>
                                            <div class="right-side">
                                                <div class="article-list">
                                                    <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                                                         <?php $image = get_post_thumb($my_query->post->ID,0,0); ?>
                                                        <div class="item">
                                                            <?php if($image["show"]!=false) { ?>
                                                                <a href="<?php the_permalink();?>">
                                                                     <?php echo ot_image_html($my_query->post->ID,60,60,"item-photo"); ?>
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
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                        <!-- END .panel -->
                        </div>
