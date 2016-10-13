<?php
/*
 * Plugin Name: VWE advertentie beheer
 * Plugin URI: http://www.magneetonline.nl
 * Description: Plugin om advertenties van vwe te tonen
 * Version: 2.0
 * Author: Sem Schilder - Magneet Online
 * Author URI: https://sem.design
 * Text Domain: magneetvwe
 */


include_once("posttypes.php");
include_once("shortcodes.php");
include_once("xmlimport.php");
include_once("templates.php");

function magneet_vwe_styles_func() {
    wp_enqueue_style( 'magneet_vwe_styles', plugins_url( 'css/magneetvwe.css', __FILE__ ) );
    wp_enqueue_style( 'photoswipe', plugins_url( 'pswp/photoswipe.css', __FILE__ ) );
    wp_enqueue_style( 'photoswipe-default-skin', plugins_url( 'pswp/default-skin/default-skin.css', __FILE__ ) );
    wp_enqueue_script('photoswipe', plugins_url('pswp/photoswipe.min.js', __FILE__), array(),'1', true);
    wp_enqueue_script('photoswipe-ui-default', plugins_url('pswp/photoswipe-ui-default.min.js', __FILE__), array(),'1', true);
    wp_enqueue_script('isotope', plugins_url('js/isotope.js', __FILE__), array('jquery', 'magneet-app'),'3.0.1', true);
    wp_enqueue_script('magneet-app', plugins_url('js/app.js', __FILE__), array('jquery'),'1', true);
}
add_action( 'wp_enqueue_scripts', 'magneet_vwe_styles_func' );

function get_attachment_meta_data_sem($attch_id) {
	$meta_data = wp_get_attachment_metadata($attch_id);
	if($meta_data == ''){
		$attachment_path = get_attached_file($attch_id);
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		$attach_data = wp_generate_attachment_metadata( $attch_id, $attachment_path);
		wp_update_attachment_metadata( $attach_id,  $attach_data );
		return $attach_data;
	}else{
		return wp_get_attachment_metadata($attch_id);
	}
}

function magneet_prijs($prijs){
	if($prijs <= 1000){
		echo 'A';
	}elseif(($prijs <= 1000) && (prijs <= 3000)){
		echo 'B';
	}elseif(($prijs <= 3000) && (prijs <= 5000)){
		echo 'C';
	}elseif(($prijs <= 5000) && (prijs <= 8000)){
		echo 'D';
	}elseif(($prijs <= 8000) && (prijs <= 10000)){
		echo 'E';
	}elseif(($prijs <= 10000) && (prijs <= 20000)){
		echo 'F';
	}else{
		echo 'G';
	}
}
   
?>
