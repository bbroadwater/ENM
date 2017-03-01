<?php
add_action('widgets_init', create_function('', 'return register_widget("OT_about");'));

class OT_about extends WP_Widget {
	function OT_about() {
		 parent::__construct(false, $name = THEME_FULL_NAME.' About',array( 'description' => __( "Widget With Image And Text", THEME_NAME )));	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'image' => '',
			'text' => '',
			'title' => '',


		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		$image = esc_attr($instance['image']);
		$text = esc_attr($instance['text']);
		$title = esc_attr($instance['title']);

        ?>
        	<p><label for="<?php echo $this->get_field_id('title'); ?>"><?php printf ( __( 'Title:' , THEME_NAME )); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
            <p>
            	<label for="<?php echo $this->get_field_id('image'); ?>" style="float:left; width:100%;"><?php printf ( __( 'Image:' , THEME_NAME )); ?> <input class="widefat ot-upload-field" id="<?php echo $this->get_field_id('image'); ?>" name="<?php echo $this->get_field_name('image'); ?>" type="text" value="<?php echo $image; ?>" /></label>
            	<span id="<?php echo $this->get_field_id('image'); ?>_button" class="action ot-upload ot-upload-button" style="position:relative; display:inline-block; margin: 3px 0 0 -28px;"><?php _e("Choose File", THEME_NAME);?></span>
            </p>
			<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php  printf ( __( 'Text:' , THEME_NAME )); ?> <textarea style="height:200px;" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea></label></p>

        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['image'] = strip_tags($new_instance['image']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
        $image = $instance['image'];
		$text = $instance['text'];
		$title = $instance['title'];

		
?>		
	<?php echo $before_widget; ?>
	<?php if($title) echo $before_title.$title.$after_title; ?>
		<div class="center">
			<?php 
				if($text) {
	            	echo wpautop(stripslashes($text));
	           	} 
       		?>
			<?php 
				if($image) {
			?>
	            <img src="<?php echo $image;?>" alt="<?php echo $title;?>"/>
	        <?php
	           	} 
           	?>		
		</div>
	<?php echo $after_widget; ?>
		
	
      <?php
	}
}
?>
