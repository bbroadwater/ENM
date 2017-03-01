<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();


	//single page titile
	$titleShow = get_post_meta ( OT_page_id(), "_".THEME_NAME."_title_show", true ); 


	//meta settings
	$postDate = get_option(THEME_NAME."_post_date_single");
	$postDateSingle = get_post_meta ( OT_page_id(), "_".THEME_NAME."_post_date", true ); 

	$postAuthor = get_option(THEME_NAME."_post_author_single");
	$postAuthorSingle = get_post_meta ( OT_page_id(), "_".THEME_NAME."_post_author", true ); 

	$postCategory = get_option(THEME_NAME."_post_category_single");
	$postCategorySingle = get_post_meta ( OT_page_id(), "_".THEME_NAME."_post_category", true ); 



	//post custom tags
	$customTax = array('item-type','item-brand','item-retailer');
	$taxNames = array(__('Type:',THEME_NAME),__('Brand:',THEME_NAME),__('Retailer:',THEME_NAME));

	// release date
	$releaseDate = get_post_meta ( $post->ID, "_".THEME_NAME."_release_date", true ); 
	// pros/cons
	$pros = get_post_meta ( $post->ID, "_".THEME_NAME."_pros", true ); 
	$cons = get_post_meta ( $post->ID, "_".THEME_NAME."_cons", true ); 
	$conclusion = get_post_meta ( $post->ID, "_".THEME_NAME."_conclusion", true ); 
	//ratings
	$ratings = get_post_meta($post->ID,"_".THEME_NAME."_ratings",true); 
	$ratingsAverage = ot_avarage_rating( $post->ID); 

?>

	<?php get_template_part(THEME_LOOP."loop-start"); ?>
		<?php get_template_part(THEME_SINGLE."page-header"); ?>
			<?php get_template_part(THEME_SINGLE."post-header"); ?>
				<?php if (have_posts()) : ?>
					<div class="article-head">
						<?php if($titleShow!="no") { ?> 
							<h1 class="fn entry-title"><?php echo the_title(); ?></h1>
						<?php } ?>
						<?php 
							if(!$ratings && !$releaseDate && !$pros && !$cons && !$conclusion && count(wp_get_post_terms($post->ID,$customTax[0]))==0 && count(wp_get_post_terms($post->ID,$customTax[1]))==0 && count(wp_get_post_terms($post->ID,$customTax[2]))==0) { 
								get_template_part(THEME_SINGLE."image"); 
							}
						?>
	
						<div class="article-info">
							
							<?php if(ot_option_compare($postAuthor,$postAuthorSingle)==true || ot_option_compare($postDate,$postDateSingle)==true) { ?>
								<div style="float: left;">
									<?php if(ot_option_compare($postAuthor,$postAuthorSingle)==true) { ?>
										<span class="reviewer">
											<?php echo the_author_posts_link(); ?>
										</span> 
									<?php } ?>
									<?php if(ot_option_compare($postAuthor,$postAuthorSingle)==true && ot_option_compare($postDate,$postDateSingle)==true) { ?>,<?php } ?>
									<?php if(ot_option_compare($postDate,$postDateSingle)==true) { ?>
										<span class="dtreviewed">
											<a href="<?php echo get_month_link(get_the_time('Y'), get_the_time('m')); ?>">
												<i class="fa fa-clock-o"></i> <?php the_time(get_option('date_format'));?>
											</a>
											<span class="value-title" title="<?php echo get_the_time('Y')."-".get_the_time('M')."-".get_the_time('d');?>"></span>
										</span>
									<?php } ?>
								</div>
							<?php } ?>
							<div class="right">
							<?php get_template_part(THEME_SINGLE."share"); ?>
						    </div>
							<div class="clear-float"></div>
						</div>
					</div>
					<?php if($releaseDate || $pros || $cons || $conclusion || count(wp_get_post_terms($post->ID,$customTax[0]))!=0 || count(wp_get_post_terms($post->ID,$customTax[1]))!=0 || count(wp_get_post_terms($post->ID,$customTax[2]))!=0) { ?>
						<div class="paragraph-row">
							<div class="column6">
					<?php
						} else {
					?>
						<div class="orange-review-width">
					<?php
						}
					?>

							<?php if($ratings || $releaseDate || $pros || $cons || $conclusion || count(wp_get_post_terms($post->ID,$customTax[0]))!=0 || count(wp_get_post_terms($post->ID,$customTax[1]))!=0 || count(wp_get_post_terms($post->ID,$customTax[2]))!=0) { ?>
								<div class="review-photo">
								<?php 
									get_template_part(THEME_SINGLE."image"); 
								?>
								</div>
							<?php } ?>
							<?php if($ratings) { ?>	
								<div class="paragraph-row" itemscope itemtype="http://data-vocabulary.org/Review">
									<div class="column7">
										<h3 class="panel-title"><?php _e("Rating", THEME_NAME);?></h3>
										<div class="rating-table">
											<?php 
													$totalRate = array();
													$rating = explode(";", $ratings);
											?>
											<?php 
													foreach($rating as $rate) { 
														$ratingValues = explode(":", $rate);
														if(isset($ratingValues[1])) {
															$ratingPrecentage = (str_replace(",",".",$ratingValues[1]))*20;
															$totalRate[] = $ratingPrecentage;
														}
														
														if($ratingValues[0]) {

											?>
												<div class="rate-item">
													<div class="right ot-star-rating">
														<span style="width:<?php echo $ratingPrecentage;?>%">
															<strong><?php echo floor(($ratingPrecentage/5) * 2) / 2;?></strong> <?php _e("out of 5", THEME_NAME);?>
														</span>
													</div>
													<strong><?php echo $ratingValues[0];?></strong>
												</div>
											<?php 
														} 
													}
										 	?>
										</div>
									</div>
									<div class="column5">
										<h3 class="panel-title"><?php _e("Total", THEME_NAME);?></h3>
										<div class="rating-total"><div class="master-rate rating"><?php echo $ratingsAverage[1];?></div>
											<div class="ot-star-rating">
												<span style="width:<?php echo $ratingsAverage[0];?>%">
													<strong itemprop="rating"><?php echo $ratingsAverage[1];?></strong> 
													<?php _e("out of 5", THEME_NAME);?>
												</span>
								                <meta itemprop="itemreviewed" content="<?php the_title(); ?>"/>
								                <meta itemprop="reviewer" content="<?php the_author();?>"/>
								                <meta itemprop="dtreviewed" content="<?php echo the_time("F d, Y"); ?>"/>
											</div>
										</div>
									</div>
									<div class="spacer-1"></div>
								</div>
							<?php } ?>

					<?php if($releaseDate || $pros || $cons || $conclusion || count(wp_get_post_terms($post->ID,$customTax[0]))!=0 || count(wp_get_post_terms($post->ID,$customTax[1]))!=0 || count(wp_get_post_terms($post->ID,$customTax[2]))!=0) { ?>
						</div>
						<div class="column6">
					<?php } ?>
						
							<?php if($releaseDate || $pros || $cons || $conclusion || count(wp_get_post_terms($post->ID,$customTax[0]))!=0 || count(wp_get_post_terms($post->ID,$customTax[1]))!=0 || count(wp_get_post_terms($post->ID,$customTax[2]))!=0) { ?>
								<!-- BEGIN .panel -->
								<div class="panel">
									<div class="p-title">
										<h2><?php _e("Overview", THEME_NAME);?></h2>
									</div>
									<ul>
										<?php 
											foreach($customTax as $key =>$tax) {
												$itemType = wp_get_post_terms($post->ID,$tax);
												$termCount = count($itemType);
												if($termCount!=0) { 
											?>
												<li>
													<strong><?php  echo $taxNames[$key];?></strong> 
													<?php 
														$i=1;
														foreach ($itemType as $type) {
													?>
														<a href="<?php echo get_term_link((int)$type->term_id, $tax );?>"><?php echo $type->name;?></a><?php if($termCount!=$i) { echo ", "; } ?>
													<?php $i++; ?>
													<?php } ?>
												</li>
										<?php 	} 
											} 
										?>
										<?php if($releaseDate) { ?>
											<li>
												<strong><?php _e("Release Date:", THEME_NAME);?></strong> <?php echo date("F d, Y", strtotime($releaseDate));?>
											</li>
										<?php } ?>
										<?php if($pros) { ?>
											<li class="graytext">
												<strong><?php _e("Pros:", THEME_NAME);?></strong>
												<?php echo wpautop(stripslashes($pros)) ;?>
											</li>
										<?php } ?>
										<?php if($cons) { ?>
											<li class="graytext">
												<strong><?php _e("Cons:", THEME_NAME);?></strong>
												<?php echo wpautop(stripslashes($cons)) ;?>
											</li>
										<?php } ?>
										<?php if($conclusion) { ?>
											<li class="graytext">
												<strong><?php _e("Conclusion:", THEME_NAME);?></strong>
												<p class="summary"><?php echo nl2br(stripslashes($conclusion)) ;?></p>
											</li>
										<?php } ?>
									</ul>
								<!-- END .panel -->
								</div>
							<?php } ?>
						<?php if($releaseDate || $pros || $cons || $conclusion || count(wp_get_post_terms($post->ID,$customTax[0]))!=0 || count(wp_get_post_terms($post->ID,$customTax[1]))!=0 || count(wp_get_post_terms($post->ID,$customTax[2]))!=0) { ?>
								</div>
							</div>
						<?php
							} else {
						?>
							</div>
						<?php
							}
						?>





					<?php the_content();?>	
<!--<div class="final_block" style="margin:auto;">

<h1 style="text-align:center;">Did You Like This Article?</h1>

<div id="welcomeDiv"  style="display:none;" class="answer_list" >

<?php //echo do_shortcode("[dynamic-sidebar id='Yes-No']"); ?>


</div>
<div style="margin:auto;width:350px;"><input class="yesno" type="button" id="butt" name="answer" value="YES" onclick="showDiv()" /><input class="yesno" type="button" id="butt1" name="answer" value="NO" onclick="showDiv1()" /></div>
</div>-->
<?php get_template_part(THEME_SINGLE."post-related"); ?>					
<?php 
						$args = array(
							'before'           => '<div class="post-pages"><p>' . __('Pages:', THEME_NAME),
							'after'            => '</p></div>',
							'link_before'      => '',
							'link_after'       => '',
							'next_or_number'   => 'number',
							'nextpagelink'     => __('Next page', THEME_NAME),
							'previouspagelink' => __('Previous page', THEME_NAME),
							'pagelink'         => '%',
							'echo'             => 1
						);

						wp_link_pages($args); 
					?>	
				<?php else: ?>
					<p><?php  _e('Sorry, no posts matched your criteria.' , THEME_NAME ); ?></p>
				<?php endif; ?>
				<div class="article-foot">
					<?php if(ot_option_compare($postCategory,$postCategorySingle)==true) { ?>
					<div class="left">
						<span>
							<i class="fa fa-folder-open"></i> 
							<?php _e("Categories:", THEME_NAME);?>
						</span>
						<?php the_category(", ");?>
					</div>
					<?php } ?>
					<?php get_template_part(THEME_SINGLE."post-tags"); ?>
					<div class="clear-float"></div>
				</div>
				
			<?php get_template_part(THEME_SINGLE."post-footer"); ?>
		<?php get_template_part(THEME_SINGLE."page-footer"); ?>
		<?php get_template_part(THEME_SINGLE."about-author"); ?>
		<?php get_template_part(THEME_SINGLE."post-related"); ?>
		<?php wp_reset_query(); ?>
		<?php if ( comments_open() ) : ?>
                   <a name="comments_tag"></a>
			<?php comments_template(); // Get comments.php template ?>
		<?php endif; ?>
	<?php get_template_part(THEME_LOOP."loop-end"); ?>