<?php 
/*
Plugin Name: Ciusan Simple Statistics
Plugin URI: http://plugin.ciusan.com/66/ciusan-simple-statistics/
Description: Show simple statistics
Author: Dannie Herdyawan
Version: 1.0
Author URI: http://www.ciusan.com/
*/

/*
   _____                                                 ___  ___
  /\  __'\                           __                 /\  \/\  \
  \ \ \/\ \     __      ___     ___ /\_\     __         \ \  \_\  \
   \ \ \ \ \  /'__`\  /' _ `\ /` _ `\/\ \  /'__'\        \ \   __  \
    \ \ \_\ \/\ \L\.\_/\ \/\ \/\ \/\ \ \ \/\  __/    ___  \ \  \ \  \
     \ \____/\ \__/.\_\ \_\ \_\ \_\ \_\ \_\ \____\  /\__\  \ \__\/\__\
      \/___/  \/__/\/_/\/_/\/_/\/_/\/_/\/_/\/____/  \/__/   \/__/\/__/

*/


class ciusan_simple_statistics extends WP_Widget {

	// constructor
	function __construct() {
		parent::__construct(
			'ciusan_simple_statistics', // Base ID
			__('Ciusan Simple Statistics', 'Ciusan'), // Name
			array('description' => __('Show simple statistics.', 'Ciusan'),) // Args
		);
	}

	// widget form creation
	function form($instance) {
		$title = $instance['title'];
?>
		<p>
        	<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
            	<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
            </label>
		</p>
<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		return $instance;
	}

	// widget display
	function widget($args, $instance) {
		extract($args, EXTR_SKIP);
		global $wpdb;
		$total_registered	= $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
		$total_posts		= $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type='post' AND post_status='publish'");
		$total_comments		= wp_count_comments();
		$title = $instance['title'];

		echo $before_widget;
		if ($title) {
			echo $before_title . $title . $after_title;
			echo '<ul>';
			echo '<li>Total Registered Users</li>';
				echo '<li style="font-size:xx-large !important;">&nbsp;'.$total_registered.'</li>';
			echo '<li>Total Posts</li>';
				echo '<li style="font-size:xx-large !important;">&nbsp;'.$total_posts.'</li>';
			echo '<li>Total Comments</li>';
				echo '<li style="font-size:xx-large !important;">&nbsp;'.$total_comments->approved.'</li>';
			echo '</ul>';
		} else {
			echo $before_title . 'Ciusan Simple Statistics' . $after_title;
			echo '<ul>';
			echo '<li>Total Registered Users</li>';
				echo '<li style="font-size:xx-large !important;">&nbsp;'.$total_registered.'</li>';
			echo '<li>Total Posts</li>';
				echo '<li style="font-size:xx-large !important;">&nbsp;'.$total_posts.'</li>';
			echo '<li>Total Comments</li>';
				echo '<li style="font-size:xx-large !important;">&nbsp;'.$total_comments->approved.'</li>';
			echo '</ul>';
		}
		echo $after_widget;
	}
}
// register widget
add_action('widgets_init', create_function('', 'return register_widget("ciusan_simple_statistics");'));

// total registered
function ciusan_total_registered() {
	global $wpdb;
	return $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->users");
}
// registee total register shortcode
add_shortcode('ciusan_total_registered', 'ciusan_total_registered');

// total posts
function ciusan_total_posts() {
	global $wpdb;
	return $wpdb->get_var("SELECT COUNT(ID) FROM $wpdb->posts WHERE post_type='post' AND post_status='publish'");
}
// register total posts shortcode
add_shortcode('ciusan_total_posts', 'ciusan_total_posts');

// total comments
function ciusan_total_comments() {
	global $wpdb;
	$total_comments_count = wp_count_comments();
	return $total_comments_count->approved;
}
// register totalcomments shortcode
add_shortcode('ciusan_total_comments', 'ciusan_total_comments');
?>