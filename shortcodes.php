<?php
function occasions_func( $atts ) {
	$args = array(
		'post_type' => 'voertuig',
		'posts_per_page'=> '-1'
	);
	$the_query = new WP_Query( $args );
	$list = array(
					'bouwjaar' => 'Bouwjaar:',
					'tellerstand' => 'Kilometerstand:',
					'transmissie' => 'Transmissie:',
					'brandstof' => 'Brandstof:',
					'verkoopprijs_particulier' => 'Vraagprijs:',
	);
	// The Loop
	if ( $the_query->have_posts() ) {
		include(__DIR__.'/templates/filters.php');
		echo '<div class="magneet--vwe-archive">';
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			include('templates/archive-content.php');
		}
		echo '</div>';
		/* Restore original Post Data */
		wp_reset_postdata();
	} else {
		echo "<h2> Er zijn op dit moment geen occasions</h2>";
	}
}
add_shortcode( 'occasions', 'occasions_func' );