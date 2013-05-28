<?php

// ********** OPTIONS PAGE **********
// **********************************

function s_ticker_options() {
  
  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  
?>
  
  <div class="wrap">
	<img src="<?PHP echo plugins_url(); ?>/wp-stock-ticker/images/help-for-wordpress-small.png" align="left"/>
    <h2>WP Stock Ticker</h2>
    <p>Use the settngs below to manage the stock market codes and indices.</p> 
	<p>The plugin pulls data from Yahoo! Finance so any correctly
 	formatted code from there will work with this plugin.</p>
	
    <p>Click <a href="" class="label success" id="add_admin_stock_field">add Stock</a> to add another field for a new code.</p>
    
    <form action="options.php" method="POST" id="stock_ticker">
    <?php settings_fields( 's_ticker-settings' ); ?>

      <h4>Stock Settings</h4>
      <table class="form-table" id="stock_value_table">

        <thead>
          <tr>
            <th>Ticker Symbol</th>
            <th>Ticker Name</th>
          </tr>
        </thead>         

        <tbody id="st_options_body">

          <?php


          if($values = get_option('s_ticker_stock_codes')) {
            //print '<pre>'.print_r($values, true).'<pre>'; die();
			$stockNames = get_option('s_ticker_stock_names');
			$i = 0;
            foreach($values as $val) {
			  
		  	  $stockName = $stockNames ? $stockNames[strtoupper($val)] : '';
			  $i++;
			  if ($i > 5) continue;
              echo trim('
                <tr valign="top" class="stock_ticker_row">
                  <td><input type="text" class="st_symbol" name="s_ticker_stock_codes[]" value="'. $val .'" /></td>
				  <td><input type="text" class="st_symbol" name="s_ticker_stock_names[]" value="'. $stockName .'" /></td>
                  <td><a href="" class="label delete" id="delete_admin_stock">delete</a></td>
                </tr>
              ');
            }
          }
          ?> 
                 
        </tbody>

      </table>
      
	  <h4>Currency Settings</h4>
      <p>Click <a href="" class="label success" id="add_admin_currency_field">add Currency</a> to add another field for a new code.</p>
      <table class="form-table" id="currency_value_table">

        <thead>
          <tr>
            <th>Currency Symbol</th>
            <th>Currency Name</th>
          </tr>
        </thead>         

        <tbody id="st_currency_options_body">

          <?php


          if($values = get_option('s_ticker_currency_codes')) {
            //print '<pre>'.print_r($values, true).'<pre>'; die();
			$currencyNames = get_option('s_ticker_currency_names');
			$i = 0;
            foreach($values as $val) {
			  
		  	  $currencyName = $currencyNames ? $currencyNames[strtoupper($val)] : '';
			  $i++;
			  if ($i > 5) continue;
              echo trim('
                <tr valign="top" class="stock_ticker_row">
                  <td><input type="text" class="st_symbol" name="s_ticker_currency_codes[]" value="'. $val .'" /></td>
				  <td><input type="text" class="st_symbol" name="s_ticker_currency_names[]" value="'. $currencyName .'" /></td>
                  <td><a href="" class="label delete" id="delete_admin_currency">delete</a></td>
                </tr>
              ');
            }
          }
          ?> 
                 
        </tbody>

      </table>
      
      <p style="margin-top: 20px"><button class="button-primary" type="submit" id="admin_stock_submit">Save Settings</button></p>
      <p id="admin-st-success"></p>
    </form>
	<h3>Love the plugin? - Consider a donation!</h3>
	<p>We happily accept donations to keep us inspired to update this plugin. <a target="_blank" href="http://helpforwp.com/donate/">Visit our site</a> to show us you care!</p>
  	<h3>Plugin Support Centre</h3>
		<p>We operate a support service for this plugin, it's located at <a target="_blank" href="http://helpforwp.com/forum/">HelpForWP.com</a>
	<h3>Consider going Pro!</h3>
	We have developed a Pro version of this plugin, it's available for just $15 (Australian)!
	<ul>
	<li>Unlimited number stock codes, index and currency symbols</li>
	<li>Support for charts, show a chart on top or below the ticker when a ticker symbol is clicked</li>
	<li>Control over the refresh time of the data from Yahoo!</li>
	<li>Ability to remove the WP Stock Ticker text from your ticker display</li>
	</ul>
	<a href="http://helpforwp.com/plugins/wp-stock-ticker/" target="_blank">Learn more WP Stock Ticker Pro.</a>	
</div>


<?php
require_once('h4wp_info.php');
}

