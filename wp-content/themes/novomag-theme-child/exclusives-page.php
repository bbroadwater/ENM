<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
Template Name: Exclusives Page
*/	
?>
<?php get_header('exclusives'); ?>
<?php get_template_part("exclusives-loop-start"); ?>
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