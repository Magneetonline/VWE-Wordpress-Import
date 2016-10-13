<?php
	get_header();
	$list = array(
					'bouwjaar' => 'Bouwjaar:',
					'tellerstand' => 'Kilometerstand:',
					'transmissie' => 'Transmissie:',
					'brandstof' => 'Brandstof:',
					'verkoopprijs_particulier' => 'Vraagprijs:'
	);
	include('filters.php')
	?>
	<div class="magneet--vwe-archive"><?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post(); 
			include('archive-content.php');
		} 
	} 
?>
	</div>
<?php
	get_footer();