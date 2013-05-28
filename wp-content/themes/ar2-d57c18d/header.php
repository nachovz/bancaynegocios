<?php
/**
 * AR2's main header template.
 *
 * @package AR2
 * @since 1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes() ?>>

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

<?php if ( is_search() || is_author() ) : ?>
<meta name="robots" content="noindex, nofollow" />
<?php endif ?>

<title><?php ar2_document_title() ?></title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />

<?php
wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/js/modernizr.custom.min.js', null, '2012-07-08' );
wp_enqueue_script( 'tinynav', get_template_directory_uri() . '/js/tinynav.min.js', array( 'jquery' ), '2012-08-02' );

if ( is_singular() ) :
wp_enqueue_style( 'colorbox_css', get_template_directory_uri() . '/css/colorbox.css', null, '2012-08-04' );
wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/js/jquery.colorbox.min.js', array( 'jquery' ), '2012-08-04' );
endif;

if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' );
?>

<?php wp_head() ?>
</head>

<body <?php body_class() ?>>
<?php ar2_body() ?>

<div id="wrapper">

<nav id="top-menu" class="clearfix" role="navigation">
<?php ar2_above_top_menu() ?>
	<?php 
	wp_nav_menu( array( 
		'sort_column'		=> 'menu_order', 
		'menu_class' 		=> 'menu clearfix', 
		'theme_location' 	=> 'top-menu',
		'container'			=> false,
		'fallback_cb' 		=> ''
	) );
	?>
<?php ar2_below_top_menu() ?>
</nav><!-- #top-menu -->
	
<header id="header">
	<a href="http://googleads.g.doubleclick.net/aclk?sa=L&ai=CLd523QSCUbXhEeTLsQek34CIDPrrrv4DAAAQASDKmLMfUKTAi_kBYN8GyAEDqQLZuKM8xlSFPuACAKgDAcgDnQSqBHZP0GR1muMSnsf91NPuKIIXQ5y4spBP9SwynjFldKwsvIlWg6PcpXxKvx6aeO2O1NSgWE-KPwhirrYj3akhrsCx8JWXbd9yjSr7O2Im00yXos3JCEeEXWA6g1LchkPCFRmspoiCyWDNaI1icEBuNbnWfVj04nPk4AQBoAYU&num=0&sig=AOD64_2fIKxLp5drAOPJeutuzmFJuMrcXQ&client=ca-pub-7250630846491692&adurl=http://www.corpbanca.com.ve/&nm=2&nx=56&ny=53&mb=2" target="_blank"><img role="banner" src="http://pagead2.googlesyndication.com/simgad/6934953269133835707" alt=""></a>
		<div class="ribbon-wrapper">
		<div class="ribbon-front">
			<a href="#"><div class="logo"></div></a>
			<div class="mail"><a href="#">
				<img src="http://dev.geekies.co/bancaynegocios/wp-content/uploads/2013/05/boletin1.png" alt="Sobre">
				<p style="color: #007f66"><strong>¡Suscribase Grátis!</strong><br><span style="font-size: 13px;">a nuestro boletín semanal</span></p>
				</a>
			</div>
			<div class="redes">
				<iframe id="fb" src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fbancaynegociosvzla&amp;send=false&amp;layout=box_count&amp;width=450&amp;show_faces=false&amp;font=lucida+grande&amp;colorscheme=light&amp;action=like&amp;height=90" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:450px; height:70px;" allowTransparency="true"></iframe>
				<a href="https://twitter.com/bancaynegocios" class="twitter-follow-button" data-show-count="false" data-lang="es" data-size="large" data-show-screen-name="false">Seguir a @bancaynegocios</a>
				<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
			</div>
			<div class="buscador">
				<script id="fecha" type="text/javascript"> var d=new Date(); var weekday=new Array("domingo","lunes","martes","miércoles","jueves","viernes", "sábado"); var monthname=new Array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre"); document.write("Caracas, " + weekday[d.getDay()] + " " + d.getDate() + " de " + monthname[d.getMonth()] + " de " + d.getFullYear());</script>
				<div class="lupa"><img src="http://dev.geekies.co/bancaynegocios/wp-content/uploads/2013/05/lupa.png" alt=""></div>
				<input type=search name=s results=5 placeholder="Buscar en Banca y Negocios" id="buscador">
			</div>
		</div>
		<div class="ribbon-topleft"></div>
		<div class="ribbon-topright"></div>
		<div class="ribbon-bottomleft"></div>
		<div class="ribbon-bottomright"></div>
	</div>
	<!-- <div id="branding" class="clearfix">
		<?php if ( is_home() || is_front_page() ) : ?>
		<hgroup class="logo">
				
		</hgroup>
		<?php else: ?>
		<div class="logo">
			
		</div>
		<?php endif ?>
		
		<div class="banner">
		<?php  ?>
		</div>
		
	</div><!-- #branding -->
</header><!-- #header -->

<?php ar2_above_nav() ?>
<nav id="main-nav" role="navigation">
	<?php 
	wp_nav_menu( array( 
		'sort_column'	=> 'menu_order', 
		'menu_class' 	=> 'menu clearfix', 
		'theme_location'=> 'main-menu',
		'container'		=> false,
		'fallback_cb'	=> 'ar2_nav_fallback_cb' 
	) );
	?>
</nav><!-- #nav -->
<?php ar2_below_nav() ?>
	
<?php ar2_above_main() ?>
<div id="main" class="clearfix">
	<?php if(method_exists('WPStockTicker', 's_ticker_display')) {
			$xx = new WPStockTicker();
			echo $xx->s_ticker_display();
		}
	?>
<a href="http://googleads.g.doubleclick.net/aclk?sa=L&ai=CeX6p3QSCUbbhEeTLsQek34CIDOLmk_MCAAAQASDKmLMfUJG5qfz-_____wFg3wbIAQOpAtm4ozzGVIU-4AIAqAMByAOdBKoEfU_QpbILFBmJZxxsXomowaONE0FaUM43u0SQcGMHxqdPw2EBPCCq56L6d90B1CdOJSPbvS8Q7PZ3QcZ1qn3Q9bdT-JU152a3WL4XYyUM_u_BYZ9c85GnUMBYIdrCXvxQXdzYEj4sxK0AnD7X37CPYN8PF_TjCWNpNCMWvOBD4AQBoAYU&num=0&sig=AOD64_0xC_UlgCYKIs6Wy0Fz_hTOSptTtg&client=ca-pub-7250630846491692&adurl=https://mispagos.provincial.com/&nm=4&nx=97&ny=72&mb=2" target="_blank"><img role="banner" src="http://pagead2.googlesyndication.com/simgad/2114608578332379806" alt=""></a>
   <div id="container" class="clearfix">
	