<?php
/*
Plugin Name: My Twitter Ticker
Plugin URI: http://www.webdev3000.com/
Description: Wordpress port of very nice Twitter Ticker from Tutorialzine.com powered by jQuery & Twitter’s Search API.
Author: Csaba Kissi
Version: 0.8.0
Author URI: http://www.webdev3000.com/
*/
class MyTwitterTicker_widget extends WP_Widget {


    function MyTwitterTicker_widget() {
        parent::WP_Widget(false,$name = 'My Twitter Ticker');
    }

    function widget($args, $instance) {
        if ( ! $this->instance ) {
                    $this->instance = true;
        }
        extract( $args );
        $title 		= apply_filters('widget_title', $instance['title']);
        $tweet_users = $instance['tweet_users'];
        $tweet_num	= $instance['tweet_num'];
        $enable_img = $instance['enable_img'];

        ?>
            <?php echo $before_widget; ?>
             <div id="twitter-ticker">
        	    <div id="top-bar">
                    <?php if($enable_img) { ?>
         	        <div id="twitIcon"><img src="<?php echo plugins_url('img/twitter_64.png',__FILE__);?>" width="64" height="64" alt="Twitter icon" /></div>
                    <?php } ?>
	                <h2 class="tut"><?php if ( $title ) echo $title; ?></h2>
	            </div>
	            <div id="tweet-container"><img id="loading" src="<?php echo plugins_url('img/loading.gif',__FILE__)?>" width="16" height="11" alt="Loading.." /></div>
	            <div id="scroll"></div>
	        </div>
           <?php echo $after_widget; ?>
        <?php
    }

    /** @see WP_Widget::update -- do not rename this */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
		$instance['tweet_users'] = strip_tags($new_instance['tweet_users']);
        $instance['tweet_num'] = strip_tags($new_instance['tweet_num']);
        $instance['enable_img'] = ( isset( $new_instance['enable_img'] ) ? 1 : 0 );
		return $instance;
    }

    /** @see WP_Widget::form -- do not rename this */
    function form($instance) {
        $title = empty($instance['title']) ? 'My Tweets' : esc_attr($instance['title']);
        $tweet_users = empty($instance['tweet_users']) ? 'mashable,TechCrunch' : esc_attr($instance['tweet_users']);
        $tweet_num =   empty($instance['tweet_num']) ? '20' : esc_attr($instance['tweet_num']);
        $enable_img =   isset($instance['enable_img']) ? $instance['enable_img'] : 1;

        ?>
         <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
         <p>
          <label for="<?php echo $this->get_field_id('tweet_users'); ?>"><?php _e('Tweet Users:'); ?></label>
          <input class="widefat" id="<?php echo $this->get_field_id('tweet_users'); ?>" name="<?php echo $this->get_field_name('tweet_users'); ?>" type="text" value="<?php echo $tweet_users; ?>" />
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('tweet_num'); ?>"><?php _e('Number of Tweets:'); ?></label>
          <input id="<?php echo $this->get_field_id('tweet_num'); ?>" name="<?php echo $this->get_field_name('tweet_num'); ?>" type="text" value="<?php echo $tweet_num; ?>" />
        </p>
        <p>
        <input class="checkbox" type="checkbox" <?php checked( $enable_img, true ); ?> id="<?php echo $this->get_field_id( 'enable_img' ); ?>" name="<?php echo $this->get_field_name( 'enable_img' ); ?>" />
        <label for="<?php echo $this->get_field_id( 'enable_img' ); ?>">Enable Image?</label>
        </p>
        <?php
    }


} // End of Class

function my_twitter_ticker_stylesheet() {
    wp_enqueue_style('twitter-ticker', plugins_url('css/twitter-ticker.css',__FILE__));
    wp_enqueue_style('jScrollPane', plugins_url('css/jScrollPane.css',__FILE__));
}
function my_twitter_ticker_scripts() {
   wp_register_script('jquery.mousewheel', plugins_url('js/jquery.mousewheel.js', __FILE__), array('jquery'), '1.3');
   wp_enqueue_script('jquery.mousewheel');
   wp_enqueue_script('jScrollPane', plugins_url('/js/jScrollPane.js',__FILE__), array('jquery'), '1.3');
   wp_enqueue_script('twitter-ticker', plugins_url('/js/twitter-ticker.js',__FILE__), array('jquery'), '1.3');
}

function my_twitter_ticker_print_script() {
    $option = get_option('widget_mytwitterticker_widget');
    foreach($option as $opt) {
        if(isset($opt['tweet_users'])) {
            $users = explode(',',$opt['tweet_users']);
            foreach($users as $user) {
               $users_new .= "'$user',";
            }
            $users_new = substr($users_new,0,-1);
            $tweet_num = $opt['tweet_num'];
            if($tweet_num < 0) $tweet_num = 20;
        }
    }
?>
<script type="text/javascript">
  var tweetUsers = [<?php echo $users_new; ?>];
  var tweetNum = <?php echo $tweet_num; ?>;
</script>
<?
}
add_action('wp_print_scripts','my_twitter_ticker_print_script');
add_action('widgets_init', create_function('', 'return register_widget("MyTwitterTicker_widget");'));
add_action('wp_print_styles', 'my_twitter_ticker_stylesheet');
add_action('wp_enqueue_scripts', 'my_twitter_ticker_scripts');
?>