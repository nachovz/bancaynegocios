===WP Stock Ticker===
Contributors: PeterShilling
Donate Link: http://helpforwp.com/donate/
Tags: stocks,tickers,finance,currency,investment,commodities,shares
Requires at least: 3.0
Tested up to: 3.4.2
Stable tag: 2.3

WP Stock Ticker allows you to display a scrolling ticker across a page or post as well as inserting the ticker into a template or widget area.

== Description ==

The plugin can run via WordPress short code or can be inserted into template files to run on each page. From version 2.1 there is now a widget for WP Stock Ticker that allows you to place the ticker into any widget area in your WordPress theme.

Finance data is pulled from Yahoo! Finance so any market that is available there can be used with this plugin. 

Codes for companies (eg AAPL) or indices (eg ^FTSE) including Non US markets companies (eg TLS.ax - Telstra in Australia).

Version 2.0 also supports currency exchange rates, Yahoo currency codes like AUDUSD=X (Aussie dollar against the US Dollar), USDJPY=X or AUDJPY=X

The ticker will also display commodities that are available on Yahoo! Finance.

Lookup currency, commodities and stock codes via <a href="http://yahoo.finance.com">yahoo.finance.com</a>.

We have also developed a Pro version: <a href="http://helpforwp.com/plugins/wp-stock-ticker/">WP Stock Ticker Pro</a>, that has even more features:

* Unlimited number of stock codes
* Unlimited number of currency pairs
* Display charts when a user clicks an individual ticker symbol
* Ability to control the caching time of the data
* Robust handling of the Yahoo Finance API (cached data will be served if Yahoo is not available)

Support for this plugin is available <a href="http://helpforwp.com/forum/">here on our website</a>.

Enjoy!

== Installation ==

Activate the plugin then you can use either a short code [s_ticker_display] to place in a page or post or use the call below to place inside a template file.

function/method call:

<pre>
if(method_exists('WPStockTicker', 's_ticker_display')) {
  $xx = new WPStockTicker();
  echo $xx->s_ticker_display();
}
</pre>

The plugin has a very easy to use admin page that allows you to manage the stock codes that you would like to display.

For more details and support please visit http://helpforwp.com/forum/wp-stock-ticker/

== Frequently Asked Questions ==

This Plugin has support and further documentation available via our web site.

Please visit <a href="http://helpforwp.com/forum/">http://helpforwp.com/forum/</a> for support or <a href="http://helpforwp.com/plugins/wp-stock-ticker/wp-stock-ticker-documentation/">this URL</a> for documentation.

== Screenshots ==

1. Admin interface to manage stock codes
2. Example ticker displayed on a page

== Changelog ==
2.4.2 Update to Support URLs
2.4.1 Change to using LastTradePrice in yahoo for more consistent price data
2.4 Bug fix in caching of Yahoo Data
2.3.3 Minor update to jquery setup
2.3 Updates to the way the plugin caches data from Yahoo!
2.1 New widget added to the plugin to place the plugin into a widget area
2.0.1 Clean up dashboard interface
2.0 New support for Currencies
	Ability to display the name instead of just the stock ticker code
	Minor bug fix on jquery

1.8 minor code tidy up, setting of default options when the plugin is activated

1.0 Initial public release