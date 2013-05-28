<?php

/*
Plugin Name: WP Stock Ticker
Plugin URI: http://HelpForWP.com
Description: A jquery based stock ticker using data from Yahoo finance via YQL (Yahoo Query Language). The ticker will display stock prices, commodities as well as currency exchange rates.
Version: 2.4.3
Author: HelpForWP
Author URI: http://HelpForWP.com

------------------------------------------------------------------------

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, 
or any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA

*/


require_once('WPStockTickerWidget.php');

class WPStockTicker {

  public function __construct() {

    if ( is_admin() ) {
		add_action( 'wp_ajax_nopriv_stock-ticker', array(&$this, 's_ticker') );
		add_action( 'wp_ajax_stock-ticker', array(&$this, 's_ticker') );
		require 'inc/s_ticker-options.php';
				
		add_action('admin_menu', array($this, 's_ticker_menu'));
		add_action('admin_init', array($this, 'register_s_ticker_settings') );
    }

    if( !is_admin() ) {
      add_action('init', array(&$this, 's_ticker_register_styles'));
      add_action('wp_print_styles', array(&$this, 's_ticker_enqueue_styles'));
      add_shortcode('s_ticker_display', array(&$this, 's_table_shortcode') );
    }

    add_action('update_option_s_ticker_stock_codes', array(&$this, 's_ticker_remove_transient'));
	add_action('update_option_s_ticker_currency_codes', array(&$this, 's_ticker_remove_transient'));

    //add_action('init', array(&$this, 's_ticker_register_scripts'));
    add_action('wp_print_scripts', array(&$this, 's_ticker_enqueue_scripts'));

	register_uninstall_hook( __FILE__, 'WPStockTicker::s_ticker_deinstall' );

	register_activation_hook( __FILE__, array( &$this, 's_ticker_activate' ) );
	register_deactivation_hook( __FILE__, array( &$this, 's_ticker_deactivate' ) );


  }


  function s_ticker_register_scripts() {
    wp_register_script('li-scroller', plugins_url('js/jquery.li-scroller.1.0.js', __FILE__));
  }
  
  function s_ticker_enqueue_scripts() {
  	if ( is_admin() ) {
		wp_enqueue_script( 'wp-stock-ticker', plugin_dir_url( __FILE__ ) . 'js/wp-stock-ticker-admin.js', array( 'jquery' ) );
		wp_localize_script( 
		  'wp-stock-ticker',
		  's_ticker',
		  array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'stNonce' => wp_create_nonce( 'stock-ticker-nonce' ),
		  )  
		); 
	}else{
		wp_enqueue_script( 'li-scroller', plugin_dir_url( __FILE__ ) . 'js/jquery.li-scroller.1.0.js', array('jquery') );
		wp_enqueue_script( 'wp-stock-ticker', plugin_dir_url( __FILE__ ) . 'js/wp-stock-ticker.js', array('jquery', 'li-scroller') );
	}
  }

  function s_ticker_register_styles() {
    wp_register_style('stockticker_style', plugins_url('css/wp-stock-ticker.css', __FILE__));
  }

  function s_ticker_enqueue_styles() {
    wp_enqueue_style( 'stockticker_style');
  }
  

  function s_ticker() {
    
    $nonce = $_REQUEST['stNonce'];
    
    if ( !wp_verify_nonce( $nonce, 'stock-ticker-nonce' ) ) {
        die('Busted!');
    }

    exit();

  }

function s_ticker_activate() {
		$current_options =	get_option('s_ticker_stock_codes');
		if(!$current_options){
			$s_default_codes = array('^NDX','^FTSE','^AORD','^AXJO');
			update_option('s_ticker_stock_codes', $s_default_codes );
		}
		$current_options =	get_option('s_ticker_stock_names');
		if(!$current_options){
			$s_default_stock_names= array('','','','');
			update_option('s_ticker_stock_names', $s_default_stock_names );
		}
		
		//for currency
		$current_options =	get_option('s_ticker_currency_codes');
		if(!$current_options){
			$s_default_currency_codes = array('AUDUSD=X','USDJPY=X');
			update_option('s_ticker_currency_codes', $s_default_currency_codes );
		}
		$current_options =	get_option('s_ticker_currency_names');
		if(!$current_options){
			$s_default_currency_names= array('','');
			update_option('s_ticker_currency_names', $s_default_currency_names );
		}
		$this->s_ticker_remove_transient();
}


function s_ticker_deactivate(){
	$this->s_ticker_remove_transient();
}


  public static function s_ticker_deinstall() {
    global $wpdb;

    if (function_exists('is_multisite') && is_multisite()) {
    // check if it is a network activation - if so, run the activation function for each blog id
      if (isset($_GET['networkwide']) && ($_GET['networkwide'] == 1)) {
        $old_blog = $wpdb->blogid;
        // Get all blog ids
        $blogids = $wpdb->get_col($wpdb->prepare("SELECT blog_id FROM $wpdb->blogs"));
        foreach ($blogids as $blog_id) {
          switch_to_blog($blog_id);
          WPStockTicker::s_ticker_run_uninstall();
        }
        switch_to_blog($old_blog);
        return;
      } 
    }
    WPStockTicker::s_ticker_run_uninstall();
    return;

  }
  public static function s_ticker_run_uninstall() {
    //delete_option('s_ticker_stock_codes');
    //delete_option('s_ticker_stock_names');	
	//delete_option('s_ticker_currency_codes');
    //delete_option('s_ticker_currency_names');	
    //delete_option('_transient_timeout_s_ticker');
    return;
  }

	function register_s_ticker_settings() {
		register_setting( 's_ticker-settings', 's_ticker_stock_codes' );
		register_setting( 's_ticker-settings', 's_ticker_stock_names' );
		register_setting( 's_ticker-settings', 's_ticker_currency_codes' );
		register_setting( 's_ticker-settings', 's_ticker_currency_names' );
		
		//when it come to call the call the callback function of the follow. All above options saved alaready
		register_setting( 's_ticker-settings', 's_ticker_call_option_process_fun', array($this, 's_ticker_option_process') );	
	}
	function s_ticker_menu() {
		add_options_page('WP-Stock-Ticker', 'WP Stock Ticker', 'manage_options', 's_ticker-options', 's_ticker_options');
	}

	
  function s_ticker_remove_transient() {
    delete_option('_transient_s_ticker');
    delete_option('_transient_timeout_s_ticker');
  }

  function s_ticker_display() {
    $html = $this->s_table_shortcode(null, 'INTERFACE');
    return $html;
  }

  function s_ticker_show_widget( $widgetID ) {
    $html = $this->s_table_shortcode(null, 'WIDGET:'.$widgetID );
    return $html;
  }
  
	function s_ticker_option_process(){
		$saved_stocks = get_option('s_ticker_stock_codes');
		$saved_stock_names = get_option('s_ticker_stock_names');
		$saved_currency_codes = get_option('s_ticker_currency_codes');
		$saved_currency_names = get_option('s_ticker_currency_names');
		
		//remove null value
		if ($saved_stocks){
			$stockNameRelAry = array();
			foreach($saved_stocks as $key => $stock){
				if (!$stock){
					unset($saved_stocks[$key]);
					unset($saved_stock_names[$key]); //remove same index from names array
				}
				$stockNameRelAry[strtoupper($stock)] = $saved_stock_names[$key];
			}
			update_option('s_ticker_stock_codes', $saved_stocks);
			update_option('s_ticker_stock_names', $stockNameRelAry);
		}
		if ($saved_currency_codes){
			$currencyNameRelAry = array();
			foreach($saved_currency_codes as $key => $currency){
				if (!$currency){
					unset($saved_currency_codes[$key]);
					unset($saved_currency_names[$key]); //remove same index from names array
				}
				$currencyNameRelAry[strtoupper($currency)] = $saved_currency_names[$key];
			}
			update_option('s_ticker_currency_codes', $saved_currency_codes);
			update_option('s_ticker_currency_names', $currencyNameRelAry);
		}
	
    }

  function s_table_shortcode($attrib, $calledBy){

	$saved_stocks = get_option('s_ticker_stock_codes');
	$saved_stock_names_rel = get_option('s_ticker_stock_names');
	$saved_currency_codes = get_option('s_ticker_currency_codes');
	$saved_currency_names_rel = get_option('s_ticker_currency_names');
	
	//merge two array
	if ($saved_stock_names_rel && $saved_currency_names_rel){
		$mergedNames = array_merge($saved_stock_names_rel, $saved_currency_names_rel);
	}else{
		$mergedNames = $saved_stock_names_rel ? $saved_stock_names_rel : $saved_currency_names_rel;
	}
	
	$res = get_transient('s_ticker');
	if ($res === false){
    	$res = $this->get_live_data($saved_stocks, $saved_currency_codes);
	}
	
    $attrib = shortcode_atts(array(), $attrib);
    
    $output = '';
	$className = 'stocks';
    if(is_array($res)) {
	
	  $idStr = '';
	  if(strpos($calledBy, 'WIDGET') !== false){
	  	$widgetAttsArray = explode(':', $calledBy);
		$idStr = 'stocks-by-widget-'.$widgetAttsArray[1];
		$className = 'stocksTickerWidget';
	  }else if ($calledBy == 'INTERFACE'){
	  	$idStr = 'stocks-by-interface';
	  }else{
	  	$idStr = 'stocks-by-shortcode';
	  }
	  
      $output .= '<div class="stocks-container"><ul id="'.$idStr.'"  class="'.$className.'">';
      foreach($res as $key => $r) {
	  		if (strlen($mergedNames[$r->symbol]) > 0){
				$output .= '<li><strong>' . $mergedNames[$r->symbol] . '</strong>';
				}else{
					$output .= '<li><strong>' . $r->symbol . '</strong>';
				}
	
				if ($saved_currency_codes && in_array($r->symbol, $saved_currency_codes)){
					$output .= '<span class="currency">';
					$output .= $r->ask . '</span></li>';
				}else{
					if ( preg_match("/\+/",strval($r->change))  ){
						$output .= '<span class="stockup">';
					}else{
						$output .= '<span class="stockdown">';
					}
					$output .= $r->ask . '</span>';
				
					if ( preg_match("/\+/",strval($r->change))  ){
						$output .= '<span class="stockup">';
					}else{
						$output .= '<span class="stockdown">';
					}
		
					$output .=  $r->change . '</span></li>';  
				}
      }
  	  $output .= '<li></li>';
		
	  $output .= '</ul></div>';
	  
	  //output scroller activate codes here.
	  return trim($output);
	}else {
		$output .= $res;
		return $output;
	}

  }
  
  

	function get_live_data($stock_array, $currency_array) {
		
		if (count($stock_array) > 5){
			$i = 0;
			foreach($stock_array as $key => $val){
				$i++;
				if ($i > 5){
					unset($stock_array[$key]);
				}
			}
		}
		if (count($currency_array) > 5){
			$i = 0;
			foreach($currency_array as $key => $val){
				$i++;
				if ($i > 5){
					unset($currency_array[$key]);
				}
			}
		}

		$stock_array_str = $stock_array ? implode('","', $stock_array) : '';
		$currency_array_str = $currency_array ? implode('","', $currency_array) : '';
		
		if ($stock_array_str && $currency_array_str){
			$strMerged = $stock_array_str .'","'. $currency_array_str;
		}else{
			$strMerged = $stock_array_str ? $stock_array_str : $currency_array_str;
		}
		if (!$strMerged) return array();

		$sql = 'select * from yahoo.finance.quotes where symbol in ("' . $strMerged .'")';
		$url = 'http://query.yahooapis.com/v1/public/yql?q=' . urlencode($sql) . '&format=json&env=store%3A%2F%2Fdatatables.org%2Falltableswithkeys';
	
    	$objarr = array();

		$dat = wp_remote_get($url);
		if ( is_wp_error($dat) ) {
			//get week long transient data
			$objarr = get_transient('s_ticker_week_long_data');
			if (!$objarr || !is_array($objarr)){
				return "Yahoo finance API is not available right now, please try again soon...";
			}
			
			return $objarr;
		}else{
			$data = json_decode(wp_remote_retrieve_body($dat));
		}
		
		if ( !is_null($data) && isset($data->error) ){
			if ( $data->error ) return "Yahoo finance API is not available right now, please try again soon...";
		}

		if (!is_null($data->query->results)){
			if(is_array($data->query->results->quote)) { //more than one symbol
				foreach($data->query->results->quote as $q) {
					$obj = new stdClass;
					$obj->symbol = $q->symbol;
					$obj->ask = $q->LastTradePriceOnly;
					$obj->change = $q->Change_PercentChange;
					
					$objarr[$obj->symbol] = $obj;
				}
			}else{
				$obj = new stdClass;
				$obj->symbol = $data->query->results->quote->symbol;
				$obj->ask = $data->query->results->quote->LastTradePriceOnly;
				$obj->change = $data->query->results->quote->Change_PercentChange;
				
				$objarr[$obj->symbol] = $obj;
			}
			set_transient('s_ticker_week_long_data', $objarr, 7*60*60*24);
			set_transient('s_ticker', $objarr, 60*60*24);
		}else{
			$objarr = get_transient('s_ticker_week_long_data');
			if (!$objarr || !is_array($objarr)){
				return "Yahoo finance API is not available right now, please try again soon...";
			}
		}

	    return $objarr; 
	}
}
	
$wp_stock_ticker = new WPStockTicker();

// register widget
add_action( 'widgets_init', create_function( '', 'register_widget( "WPStockerWidget" );' ) );