<?php
	get_header();
	$list = array(
					'bouwjaar' => 'Bouwjaar:',
					'tellerstand' => 'Kilometerstand:',
					'transmissie' => 'Transmissie:',
					'brandstof' => 'Brandstof:',
					'verkoopprijs_particulier' => 'Vraagprijs:'
	);
	?>
	<div id="filter-new"></div>
	<div class="magneet--vwe-archive"><?php
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post(); 
			include('archive-content.php');
		} 
	} 
?>
	</div>
	<div id="filter-old">
		<?php
		include('filters.php')	
		?>
	</div>
<?php
	get_footer();