<?php
	//hier post informatie
    //$xmlData =  simplexml_load_file("php://input");
	global $wpdb;
	$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https" : "http";
	if(isset($_GET['test'])){
		$test = $_GET['test'];
	}else{
		$test = '';
	}
	if($_SERVER["REMOTE_ADDR"] == "82.94.240.8" OR $test == "j") {
		add_action( 'wp_loaded', 'magneet_load_content' );
    }
    
    function magneet_load_content(){
		//$xml = simplexml_load_file(dirname( __FILE__ )."/test.xml");
		$xml = simplexml_load_file("php://input");
		$apiAction = $xml->attributes()['actie'];
			
		switch($apiAction){
			case "add":
				import_item($xml);
				die("1");
			case "change":
				$post_id = get_post_id_by_meta_key_and_value("voertuignr_hexon", $xml->voertuignr_hexon, false);
				wp_delete_post( $post_id, true );
				import_item($xml);
				die("1");
			case "delete":
				$post_id = get_post_id_by_meta_key_and_value("voertuignr_hexon", $xml->voertuignr_hexon, false);
				wp_delete_post( $post_id, true );
				die("1");
		}   
	}
    
    function import_item($xml){
	    global $wpdb;
		if(!get_post_id_by_meta_key_and_value("voertuignr_hexon", $xml->voertuignr_hexon)) {
			$post = array(
				'post_author' => 2,
				'post_content' => "{$xml->opmerkingen}",
				'post_name' => "{$xml->titel}",
				'post_status' => 'publish',
				'post_excerpt' => "{$xml->opmerkingen}",
				'post_title' => "{$xml->titel}",
				'post_type' => 'voertuig'
			);
			;
				
			// Attempt to add post
			if($ids = wp_insert_post($post)) {
				foreach($xml as $key => $value){
					if(count($value->children())>0){
						add_post_meta($ids, "$key", json_encode($value, JSON_HEX_QUOT));
					}elseif($value != ""){
						add_post_meta($ids, "$key", "$value");
					}
				}
				add_post_meta($ids, "img_gallery", Download_Images($xml));
				Generate_Featured_Image($xml->afbeeldingen->afbeelding[0]->url, $ids);
			}else{
				die('nope inserting');
			}
		}else{
			die('nope bestaat al');
		}
	}
	
	function Download_Images($xml){
		$image_ids = array();
		foreach($xml->afbeeldingen->afbeelding as $image){
			$file = strtok($image->url, '?');
			$filename = basename($file);
			$upload_file = wp_upload_bits($filename, null, file_get_contents($file));
			if (!$upload_file['error']) {
				$wp_filetype = wp_check_filetype($filename, null );
				$attachment = array(
					'post_mime_type' => $wp_filetype['type'],
					'post_parent' => $parent_post_id,
					'post_title' => preg_replace('/\.[^.]+$/', '', $filename),
					'post_content' => '',
					'post_status' => 'inherit'
				);
				$attachment_id = wp_insert_attachment( $attachment, $upload_file['file'], $parent_post_id );
				if (!is_wp_error($attachment_id)) {
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					$attachment_data = wp_generate_attachment_metadata( $attachment_id, $upload_file['file'] );
					wp_update_attachment_metadata( $attachment_id,  $attachment_data );
				}
			}
			
		    array_push($image_ids, $attachment_id);
		}
		return json_encode($image_ids, JSON_HEX_QUOT);
	}
	
	function Generate_Featured_Image($image_url, $post_id){
		$image_url = strtok($image_url, '?');
	    $upload_dir = wp_upload_dir();
	    $image_data = file_get_contents($image_url);
	    $filename = basename($image_url);
	    if(wp_mkdir_p($upload_dir['path']))     $file = $upload_dir['path'] . '/' . $filename;
	    else                                    $file = $upload_dir['basedir'] . '/' . $filename;
	    file_put_contents($file, $image_data);
	    $wp_filetype = wp_check_filetype($filename, null );
	    $attachment = array(
	        'post_mime_type' => $wp_filetype['type'],
	        'post_title' => sanitize_file_name($filename),
	        'post_content' => '',
	        'post_status' => 'inherit'
	    );
	    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
	    require_once(ABSPATH . 'wp-admin/includes/image.php');
	    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
	    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
	    $res2= set_post_thumbnail( $post_id, $attach_id );
	}
	
    function get_post_id_by_meta_key_and_value($key, $value, $bool = true) {
		global $wpdb;
		$meta = $wpdb->get_results("SELECT * FROM `".$wpdb->postmeta."` WHERE meta_key='".$wpdb->escape($key)."' AND meta_value='".$wpdb->escape($value)."'");
	
		if (is_array($meta) && !empty($meta) && isset($meta[0])) {
			$meta = $meta[0];
		}		
		
		if(is_object($meta)){ 
			$page = $wpdb->get_results("SELECT ID FROM `".$wpdb->posts."` WHERE ID='".$wpdb->escape($meta->post_id)."'");
			
			if(!empty($page[0]->ID)) {
				if($bool) {
					return true;
				}
				else {
					return $page[0]->ID;
				}
			}
		}
		else {
			if(!$bool) {
				return false;
			}
			else {
				return "";
			}
		}
	}
?>
