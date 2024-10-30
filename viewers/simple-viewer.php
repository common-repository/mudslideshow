<?php

/**
* Create the HTML code for a simple gallery
*
* @access public
* @param xml data The data description of the gallery.
* @param string update_post The post elements for the data.php script to update this gallery.
* @param int size The size of the frame.
* @param string float The side where the frame has to float.
* @param int conf A configuration number for future releases.
* @return string The HTML code for the simple frame viewer.
*/
function muds_show_simple_general($data, $update_post, $size, $float, $conf, $type, $rand=0) {

	global $post, $current_user;

	$center = "";

	switch($type) {
		case MUDS_TYPE_PICASA:
			$size_aux = str_replace('-c', '', $size);
			break;
		case MUDS_TYPE_FLICKR:
			switch($size) {
				case 's':
					$size_aux=75;
					break;
				case 't':
					$size_aux=100;
					break;
				case 'm':
					$size_aux=240;
					break;
				case 'l':
					$size_aux=500;
					break;
				case 'full':
					$size_aux=500;
					if(defined('MUDS_MAX_SIZE')) $size_aux=MUDS_MAX_SIZE;
					break;	
			}
			break;
		
	}
	
	//Calculate the position for the buttons
	$box_height=$size_aux+10;
	$box_width=$size_aux+10;
	$slidemeter_left=$size_aux-110;
	$slidemeter_top=$size_aux-35;
		
	if($rand==0) $rand = mt_rand(111111,999999); //The identifier
	
	//Data to align the frame
	if($float=='center') {
		$center=" align=\"center\"";
	}
	$class="";
	$list = "";

	$max_height = 0;
	$max_width = 0;
	foreach($data as $item) {
		if((int)$item->width < (int)$item->height) {
			$max_height = $size_aux;
		} else {
			$aux = ($item->height * $size_aux) / $item->width;
			if($aux>$max_height) {
				$max_height = $aux;
			}
		}

		if((int)$item->width > (int)$item->height) {
			$max_width = $size_aux;
		} else {
			$aux = ($item->width * $size_aux) / $item->height;
			if($aux>$max_width) {
				$max_width = $aux;
			}
		}
	}

	//$max_height = $max_height + 60;
	
	if($photo_gallery = $data) { //Parse the data
		$total = count($photo_gallery->photo);
		$reverse = 0; 
		if($conf & MUDS_OPT_REVERSEORDER) {
			$reverse = $total - 1;
		}
		//Create the simple frame	
		for($i = 0; $i < $total; $i++) { //gallery as $photo) { //Go trhough the gallery
			$photo = $photo_gallery->photo[abs($reverse - $i)];
			//Get the photo
			if($size!='full') {
				$media = str_replace('%size%', $size, $photo->resize);
				if($type==MUDS_TYPE_FLICKR && $size=='l') $media = str_replace('_%size%', '', $photo->resize);
			} else {
				$media = $photo->src;
			}
			$photo_width = 0;
			$photo_height = 0;
			if((int)$photo->width < (int)$photo->height) {
				$photo_height = $size_aux;
			} else {
				$aux = ($photo->height * $size_aux) / $photo->width;
				if($aux>$photo_height) {
					$photo_height = $aux;
				}
			}
	
			if((int)$photo->width > (int)$photo->height) {
				$photo_width = $size_aux;
			} else {
				$aux = ($photo->width * $size_aux) / $photo->height;
				if($aux>$photo_width) {
					$photo_width = $aux;
				}
			}
			$list .= "<div class='item' style='width : ".$max_width."px;'>
					<div class='imagen' style='width : ".$max_width."px; height: ".$max_height."px; background: url(".$media.") no-repeat center center;'></div>";
			if($conf & MUDS_OPT_COMMENT) $list .= "<div class='texto'><p>{$photo->comment}</p></div>";
			$list .= "</div>";
		}

		$answer="<div class=\"slide$float\"".$center.">
			<div class='simpleslider' id='slider-$rand'>
				<div class='items'>$list</div>
				<div class='player'>
					<div class='button back'></div>
					<div class='pagination'></div>
					<div class='button next'></div>
				</div>
			</div>
			<script>
				jQuery(document).ready(function() { simpleSlider('#slider-$rand', ".$total."); });
			</script>
		</div>";
	}
	
	return $answer;

}

?>
