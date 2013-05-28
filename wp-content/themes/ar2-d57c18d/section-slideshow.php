<?php
/**
 * The template for displaying content in 'Slideshow' post section.
 * @since 2.0
 */
?>

<li id="post-<?php the_ID() ?>">

	<a href="<?php the_permalink(); ?>" rel="bookmark"><?php echo ar2_get_thumbnail( 'single-thumb' ) ?></a>
	<div class="entry-meta">
		<a class="entry-title" href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
		<div class="entry-summary">
			<div class="entry-info">
				<?php printf( __( 'Posted on %s', 'ar2' ), '<abbr class="published">' . ar2_posted_on( false ) . '</abbr>' ); ?>
				<?php the_tags( __( ' | ', 'ar2' )) ?>
			</div>
			<?php the_excerpt() ?>
		</div>
	</div>

</li>

<a href="http://googleads.g.doubleclick.net/aclk?sa=L&ai=CNqcdu8iCUcOMDrTV0AGwjIGgCKq_jewDAAAQASDKmLMfUJWWj_EBYN8GyAECqQLZuKM8xlSFPuACAKgDAcgDnQSqBHRP0NuaH1e54TIxTJLJQlpvPaoWlescuc0vF7ZL2NpHzo1ZFis83hP65-oZE-WddBjP2NSAiICGOUref1eOwGNnbRBpXb1QMOBn3LYWohMHf2jSnNttPTPjXE_P_R_B7iWRWucTxHpwLPupRTZ_sePHGkfwL-AEAaAGFA&num=0&sig=AOD64_2d0VRE329iDYhJEiEda_L208O4zQ&client=ca-pub-7250630846491692&adurl=http://www.bancoplaza.com/&nm=4&nx=182&ny=41&mb=2" target="_blank"><img role="banner" src="http://pagead2.googlesyndication.com/simgad/2501182255455591262" alt="" id="publicidad2"></a>