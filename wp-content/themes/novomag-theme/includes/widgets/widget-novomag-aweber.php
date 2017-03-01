<?php
add_action('widgets_init', create_function('', 'return register_widget("OT_aweber");'));

class OT_aweber extends WP_Widget {
	function OT_aweber() {
		 parent::__construct(false, $name = THEME_FULL_NAME.' AWeber');	
	}

	function form($instance) {
		/* Set up some default widget settings. */
		$defaults = array(
			'title' => '',
			'text' => '',
			'code' => '',
			'list' => '',
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		if(get_option(THEME_NAME."_footer_subscribe_code")) {
			/* Set up some default widget settings. */
			$defaults = array(
				'code' => get_option(THEME_NAME."_footer_subscribe_code")
			);
		}
		
		$instance = wp_parse_args( (array) $instance, $defaults );
	
		$title = esc_attr($instance['title']);
		$text = esc_attr($instance['text']);
		if(get_option(THEME_NAME."_footer_subscribe_code")) {
			$code = get_option(THEME_NAME."_footer_subscribe_code");
		} else {
			$code = esc_attr($instance['code']);
		}
		
		$list = esc_attr($instance['list']);
		$keys = get_option(THEME_NAME."_aweber_keys");
		
		
        if ($keys['access_key']) {
            extract($keys);
            $error_ = null;
            try {
                $aweber = new AWeberAPI($consumer_key, $consumer_secret);
                $account = $aweber->getAccount($access_key, $access_secret);
            } catch (AWeberException $e) {
                $error_ = get_class($e);
                $account = null;
            }
            if (!$account) {
                if($error_ != 'AWeberOAuthException' && $error_ != 'AWeberOAuthDataMissing') {
                echo "Unable to connect to AWeber's API.  Please refresh the page, or attempt to reauthorize.";
                $temp_error = True;
				} else {
					$this->deauthorize();
					 echo "AWeber Web Form authentication failed";
				}
			} else {
				$authorize_success = True;
				$button_value = 'Remove Connection';
			}
		}
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php printf ( __( 'Title:' , THEME_NAME )); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
          

			<p><label for="<?php echo $this->get_field_id('text'); ?>"><?php  printf ( __( 'Text:' , THEME_NAME )); ?> <textarea style="height:200px;" class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea></label></p>

			<p><strong>Step 1:</strong>	<a href="https://auth.aweber.com/1.0/oauth/authorize_app/0046e0e1" target="_blank"><?php printf ( __( 'Click here to get your authorization code.' , THEME_NAME )); ?></a></p>
            <p><label for="<?php echo $this->get_field_id('code'); ?>"><?php printf ( __( '<strong>Step 2:</strong>	Paste in your authorization code:' , THEME_NAME )); ?> <input class="widefat" id="<?php echo $this->get_field_id('code'); ?>" name="<?php echo $this->get_field_name('code'); ?>" type="text" value="<?php echo $code; ?>" /></label></p>
		<?php
		  	if(isset($account)) {
            	$lists = $account->lists;
        	}
            if (!empty($lists)) {
 
		?>
		    <p><label for="<?php echo $this->get_field_id('list'); ?>"><?php printf ( __( 'Select the list you\'d like people to subscribe to:' , THEME_NAME )); ?></label>
                <select class="widefat " name="<?php echo $this->get_field_name('list'); ?>" id="<?php echo $this->get_field_id('list'); ?>">
					<option value="FALSE"><?php printf ( __( 'Select A List' , THEME_NAME )); ?></option>
					<?php foreach ($lists as $this_list): ?>
						<option value="<?php echo $this_list->id; ?>"<?php echo ($this_list->id == $list) ? ' selected="selected"' : ""; ?>><?php echo $this_list->name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
            <?php } else { ?>
				<?php printf ( __( 'This AWeber account does not currently have any lists or your authorization code is incorrect!' , THEME_NAME )); ?>
            <?php } ?>
        <?php 
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['text'] = strip_tags($new_instance['text']);
		$instance['list'] = strip_tags($new_instance['list']);
		$instance['color'] = strip_tags($new_instance['color']);
		
		if($instance['code']!=$new_instance['code'] && $new_instance['code']!=get_option(THEME_NAME."_footer_subscribe_code")) {
			$instance['code'] = strip_tags($new_instance['code']);
			update_option(THEME_NAME."_footer_subscribe_code", $instance['code']);
		
			$oauth_id = $new_instance['code'];
			
			if($oauth_id) {
				try {
					list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = AWeberAPI::getDataFromAweberID($oauth_id);
				} catch (AWeberAPIException $exc) {
					list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = null;
					# make error messages customer friendly.
					$descr = $exc->description;
					$descr = preg_replace('/http.*$/i', '', $descr);     # strip labs.aweber.com documentation url from error message
					$descr = preg_replace('/[\.\!:]+.*$/i', '', $descr); # strip anything following a . : or ! character
					$error_code = " ($descr)";
				} catch (AWeberOAuthDataMissing $exc) {
					list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = null;
				} catch (AWeberException $exc) {
					list($consumerKey, $consumerSecret, $accessKey, $accessSecret) = null;
				}
			}
			
			$keys = array(
				'consumer_key' => $consumerKey,
				'consumer_secret' => $consumerSecret,
				'access_key' => $accessKey,
				'access_secret' => $accessSecret,
			);
			
			update_option(THEME_NAME."_aweber_keys", $keys);
		}
		return $instance;
	}

	function widget($args, $instance) {
		extract( $args );
		$title = $instance['title'];
		$text = $instance['text'];
		$list = $instance['list'];

?>
		
	<?php echo $before_widget; ?>
		<?php if($title) echo $before_title.$title.$after_title; ?>
			<div>
				<div class="subscribe-feed">
					<div class="coloralert aweber-success" style="background: #83b827; display:none;">
					   <p><?php _e("Success! Everything went well, You are now subscribed !", THEME_NAME);?></p>
					   <a href="#close-alert"><i class="fa fa-plus"></i></a>
					</div>
					<div class="coloralert aweber-fail" style="background:#a12717; display:none;">
					   <p><?php _e("Error Occurred!", THEME_NAME);?></p>
					   <a href="#close-alert"><i class="fa fa-plus"></i></a>
					</div>

					<div class="coloralert aweber-loading" style="display:none; background: #AFA57E;">
					   <p><?php _e("Loading.. <br/>This may take a few seconds !", THEME_NAME);?></p>
					   <a href="#close-alert"><i class="fa fa-plus"></i></a>
					</div>

					<?php if($list && $list!="FALSE") { ?>

						<form id="" name="aweber-form" action="" class="subscribe-form aweber-form">
							<input type="hidden" name="listID" value="<?php echo $list;?>" />
							<p class="sub-nickname">
								<input type="text" value="" placeholder="<?php _e("Name",THEME_NAME);?>" name="u_name" class="u_name" />
							</p>
							<p class="sub-nickname">
								<input type="text" value="" placeholder="<?php _e("E-mail address",THEME_NAME);?>" name="email" class="email" />
							</p>
							<p class="sub-submit">
								<input type="submit" value="<?php _e("Subscribe",THEME_NAME);?>" id="" class="button aweber-submit" />
							</p>
						</form>
					<?php 
						} else { 
					?>
						<center><strong><?php _e("There is no list selected.",THEME_NAME); ?> </strong></center>
					<?php	} ?>
				</div>
				<?php if($text) { ?>
					<p><?php echo $text;?></p>
				<?php } ?>
			</div>



	<?php echo $after_widget; ?>
        <?php
	}
}
?>