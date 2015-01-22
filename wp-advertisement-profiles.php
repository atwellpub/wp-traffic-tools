<?php

define('ADVERTISEMENTS_URLPATH', WP_PLUGIN_URL.'/'.plugin_basename( dirname(__FILE__) ).'/' );
add_action( 'widgets_init', 'wptt_advertisements_load_widgets' );

function wptt_advertisements_load_widgets() {

	register_widget( 'wpt_widgets_advertisments_1' );
	register_widget( 'wpt_widgets_advertisments_2' );
	register_widget( 'wpt_widgets_advertisments_3' );
	register_widget( 'wpt_widgets_advertisments_4' );
	register_widget( 'wpt_widgets_advertisments_5' );
	register_widget( 'wpt_widgets_advertisments_6' );

}
	
	
	
	class wpt_widgets_advertisments_1 extends WP_Widget 
	{
		
		/**
		 * Widget setup.
		 */
		function wpt_widgets_advertisments_1() {
			
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'class_wpt_advertisments_widget_1', 'description' => __('Widget #1 : Add this widget to sidebar to intercept and display dynamic advertisments. If no advertisment is detected then widget will not be displayed.', 'wpt_widget') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_wpt_widgets_advertisments_1' );

			/* Create the widget. */
			$this->WP_Widget( 'id_wpt_widgets_advertisments_1', __('WPTT: Advertisment Widget #1', 'wptt_widget_1'), $widget_ops, $control_ops );
		}
		
		/**
		 * How to display the widget on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			//echo 2;exit;	
			
			if ($_SESSION['wpt_ad_content_1'])
			{
			
				/* Our variables from the widget settings. */
				$title = apply_filters('widget_title', $instance['title'] );

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title && $_SESSION['wpt_ad_content_1'])
				
					echo $before_title . $title . $after_title;

				$content =  str_replace("_nl_","\n",$_SESSION['wpt_ad_content_1']);
				$content = do_shortcode($content);
				echo $content;
				/* After widget (defined by themes). */
				echo $after_widget;
			}
			else
			{
				$title = apply_filters('widget_title', $instance['title'] );
				
				if ( $title && $_SESSION['wpt_ad_content_1'] )
				
					echo $before_title . $title . $after_title;
					
				echo "<div id='id_wpt_adblock_1'></div>";
			}
		}

		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => __('Example', 'example'));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

		<?php
		}
	}
	
	
	class wpt_widgets_advertisments_2 extends WP_Widget 
	{
		/**
		 * Widget setup.
		 */
		function wpt_widgets_advertisments_2() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'class_wpt_advertisments_widget_2', 'description' => __('Widget #2 : Add this widget to sidebar to intercept and display dynamic advertisments. If no advertisment is detected then widget will not be displayed.', 'wpt_widget') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_wpt_widgets_advertisments_2' );

			/* Create the widget. */
			$this->WP_Widget( 'id_wpt_widgets_advertisments_2', __('WPTT: Advertisment Widget #2', 'wptt_widget_2'), $widget_ops, $control_ops );
		}
		
		/**
		 * How to display the widget on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			
			//echo $_SESSION['wpt_ad_content_2'];
			if ($_SESSION['wpt_ad_content_2'])
			{
				/* Our variables from the widget settings. */
				$title = apply_filters('widget_title', $instance['title'] );

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title && $_SESSION['wpt_ad_content_2'])
				
					echo $before_title . $title . $after_title;

				$content =  str_replace("_nl_","\n",$_SESSION['wpt_ad_content_2']);
				$content = do_shortcode($content);
				echo $content;
				
				/* After widget (defined by themes). */
				echo $after_widget;
			}
			else
			{
				$title = apply_filters('widget_title', $instance['title'] );
				
				if ( $title && $_SESSION['wpt_ad_content_2'] )
				
					echo $before_title . $title . $after_title;
					
				echo "<div id='id_wpt_adblock_2'></div>";
			}
		}

		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => __('Example', 'example'));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

		<?php
		}
	}
	
	class wpt_widgets_advertisments_3 extends WP_Widget 
	{
		/**
		 * Widget setup.
		 */
		function wpt_widgets_advertisments_3() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'class_wpt_advertisments_widget_3', 'description' => __('Widget #3 : Add this widget to sidebar to intercept and display dynamic advertisments. If no advertisment is detected then widget will not be displayed.', 'wpt_widget') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_wpt_widgets_advertisments_3' );

			/* Create the widget. */
			$this->WP_Widget( 'id_wpt_widgets_advertisments_3', __('WPTT: Advertisment Widget #3', 'wptt_widget_3'), $widget_ops, $control_ops );
		}
		
		/**
		 * How to display the widget on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			
			if ($_SESSION['wpt_ad_content_3'])
			{
				/* Our variables from the widget settings. */
				$title = apply_filters('widget_title', $instance['title'] );

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title && $_SESSION['wpt_ad_content_3'])
				
					echo $before_title . $title . $after_title;

				$content =  str_replace("_nl_","\n",$_SESSION['wpt_ad_content_3']);
				$content = do_shortcode($content);
				echo $content;
				
				/* After widget (defined by themes). */
				echo $after_widget;
			}
			else
			{
				$title = apply_filters('widget_title', $instance['title'] );
				
				if ( $title && $_SESSION['wpt_ad_content_3'] )
				
					echo $before_title . $title . $after_title;
					
				echo "<div id='id_wpt_adblock_3'></div>";
			}
		}

		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => __('Example', 'example'));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

		<?php
		}
	}
	
	
	class wpt_widgets_advertisments_4 extends WP_Widget 
	{
		/**
		 * Widget setup.
		 */
		function wpt_widgets_advertisments_4() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'class_wpt_advertisments_widget_4', 'description' => __('Widget #4 : Add this widget to sidebar to intercept and display dynamic advertisments. If no advertisment is detected then widget will not be displayed.', 'wpt_widget') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_wpt_widgets_advertisments_4' );

			/* Create the widget. */
			$this->WP_Widget( 'id_wpt_widgets_advertisments_4', __('WPTT: Advertisment Widget #4', 'wptt_widget_4'), $widget_ops, $control_ops );
		}
		
		/**
		 * How to display the widget on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			
			if ($_SESSION['wpt_ad_content_4'])
			{
				/* Our variables from the widget settings. */
				$title = apply_filters('widget_title', $instance['title'] );

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title && $_SESSION['wpt_ad_content_4'])
				
					echo $before_title . $title . $after_title;

				$content =  str_replace("_nl_","\n",$_SESSION['wpt_ad_content_4']);
				$content = do_shortcode($content);
				echo $content;
				
				/* After widget (defined by themes). */
				echo $after_widget;
			}
			else
			{
				$title = apply_filters('widget_title', $instance['title'] );
				
				if ( $title && $_SESSION['wpt_ad_content_4'] )
				
					echo $before_title . $title . $after_title;
					
				echo "<div id='id_wpt_adblock_4'></div>";
			}
		}

		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => __('Example', 'example'));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

		<?php
		}
	}
	
	class wpt_widgets_advertisments_5 extends WP_Widget 
	{
		/**
		 * Widget setup.
		 */
		function wpt_widgets_advertisments_5() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'class_wpt_advertisments_widget_5', 'description' => __('Widget #5 : Add this widget to sidebar to intercept and display dynamic advertisments. If no advertisment is detected then widget will not be displayed.', 'wpt_widget') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_wpt_widgets_advertisments_5' );

			/* Create the widget. */
			$this->WP_Widget( 'id_wpt_widgets_advertisments_5', __('WPTT: Advertisment Widget #5', 'wptt_widget_5'), $widget_ops, $control_ops );
		}
		
		/**
		 * How to display the widget on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			
			if ($_SESSION['wpt_ad_content_5'])
			{
				/* Our variables from the widget settings. */
				$title = apply_filters('widget_title', $instance['title'] );

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title && $_SESSION['wpt_ad_content_5'])
				
					echo $before_title . $title . $after_title;

				$content =  str_replace("_nl_","\n",$_SESSION['wpt_ad_content_1']);
				$content = do_shortcode($content);
				echo $content;
				
				/* After widget (defined by themes). */
				echo $after_widget;
			}
			else
			{
				$title = apply_filters('widget_title', $instance['title'] );
				
				if ( $title && $_SESSION['wpt_ad_content_5'] )
				
					echo $before_title . $title . $after_title;
					
				echo "<div id='id_wpt_adblock_5'></div>";
			}
		}

		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => __('Example', 'example'));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

		<?php
		}
	}
	
	class wpt_widgets_advertisments_6 extends WP_Widget 
	{
		/**
		 * Widget setup.
		 */
		function wpt_widgets_advertisments_6() {
			/* Widget settings. */
			$widget_ops = array( 'classname' => 'class_wpt_advertisments_widget_6', 'description' => __('Widget #6 : Add this widget to sidebar to intercept and display dynamic advertisments. If no advertisment is detected then widget will not be displayed.', 'wpt_widget') );

			/* Widget control settings. */
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'id_wpt_widgets_advertisments_6' );

			/* Create the widget. */
			$this->WP_Widget( 'id_wpt_widgets_advertisments_6', __('WPTT: Advertisment Widget #6', 'wptt_widget_6'), $widget_ops, $control_ops );
		}
		
		/**
		 * How to display the widget on the screen.
		 */
		function widget( $args, $instance ) {
			extract( $args );
			
			if ($_SESSION['wpt_ad_content_6'])
			{
				/* Our variables from the widget settings. */
				$title = apply_filters('widget_title', $instance['title'] );

				/* Before widget (defined by themes). */
				echo $before_widget;

				/* Display the widget title if one was input (before and after defined by themes). */
				if ( $title && $_SESSION['wpt_ad_content_6'])
				
					echo $before_title . $title . $after_title;

				$content =  str_replace("_nl_","\n",$_SESSION['wpt_ad_content_6']);
				$content = do_shortcode($content);
				echo $content;
				
				/* After widget (defined by themes). */
				echo $after_widget;
			}
			else
			{
				$title = apply_filters('widget_title', $instance['title'] );
				
				if ( $title && $_SESSION['wpt_ad_content_6'] )
				
					echo $before_title . $title . $after_title;
					
				echo "<div id='id_wpt_adblock_6'></div>";
			}
		}

		/**
		 * Update the widget settings.
		 */
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			/* Strip tags for title and name to remove HTML (important for text inputs). */
			$instance['title'] = strip_tags( $new_instance['title'] );
			return $instance;
		}

		/**
		 * Displays the widget settings controls on the widget panel.
		 * Make use of the get_field_id() and get_field_name() function
		 * when creating your form elements. This handles the confusing stuff.
		 */
		function form( $instance ) {

			/* Set up some default widget settings. */
			$defaults = array( 'title' => __('Example', 'example'));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<!-- Widget Title: Text Input -->
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'hybrid'); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>

		<?php
		}
	}
	

	//ADD SETTINGS TO POST EDITING AREA
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	
	function wpt_spyntax($content)
	{
		if ( preg_match('/\{([^{}]+)\}/', $content, $matches) ) {
			$inner_elements = explode('|', $matches[1]);
			$random_element = $inner_elements[array_rand($inner_elements)];
			$content = str_replace($matches[0], $random_element, $content);
			$content = wpt_spyntax($content);
		}
		return $content;
	}
	
	function adviertisements_add_meta_box()
	{	
		global $rp;
		if ($rp[3]==1)
		{
			add_meta_box( 'wp-advertisement-dropper', 'Special Advertisements', 'adviertisements_meta_box' , 'post', 'advanced', 'high' );
			add_meta_box( 'wp-advertisement-dropper', 'Special Advertisements', 'adviertisements_meta_box' , 'page', 'advanced', 'high' );
		}
	}
	
	add_action('admin_menu', 'adviertisements_add_meta_box');
	
	function adviertisements_meta_box()
	{
		global $post;
		global $table_prefix;
		$post_id = $post->ID;
		//echo $post_id;exit;
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles WHERE post_id='{$post_id}' LIMIT 1";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_profile_id = $arr['id'];
			$advertisements_post_id = $arr['post_id'];
			$advertisements_post_content_profile_id = $arr['content_profile_id'];
			$advertisements_post_placement = $arr['placement'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles ";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_content_profile_id[] = $arr['id'];
			$advertisements_content_profile_name[] = $arr['profile_name'];
		}
		
		
		?>
		<div class=" " id="trackbacksdiv">
			<div class="inside">
					<table>
						<tr>
							<td>
								<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Ad to use."> 
									Use Advertisement:
								</label>
							</td>
							<td>
								<input type='hidden' name='advertisements_post_profile_id' value='<?php echo $advertisements_profile_id; ?>'>
								<input type='hidden' name='advertisements_post_post_id' value='<?php echo $post_id; ?>'>
								<select <?php echo $add; ?> name='advertisements_post_content_profile_id'>
									<option value='x'>No advertisements used.</option>
									<?php

									foreach ($advertisements_content_profile_id as $k=>$v)
									{
										if ($advertisements_post_content_profile_id==$v)
										{
										
											$selected = 'selected';
										}
										else
										{
											$selected = '';
										}
										echo "<option value='$v' $selected>$advertisements_content_profile_name[$k]</option>";
									}
									
									?>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<label for=keyword>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Ad to use."> 
									Placement:
								</label>
							</td>
							<td>
								<select <?php echo $add; ?> name='advertisements_post_content_placement'>
									<option value='above' <?php if ($advertisements_post_placement=='above'){echo "selected='true'"; } ?>>Above the Content</option>									
									<option value='middle' <?php if ($advertisements_post_placement=='middle'){echo "selected='true'"; } ?>>Middle of the Content</option>									
									<option value='below' <?php if ($advertisements_post_placement=='below'){echo "selected='true'"; } ?>>Below the Content</option>									
									<option value='widget_1' <?php if ($advertisements_post_placement=='widget_1'){echo "selected='true'"; } ?>>Widget #1</option>								
									<option value='widget_2' <?php if ($advertisements_post_placement=='widget_2'){echo "selected='true'"; } ?>>Widget #2</option>							
									<option value='widget_3' <?php if ($advertisements_post_placement=='widget_3'){echo "selected='true'"; } ?>>Widget #3</option>							
									<option value='widget_4' <?php if ($advertisements_post_placement=='widget_4'){echo "selected='true'"; } ?>>Widget #4</option>							
									<option value='widget_5' <?php if ($advertisements_post_placement=='widget_5'){echo "selected='true'"; } ?>>Widget #5</option>							
									<option value='widget_6' <?php if ($advertisements_post_placement=='widget_6'){echo "selected='true'"; } ?>>Widget #6</option>							
								</select>
							</td>
						</tr>
					</table>
				
				
			</div>	
		</div>
		<?php
	}
	
	//ADD MENU ITEM AND OPTIONS PAGE
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	//*****************************************
	
	function advertisements_add_javascript()
	{
		global $rp;
		if ($rp[3]!=1)
		{
			$add = "disabled='disabled' ";
		}else{ $add = "";}
		$add = str_replace("'",'"',$add);
		?>
			<style type='text/css'>
			input , textarea
			{
				color:#999999;
			}
			.class_navtab_active {

				color:#99999;
				border-left-color: #ADCCE1;
				border-left-style: solid;
				border-left-width: 1px;
				border-right-color: #ADCCE1;
				border-right-style: solid;
				border-right-width: 1px;
				border-top-color: #ADCCE1;
				border-top-style: solid;
				border-top-width: 1px;
				border-bottom-color: #ADCCE1;
				border-bottom-style: solid;
				border-bottom-width: 0px;
				padding-bottom: 0.2em;
				padding-left: 0.5em;
				padding-right: 0.5em;
				padding-top: 0.2em;
				cursor:pointer;
				margin-right:-6px;
				text-decoration:none;
			}
			
			.class_navtab_inactive {
				color:#A3A3A3;

				border-left-color: #A3A3A3;
				border-left-style: solid;
				border-left-width: 1px;
				border-right-color: #A3A3A3;
				border-right-style: solid;
				border-right-width: 1px;
				border-top-color: #A3A3A3;
				border-top-style: solid;
				border-top-width: 1px;
				border-bottom-color: #A3A3A3;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				padding-bottom: 0.2em;
				padding-left: 0.5em;
				padding-right: 0.5em;
				padding-top: 0.2em;
				position: relative;
				cursor:pointer;
				margin-right:-6px;
			}
			
			.class_navtab_spacer {
				color:#A3A3A3;
				border-bottom-color: #A3A3A3;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				padding-bottom: 0.2em;
				padding-left: 0.5em;
				padding-right: 0.5em;
				padding-top: 0.2em;
				position: relative;
				cursor:pointer;
				width:100%;
			}

			.class_container
			{
				border-color:#ADCCE1;
				border-left-style: solid;
				border-left-width: 1px;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				padding:10px;
			}
			</style>
			<script type="text/javascript">
				
				jQuery(document).ready(function() 
				{
					
					jQuery("#id_advertisements_accordion").accordion({
							autoHeight: false,
							collapsible: true,
							active: -1
					});
					
					<?php
					if ($_GET['container']=='keyword_profiles')
					{
						echo 'jQuery(\'#id_container_keyword_profiles\').show();';
						echo 'jQuery(\'#id_container_post_profiles\').hide();';
						echo 'jQuery(\'#id_container_category_profiles\').hide();';
						echo 'jQuery(\'#id_container_google_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_keyword_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_category_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_google_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					}
					else if ($_GET['container']=='post_profiles')
					{
						echo 'jQuery(\'#id_container_keyword_profiles\').hide();';
						echo 'jQuery(\'#id_container_post_profiles\').show();';
						echo 'jQuery(\'#id_container_category_profiles\').hide();';
						echo 'jQuery(\'#id_container_google_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_keyword_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_post_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_category_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_google_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					}
					else if ($_GET['container']=='category_profiles')
					{
						echo 'jQuery(\'#id_container_keyword_profiles\').hide();';
						echo 'jQuery(\'#id_container_post_profiles\').hide();';
						echo 'jQuery(\'#id_container_category_profiles\').show();';
						echo 'jQuery(\'#id_container_google_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_keyword_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_category_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_google_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					
					}
					else if ($_GET['container']=='google_profiles')
					{
						echo 'jQuery(\'#id_container_keyword_profiles\').hide();';
						echo 'jQuery(\'#id_container_post_profiles\').hide();';
						echo 'jQuery(\'#id_container_category_profiles\').hide();';
						echo 'jQuery(\'#id_container_google_profiles\').show();';
						
						echo 'jQuery(\'#id_navtab_keyword_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_category_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_google_profiles\').attr(\'class\',\'class_navtab_active\');';
					
					}
					else 
					{

						echo 'jQuery(\'#id_container_keyword_profiles\').show();';
						echo 'jQuery(\'#id_container_post_profiles\').hide();';
						echo 'jQuery(\'#id_container_category_profiles\').hide();';
						echo 'jQuery(\'#id_container_google_profiles\').hide();';
						
						echo 'jQuery(\'#id_navtab_keyword_profiles\').attr(\'class\',\'class_navtab_active\');';
						echo 'jQuery(\'#id_navtab_post_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_category_profiles\').attr(\'class\',\'class_navtab_inactive\');';
						echo 'jQuery(\'#id_navtab_google_profiles\').attr(\'class\',\'class_navtab_inactive\');';
					}
					?>
					
					jQuery('#id_navtab_keyword_profiles').live('click', function() {
						jQuery('#id_container_keyword_profiles').show();
						jQuery('#id_container_post_profiles').hide();
						jQuery('#id_container_category_profiles').hide();
						jQuery('#id_container_google_profiles').hide();
						
						jQuery('#id_navtab_keyword_profiles').attr('class','class_navtab_active');
						jQuery('#id_navtab_post_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_category_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_google_profiles').attr('class','class_navtab_inactive');
					});
					
					jQuery('#id_navtab_post_profiles').live('click', function() {
						jQuery('#id_container_keyword_profiles').hide();
						jQuery('#id_container_post_profiles').show();
						jQuery('#id_container_category_profiles').hide();
						jQuery('#id_container_google_profiles').hide();
						
						jQuery('#id_navtab_keyword_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_post_profiles').attr('class','class_navtab_active');
						jQuery('#id_navtab_category_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_google_profiles').attr('class','class_navtab_inactive');
					});
					
					jQuery('#id_navtab_category_profiles').live('click', function() {
						jQuery('#id_container_keyword_profiles').hide();
						jQuery('#id_container_post_profiles').hide();
						jQuery('#id_container_category_profiles').show();
						jQuery('#id_container_google_profiles').hide();
						
						jQuery('#id_navtab_keyword_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_post_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_category_profiles').attr('class','class_navtab_active');
						jQuery('#id_navtab_google_profiles').attr('class','class_navtab_inactive');
					});
					
					
					jQuery('#id_navtab_google_profiles').live('click', function() {
						jQuery('#id_container_keyword_profiles').hide();
						jQuery('#id_container_post_profiles').hide();
						jQuery('#id_container_category_profiles').hide();
						jQuery('#id_container_google_profiles').show();
						
						jQuery('#id_navtab_keyword_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_post_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_category_profiles').attr('class','class_navtab_inactive');
						jQuery('#id_navtab_google_profiles').attr('class','class_navtab_active');
					});
					
					jQuery('#id_advertisements_form_content_add_profile').click(function() {
						//alert('hello');
						var html = '<tr><td style="width:140px"><input <?php echo $add; ?> type="hidden" name="advertisements_content_profile_id[]" value="x">Advertisment Name:<br></td><td align="left"><input <?php echo $add; ?> name="advertisements_content_profile_name[x]" style="width:300px;"></td></tr><tr><td colspan=2 >Advertisement Code:<br><font style="font-size:10px;"><i><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will call the exact keyword discovered (Out of the group associated with a keyword profile). Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript. ADVANCED: set-up your variable like this: %keyword_query-exludeword1,excludeword2,excludeword3% to have each exclude word stripped from the keyphrase (Good for long tail keywords coming in from Google)">%keyword_query% <br><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will use the title of the post as a keyword, stripping out common words like "and/are/the/a,etc". Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript. ADVANCED: set-up your variable like this: %keyword_title_filtered-exludeword1,excludeword2,excludeword3% to have each exclude word stripped from the keyphrase (Good for long tail keywords coming in from Google)">%keyword_title_filtered% <br><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will choose a tag at random to display the keyword. "and/are/the/a,etc". Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript."> %keyword_random_tag% <br><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will check for a query, then create a keyword out of the title if no query is found. Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript. ADVANCED: set-up your variable like this: %keyword_autodiscover-exludeword1,excludeword2,excludeword3% to have each exclude word stripped from the keyphrase (Good for long tail keywords coming in from Google)">%keyword_auto_discover% <br><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enclose spyntax ready content in [spyntax][/spyntax] formatting blocks to have WPTT spin the content before publishing.">[spyntax][/spyntax]</i></font><textarea <?php echo $add; ?> name="advertisements_content_profile_content[x]" style="width:100%; height:80px;"></textarea></td></tr>';
						jQuery('#id_advertisements_table_content_profiles tr:last').after(html);
					});
					
					jQuery('#id_advertisements_form_content_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_advertisements_form_content").submit();
					});
					
					jQuery('#id_advertisements_form_keywords_add_profile').click(function() {
						var marker = jQuery('#id_advertisements_table_keywords_profiles tr').length;
						marker = marker-2;
						var content_profiles = jQuery('#id_advertisements_select_content_profiles').clone().html();
						content_profiles = content_profiles.replace('[]','['+marker+']');
						var content_placement = '<select <?php echo $add; ?> name=\'advertisements_keywords_placement['+marker+']\'><option value=\'above\' >Above the Content</option><option value=\'middle\'>Middle of the Content</option><option value=\'below\' >Below the Content</option><option value=\'widget_1\'>Widget #1</option><option value=\'widget_2\'>Widget #2</option><option value="widget_3" >Widget #3</option><option value="widget_4" >Widget #4</option><option value="widget_5" >Widget #5</option><option value="widget_6" >Widget #6</option></select>';
						var profile_status = '<select <?php echo $add; ?> name=\'advertisements_keywords_status['+marker+']\' ><option value=\'1\' >Active</option><option value=\'0\' >Not Active</option></select>';
						
						var html = '<tr><td width=\'20\'><img  onClick="jQuery(this).parent().parent().remove();" src="<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png" style="cursor:pointer;"><input <?php echo $add; ?> type=hidden name="advertisements_keywords_profile_id['+marker+']" value="x"></td><td><input <?php echo $add; ?>  name=\'advertisements_keywords_keywords['+marker+']\'  value=\'\' style=\'width:230px\'></td><td>'+content_profiles+'</td><td>'+content_placement+'</td><td><input <?php echo $add; ?>  name="advertisements_keywords_geotargeting['+marker+']" value="" style="width:100px"></td><td align="center"><input <?php echo $add; ?> name="advertisements_keywords_search_content['+marker+']" type="checkbox"></td><td align="center"><input <?php echo $add; ?> name="advertisements_keywords_search_referral['+marker+']" type="checkbox"></td><td>'+ profile_status +'</td></tr>';
						jQuery('#id_advertisements_table_keywords_profiles tr:last').after(html);
					
					});
					
					jQuery('#id_advertisements_form_google_add_profile').click(function() {
						var marker = jQuery('#id_advertisements_table_google_profiles tr').length;
						//alert (marker);
						marker = marker-2;
						var content_profiles = jQuery('#id_advertisements_select_content_profiles').clone().html();
						//alert(content_profiles);
						content_profiles = content_profiles.replace('[]','['+marker+']');
						//alert(content_profiles);
						var content_placement = '<select <?php echo $add; ?> name=\'advertisements_google_placement['+marker+']\'><option value=\'above\' >Above the Content</option><option value=\'middle\'>Middle of the Content</option><option value=\'below\' >Below the Content</option><option value=\'widget_1\'>Widget #1</option><option value=\'widget_2\'>Widget #2</option><option value="widget_3" >Widget #3</option><option value="widget_4" >Widget #4</option><option value="widget_5" >Widget #5</option><option value="widget_6" >Widget #6</option></select>';
						var profile_status = '<select <?php echo $add; ?> name=\'advertisements_google_status['+marker+']\' ><option value=\'1\' >Active</option><option value=\'0\' >Not Active</option></select>';
						var html = '<tr><td width=\'20\'><img  onClick="jQuery(this).parent().parent().remove();" src="<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png" style="cursor:pointer;"><input <?php echo $add; ?> type=hidden name="advertisements_google_profile_id[]" value="x"></td><td align="left" id=\'id_advertisements_td_advertisment_profiles\'>'+content_profiles+'</td><td align="left">'+content_placement+'</td><td align="left">'+ profile_status +'</td></tr>';
						jQuery('#id_advertisements_table_google_profiles tr:last').after(html);
					});
					
					jQuery('#id_advertisements_form_category_add_profile').click(function() {
						var marker = jQuery('#id_advertisements_table_category_profiles tr').length;
						marker = marker;
						marker = marker-2;
						var content_profiles = jQuery('#id_advertisements_select_content_profiles').clone().html();
						content_profiles = content_profiles.replace('[]','['+marker+']');
						content_profiles = content_profiles.replace('_keywords_','_category_');
						
						var category_selects = jQuery('#id_advertisements_select_category_selects').clone().html();
						//alert(category_selects);
						category_selects = category_selects.replace('[]','['+marker+']');
						category_selects = category_selects.replace('[0]','['+marker+']');
						//alert(category_selects);
						var content_placement = '<select <?php echo $add; ?> name=\'advertisements_category_placement['+marker+']\'><option value=\'above\' >Above the Content</option><option value=\'middle\'>Middle of the Content</option><option value=\'below\' >Below the Content</option><option value=\'widget_1\'>Widget #1</option><option value=\'widget_2\'>Widget #2</option><option value="widget_3" >Widget #3</option><option value="widget_4" >Widget #4</option><option value="widget_5" >Widget #5</option><option value="widget_6" >Widget #6</option></select>';
						var profile_status = '<select <?php echo $add; ?> name=\'advertisements_category_status['+marker+']\' ><option value=\'1\' >Active</option><option value=\'0\' >Not Active</option></select>';
						var html = '<tr><td width=\'20\'><img  onClick="jQuery(this).parent().parent().remove();" src="<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png" style="cursor:pointer;"><input <?php echo $add; ?> type=hidden name="advertisements_category_profile_id['+marker+']" value="x"></td><td align="left" id=\'id_advertisements_td_category_advertisment_profiles\'>'+content_profiles+'</td><td align="left">'+category_selects+'</td><td align="left">'+content_placement+'</td><td><input <?php echo $add; ?>  name="advertisements_category_geotargeting['+marker+']" value="" style="width:100px"></td><td align="left">'+ profile_status +'</td></tr>';
						jQuery('#id_advertisements_table_category_profiles tr:last').after(html);
						//jQuery('#id_advertisements_td_category_advertisment_profiles select').attr('name','advertisements_category_content_profile_id['+marker+']');
						jQuery('.class_advertisments_category_selects_placeholder').remove();
					});
					
					jQuery('#id_advertisements_form_post_add_profile').click(function() {
						var marker = jQuery('#id_advertisements_table_post_profiles tr').length;
						marker = marker-2;
						var content_profiles = jQuery('#id_advertisements_select_content_profiles').clone().html();
						content_profiles = content_profiles.replace('[]','['+marker+']');
						content_profiles = content_profiles.replace('_keywords','_post');
						var content_placement = '<select <?php echo $add; ?> name=\'advertisements_post_placement['+marker+']\'><option value=\'above\' >Above the Content</option><option value=\'middle\'>Middle of the Content</option><option value=\'below\' >Below the Content</option><option value=\'widget_1\'>Widget #1</option><option value=\'widget_2\'>Widget #2</option><option value="widget_3" >Widget #3</option><option value="widget_4" >Widget #4</option><option value="widget_5" >Widget #5</option><option value="widget_6" >Widget #6</option></select>';
						var html = '<tr><td width=\'20\'><img  onClick="jQuery(this).parent().parent().remove();" src="<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png" style="cursor:pointer;"></td><td><input <?php echo $add; ?> type=hidden name="advertisements_post_profile_id['+marker+']" value="x"><input <?php echo $add; ?>  name=\'advertisements_post_post_id['+marker+']\'  value=\'\' style=\'width:50px\'></td><td>'+content_profiles+'</td><td>'+content_placement+'</td><td><input <?php echo $add; ?>  name="advertisements_post_geotargeting['+marker+']" value="" style="width:100px"></td></tr>';
						jQuery('#id_advertisements_table_post_profiles tr:last').after(html);
					});
					
					jQuery('.class_advertisements_content_del').click(function() {
						var cid = this.id.replace('id_advertisements_content_del_','');
						jQuery('#id_advertisements_content_h3_'+cid).html('<i>Removed</i>');
						jQuery('#id_advertisements_content_table_'+cid).remove();
					});
					
					jQuery('#id_advertisements_form_keywords_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_advertisements_form_keywords").submit();
					});
					
					jQuery('#id_advertisements_form_google_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_advertisements_form_google").submit();
					});
					
					jQuery('#id_advertisements_form_category_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_advertisements_form_category").submit();
					});
					
				
					
					jQuery('#id_advertisements_form_post_save_profile').click(function() {
						//alert('hello');
						jQuery("#id_advertisements_form_post").submit();
					});
				});
				


			</script>
		<?php
	}
	
	function wptt_advertisements_settings()
	{
		global $table_prefix;
		global $rp;
		if ($rp[3]!=1)
		{
			$add = "disabled='disabled' ";
		}else{ $add = "";}
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_post_profile_id[] = $arr['id'];
			$advertisements_post_post_id[] = $arr['post_id'];
			$advertisements_post_content_profile_id[] = $arr['content_profile_id'];
			$advertisements_post_placement[] = $arr['placement'];
			$advertisements_post_geotargeting[] = $arr['geotargeting'];
			$advertisements_post_drop_count[] = $arr['drop_count'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_keywords_profiles";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_keywords_profile_id[] = $arr['id'];
			$advertisements_keywords_content_profile_id[] = $arr['content_profile_id'];
			$advertisements_keywords_keywords[] = $arr['keywords'];
			$advertisements_keywords_placement[] = $arr['placement'];
			$advertisements_keywords_geotargeting[] = $arr['geotargeting'];
			$advertisements_keywords_search_content[] = $arr['search_content'];
			$advertisements_keywords_search_referral[] = $arr['search_referral'];
			$advertisements_keywords_status[] = $arr['status'];
			$advertisements_keywords_drop_count[] = $arr['drop_count'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_google_profiles";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_google_profile_id[] = $arr['id'];
			$advertisements_google_content_profile_id[] = $arr['content_profile_id'];
			$advertisements_google_placement[] = $arr['placement'];
			$advertisements_google_status[] = $arr['status'];
			$advertisements_google_drop_count[] = $arr['drop_count'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_category_profiles";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_category_profile_id[] = $arr['id'];
			$advertisements_category_content_profile_id[] = $arr['content_profile_id'];
			$advertisements_category_category_id[] = $arr['category_id'];
			$advertisements_category_placement[] = $arr['placement'];
			$advertisements_category_geotargeting[] = $arr['geotargeting'];
			$advertisements_category_status[] = $arr['status'];
			$advertisements_category_drop_count[] = $arr['drop_count'];
		}
		
		$query = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles ";
		$result = mysql_query($query);
		if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
		while ($arr = mysql_fetch_array($result))
		{
			$advertisements_content_profile_id[] = $arr['id'];
			$advertisements_content_profile_name[] = $arr['profile_name'];
			$advertisements_content_profile_content[] = stripslashes($arr['content']);
		}
		
		?>
		
		<div class='wptt_featurebox'>
			<br>
			<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_content_add_profile'>Add Advertisement Block</span>&nbsp&nbsp;&nbsp&nbsp;
			<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_content_save_profile'>Save Block(s)</span>
			<br><br>
			<form name='advertisements_content_profile_add' id='id_advertisements_form_content' method="post" action="admin.php?page=wptt_slug_submenu_advertisement_profiles">
			<input type='hidden' name='advertisements_content_form_nature' value='save_profile'>
			<table id='id_advertisements_table_content_profiles' style='width:100%'>
				<tr>
					
				</tr>
			</table>
			<div id='id_advertisements_accordion'>
				<?php
				if ($advertisements_content_profile_id)
				{
					foreach ($advertisements_content_profile_id as $k=>$v)
					{
						if ( $advertisements_content_profile_name[$k])
						{
							$i=$k+1;
							?>
							<h3 style='font-size:14px;' id='id_advertisements_content_h3_<?php echo $advertisements_content_profile_id[$k]; ?>'><a href="#"><?php echo $advertisements_content_profile_name[$k]; ?></a> 
								<input type='hidden' name="advertisements_content_profile_id[]" style="width:200px;" value='<?php echo $advertisements_content_profile_id[$k]; ?>'>
										
							</h3>
							<div >
								<table width='100%' id='id_advertisements_content_table_<?php echo $advertisements_content_profile_id[$k]; ?>'>
									<tr>
										<td style='width:150px;font-size:10px' >
										 AD NAME:<br>
										</td>
										<td>
											<input <?php echo $add; ?> name="advertisements_content_profile_name[<?php echo $v; ?>]" style="width:250px;" value='<?php echo $advertisements_content_profile_name[$k]; ?>'>
											&nbsp;&nbsp; <img  src='<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png' style='cursor:pointer;' class='class_advertisements_content_del' id='id_advertisements_content_del_<?php echo $advertisements_content_profile_id[$k]; ?>'>
										</td>
									</tr>
									<tr>
										<td width='' valign=top>
											
											<font style='font-size:10px'>AD CONTENT:</font>
										</td>
										<td>
											<font style='font-size:10px;'>
											<i>
											<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will call the exact keyword discovered, be it from the Google Search the user came in on (if used within a Google Searches Profile), or the keyword found within the content that caused the ad to place (if used with a Keyword Targeted Profile).  Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript. ADVANCED: set-up your variable like this: %keyword_query-exludeword1,excludeword2,excludeword3% to have each exclude word stripped from the keyphrase (Good for long tail keywords coming in from Google)"> 											
											%keyword_query% <br>
											<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will use the title of the post as a keyword, stripping out common words like 'and/are/the/a,etc'. Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript. ADVANCED: set-up your variable like this: %keyword_title-exludeword1,excludeword2,excludeword3% to have each exclude word stripped from the keyphrase (Good for long tail keywords coming in from Google)"> 											
											%keyword_title_filtered% <br>
											<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will choose a tag at random to display the keyword. 'and/are/the/a,etc'. Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript."> 											
											%keyword_random_tag% <br>
											<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="This variable will check for a query, then create a keyword out of the title if no query is found. Use with 3rd party shortcodes such as phpBay and phpZon. You can also use this with javascript. ADVANCED: set-up your variable like this: %keyword_autodiscover-exludeword1,excludeword2,excludeword3% to have each exclude word stripped from the keyphrase (Good for long tail keywords coming in from Google)"> 											
											%keyword_auto_discover% <br>
											<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Enclose spyntax ready content in [spyntax][/spyntax] formatting blocks to have WPTT spin the content before publishing.">[spyntax][/spyntax]
											</i></font>
											<br>
											<textarea <?php echo $add; ?> name="advertisements_content_profile_content[<?php echo $v; ?>]" style="width:100%; height:200px;"><?php echo $advertisements_content_profile_content[$k]; ?></textarea>
										</td>
									</tr>
								</table>
							</div>
							<?php
						}
					}
				}
				?>
				
			</div>			
			</form>
		</div>
		<br><br>
		<div class='wptt_featurebox'>
			
			<span class='class_navtab_active' id='id_navtab_keyword_profiles'>Keyword Targeted Placements</span>
			<span class='class_navtab_inactive' id='id_navtab_post_profiles'>Post Specific Placements</span>
			<span class='class_navtab_inactive' id='id_navtab_category_profiles'>Category Specific Placements</span>
			<span class='class_navtab_inactive' id='id_navtab_google_profiles'>Search Engine Traffic Placements</span>	

			<div id='id_container_keyword_profiles' class='class_container'>	
				<h3>Keyword Detection Profiles</h3>
				
				<br>
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_keywords_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_keywords_save_profile'>Save Profile(s)</span>
				<br><br>
				<form name='advertisements_keywords_profile_add' id='id_advertisements_form_keywords' method="post" action="admin.php?page=wptt_slug_submenu_advertisement_profiles">
				<input type='hidden' name='advertisements_keywords_form_nature' value='save_profile'>	
				<table id='id_advertisements_table_keywords_profiles' style='width:100%'>
					<tr>
						<td colspan='7'>
							<small><i>Search post body & title or the referring URL for certain keywords, if a match is found then the advertisment will display.</i>
							<br><br>
							<i>Geotargeting Syntax Examples:</i><br> 
								{countrycode:us} <a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> 
								{regioncode:al} <a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> 
								{areacode:334}
								{city:birmingham}
							<br><br>
							</small>
						</td>
					</tr>
					<tr>
						<td width='20' align='center'>
							#
						</td>
						<td align='center' width='140'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="seperate keywords with commas. WP Traffic Tools will check post content for these keywords and if found it will insert the associated advertisment.">
								<i>Keywords to Search</i>												
						</td>
						<td align='center'>
								<i>Advertisement</i>											
						</td>
						<td align='center'>
								<i>Placement</i>											
						</td>
						<td align='center'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Add geotargeting syntax here to limit ads to certain geographic regions. Leave this field blank to ignore geo-limitations. You may only use one targeting code at a time. eg: {areacode:334}.">
								<i>Geotargeting</i>											
						</td>

						<td align='center'>
								<i>Search Content</i>											
						</td>
						<td align='center'>
								<i>Search Referral</i>											
						</td>
						<td align='center'>
								<i>Status</i>											
						</td>
					</tr>
					<?php
					if ($advertisements_keywords_profile_id)
					{
						foreach ($advertisements_keywords_profile_id as $k=>$v)
						{
							$i=$k+1;
							
							?>
							<tr>
								<td width='20'>
									<input type=hidden name='advertisements_keywords_profile_id[<?php echo $k; ?>]' value='<?php echo $v; ?>'>
									<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
								</td>
								<td>
									<input <?php echo $add; ?>  name='advertisements_keywords_keywords[<?php echo $k; ?>]' value='<?php echo $advertisements_keywords_keywords[$k]; ?>' style='width:230px'>			
								</td>
								<td >
									<select <?php echo $add; ?> name='advertisements_keywords_content_profile_id[<?php echo $k; ?>]' >
											<?php
											
											foreach ($advertisements_content_profile_id as $a=>$b)
											{
												if ($advertisements_keywords_content_profile_id[$k]==$b)
												{
													$selected = 'selected=true';
												}
												else
												{
													$selected = '';
												}
												
												echo "<option value='$b' $selected>$advertisements_content_profile_name[$a]</option>";
											}
											
											?>
									</select>
								</td>
								<td <?php if ($k==0) { echo " id='id_advertisements_select_placement'"; } ?>>
									
									<select <?php echo $add; ?> name='advertisements_keywords_placement[<?php echo $k; ?>]' id='id_advertisements_select_placement'>
											<option value='above' <?php if ($advertisements_keywords_placement[$k]=='above'){echo "selected='true'"; } ?>>Above the Content</option>									
											<option value='middle' <?php if ($advertisements_keywords_placement[$k]=='middle'){echo "selected='true'"; } ?>>Middle of the Content</option>									
											<option value='below' <?php if ($advertisements_keywords_placement[$k]=='below'){echo "selected='true'"; } ?>>Below the Content</option>									
											<option value='widget_1' <?php if ($advertisements_keywords_placement[$k]=='widget_1'){echo "selected='true'"; } ?>>Widget #1</option>									
											<option value='widget_2' <?php if ($advertisements_keywords_placement[$k]=='widget_2'){echo "selected='true'"; } ?>>Widget #2</option>
											<option value='widget_3' <?php if ($advertisements_keywords_placement[$k]=='widget_3'){echo "selected='true'"; } ?>>Widget #3</option>							
											<option value='widget_4' <?php if ($advertisements_keywords_placement[$k]=='widget_4'){echo "selected='true'"; } ?>>Widget #4</option>							
											<option value='widget_5' <?php if ($advertisements_keywords_placement[$k]=='widget_5'){echo "selected='true'"; } ?>>Widget #5</option>							
											<option value='widget_6' <?php if ($advertisements_keywords_placement[$k]=='widget_6'){echo "selected='true'"; } ?>>Widget #6</option>	
									</select>
								</td>
								<td>
									<input <?php echo $add; ?>  name='advertisements_keywords_geotargeting[<?php echo $k; ?>]' value='<?php echo $advertisements_keywords_geotargeting[$k]; ?>' style='width:100px'>			
								</td>
								<td align='center'>
									<input <?php echo $add; ?> name='advertisements_keywords_search_content[<?php echo $k; ?>]' type='checkbox' <?php if ($advertisements_keywords_search_content[$k]=='1'){ echo "checked='true'";}?>>
								</td>
								<td align='center'>
									<input <?php echo $add; ?> name='advertisements_keywords_search_referral[<?php echo $k; ?>]' type='checkbox' <?php if ($advertisements_keywords_search_referral[$k]=='1'){ echo "checked='true'";}?>>
								</td>
								<td align='center' <?php if ($k==0) { echo " id='id_advertisements_select_status'"; } ?>>
									<select <?php echo $add; ?> name='advertisements_keywords_status[<?php echo $k; ?>]' >
										<?php
											if ($advertisements_keywords_status[$k]=='1')
											{
												echo "<option value='1' selected=true>Active</option>";
												echo "<option value='0' >Not Active</option>";
											}
											else
											{
												echo "<option value='1'>Active</option>";
												echo "<option value='0' selected=true>Not Active</option>";
											}	
										?>
									</select>
									
								</td>
							</tr>
						<?php
						}
					}
					else
					{
					?>
							
					<?php
					}
					?>
				</table>				
				</form>
					<div align='center'  id='id_advertisements_select_content_profiles'  class="class_advertisements_keywords_remove" style="display:none">
						<select <?php echo $add; ?> name='advertisements_keywords_content_profile_id[]' class="class_advertisements_keywords_remove">
								<?php
								
								foreach ($advertisements_content_profile_id as $a=>$b)
								{
									if ($advertisements_keywords_content_profile_id==$b)
									{
										$selected = 'selected=true';
									}
									else
									{
										$selected = '';
									}
									
									echo "<option value='$b' $selected>$advertisements_content_profile_name[$a]</option>";
								}
								
								?>
						</select>								
					</div>					
					<div  id='id_advertisements_select_status'  style="display:none" class="class_advertisements_keywords_remove" class="class_advertisements_keywords_remove">
							<select <?php echo $add; ?> name='advertisements_keywords_status[]'>
									<?php
										
											echo "<option value='1' selected=true>Active</option>";
											echo "<option value='0' >Not Active</option>";
									?>
						</select>
					</div>
				</div>
				
				<div id='id_container_post_profiles'  class='class_container'>	
				<h3>Post Specific Profiles</h3>
				
				<br>
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_post_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_post_save_profile'>Save Profile(s)</span>
				<br><br>
				<form name='advertisements_post_profile_add' id='id_advertisements_form_post' method="post" action="admin.php?page=wptt_slug_submenu_advertisement_profiles">	
				<input type='hidden' name='advertisements_post_form_nature' value='save_profile'>
				<table id='id_advertisements_table_post_profiles' style='width:100%'>
					<tr>
						<td colspan='4'>
							<small>
							<i>Post specific profiles are applied to individual posts. These settings can also be edited from within the post editing / creation area of Wordpress.</i>
							<br><br>
							<i>Geotargeting Syntax Examples:</i><br>
								{countrycode:us} <a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> 
								{regioncode:al} <a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> 
								{areacode:334}
								{city:birmingham}
							<br><br>
							</small>
						</td>
					</tr>
					<tr>
						<td width='20' align='center'>
							#
						</td>
						<td align='left' width='140'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Post ID to insert advertisement into. If you would like to display an advertisement on the homepage please enter in 'h' as your post_id. Only one profile is currenly allowed to be created on the homepage.">  <i>Post ID</i>												
						</td>
						<td align='left'>
								<i>Advertisments</i>										
						</td>
						<td align='left'>
								<i>Placement</i>										
						</td>
						<td align='left'>
								<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Add geotargeting syntax here to limit ads to certain geographic regions. Leave this field blank to ignore geo-limitations. You may only use one targeting code at a time. eg: {areacode:334}.">
								<i>Geotargeting</i>										
						</td>
					</tr>
					<?php
					if ($advertisements_post_profile_id)
					{
						foreach ($advertisements_post_profile_id as $k=>$v)
						{
							$i=$k+1;
							?>
							
							<tr>
								<td width='20'>
									<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
									<input type=hidden name="advertisements_post_profile_id[<?php echo $k; ?>]" value="<?php echo $advertisements_post_profile_id[$k]; ?>">
								</td>
								<td>
									<input <?php echo $add; ?>  name='advertisements_post_post_id[<?php echo $k; ?>]' size=45 value='<?php echo $advertisements_post_post_id[$k]; ?>' style='width:50px'>			
								</td>
								<td <?php if ($k==0) { echo " id='id_select_post_content_profiles'"; } ?>>
									<select <?php echo $add; ?> name='advertisements_post_content_profile_id[<?php echo $k; ?>]'>
											<?php
											
											foreach ($advertisements_content_profile_id as $a=>$b)
											{
												if ($advertisements_post_content_profile_id[$k]==$b)
												{
													$selected = 'selected=true';
												}
												else
												{
													$selected = '';
												}
												
												echo "<option value='$b' $selected>$advertisements_content_profile_name[$a]</option>";
											}
											
											?>
									</select>
									
								
								</td>
								<td>				
									<select <?php echo $add; ?> name='advertisements_post_placement[<?php echo $k; ?>]' id='id_advertisements_select_content_placement'>
											<option value='above' <?php if ($advertisements_post_placement[$k]=='above'){echo "selected='true'"; } ?>>Above the Content</option>									
											<option value='middle' <?php if ($advertisements_post_placement[$k]=='middle'){echo "selected='true'"; } ?>>Middle of the Content</option>									
											<option value='below' <?php if ($advertisements_post_placement[$k]=='below'){echo "selected='true'"; } ?>>Below the Content</option>
											<option value='widget_1' <?php if ($advertisements_post_placement[$k]=='widget_1'){echo "selected='true'"; } ?>>Widget #1</option>											
											<option value='widget_2' <?php if ($advertisements_post_placement[$k]=='widget_2'){echo "selected='true'"; } ?>>Widget #2</option>
											<option value='widget_3' <?php if ($advertisements_post_placement[$k]=='widget_3'){echo "selected='true'"; } ?>>Widget #3</option>							
											<option value='widget_4' <?php if ($advertisements_post_placement[$k]=='widget_4'){echo "selected='true'"; } ?>>Widget #4</option>							
											<option value='widget_5' <?php if ($advertisements_post_placement[$k]=='widget_5'){echo "selected='true'"; } ?>>Widget #5</option>							
											<option value='widget_6' <?php if ($advertisements_post_placement[$k]=='widget_6'){echo "selected='true'"; } ?>>Widget #6</option>	
									</select>
								</td>
								<td>
									<input <?php echo $add; ?>  name='advertisements_post_geotargeting[<?php echo $k; ?>]' value='<?php echo $advertisements_post_geotargeting[$k]; ?>' style='width:100px'>			
								</td>
							</tr>
						<?php
						}
					}
					?>
				</table>				
				</form>
			</div>	
			
			
			<div id='id_container_category_profiles'  class='class_container'>	
				<h3>Category Specific Profiles</h3>
				
				<br>
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_category_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_category_save_profile'>Save Profile(s)</span>
				<br><br>
				<form name='advertisements_category_profile_add' id='id_advertisements_form_category' method="post" action="admin.php?page=wptt_slug_submenu_advertisement_profiles">
				<input type='hidden' name='advertisements_category_form_nature' value='save_profile'>	
				<table id='id_advertisements_table_category_profiles' style='width:100%'>
					<tr>
						<td colspan='4'>
							<small>
							<i>Category placements will apply an advertisment to all posts associated with a category, unless the post is determined to have a keyword specific placement already detected, in which if the former is the case then the keyword specific pofiles and post specific profiles will take precedence over the category specific profiles.</i>
							<br><br>
							<i>Geotargeting Syntax Examples:</i><br>
								{countrycode:us} <a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/country-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available country codes."></a> 
								{regioncode:al} <a href='<?php echo WPTRAFFICTOOLS_URLPATH; ?>/includes/region-codes.txt' target=_blank><img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/link.gif" style="cursor:pointer;" border=0 title="Click here to see a list of available region codes."></a> 
								{areacode:334}
								{city:birmingham}
							<br><br>
							</small>
						</td>
					</tr>
					<tr>
						<td width='20' align='center'>
							#
						</td>
						<td align='left'>
								<i>Advertisement</i>											
						</td>
						<td align='left'>
								<i>Category</i>											
						</td>
						<td align='left'>
								<i>Placement</i>											
						</td>
						<td align='left'>
							<img src="<?php echo WPTRAFFICTOOLS_URLPATH; ?>images/tip.png" style="cursor:pointer;" border=0 title="Add geotargeting syntax here to limit ads to certain geographic regions. Leave this field blank to ignore geo-limitations. You may only use one targeting code at a time. eg: {areacode:334}.">
							<i>Geotargeting</i>											
						</td>
						<td align='left'>
								<i>Status</i>											
						</td>
					</tr>
					<?php
					if ($advertisements_category_profile_id)
					{
						foreach ($advertisements_category_profile_id as $k=>$v)
						{
							$i=$k+1;
							
							?>
							<tr>
								<td width='20'>
									<input type=hidden name='advertisements_category_profile_id[<?php echo $k; ?>]' value='<?php echo $v; ?>'>
									<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
								</td>
								<td id='id_advertisements_td_category_advertisment_profiles'>
									<select <?php echo $add; ?> name='advertisements_category_content_profile_id[<?php echo $k; ?>]' >
											<?php
											
											foreach ($advertisements_content_profile_id as $a=>$b)
											{
												if ($advertisements_category_content_profile_id[$k]==$b)
												{
													$selected = 'selected=true';
												}
												else
												{
													$selected = '';
												}
												
												echo "<option value='$b' $selected>$advertisements_content_profile_name[$a]</option>";
											}
											
											?>
									</select>
								</td>
								<td id='id_advertisements_select_category_selects' >
									<?php
									$args = array('name'=>"advertisements_category_category_id[{$k}]",'selected'=>"$advertisements_category_category_id[$k]",'hide_empty' => 0);
									wp_dropdown_categories( $args );
									?>
								</td>
								<td <?php if ($k==0) { echo " id='id_advertisements_select_placement'"; } ?>>
									<select <?php echo $add; ?> name='advertisements_category_placement[<?php echo $k; ?>]' id='id_advertisements_select_placement'>
											<option value='above' <?php if ($advertisements_category_placement[$k]=='above'){echo "selected='true'"; } ?>>Above the Content</option>									
											<option value='middle' <?php if ($advertisements_category_placement[$k]=='middle'){echo "selected='true'"; } ?>>Middle of the Content</option>									
											<option value='below' <?php if ($advertisements_category_placement[$k]=='below'){echo "selected='true'"; } ?>>Below the Content</option>
											<option value='widget_1' <?php if ($advertisements_category_placement[$k]=='widget_1'){echo "selected='true'"; } ?>>Widget #1</option>	
											<option value='widget_2' <?php if ($advertisements_category_placement[$k]=='widget_2'){echo "selected='true'"; } ?>>Widget #2</option>	
											<option value='widget_3' <?php if ($advertisements_category_placement[$k]=='widget_3'){echo "selected='true'"; } ?>>Widget #3</option>							
											<option value='widget_4' <?php if ($advertisements_category_placement[$k]=='widget_4'){echo "selected='true'"; } ?>>Widget #4</option>							
											<option value='widget_5' <?php if ($advertisements_category_placement[$k]=='widget_5'){echo "selected='true'"; } ?>>Widget #5</option>							
											<option value='widget_6' <?php if ($advertisements_category_placement[$k]=='widget_6'){echo "selected='true'"; } ?>>Widget #6</option>	
									</select>
								</td>
								<td>
									<input <?php echo $add; ?>  name='advertisements_category_geotargeting[<?php echo $k; ?>]' value='<?php echo $advertisements_category_geotargeting[$k]; ?>' style='width:100px'>			
								</td>
								<td align='left' <?php if ($k==0) { echo " id='id_advertisements_select_status'"; } ?>>
									<select <?php echo $add; ?> name='advertisements_category_status[<?php echo $k; ?>]' >
										<?php										
											if ($advertisements_category_status[$k]=='1')
											{
												echo "<option value='1' selected=true>Active</option>";
												echo "<option value='0' >Not Active</option>";
											}
											else
											{
												echo "<option value='1' >Active</option>";
												echo "<option value='0' selected=true>Not Active</option>";
											}	
										?>
									</select>
									
								</td>
								
							</tr>
						<?php
						}
					}
					else
					{
						?>
							<div id='id_advertisements_select_category_selects' class='class_advertisments_category_selects_placeholder' style='display:none'>
								<?php
									$args = array('name'=>'advertisements_category_category_id[]','selected'=>"$advertisements_category_category_id[$k]");
									wp_dropdown_categories( $args );
								?>
							</div>
						<?php
					}
					?>
				
				</table>	
				</form>
			</div>
			
			
			<div id='id_container_google_profiles'  class='class_container'>	
				<h3>Search Engine Specific Profiles</h3>
				
				<br>
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_google_add_profile'>Add Profile</span>&nbsp&nbsp;&nbsp&nbsp;
				<span style='background-color:#1E90FF;border-style:solid;border-width:1px;padding:2px;border-color:#000000;color:#fff;cursor:pointer;' id='id_advertisements_form_google_save_profile'>Save Profile(s)</span>
				<br><br>
				<form name='advertisements_google_profile_add' id='id_advertisements_form_google' method="post" action="admin.php?page=wptt_slug_submenu_advertisement_profiles">
				<input type='hidden' name='advertisements_google_form_nature' value='save_profile'>	
				<table id='id_advertisements_table_google_profiles' style='width:100%'>
					<tr>
						<td colspan='4'>
						<i>Search profiles are applied globally, but will only affect traffic incomming from search engine traffic. When making use of search engine profiles, the %keyword_query% variable within the advertisement template will be replaced by the term the user searched to find the post/page; opening up a wide variety of creative programming uses. </i>
						<br><br>
						</td>
					</tr>
					<tr>
						<td width='20' align='center'>
							#
						</td>
						<td align='left'>
								<i>Advertisement</i>											
						</td>
						<td align='left'>
								<i>Placement</i>											
						</td>
						<td align='left'>
								<i>Status</i>											
						</td>
					</tr>
					<?php
					if ($advertisements_google_profile_id)
					{
						foreach ($advertisements_google_profile_id as $k=>$v)
						{
							$i=$k+1;
							
							?>
							<tr>
								<td width='20'>
									<input type=hidden name='advertisements_google_profile_id[<?php echo $k; ?>]' value='<?php echo $v; ?>'>
									<img  onClick='jQuery(this).parent().parent().remove();' src='<?php echo ADVERTISEMENTS_URLPATH; ?>images/remove.png' style='cursor:pointer;'>
								</td>
								<td id='id_advertisements_td_google_advertisment_profiles'>
									<select <?php echo $add; ?> name='advertisements_google_content_profile_id[<?php echo $k; ?>]' >
											<?php
											
											foreach ($advertisements_content_profile_id as $a=>$b)
											{
												if ($advertisements_google_content_profile_id[$k]==$b)
												{
													$selected = 'selected=true';
												}
												else
												{
													$selected = '';
												}
												
												echo "<option value='$b' $selected>$advertisements_content_profile_name[$a]</option>";
											}
											
											?>
									</select>
								</td>
								<td <?php if ($k==0) { echo " id='id_advertisements_select_placement'"; } ?>>
									<select <?php echo $add; ?> name='advertisements_google_placement[<?php echo $k; ?>]' id='id_advertisements_select_placement'>
											<option value='above' <?php if ($advertisements_google_placement[$k]=='above'){echo "selected='true'"; } ?>>Above the Content</option>									
											<option value='middle' <?php if ($advertisements_google_placement[$k]=='middle'){echo "selected='true'"; } ?>>Middle of the Content</option>									
											<option value='below' <?php if ($advertisements_google_placement[$k]=='below'){echo "selected='true'"; } ?>>Below the Content</option>
											<option value='widget_1' <?php if ($advertisements_google_placement[$k]=='widget_1'){echo "selected='true'"; } ?>>Widget #1</option>	
											<option value='widget_2' <?php if ($advertisements_google_placement[$k]=='widget_2'){echo "selected='true'"; } ?>>Widget #2</option>
											<option value='widget_3' <?php if ($advertisements_google_placement[$k]=='widget_3'){echo "selected='true'"; } ?>>Widget #3</option>							
											<option value='widget_4' <?php if ($advertisements_google_placement[$k]=='widget_4'){echo "selected='true'"; } ?>>Widget #4</option>							
											<option value='widget_5' <?php if ($advertisements_google_placement[$k]=='widget_5'){echo "selected='true'"; } ?>>Widget #5</option>							
											<option value='widget_6' <?php if ($advertisements_google_placement[$k]=='widget_6'){echo "selected='true'"; } ?>>Widget #6</option>		
									</select>
								</td>				
								<td align='left' <?php if ($k==0) { echo " id='id_advertisements_select_status'"; } ?>>
									<select <?php echo $add; ?> name='advertisements_google_status[<?php echo $k; ?>]' >
										<?php
	
											if ($advertisements_google_status[$k]=='1')
											{

												echo "<option value='1' selected=true>Active</option>";
												echo "<option value='0' >Not Active</option>";
											}
											else
											{
												echo "<option value='1'>Active</option>";
												echo "<option value='0'  selected=true>Not Active</option>";
											}	
										?>
									</select>
									
								</td>
								
							</tr>
						<?php
						}
					}
					?>
				
				</table>	
				</form>
			</div>
		</div>
		<br><br><br>
		
	<?php
	}
		
	function advertisements_update_settings()
	{
		
		global $table_prefix;
		global $wordpress_url;
		
		
		if ($_POST['advertisements_content_form_nature']=='save_profile')
		{
			//get all current profiles
			$advertisements_content_profile_id = array();
			$query = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles ";
			$result = mysql_query($query);
			if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
			
			$content_profile_id = array();
			while ($arr = mysql_fetch_array($result))
			{
				$content_profile_id[] = $arr['id'];
				$content_profile_name[] = $arr['profile_name'];
				$content_content[] = $arr['content'];
			}
			
			
			//retrieve new batch
			$profile_id = $_POST['advertisements_content_profile_id'] ;
			$profile_name = $_POST['advertisements_content_profile_name'] ;
			$profile_content =$_POST['advertisements_content_profile_content'] ;
			
			//delete from database what is no longer 
			//print_r($profile_id);
			//echo "<hr><br><br>";
			foreach ($content_profile_id as $k=>$v)
			{
				$v = trim($v);
				
				if (!in_array($v, $profile_id))
				{

					$query = "DELETE FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id='$v'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			if ($profile_id)
			{
				//insert new items and update old items
				foreach ($profile_id as $k=>$v)
				{
					//print_r($profile_id);exit;
					$profile_name[$v] = addslashes(trim($profile_name[$v]));
					/*
					echo "<hr>";
					print_r($profile_id);
					echo "<hr> Profile Content:";
					print_r($profile_content);
					echo "<hr> Profile Name:";
					print_r($profile_name);
					echo "<hr> This Profile Name:";
					echo $profile_name[$v];
					echo "<br>$k";
					*/
					$profile_content[$v] = addslashes(trim($profile_content[$v]));
					
					if ($v=='x'&&$profile_name[$v]&&$profile_content[$v])
					{
						//echo "insert<br>";
						$query = "INSERT INTO {$table_prefix}wptt_advertisements_content_profiles (`profile_name`,`content`) VALUES ('$profile_name[$v]','$profile_content[$v]')";
						$result = mysql_query($query);
						if (!$result) { echo $query."<br>";; echo mysql_error(); }
					}
					else
					{
						//echo "update<br>";
						$query = "UPDATE {$table_prefix}wptt_advertisements_content_profiles SET profile_name='$profile_name[$v]', content='$profile_content[$v]' WHERE id='$v'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}	
			}
		}
		
		if ($_POST['advertisements_keywords_form_nature']=='save_profile')
		{
			//echo 1;
			//get all current profiles
			$keywords_profile_id = array();
			
			$query = "SELECT * FROM {$table_prefix}wptt_advertisements_keywords_profiles ";
			$result = mysql_query($query);
			if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
			
			$keywords_profile_id = array();
			while ($arr = mysql_fetch_array($result))
			{
				$keywords_profile_id[] = $arr['id'];
				$keywords_keywords[] = $arr['keywords'];
				$keywords_content_profile_id[] = $arr['content_profile_id'];
				$keywords_search_content[] = $arr['search_content'];
				$keywords_search_referral[] = $arr['search_referral'];
				$keywords_placement[] = $arr['placement'];
				$keywords_geotargeting[] = $arr['geotargeting'];
				$keywords_status[] = $arr['status'];
			}
			
			
			//retrieve new batch
			$profile_id = $_POST['advertisements_keywords_profile_id'];
			$content_profile_id = $_POST['advertisements_keywords_content_profile_id'];
			$keywords = $_POST['advertisements_keywords_keywords'];
			$placement = $_POST['advertisements_keywords_placement'];
			$geotargeting = $_POST['advertisements_keywords_geotargeting'];
			$search_content = $_POST['advertisements_keywords_search_content'];
			$search_referral = $_POST['advertisements_keywords_search_referral'];
			$status = $_POST['advertisements_keywords_status'];
			
			//print_r($content_profile_id);
			//echo "<br>";
			//print_r($profile_id);exit;
			//delete from database what is no longer 

			foreach ($keywords_profile_id as $k=>$v)
			{
				if ($profile_id)
				{
					if (!in_array($v, $profile_id))
					{
						$query = "DELETE FROM {$table_prefix}wptt_advertisements_keywords_profiles WHERE id='$v'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}
				else
				{
					$query = "DELETE FROM {$table_prefix}wptt_advertisements_keywords_profiles";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			
			//insert new items and update old items
			if ($profile_id)
			{
				foreach ($profile_id as $k=>$v)
				{
					if ($search_content[$k]=='on')
					{
						$search_content[$k] = 1;
					}
					else
					{
						$search_content[$k] = 0;
					}
					
					if ($search_referral[$k]=='on')
					{
						$search_referral[$k] = 1;
					}
					else
					{
						$search_referral[$k] = 0;
					}
					
					if ($profile_id[$k]=='x'&&$keywords[$k])
					{
						//echo 1; exit;
						$query = "INSERT INTO {$table_prefix}wptt_advertisements_keywords_profiles (`content_profile_id`,`keywords`,`placement`,`geotargeting`,`search_content`,`search_referral`,`status`,`drop_count`) VALUES ('$content_profile_id[$k]','$keywords[$k]','$placement[$k]','$geotargeting[$k]','$search_content[$k]','$search_referral[$k]','$status[$k]','0')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
					else
					{
						//echo 2; exit;
						$query = "UPDATE {$table_prefix}wptt_advertisements_keywords_profiles SET content_profile_id='$content_profile_id[$k]', keywords='$keywords[$k]', placement='$placement[$k]', geotargeting='$geotargeting[$k]' , search_content='$search_content[$k]', search_referral='$search_referral[$k]', status='$status[$k]'  WHERE id='$profile_id[$k]'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}
			}
		}
		
		if ($_POST['advertisements_category_form_nature']=='save_profile')
		{
			//echo 1;
			//get all current profiles
			$category_profile_id = array();
			
			$query = "SELECT * FROM {$table_prefix}wptt_advertisements_category_profiles ";
			$result = mysql_query($query);
			if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
			

			while ($arr = mysql_fetch_array($result))
			{
				$category_profile_id[] = $arr['id'];
				$category_category_id[] = $arr['category_id'];
				$category_content_profile_id[] = $arr['content_profile_id'];
				$category_placement[] = $arr['placement'];
				$category_geotargeting[] = $arr['geotargeting'];
				$category_status[] = $arr['status'];
			}
			
			
			//retrieve new batch
			$profile_id = $_POST['advertisements_category_profile_id'];
			$category_id = $_POST['advertisements_category_category_id'];			
			$content_profile_id = $_POST['advertisements_category_content_profile_id'];			
			$placement = $_POST['advertisements_category_placement'];
			$geotargeting = $_POST['advertisements_category_geotargeting'];
			$status = $_POST['advertisements_category_status'];
			
			//print_r($content_profile_id); exit;
			//delete from database what is no longer 
			foreach ($category_profile_id as $k=>$v)
			{
				if ($profile_id)
				{
					if (!in_array($v, $profile_id))
					{
						$query = "DELETE FROM {$table_prefix}wptt_advertisements_category_profiles WHERE id='$v'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}
				else
				{
					$query = "TRUNCATE {$table_prefix}wptt_advertisements_category_profiles ";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			if ($profile_id)
			{
				//insert new items and update old items
		
				foreach ($profile_id as $k=>$v)
				{				
					if ($profile_id[$k]=='x')
					{
						//echo 2; exit;
						//echo $k.":".$v;
						//echo $content_profile_id[$k];
						//echo "<hr>";
						$query = "INSERT INTO {$table_prefix}wptt_advertisements_category_profiles (`content_profile_id`,`category_id`,`placement`,`geotargeting`,`status`,`drop_count`) VALUES ('$content_profile_id[$k]','$category_id[$k]','$placement[$k]','$geotargeting[$k]','$status[$k]','0')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
					else
					{
						//echo 2; exit;
						//echo $k.":".$v;
						//echo $content_profile_id[$k];
						//echo "<hr>";
						$query = "UPDATE {$table_prefix}wptt_advertisements_category_profiles SET content_profile_id='$content_profile_id[$k]', category_id='$category_id[$k]',  placement='$placement[$k]', geotargeting='$geotargeting[$k]', status='$status[$k]'  WHERE id='$profile_id[$k]'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}	
			}
		}
		
		if ($_POST['advertisements_google_form_nature']=='save_profile')
		{
			//echo 1;
			//get all current profiles
			$google_profile_id = array();
			
			$query = "SELECT * FROM {$table_prefix}wptt_advertisements_google_profiles ";
			$result = mysql_query($query);
			if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
			

			while ($arr = mysql_fetch_array($result))
			{
				$google_profile_id[] = $arr['id'];
				$google_content_profile_id[] = $arr['content_profile_id'];
				$google_placement[] = $arr['placement'];
				$google_status[] = $arr['status'];
			}
			
			
			//retrieve new batch
			$profile_id = $_POST['advertisements_google_profile_id'];
			$content_profile_id = $_POST['advertisements_google_content_profile_id'];			
			$placement = $_POST['advertisements_google_placement'];
			$status = $_POST['advertisements_google_status'];
			
			//print_r($content_profile_id); exit;
			//delete from database what is no longer 
			foreach ($google_profile_id as $k=>$v)
			{
				if ($profile_id)
				{
					if (!in_array($v, $profile_id))
					{
						$query = "DELETE FROM {$table_prefix}wptt_advertisements_google_profiles WHERE id='$v'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}
				else
				{
					$query = "TRUNCATE {$table_prefix}wptt_advertisements_google_profiles ";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			if ($profile_id)
			{
				//insert new items and update old items
				foreach ($profile_id as $k=>$v)
				{				
					if ($profile_id[$k]=='x')
					{
						//echo 1; exit;
						$query = "INSERT INTO {$table_prefix}wptt_advertisements_google_profiles (`content_profile_id`,`placement`,`status`,`drop_count`) VALUES ('$content_profile_id[$k]','$placement[$k]','$status[$k]','0')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
					else
					{
						//echo 2; exit;
						$query = "UPDATE {$table_prefix}wptt_advertisements_google_profiles SET content_profile_id='$content_profile_id[$k]', placement='$placement[$k]', status='$status[$k]'  WHERE id='$profile_id[$k]'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}	
			}
		}
		
		
		if ($_POST['advertisements_post_form_nature']=='save_profile')
		{
			//echo 1;
			//get all current profiles
			$post_profile_id = array();
			
			$query = "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles ";
			$result = mysql_query($query);
			if (!$result) {echo 11; echo $query;  echo mysql_error(); exit;}
			
			$post_profile_id = array();
			while ($arr = mysql_fetch_array($result))
			{
				$post_profile_id[] = $arr['id'];
				$post_post_id[] = $arr['post_id'];
				$post_content_profile_id[] = $arr['content_profile_id'];
				$post_geotargeting[] = $arr['geotargeting'];
				//$keywords_status[] = $arr['status'];
			}
			
			
			//retrieve new batch
			$profile_id = $_POST['advertisements_post_profile_id'];
			$post_id = $_POST['advertisements_post_post_id'];
			$content_profile_id = $_POST['advertisements_post_content_profile_id'];
			$placement = $_POST['advertisements_post_placement'];
			$geotargeting = $_POST['advertisements_post_geotargeting'];
			
			
			//print_r($post_id); exit;
			//delete from database what is no longer 
			foreach ($post_profile_id as $k=>$v)
			{
				if (!in_array($profile_id[$k], $post_profile_id))
				{
					$query = "DELETE FROM {$table_prefix}wptt_advertisements_post_profiles WHERE id='$v'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error(); }
				}
			}
			
			
			//insert new items and update old items
			if ($post_id)
			{
				foreach ($post_id as $k=>$v)
				{
					if ($profile_id[$k]=='x'&&$post_id[$k])
					{
						//echo 1; exit;
						$query = "INSERT INTO {$table_prefix}wptt_advertisements_post_profiles (`id`,`post_id`,`content_profile_id`,`placement`,`geotargeting`) VALUES ('','$post_id[$k]','$content_profile_id[$k]','$placement[$k]','$geotargeting[$k]')";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo 1; echo mysql_error(); }
					}
					else
					{
						//echo $profile_id[$k]; exit;
						$query = "UPDATE {$table_prefix}wptt_advertisements_post_profiles SET content_profile_id='$content_profile_id[$k]', post_id='$post_id[$k]', placement='$placement[$k]', geotargeting='$geotargeting[$k]' WHERE id='$profile_id[$k]'";
						$result = mysql_query($query);
						if (!$result) { echo $query; echo mysql_error(); }
					}
				}	
			}
		}
	}
	
	function wptt_display_advertisement_profiles()
	{
		global $global_wptt;
		advertisements_update_settings();
		advertisements_add_javascript();
		traffic_tools_javascript();
		traffic_tools_update_check();
	

		include('wptt_style.php');
		echo "<img src='".WPTRAFFICTOOLS_URLPATH."images/wptt_logo.png'>";
		
		echo "<div id='id_wptt_display' class='class_wptt_display'>";
	
		echo '<div class="wrap">';

		echo "<h2>Advertisement Profiles</h2>";
		wptt_advertisements_settings();
		wptt_display_footer();
		echo '</div>';
		echo '</div>';

	}
	
    
	function advertisements_save_post($postID)
	{
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) 
		{
		
		}
		else
		{			
			
			global $table_prefix;

			$advertisements_post_profile_id = $_POST['advertisements_post_profile_id'];
			$advertisements_post_post_id = $_POST['advertisements_post_post_id'];
			$advertisements_post_content_profile_id = $_POST['advertisements_post_content_profile_id'];
			$advertisements_post_content_placement = $_POST['advertisements_post_content_placement'];
			
			if ($advertisements_post_content_profile_id!='x')
			{
				$query = "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles WHERE post_id='{$advertisements_post_post_id}'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}
				
				if (mysql_num_rows($result)>0)
				{
					$query = "UPDATE {$table_prefix}wptt_advertisements_post_profiles SET post_id='{$advertisements_post_post_id}', content_profile_id ='{$advertisements_post_content_profile_id}',  placement ='{$advertisements_post_content_placement}' WHERE post_id='{$advertisements_post_post_id}'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error();  exit;}
				}
				else
				{
					$query = "INSERT INTO {$table_prefix}wptt_advertisements_post_profiles (`post_id`,`content_profile_id`,`placement` , `drop_count`, `geotargeting`) VALUES ('$advertisements_post_post_id','$advertisements_post_content_profile_id','$advertisements_post_content_placement','0','')";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo 2;echo mysql_error();  exit;}
				}
			}
			else
			{
				$query = "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles WHERE id='{$advertisements_post_profile_id}'";
				$result = mysql_query($query);
				if (!$result) { echo $query; echo mysql_error(); exit;}
				
				if (mysql_num_rows($result)>0&&$advertisements_post_content_profile_id=='x')
				{
					$query = "DELETE FROM {$table_prefix}wptt_advertisements_post_profiles WHERE id='$advertisements_post_profile_id'";
					$result = mysql_query($query);
					if (!$result) { echo $query; echo mysql_error();  exit;}
				}
			}
			
		}
		
		return $postID;
	}
	
	function advertisements_replace_tokens($ad_content, $v)
	{
		//echo $ad_content; exit;
		if (strstr($ad_content,"%keyword_query%"))
		{

			$ad_content = str_replace('%keyword_query%', $v, $ad_content);
		}
		
		if (strstr($ad_content,'%keyword_title_filtered%'))
		{
			$this_keyword = wpt_title_as_keyword();
			$ad_content = str_replace('%keyword_title_filtered%', $this_keyword, $ad_content);
		}
		
		if (strstr($ad_content,'%keyword_auto_discover%'))
		{
			if (!$v)
			{
				$this_keyword = wpt_title_as_keyword();
			}
			else
			{
				$this_keyword = $v;
			}
			$ad_content = str_replace('%keyword_title_filtered%', $this_keyword, $ad_content);
		}
		
		if (strstr($ad_content,'%keyword_autodiscover-')&&$i<20)
		{
			if (!$v)
			{
				$this_keyword = wpt_title_as_keyword();
			}
			else
			{
				$this_keyword = $v;
			}
			
			preg_match_all('/%keyword_query-(.*?)%/si',$ad_content, $match);
			$exclude_words = explode(',',$match[1][0]);
			
			$keys = array_keys($exclude_words);
			$size = sizeOf($keys);
			for ($k=0; $k<$size; $k++)
			{
				$this_keyword = str_replace($exclude_words[$k],'',$this_keyword);
			}
			$ad_content = preg_replace('/%keyword_query-(.*?)%/si', $this_keyword, $ad_content,-1);
			$i++;
		}
		
		if (strstr($ad_content,'%keyword_random_tag%'))
		{
			$this_keyword = wpt_tag_as_keyword(1);
			$ad_content = str_replace('%keyword_title_filtered%', $this_keyword, $ad_content);
		}
		
		if (strstr($ad_content,'%keyword_query-')&&$i<20)
		{
			preg_match_all('/%keyword_query-(.*?)%/si',$ad_content, $match);
			$exclude_words = explode(',',$match[1][0]);
			
			$keys = array_keys($exclude_words);
			$size = sizeOf($keys);
			for ($k=0; $k<$size; $k++)
			{
				$v = str_replace($exclude_words[$k],'',$v);
			}
			$ad_content = preg_replace('/%keyword_query-(.*?)%/si', $v, $ad_content,-1);
			$i++;
		}
		

		if (strstr($ad_content,'%keyword_title_filtered-')&&$i<20)
		{
			preg_match_all('/%keyword_title_filtered-(.*?)%/si',$ad_content, $match);
			$exclude_words = explode(',',$match[1][0]);
			
			$this_keyword = wpt_title_as_keyword();
			
			$keys = array_keys($exclude_words);
			$size = sizeOf($keys);
			for ($k=0; $k<$size; $k++)
			{
				$this_keyword = str_replace($exclude_words[$k],'',$this_keyword);
			}
			$ad_content = preg_replace('/%keyword_title_filtered-(.*?)%/si', $this_keyword, $ad_content,-1);
			$i++;
		}
		
		if (strstr($ad_content,"[spyntax]"))
		{
			//echo 1;
			$ad_content = str_replace(array('[spyntax]','[/spyntax]'),'', $ad_content);
			$ad_content = wpt_spyntax($ad_content);
		}
		//echo 2;
		
		return $ad_content;
	}
	
	function advertisements_add_post_content($content) 
	{
		global $post;
		global $table_prefix;
		global $search_visitor;
		
		$google_query = $_SESSION['keywords_query'];
		if (!$google_query)
		{
			$google_query = $_COOKIE['keywords_query'];
		}
		
		$pid = $post->ID; 
		$title = $post->post_title; 
		
		
		//check post specific
		if (is_single()==1||is_page()==1||is_archive()==1)
		{
			//check this post id for a advertisement profile
			$query= "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles WHERE post_id = '{$pid}' LIMIT 3";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			while ($arr = mysql_fetch_array($result))
			{		
				//echo 1;
				$profile_id = $arr['id'];
				$content_profile_id = $arr['content_profile_id'];
				$placement = $arr['placement'];
				$geotargeting = $arr['geotargeting'];
				unset($geonomatch);
				if ($geotargeting)
				{
					//echo 1; exit;
					if (!$geo_array)
					{
						$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
					}
					
					preg_match('/{(.*?)}/i',$geotargeting,$match);
				
					if ($match)
					{
						//echo 1; exit;
						//print_r($match);
						//echo "<hr>";
						$newmatch = explode(":",$match[1]);
						//print_r($newmatch);
						//echo $newmatch[0];exit;
						//echo $geo_array["geoplugin_".$newmatch[0]];exit;
						if ($newmatch[0]=='areacode'){$newmatch[0]='areaCode';}
						else if ($newmatch[0]=='countrycode'){$newmatch[0]='countryCode';}
						else if ($newmatch[0]=='regioncode'){$newmatch[0]='regionCode';}
						if (strtolower($geo_array["geoplugin_".$newmatch[0]])==$newmatch[1])
						{
							//echo 1;exit;
						}
						else
						{
							//echo 2; exit;
							$geonomatch=1;
						}
					}					
				}
				//echo $geonomatch;exit;
				if ($geonomatch!=1)
				{
					//echo $placement;exit;
					$query= "UPDATE {$table_prefix}wptt_advertisements_post_profiles SET drop_count = (drop_count+1) WHERE id='{$profile_id}'";
					$result = mysql_query($query);
					if (!$result){echo $query; echo mysql_error(); exit;}
					
					$query= "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id = '{$content_profile_id}' ";
					$result = mysql_query($query);
					if (!$result){echo $query; echo mysql_error(); exit;}
					
					$arr = mysql_fetch_array($result);
					$ad_content = stripslashes($arr['content']);
					
					$ad_content = advertisements_replace_tokens($ad_content,  $google_query );
					
					if ($placement=='above'&&!$above_exit)
					{
						
						$content = $ad_content.$content;
						$above_exit = 1;
					}
					if ($placement=='middle'&&!$middle_exit)
					{
						$count = strlen($content);
						$half =  $count/2;
						$left = substr($content, 0, $half);
						$right = substr($content, $half);
						$right = explode('. ',$right);
						$right[1] = $ad_content.$right[1];
						$right = implode('. ',$right);
						$content =  $left.$right;
						$middle_exit = 1;
					}
					if ($placement=='below'&&!$below_exit)
					{
						$content = $content.$ad_content;
						$below_exit = 1;
					}
					if ($placement=='widget_1')
					{
						$_SESSION['wpt_ad_content_1'] = $ad_content;
						$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
						$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_ ', $_SESSION['wpt_ad_content_1']);
						$widget_1_exit =1;
					}
					if ($placement=='widget_2')
					{
						$_SESSION['wpt_ad_content_2'] = $ad_content;
						$_SESSION['wpt_ad_content_2'] = str_replace('"',"'",$_SESSION['wpt_ad_content_2'] );
						$_SESSION['wpt_ad_content_2'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_2']);
						$widget_2_exit =1;					
					}
					if ($placement=='widget_3')
					{
						$_SESSION['wpt_ad_content_3'] = $ad_content;
						$_SESSION['wpt_ad_content_3'] = str_replace('"',"'",$_SESSION['wpt_ad_content_3'] );
						$_SESSION['wpt_ad_content_3'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_3']);
						$widget_3_exit =1;
						
					}
					if ($placement=='widget_4')
					{
						$_SESSION['wpt_ad_content_4'] = $ad_content;
						$_SESSION['wpt_ad_content_4'] = str_replace('"',"'",$_SESSION['wpt_ad_content_4'] );
						$_SESSION['wpt_ad_content_4'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_4']);
						$widget_4_exit =1;
					}
					if ($placement=='widget_5')
					{
						$_SESSION['wpt_ad_content_5'] = $ad_content;
						$_SESSION['wpt_ad_content_5'] = str_replace('"',"'",$_SESSION['wpt_ad_content_5'] );
						$_SESSION['wpt_ad_content_5'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_5']);
						$widget_5_exit =1;
					}
					if ($placement=='widget_6')
					{
						$_SESSION['wpt_ad_content_6'] = $ad_content;
						$_SESSION['wpt_ad_content_6'] = str_replace('"',"'",$_SESSION['wpt_ad_content_6'] );
						$_SESSION['wpt_ad_content_6'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_6']);
						$widget_6_exit =1;
					}
				}
				
			}
			
			
			//now check if google
			if ($search_visitor == 1)
			{
				//echo $google_query;exit;
				if ($google_query)
				{					
					//check this post id for a advertisement profile
					$query= "SELECT * FROM {$table_prefix}wptt_advertisements_google_profiles WHERE status>0";
					$result = mysql_query($query);
					if (!$result){echo $query; echo mysql_error(); exit;}
					$count = mysql_num_rows($result);
				
					if ($count>0)
					{

						while($arr = mysql_fetch_array($result))
						{
							//print_r($arr);exit;
							$profile_id = $arr['id'];
							$content_profile_id = $arr['content_profile_id'];
							$_SESSION['ad_content_profile'] = $content_profile_id;
							$placement = $arr['placement'];
							$status = $arr['status'];
									
							$query2 = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id = '{$content_profile_id}' ";
							$result2 = mysql_query($query2);
							if (!$result){echo $query2; echo mysql_error(); exit;}
									
							$array = mysql_fetch_array($result2);
							$ad_content = stripslashes($array['content']);
											
							$ad_content = advertisements_replace_tokens($ad_content, $google_query);
							
							//echo $ad_content; exit;
							
							if ($status==2)
							{
								$ad_content = "<!--cached ad-->$ad_content<!--cached ad-->";
								if (strpos($content, "<!--cached ad-->", 1))
								{
									$content = preg_replace('/\<!--cached ad--\>(.*?)\<!--cached ad--\>/si','',$content);
								}
								
							}
							if ($placement=='above'&&!$above_exit)
							{
								$content = $ad_content.$content;
								if ($status==2)
								{
									$this_content = addslashes($content);
									$query2= "UPDATE {$table_prefix}posts SET post_content = '$this_content' WHERE id='{$pid}'";
									$result2 = mysql_query($query2);
									if (!$result2){echo $query2; echo mysql_error(); exit;}
								}
								$above_exit = 1;
								$google_exit =1;
							}
							if ($placement=='middle'&&!$middle_exit)
							{
								$count = strlen($content);
								$half =  $count/2;
								$left = substr($content, 0, $half);
								$right = substr($content, $half);
								$right = explode('. ',$right);
								$right[1] = $ad_content.$right[1];
								$right = implode('. ',$right);
								$content =  $left.$right;
								if ($status==2)
								{
									$this_content = addslashes($content);
									$query2= "UPDATE {$table_prefix}posts SET post_content = '$this_content' WHERE id='{$pid}'";
									$result2 = mysql_query($query2);
									if (!$result2){echo $query2; echo mysql_error(); exit;}
								}
								$middle_exit = 1;
								$google_exit =1;
							}
							if ($placement=='below'&&!$below_exit)
							{
								$content = $content.$ad_content;
								if ($status==2)
								{
									$this_content = addslashes($content);
									$query2= "UPDATE {$table_prefix}posts SET post_content = '$this_content' WHERE id='{$pid}'";
									$result2 = mysql_query($query2);
									if (!$result2){echo $query2; echo mysql_error(); exit;}
								}
								$below_exit = 1;
								$google_exit =1;
							}
							if ($placement=='widget_1'&&!$$widget_1_exit)
							{
								$_SESSION['wpt_ad_content_1'] = $ad_content;
								$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
								$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_1']);
								$widget_1_exit =1;
							}
							if ($placement=='widget_2'&&!$$widget_2_exit)
							{
								$_SESSION['wpt_ad_content_2'] = $ad_content;
								$_SESSION['wpt_ad_content_2'] = str_replace('"',"'",$_SESSION['wpt_ad_content_2'] );
								$_SESSION['wpt_ad_content_2'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_2']);
								$widget_2_exit =1;
							}
							if ($placement=='widget_3'&&!$$widget_3_exit)
							{
								$_SESSION['wpt_ad_content_3'] = $ad_content;
								$_SESSION['wpt_ad_content_3'] = str_replace('"',"'",$_SESSION['wpt_ad_content_3'] );
								$_SESSION['wpt_ad_content_3'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_3']);
								
							}
							if ($placement=='widget_4'&&!$$widget_4_exit)
							{
								$_SESSION['wpt_ad_content_4'] = $ad_content;
								$_SESSION['wpt_ad_content_4'] = str_replace('"',"'",$_SESSION['wpt_ad_content_4'] );
								$_SESSION['wpt_ad_content_4'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_4']);
							}
							if ($placement=='widget_5'&&!$$widget_5_exit)
							{
								$_SESSION['wpt_ad_content_5'] = $ad_content;
								$_SESSION['wpt_ad_content_5'] = str_replace('"',"'",$_SESSION['wpt_ad_content_5'] );
								$_SESSION['wpt_ad_content_5'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_5']);
							}
							if ($placement=='widget_6'&&!$$widget_6_exit)
							{
								$_SESSION['wpt_ad_content_6'] = $ad_content;
								$_SESSION['wpt_ad_content_6'] = str_replace('"',"'",$_SESSION['wpt_ad_content_6'] );
								$_SESSION['wpt_ad_content_6'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_6']);
							}
						}						
					}			
				}
			}
			
			//now check content for keyword recognition:
			//check this post id for a advertisement profile
			$query= "SELECT * FROM {$table_prefix}wptt_advertisements_keywords_profiles WHERE status='1'";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			if ($count>0)
			{

				while(($arr = mysql_fetch_array($result)))
				{
					//print_r($arr);exit;
					$profile_id = $arr['id'];
					$content_profile_id = $arr['content_profile_id'];
					$placement = $arr['placement'];
					$geotargeting = $arr['geotargeting'];
					$search_content = $arr['search_content'];
					$search_referral = $arr['search_referral'];
					$these_keywords = $arr['keywords'];
					$these_keywords = explode(',',$these_keywords);
					
					if ($geotargeting)
					{
						unset($geonomatch);
						if (!$geo_array)
						{
							$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
						}
						
						preg_match('/{(.*?)}/i',$geotargeting,$match);
					
						if ($match)
						{
							//print_r($match);
							//echo "<hr>";
							$newmatch = explode(":",$match[1]);
							//print_r($newmatch);
							//echo $newmatch[0];exit;
							//echo $geo_array["geoplugin_".$newmatch[0]];exit;
							if ($newmatch[0]=='areacode'){$newmatch[0]='areaCode';}
							else if ($newmatch[0]=='countrycode'){$newmatch[0]='countryCode';}
							else if ($newmatch[0]=='regioncode'){$newmatch[0]='regionCode';}
							if (strtolower($geo_array["geoplugin_".$newmatch[0]])==$newmatch[1])
							{
								//echo 1;exit;
							}
							else
							{
								//echo 2; exit;
								$geonomatch=1;
							}
						}
						
					}
					
					if ($geonomatch!=1)
					{
					
						$keys = array_keys($these_keywords);
						//print_r($these_keywords);
						$size = sizeOf($keys);
						
						for ($k=0; $k<$size; $k++)
						{
							if ($search_content==1)
							{
								//echo $content;exit;
								if ((stristr($content, $these_keywords[$k])||stristr($title, $these_keywords[$k])))
								{
									//echo 'yay'; exit;
									$query2= "UPDATE {$table_prefix}wptt_advertisements_keywords_profiles SET drop_count = (drop_count+1) WHERE id='{$profile_id}'";
									$result2 = mysql_query($query2);
									if (!$result2){echo $query2; echo mysql_error(); exit;}
									
									$query2 = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id = '{$content_profile_id}' ";
									$result2 = mysql_query($query2);
									if (!$result){echo $query2; echo mysql_error(); exit;}
									
									$array = mysql_fetch_array($result2);
									$ad_content = stripslashes($array['content']);
									
									$ad_content = advertisements_replace_tokens($ad_content,  $these_keywords[$k]);
									
									if ($placement=='above'&&!$above_exit)
									{
										$content = $ad_content.$content;
										$above_exit=1;
										$keywords_exit =1;
									}
									else if ($placement=='middle'&&!$middle_exit)
									{
										$count = strlen($content);
										$half =  $count/2;
										$left = substr($content, 0, $half);
										$right = substr($content, $half);
										$right = explode('. ',$right);
										$right[1] = $ad_content.$right[1];
										$right = implode('. ',$right);
										$content =  $left.$right;
										$middle_exit=1;
										$keywords_exit =1;
									}
									else if ($placement=='below'&&!$below_exit)
									{
										$content = $content.$ad_content;
										$below_exit=1;
										$keywords_exit =1;
									}	
									if ($placement=='widget_1'&&!$widget_1_exit)
									{										
										$_SESSION['wpt_ad_content_1'] = $ad_content;
										$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
										$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_1']);
										$widget_1_exit =1;
										$keywords_exit =1;
									}
									if ($placement=='widget_2'&&!$widget_2_exit)
									{
										$_SESSION['wpt_ad_content_2'] = $ad_content;
										$_SESSION['wpt_ad_content_2'] = str_replace('"',"'",$_SESSION['wpt_ad_content_2'] );
										$_SESSION['wpt_ad_content_2'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_2']);
										$keywords_exit =1;
										$widget_2_exit =1;
										//echo $_SESSION['wpt_ad_content_2'];exit;
									}
									if ($placement=='widget_3'&&!$$widget_3_exit)
									{
										$_SESSION['wpt_ad_content_3'] = $ad_content;
										$_SESSION['wpt_ad_content_3'] = str_replace('"',"'",$_SESSION['wpt_ad_content_3'] );
										$_SESSION['wpt_ad_content_3'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_3']);
										$keywords_exit =1;
										$widget_3_exit =1;
										
									}
									if ($placement=='widget_4'&&!$$widget_4_exit)
									{
										$_SESSION['wpt_ad_content_4'] = $ad_content;
										$_SESSION['wpt_ad_content_4'] = str_replace('"',"'",$_SESSION['wpt_ad_content_4'] );
										$_SESSION['wpt_ad_content_4'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_4']);
										$keywords_exit =1;
										$widget_4_exit =1;
									}
									if ($placement=='widget_5'&&!$$widget_5_exit)
									{
										$_SESSION['wpt_ad_content_5'] = $ad_content;
										$_SESSION['wpt_ad_content_5'] = str_replace('"',"'",$_SESSION['wpt_ad_content_5'] );
										$_SESSION['wpt_ad_content_5'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_5']);
										$keywords_exit =1;
										$widget_5_exit =1;
									}
									if ($placement=='widget_6'&&!$$widget_6_exit)
									{
										$_SESSION['wpt_ad_content_6'] = $ad_content;
										$_SESSION['wpt_ad_content_6'] = str_replace('"',"'",$_SESSION['wpt_ad_content_6'] );
										$_SESSION['wpt_ad_content_6'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_6']);
										$keywords_exit =1;
										$widget_6_exit =1;
									}
									
								}
							}
							
							if ($search_referral==1&&!$keywords_exit)
							{
								$referrer = $_SERVER['HTTP_REFERER'];
								$referrer = rawurldecode($referrer);
								
								if (stristr($referrer, $these_keywords[$k])&&!$exit)
								{
									//echo 2;exit;
									$query2= "UPDATE {$table_prefix}wptt_advertisements_keywords_profiles SET drop_count = (drop_count+1) WHERE id='{$profile_id}'";
									$result2 = mysql_query($query2);
									if (!$result2){echo $query2; echo mysql_error(); exit;}
									
									$query2 = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id = '{$content_profile_id}' ";
									$result2 = mysql_query($query2);
									if (!$result2){echo $query2; echo mysql_error(); exit;}
									
									$array = mysql_fetch_array($result2);
									$ad_content = stripslashes($array['content']);
									
									$ad_content = advertisements_replace_tokens($ad_content,  $these_keywords[$k]);
									
									if ($placement=='above'&&$above_exit!=1)
									{
										$content = $ad_content.$content;
										$above_exit=1;
										$keywords_exit = 1;
									}
									else if ($placement=='middle'&&$middle_exit!=1)
									{
										$count = strlen($content);
										$half =  $count/2;
										$left = substr($content, 0, $half);
										$right = substr($content, $half);
										$right = explode('. ',$right);
										$right[1] = $ad_content.$right[1];
										$right = implode('. ',$right);
										$content =  $left.$right;
										$middle_exit=1;
										$keywords_exit = 1;
									}
									else if ($placement=='below'&&$below_exit!=1)
									{
										$content = $content.$ad_content;
										$below_exit=1;
										$keywords_exit = 1;
									}
									else if ($placement=='widget_1'&&$widget_1_exit!=1)
									{
										$_SESSION['wpt_ad_content_1'] = $ad_content;
										$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
										$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_1']);
										$widet_1_exit = 1;
									}
									else if ($placement=='widget_2'&&$widget_2_exit!=1)
									{
										$_SESSION['wpt_ad_content_2'] = $ad_content;
										$_SESSION['wpt_ad_content_2'] = str_replace('"',"'",$_SESSION['wpt_ad_content_2'] );
										$_SESSION['wpt_ad_content_2'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_2']);
										$widet_2_exit = 2;
									}
									if ($placement=='widget_3'&&!$$widget_3_exit)
									{
										$_SESSION['wpt_ad_content_3'] = $ad_content;
										$_SESSION['wpt_ad_content_3'] = str_replace('"',"'",$_SESSION['wpt_ad_content_3'] );
										$_SESSION['wpt_ad_content_3'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_3']);
										$widget_3_exit =1;
										
									}
									if ($placement=='widget_4'&&!$$widget_4_exit)
									{
										$_SESSION['wpt_ad_content_4'] = $ad_content;
										$_SESSION['wpt_ad_content_4'] = str_replace('"',"'",$_SESSION['wpt_ad_content_4'] );
										$_SESSION['wpt_ad_content_4'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_4']);
										$widget_4_exit =1;
									}
									if ($placement=='widget_5'&&!$$widget_5_exit)
									{
										$_SESSION['wpt_ad_content_5'] = $ad_content;
										$_SESSION['wpt_ad_content_5'] = str_replace('"',"'",$_SESSION['wpt_ad_content_5'] );
										$_SESSION['wpt_ad_content_5'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_5']);
										$widget_5_exit =1;
									}
									if ($placement=='widget_6'&&!$$widget_6_exit)
									{
										$_SESSION['wpt_ad_content_6'] = $ad_content;
										$_SESSION['wpt_ad_content_6'] = str_replace('"',"'",$_SESSION['wpt_ad_content_6'] );
										$_SESSION['wpt_ad_content_6'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_6']);
										$widget_6_exit =1;
									}
									
								}
							}
						}	
					}
				}			
			}
			
			//check for category advertisements
			if ($google_exit!=1)
			{
				$cat = get_the_category();
				//print_r($cat_id);
				$cat_id = $cat[0]->cat_ID;
				$parent_cat_id = $cat[0]->category_parent;
				//echo $parent_cat_id;exit;
				//echo $cat_id;exit;
				//check this post id for a advertisement profile
				$query= "SELECT * FROM {$table_prefix}wptt_advertisements_category_profiles WHERE category_id='$cat_id' AND status>0";
				$result = mysql_query($query);
				if (!$result){echo $query; echo mysql_error(); exit;}
				$count = mysql_num_rows($result);
				
			
				
				if ($count<1)
				{
					
					$query= "SELECT * FROM {$table_prefix}wptt_advertisements_category_profiles WHERE category_id='$parent_cat_id' AND status>0";
					$result = mysql_query($query);
					if (!$result){echo $query; echo mysql_error(); exit;}
				}
				
				while ($arr=mysql_fetch_array($result))
				{
					//print_r($arr);exit;
					$profile_id = $arr['id'];
					$content_profile_id = $arr['content_profile_id'];
					$placement = $arr['placement'];
					$geotargeting = $arr['geotargeting'];
					$status = $arr['status'];
							
					if ($geotargeting)
					{
						unset($geonomatch);
						if (!$geo_array)
						{
							$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
						}
						
						preg_match('/{(.*?)}/i',$geotargeting,$match);
					
						//print_r($geo_array);
						
						if ($match)
						{
							//print_r($match);exit;
							//echo "<hr>";
							$newmatch = explode(":",$match[1]);
							//print_r($newmatch);
							//echo $newmatch[0];exit;
							if ($newmatch[0]=='areacode'){$newmatch[0]='areaCode';}
							else if ($newmatch[0]=='countrycode'){$newmatch[0]='countryCode';}
							else if ($newmatch[0]=='regioncode'){$newmatch[0]='regionCode';}
							//echo $geo_array["geoplugin_".$newmatch[0]];
							if (strtolower($geo_array["geoplugin_".$newmatch[0]])==$newmatch[1])
							{
								//echo 1; exit;
							}
							else
							{
								$geonomatch=1;
							}
						}
						
					}
					
					if ($geonomatch!=1)
					{
						//echo 'yay'; 
						$query2= "UPDATE {$table_prefix}wptt_advertisements_category_profiles SET drop_count = (drop_count+1) WHERE id='{$profile_id}'";
						$result2 = mysql_query($query2);
						if (!$result2){echo $query2; echo mysql_error(); exit;}
										
						$query2 = "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id = '{$content_profile_id}' ";
						$result2 = mysql_query($query2);
						if (!$result){echo $query2; echo mysql_error(); exit;}
										
						$array = mysql_fetch_array($result2);
						$ad_content = stripslashes($array['content']);
										
						$ad_content = advertisements_replace_tokens($ad_content, $google_query);
								
						//echo $ad_content; exit;
						
						
						if ($placement=='above'&&!$above_exit)
						{
							//echo 1;exit;
							$content = $ad_content.$content;
							$above_exit = 1;
							
						}
						else if ($placement=='middle'&&!$middle_exit)
						{
							$count = strlen($content);
							$half =  $count/2;
							$left = substr($content, 0, $half);
							$right = substr($content, $half);
							$right = explode('. ',$right);
							$right[1] = $ad_content.$right[1];
							$right = implode('. ',$right);
							$content =  $left.$right;
							$middle_exit = 1;
							
						}
						else if ($placement=='below'&&!$below_exit) 
						{
							$content = $content.$ad_content;
							$below_exit=1;
						}
						else if ($placement=='widget_1'&&!$widget_1_exit)
						{
							$_SESSION['wpt_ad_content_1'] = $ad_content;
							$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
							$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_1']);
							$widget_1_exit = 1;
						}
						else if ($placement=='widget_2'&&!$widget_2_exit) 
						{
							$_SESSION['wpt_ad_content_2'] = $ad_content;
							$_SESSION['wpt_ad_content_2'] = str_replace('"',"'",$_SESSION['wpt_ad_content_2'] );
							$_SESSION['wpt_ad_content_2'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_2']);
							$widget_2_exit = 1;
						}
						if ($placement=='widget_3'&&!$$widget_3_exit)
						{
							$_SESSION['wpt_ad_content_3'] = $ad_content;
							$_SESSION['wpt_ad_content_3'] = str_replace('"',"'",$_SESSION['wpt_ad_content_3'] );
							$_SESSION['wpt_ad_content_3'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_3']);
							$widget_3_exit = 1;
							
						}
						if ($placement=='widget_4'&&!$$widget_4_exit)
						{
							$_SESSION['wpt_ad_content_4'] = $ad_content;
							$_SESSION['wpt_ad_content_4'] = str_replace('"',"'",$_SESSION['wpt_ad_content_4'] );
							$_SESSION['wpt_ad_content_4'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_4']);
							$widget_4_exit =1;
						}
						if ($placement=='widget_5'&&!$$widget_5_exit)
						{
							$_SESSION['wpt_ad_content_5'] = $ad_content;
							$_SESSION['wpt_ad_content_5'] = str_replace('"',"'",$_SESSION['wpt_ad_content_5'] );
							$_SESSION['wpt_ad_content_5'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_5']);
							$widget_5_exit = 1;
						}
						if ($placement=='widget_6'&&!$$widget_6_exit)
						{
							$_SESSION['wpt_ad_content_6'] = $ad_content;
							$_SESSION['wpt_ad_content_6'] = str_replace('"',"'",$_SESSION['wpt_ad_content_6'] );
							$_SESSION['wpt_ad_content_6'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_6']);
							$widget_6_exit = 1;
						}
					}
				}
			}
			
		}
		else
		{
			//check this post id for a advertisement profile
			$query= "SELECT * FROM {$table_prefix}wptt_advertisements_post_profiles WHERE post_id = 'h' LIMIT 9";
			$result = mysql_query($query);
			if (!$result){echo $query; echo mysql_error(); exit;}
			$count = mysql_num_rows($result);
			
			while ($arr = mysql_fetch_array($result))
			{
				//echo 1;exit;
				$profile_id = $arr['id'];
				$content_profile_id = $arr['content_profile_id'];
				$placement = $arr['placement'];
				$geotargeting = $arr['geotargeting'];
				
				if ($geotargeting)
				{
					unset($geonomatch);
					if (!$geo_array)
					{
						$geo_array = unserialize(traffic_tools_remote_connect('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
					}
					
					preg_match('/{(.*?)}/i',$geotargeting,$match);
				
					//print_r($geo_array);
					
					if ($match)
					{
						//print_r($match);exit;
						//echo "<hr>";
						$newmatch = explode(":",$match[1]);
						//print_r($newmatch);
						//echo $newmatch[0];exit;
						if ($newmatch[0]=='areacode'){$newmatch[0]='areaCode';}
						else if ($newmatch[0]=='countrycode'){$newmatch[0]='countryCode';}
						else if ($newmatch[0]=='regioncode'){$newmatch[0]='regionCode';}
						//echo $geo_array["geoplugin_".$newmatch[0]];
						if (strtolower($geo_array["geoplugin_".$newmatch[0]])==$newmatch[1])
						{
							//echo 1; exit;
						}
						else
						{
							//echo 1; exit;
							$geonomatch=1;
						}
					}
					
				}
				
				if ($geonomatch!=1)
				{
					//echo 2; exit;
					$query2= "UPDATE {$table_prefix}wptt_advertisements_post_profiles SET drop_count = (drop_count+1) WHERE id='{$profile_id}'";
					$result2 = mysql_query($query2);
					if (!$result2){echo $query; echo mysql_error(); exit;}
					
					$query2= "SELECT * FROM {$table_prefix}wptt_advertisements_content_profiles WHERE id = '{$content_profile_id}' ";
					$result2 = mysql_query($query2);
					if (!$result2){echo $query2; echo mysql_error(); exit;}
					
					$arr = mysql_fetch_array($result2);
					$ad_content = stripslashes($arr['content']);
					//echo $ad_content;exit;
					$ad_content = advertisements_replace_tokens($ad_content,  $google_query );
					
					if ($placement=='above'&&$exit!=1)
					{
						$content = $ad_content.$content;
						$exit = 1;
					}
					else if ($placement=='middle'&&$exit!=1)
					{
						$count = strlen($content);
						$half =  $count/2;
						$left = substr($content, 0, $half);
						$right = substr($content, $half);
						$right = explode('. ',$right);
						$right[1] = $ad_content.$right[1];
						$right = implode('. ',$right);
						$content =  $left.$right;
						$exit = 1;
					}
					else if ($placement=='below'&&$exit!=1)
					{
						$content = $content.$ad_content;
						$exit = 1;
					}
					else if ($placement=='widget_1')
					{
						$_SESSION['wpt_ad_content_1'] = $ad_content;
						$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
						$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_1']);
						//echo $ad_content;exit;
						//echo $_SESSION['wpt_ad_content_1'];exit;
					}
					else if ($placement=='widget_1'&&!$widget_1_exit)
					{
						$_SESSION['wpt_ad_content_1'] = $ad_content;
						$_SESSION['wpt_ad_content_1'] = str_replace('"',"'",$_SESSION['wpt_ad_content_1'] );
						$_SESSION['wpt_ad_content_1'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_1']);
					}
					else if ($placement=='widget_2'&&!$widget_2_exit) 
					{
						$_SESSION['wpt_ad_content_2'] = $ad_content;
						$_SESSION['wpt_ad_content_2'] = str_replace('"',"'",$_SESSION['wpt_ad_content_2'] );
						$_SESSION['wpt_ad_content_2'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_2']);
					}
					else if ($placement=='widget_3'&&!$$widget_3_exit)
					{
						$_SESSION['wpt_ad_content_3'] = $ad_content;
						$_SESSION['wpt_ad_content_3'] = str_replace('"',"'",$_SESSION['wpt_ad_content_3'] );
						$_SESSION['wpt_ad_content_3'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_3']);
						
					}
					else if ($placement=='widget_4'&&!$$widget_4_exit)
					{
						$_SESSION['wpt_ad_content_4'] = $ad_content;
						$_SESSION['wpt_ad_content_4'] = str_replace('"',"'",$_SESSION['wpt_ad_content_4'] );
						$_SESSION['wpt_ad_content_4'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_4']);
						$keywords_exit =1;
						$widget_4_exit =1;
					}
					else if ($placement=='widget_5'&&!$$widget_5_exit)
					{
						$_SESSION['wpt_ad_content_5'] = $ad_content;
						$_SESSION['wpt_ad_content_5'] = str_replace('"',"'",$_SESSION['wpt_ad_content_5'] );
						$_SESSION['wpt_ad_content_5'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_5']);
					}
					else if ($placement=='widget_6'&&!$$widget_6_exit)
					{
						$_SESSION['wpt_ad_content_6'] = $ad_content;
						$_SESSION['wpt_ad_content_6'] = str_replace('"',"'",$_SESSION['wpt_ad_content_6'] );
						$_SESSION['wpt_ad_content_6'] = str_replace(array("\r", "\r\n", "\n"), ' _nl_  ', $_SESSION['wpt_ad_content_6']);
					}
				}
			}
		}
		return $content;
	}
	
	function advertisments_add_jquery() 
	{
		?>
		<script type='text/javascript'>
		jQuery(document).ready(function() 
		{			
			var html_1 = "<?php echo str_replace(array('<script','</script>'), array('<scr"+"ipt', '</scr"+"ipt>'), $_SESSION['wpt_ad_content_1']); ?>";
			if (html_1)
			{				
				
				html_1 = html_1.replace(/ _nl_ /g,"\n");				
				jQuery('#id_wpt_adblock_1').html(html_1);
			}
			var html_2 = "<?php echo str_replace(array('<script ','</script>'), array('<scr"+"ipt ', '</scr"+"ipt>'), $_SESSION['wpt_ad_content_2']); ?>";
			if (html_2)
			{
				html_2 = html_2.replace(/ _nl_ /g,"\n");
				jQuery('#id_wpt_adblock_2').html(html_2);
			}
			
			var html_3 = "<?php echo str_replace(array('<script ','</script>'), array('<scr"+"ipt ', '</scr"+"ipt>'), $_SESSION['wpt_ad_content_3']); ?>";
			if (html_3)
			{
				html_3 = html_3.replace(/ _nl_ /g,"\n");
				jQuery('#id_wpt_adblock_3').html(html_3);
			}
			
			var html_4 = "<?php echo str_replace(array('<script ','</script>'), array('<scr"+"ipt ', '</scr"+"ipt>'), $_SESSION['wpt_ad_content_4']); ?>";
			if (html_4)
			{
				html_4 = html_4.replace(/ _nl_ /g,"\n");
				jQuery('#id_wpt_adblock_4').html(html_4);
			}
			
			var html_5 = "<?php echo str_replace(array('<script ','</script>'), array('<scr"+"ipt>', '</scr"+"ipt>'), $_SESSION['wpt_ad_content_5']); ?>";
			if (html_5)
			{
				html_5 = html_5.replace(/ _nl_ /g,"\n");
				jQuery('#id_wpt_adblock_5').html(html_5);
			}
			
			var html_6 = "<?php echo str_replace(array('<script ','</script>'), array('<scr"+"ipt ', '</scr"+"ipt>'), $_SESSION['wpt_ad_content_6']); ?>";
			if (html_6)
			{
				html_6 = html_6.replace(/ _nl_ /g,"\n");
				jQuery('#id_wpt_adblock_6').html(html_6);
			}
		});
		</script>
		<?php
	}

	/*
	//on activation
	register_activation_hook(__FILE__, 'advertisements_activate');
	add_action('admin_menu', 'advertisements_add_menu');
	*/
	add_action('edit_post','advertisements_save_post');
	add_filter('the_content', 'advertisements_add_post_content', 0);
	add_action('get_footer', 'advertisments_add_jquery');
	
?>