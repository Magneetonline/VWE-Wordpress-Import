<?php
	//custom archive page. Should work with most themes. 
function get_custom_post_type_template( $archive_template ) {
     global $post;
     if ( is_post_type_archive ( 'voertuig' ) ) {
        $archive_template = dirname( __FILE__ ) . '/templates/archive.php';
     }
     return $archive_template;
}

add_filter( 'archive_template', 'get_custom_post_type_template' ) ;



//content injection on single page. Should work with most themes.
add_filter ('the_content', 'insertData');
	function insertData($content) {
		$list = array(
					'bouwjaar' => 'Bouwjaar:',
					'tellerstand' => 'Kilometerstand:',
					'transmissie' => 'Transmissie:',
					'brandstof' => 'Brandstof:',
					'verkoopprijs_particulier' => 'Vraagprijs:',
					'aantal_deuren' => 'Aantal deuren:',
					'aantal_handzenders' => 'Aantal handzenders:',
					'aantal_sleutels' => 'Aantal sleutels:',
					'aantal_zitplaatsen' => 'Aantal zitplaatsen:',
					'acceleratie' => 'Acceleratie:',
					'basiskleur' => 'Basiskleur:',
					'bekleding' => 'Bekleding:',
					'carrosserie' => 'Carrosserie:',
					'cilinder_aantal' => 'Cilinder aantal:',
					'cilinder_inhoud' => 'Cilinder inhoud:',
					'garantie_maanden' => 'Garantie:',
					'gereserveerd' => 'Gereserveerd:',
					'gvw' => 'GVW:',
					'interieurkleur' => 'Interieurkleur:',
					'massa' => 'Gewicht:',
					'merk' => 'Merk:',
					'model' => 'Model:',
					'onderhoudsboekjes' => 'Onderhoudsboekjes:',
					'topsnelheid' => 'Tropsnelheid:',
					'type' => 'Type:',
					
		);
		global $post;
		if ( is_singular( 'voertuig' ) &&  $post->ID != 2343 &&  $post->ID != 2339 &&  $post->ID != 2363) {
			$contentn.= "<div class=\"my-gallery\" itemscope itemtype=\"http://schema.org/ImageGallery\">";
				foreach(json_decode(get_post_meta(get_the_ID(), 'img_gallery', true)) as $image){
					$data = get_attachment_meta_data_sem($image);
					$contentn.=  "<figure itemprop=\"associatedMedia\" itemscope itemtype=\"http://schema.org/ImageObject\">
        <a href=\"". wp_get_attachment_url( $image )."\" itemprop=\"contentUrl\" data-size=\"{$data['width']}x{$data['height']}\">
            <img src=\"".wp_get_attachment_image_src( $image, 'medium' )[0]."\" itemprop=\"thumbnail\" alt=\"Florijnmobilteit\" />
        </a>
        <figcaption itemprop=\"caption description\">".get_post_meta(get_the_ID(), 'title', true)."</figcaption>
    </figure>";
				}
			$contentn.= "</div>";
			$contentn.= $content;
			$contentn.= '<ul class="magneet--vwe-accessoire__single"><h4>Deze auto bevat</h4>';
			foreach(json_decode(get_post_meta(get_the_ID(), 'zoekaccessoires', true))->accessoire as $accessoire){
				$contentn.= "<li class=\"magneet--vwe-accessoire__item\"><span><i class=\"fa fa-check\" aria-hidden=\"true\"></i></span> {$accessoire}</li>";
			}
			$contentn.= '</ul><hr class="magneet--vwe-divider">';
	    	$contentn.= '<ul class="magneet--vwe-features__single"><h4>Specificaties</h4>';
			foreach($list as $key => $value){
				$contentn.= "<li class=\"magneet--vwe-features__item\">
					<span class=\"magneet--vwe-features__label\">{$value}</span>
					<span class=\"magneet--vwe-features__value type-{$key}\">".get_post_meta(get_the_ID(), $key, true)."</span>
				</li>";
			}
	      $contentn.= '</ul>';
	      $contentn.= file_get_contents(__DIR__.'/templates/pswp.php');
	     }else{
		     $contentn = $content;
	     }
	   return $contentn;
	}
?>