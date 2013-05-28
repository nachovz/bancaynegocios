<?php
/*
Plugin Name: jQuery Accordion Category Posts
Plugin URI: http://wordpress.org/extend/plugins/jquery-accordion-category-posts/
Description: A simple post listing by category widget usign jQuery UI Accordion
Version: 1.0
Author: Starcom Systems
Author URI: http://www.starcomsystems.net/
*/

// INITIAL VARIABLES FUNCTION
function ssjac_add_options() {
	add_option( 'ssjac_numcat', '5' );
	add_option( 'ssjac_numpost', '5' );
}	
register_activation_hook( __FILE__, 'ssjac_add_options' );

//REMOVE OPTIONS ON DEACTIVATION
function ssjac_del_options() {
	delete_option( 'ssjac_numcat' );
	delete_option( 'ssjac_numpost' );
}	
register_deactivation_hook( __FILE__, 'ssjac_del_options' );

/* START - REGISTER JQUERY LIBS FOR ACCORDION */

function ssjac_jquerylibs() { // Call jQuery 1.4
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', WP_PLUGIN_URL.'/jquery-accordion-category-posts/jqueryui/jquery-1.4.2.js', '', '1.4.2');

    wp_deregister_script( 'jquery-ui-core' );
    wp_register_script( 'jquery-ui-core', WP_PLUGIN_URL.'/jquery-accordion-category-posts/jqueryui/ui/jquery.ui.core.js', '', '1.8.5');

    wp_register_script( 'jquery-ui-widget', WP_PLUGIN_URL.'/jquery-accordion-category-posts/jqueryui/ui/jquery.ui.widget.js', '', '1.8.5');
    wp_register_script( 'jquery-ui-accordion', WP_PLUGIN_URL.'/jquery-accordion-category-posts/jqueryui/ui/jquery.ui.accordion.js', '', '1.8.5');
    wp_register_script( 'jquery-accordion-func', WP_PLUGIN_URL.'/jquery-accordion-category-posts/jqueryui/jquery_accordion.js', '', '1.8.5');
}    

if ( !is_admin() ) {
	ssjac_jquerylibs();	
	add_action( 'wp_head', wp_enqueue_script( 'jquery' ) );
	add_action( 'wp_head', wp_enqueue_script( 'jquery-ui-core' ) );
	add_action( 'wp_head', wp_enqueue_script( 'jquery-ui-widget' ) );
	add_action( 'wp_head', wp_enqueue_script( 'jquery-ui-accordion' ) );
	add_action( 'wp_head', wp_enqueue_script( 'jquery-accordion-func' ) );
}
/* END - REGISTER JQUERY LIBS FOR ACCORDION */


/* START - STYLE SHEET FOR ACCORDION */
function ssjac_call_uistyles() {
	  $ssjacStyleUrl = WP_PLUGIN_URL . '/jquery-accordion-category-posts/jqueryui/themes/base/jquery.ui.all.css';
	  $ssjacStyleFile = WP_PLUGIN_DIR . '/jquery-accordion-category-posts/jqueryui/themes/base/jquery.ui.all.css';
	  if ( file_exists($ssjacStyleFile) ) {
		  wp_register_style('myStyleSheets', $ssjacStyleUrl);
		  wp_enqueue_style( 'myStyleSheets');
	  }
}
add_action('wp_print_styles', 'ssjac_call_uistyles');
/* END - STYLE SHEET FOR ACCORDION */

function ssjac_load_accordion() {
	$accdivs = '<div id="accordion">';
	$numofcats = get_option('ssjac_numcat');
	$numofposts = get_option('ssjac_numpost');
	$catargs = 'number='.$numofcats.'&include=28,33,32';
	
	$categories = get_categories( $catargs );
	foreach ( $categories as $category ) {
		$ssjac_catid = $category->term_id;
		$accdivs .= '<h3><a href="#">'.$category->cat_name.'</a></h3>';
		$accdivs .= '<div>';
		$queryargs = 'posts_per_page='.$numofposts.'&cat='.$ssjac_catid;
		query_posts($queryargs);		
			if ( have_posts() ) : while ( have_posts() ) : the_post(); 
				$accdivs .= '<a href='.get_permalink().' rel=bookmark title=Permanent Link to '.get_the_title().'>'.get_the_title().'</a><br>';
			endwhile; else:
			endif;
			wp_reset_query();
		$accdivs .= '</div>';
	}
	$accdivs .= '</div>';
	echo $accdivs;
	return $accdivs;
}

register_sidebar_widget( "jQuery Accordion Categories", "ssjac_load_accordion" );


function ssjac_admin_update() {

  if (!current_user_can('manage_options'))  {
    wp_die( __('You do not have sufficient permissions to access this page.') );
  }
  
	$CreateForm = '<div style="margin-top:60px;">';
  	if (isset($_POST['submit'])) { //Getting admin form update
		$ssjac_numcat = mysql_real_escape_string($_REQUEST['numcats']);
		$ssjac_numpost = mysql_real_escape_string($_REQUEST['numposts']);
		update_option( 'ssjac_numcat', $ssjac_numcat );
		update_option( 'ssjac_numpost', $ssjac_numpost );
		$CreateForm .= '<strong>Options updated</strong>.<br /><br />';
	}
	$CreateForm .= '<h2>jQuery UI Accordion Categories Options</h2>';
	$CreateForm .= '<form name="form1" method="post" action="' . $_SERVER["REQUEST_URI"] . '">';
	$CreateForm .= 'Number of categories to be displayed: ';
	$CreateForm .= '<input type="text" name="numcats" value='.get_option('ssjac_numcat').'><br />';
	$CreateForm .= 'Number of posts to be displayed under each category: ';
	$CreateForm .= '<input type="text" name="numposts" value='.get_option('ssjac_numpost').'><br />';
	$CreateForm .= '<br /><input type="submit" value="Update Options" name="submit"><br />';
	$CreateForm .= '</form>';
	$CreateForm .= '<br /><br />jQuery UI Accordion Categories plugin developed by <a href="http://www.starcomsystems.net/" target="_blank">Starcom Systems</a>';
	$CreateForm .= '</div>';
	
	echo $CreateForm;

}

function ssjac_plugin_menu() {
  add_options_page('jQuery Accordion Categories', 'jQuery Accordion Categories', 'manage_options', 'ssjac-options', 'ssjac_admin_update');
}

add_action('admin_menu', 'ssjac_plugin_menu');

?>