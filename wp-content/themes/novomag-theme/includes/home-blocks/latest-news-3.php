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

    <!-- BEGIN .panel -->
    <div class="panel">
        <?php if($title) { ?>
            <div class="p-title">
                <h2 style="background-color: <?php echo $pageColor;?>;"><?php echo $title;?></h2>
            </div>
        <?php } ?>
        <div class="video-carousel">
            <a href="#" class="carousel-left"><i class="fa fa-chevron-left"></i></a>
            <a href="#" class="carousel-right"><i class="fa fa-chevron-right"></i></a>
            <!-- BEGIN .inner-carousel -->
            <div class="inner-carousel">
                <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                    <div class="item">
                        <a href="<?php the_permalink();?>">
                            <?php echo ot_image_html($my_query->post->ID,357,237,"item-photo"); ?>
                        </a>
                        <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                    </div>
                <?php endwhile; ?>
                <?php endif; ?>
            <!-- END .inner-carousel -->
            </div>
        </div>
    <!-- END .panel -->
    </div>

