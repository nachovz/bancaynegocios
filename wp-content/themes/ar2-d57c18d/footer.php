	</div><!-- #main -->
</div><!-- #wrapper -->
	<?php ar2_before_footer() ?>
   
	<footer id="footer" class="clearfix" role="contentinfo">

		<nav class="footer-meta">
			<ul id="menu-top-menus-1" class="menu clearfix">
				<?php
				wp_nav_menu( array( 
					'sort_column'	=> 'menu_order', 
					'menu_class' 	=> 'menu clearfix', 
					'theme_location'=> 'footer-nav',
					'container'		=> false,
					'fallback_cb'	=> 'ar2_footer_nav_fallback_cb',
					'depth'			=> 1,
					'items_wrap'	=> '%3$s'
				) );
				?>
			</ul>
			<div class="footnote">
				<div class="logofooter"><a href="#"></a></div>
				<div class="copyright"><?php echo html_entity_decode( ar2_get_theme_option( 'footer_message' ) ); ?></div>
				<div class="lupafooter"><img src="http://dev.geekies.co/bancaynegocios/wp-content/uploads/2013/05/lupa.png" alt=""></div>
				<div>
					<input type=search name=s results=5 placeholder="Buscar en Banca y Negocios" id="buscadorfooter">	
				</div>
			</div>
		</nav><!-- .footer-meta -->
		<div class="footer-sidebar-container clearfix">
			<?php 
				$footer_sidebars = 4;
			
				for ($i = 1; $i < $footer_sidebars + 1; $i++) : 
			?>
				<div id="footer-sidebar-<?php echo $i ?>" class="footer-sidebar clearfix xoxo">
					<?php if ( !dynamic_sidebar( 'footer-sidebar-' . $i ) ) : ?>
					<?php endif; ?>
				</div>
			<?php endfor; ?>
		</div>
		
	</footer>



<?php wp_footer() ?>
</body>
</html>
   