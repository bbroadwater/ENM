<?php
	//post tags
	$posttags = get_the_tags();
	$tagCount = count($posttags);
?>
<?php if ($posttags) { ?>

	<div class="right">
		<span>
			<i class="fa fa-tags"></i> 
			<?php _e("Tags:", THEME_NAME);?>
		</span>
		<?php	
			$i=1;
			foreach($posttags as $tag) {
				echo '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name . '</a>'; 
				if($i!=$tagCount) echo ", ";
				$i++;
			}
		?>
	</div>
<?php } ?>