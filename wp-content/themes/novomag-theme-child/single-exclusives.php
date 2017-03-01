<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
//meta settings
	$postDate = get_option(THEME_NAME."_post_date_single");
	$postDateSingle = get_post_meta ( OT_page_id(), "_".THEME_NAME."_post_date", true );



?>
<?php

/*
Single Post Template: [single Exclusives Template]
Description: This part is optional, but helpful for describing the Post Template
*/
?>

<?php get_header('exclusives'); ?>
<?php get_template_part("exclusives-loop-start"); ?>
<div class="article-head">
<h1 class="fn entry-title"><?php echo the_title(); ?></h1>
<div class="article-info">
							<?php get_template_part(THEME_SINGLE."share"); ?>
								<div class="right">
										<span class="dtreviewed">
											<a href="#">
												<i class="fa fa-clock-o"></i> <?php the_time(get_option('date_format'));?>
											</a>
											<span class="value-title" title="<?php echo get_the_time('Y')."-".get_the_time('M')."-".get_the_time('d');?>"></span>
										</span>
									
								</div>
							<div class="clear-float"></div>
						</div>
                   </div>
	 <?php the_content();?></div>
                <!-- BEGIN #sidebar -->
	<aside id="sidebar" class="<?php OT_sidebarClass(OT_page_ID());?>" style="margin-bottom: 25px;">
		<div class="widget">
								<a class="plink" target="_blank" href="<?php if(get_field('side_ad_banner_url')) { the_field('side_ad_banner_url'); } else { echo "javascript:;"; } ?>" ><?php if(get_field('side_ad_banner')) { ?>
                    <img src="<?php the_field('side_ad_banner'); ?>" alt=""  />
                 <?php } ?> 
        </a>
        </div>
        <div class="widget">
        <a class="plink" target="_blank" href="<?php if(get_field('side_ad_banner_url_2')) { the_field('side_ad_banner_url_2'); } else { echo "javascript:;"; } ?>" ><?php if(get_field('side_ad_banner_2')) { ?>
                    <img src="<?php the_field('side_ad_banner_2'); ?>" alt="" />
                 <?php } ?> 
        </a>
      	</div>				
	<!-- END #sidebar -->
	</aside>
                
			<?php get_template_part(THEME_SINGLE."page-footer"); ?>	
			
			</div>

<?php get_footer(); ?>