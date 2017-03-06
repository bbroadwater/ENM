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
		<h1 class="single-head"><?php echo the_title(); ?></h1>
		<div class="article-info">
			<div class="left">
				<?php if (get_field('author')): ?>
					By <?php echo get_field('author') ?>
				<?php endif ?>
			</div>

			<div class="right">
				<span class="dtreviewed">
					<a href="#">
						<i class="fa fa-clock-o"></i> <?php echo date('F j, Y');?>
					</a>
					<span class="value-title" title="<?php echo date('Y-M-d');?>"></span>
				</span>
			</div>
			<div class="clear-float"></div>
		</div>
	</div>
	<?php the_content();?>
</div>

<!-- BEGIN #sidebar -->
<aside id="sidebar" class="<?php OT_sidebarClass(OT_page_ID());?>" style="margin-bottom: 25px;">
	<div class="widget">
		<a class="plink" target="_blank" href="<?php if(get_field('side_ad_banner_url')) { the_field('side_ad_banner_url'); } else { echo "javascript:;"; } ?>" >
			<?php if(get_field('side_ad_banner')) { ?>
				<img src="<?php the_field('side_ad_banner'); ?>" alt=""  />
			<?php } ?> 
		</a>
	</div>

	<?php if ($recent_articles = recent_articles()): ?>
		<div class="widget">
			<div class="w-title">
				<h3>Related Articles</h3>
			</div>
			<ul id="widget-recent-posts">
				<?php foreach ($recent_articles as $_news): ?>
					<li>
						<a href="<?php echo $_news['url'] ?>"><img width="150" height="150" src="<?php echo $_news['image']['sizes']['thumbnail'] ?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" style="opacity: 1;"></a>
						<p><a href="<?php echo $_news['url'] ?>"><?php echo $_news['headline'] ?></a></p>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	<?php endif ?>
		<br><br>
	<?php if ($latest_news = latest_news()): ?>
		<div class="widget">
			<div class="w-title">
				<h3>Latest News</h3>
			</div>
			<ul id="widget-recent-posts">
				<?php foreach ($latest_news as $_news): ?>
					<li>
						<a href="<?php echo $_news['url'] ?>"><img width="150" height="150" src="<?php echo $_news['image']['sizes']['thumbnail'] ?>" class="attachment-thumbnail size-thumbnail wp-post-image" alt="" style="opacity: 1;"></a>
						<p><a href="<?php echo $_news['url'] ?>"><?php echo $_news['headline'] ?></a></p>
					</li>
				<?php endforeach ?>
			</ul>
		</div>
	<?php endif ?>

	<div class="widget">
		<a class="plink" target="_blank" href="<?php if(get_field('side_ad_banner_url_2')) { the_field('side_ad_banner_url_2'); } else { echo "javascript:;"; } ?>" >
			<?php if(get_field('side_ad_banner_2')) { ?>
				<img src="<?php the_field('side_ad_banner_2'); ?>" alt="" />
			<?php } ?> 
		</a>
	</div>
</aside>
<!-- END #sidebar -->

<?php get_template_part(THEME_SINGLE."page-footer"); ?>	

</div>

<?php get_footer('exclusives'); ?>
