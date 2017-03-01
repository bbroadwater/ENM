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

   
?>
    <!-- BEGIN .panel -->
    <div class="panel">
        <?php if($title) { ?>
            <div class="p-title">
                <h2 style="background: <?php echo $pageColor;?>;"><?php echo $title;?></h2>
            </div>
        <?php } ?>
        <div class="review-block">
            <?php if ($my_query->have_posts()) : while ($my_query->have_posts()) : $my_query->the_post(); ?>
                <?php 
                    $ratings = get_post_meta( $post->ID, "_".THEME_NAME."_ratings", true );
                    $categories = get_the_category($post->ID); 
                    $count = count($categories);
                    $randID = rand(0,$count-1);
                ?>
                    <div class="item">
                        <a href="<?php the_permalink();?>">
                            <?php echo ot_image_html($my_query->post->ID,345,230,"item-photo"); ?>
                        </a>
                        <h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                        <div class="rating-table">
                            <?php 
                                $average =  ot_avarage_rating($my_query->post->ID);
                                if($ratings) {
                                    $totalRate = array();
                                    $rating = explode(";", $ratings);
                                    foreach($rating as $rate) { 
                                        $ratingValues = explode(":", $rate);
                                        if(isset($ratingValues[1])) {
                                            $ratingPrecentage = (str_replace(",",".",$ratingValues[1]))*20;
                                        }
                                        $totalRate[] = $ratingPrecentage;
                                        if($ratingValues[0]) {

                            ?>

                                <div class="rate-item">
                                    <div class="right ot-star-rating"><span style="width:<?php echo $ratingPrecentage;?>%"><strong class="rating"><?php echo floor(($ratingPrecentage/5) * 2) / 2;?></strong> <?php _e("out of 5", THEME_NAME);?></span></div>
                                    <strong><?php echo $ratingValues[0];?></strong>
                                </div>
                            <?php 
                                        } 
                                    }
                                }
                            ?>

                        </div>
                        <p><?php echo get_post_meta ( $post->ID, "_".THEME_NAME."_conclusion", true );?>
                            <a href="<?php the_permalink();?>"><?php _e("Read More ...", THEME_NAME);?></a>
                        </p>
                    </div>
            <?php endwhile; ?>
            <?php endif; ?>
        </div>
    <!-- END .panel -->
    </div>