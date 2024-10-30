<?php
	//Local URL
	$url = get_bloginfo( 'wpurl' );
	$local_url = parse_url( $url );
	$aux_url   = parse_url(wp_guess_url());
	$url = str_replace($local_url['host'], $aux_url['host'], $url);
	
	// Define custom JavaScript function
	echo "<script type='text/javascript'>
	mudslide_i18n_error = '".__("Can\'t read MudSlideShow Feed", 'mudslide')."';
	mudslide_url = '$url';
	var muds_loading_img = new Image(); 
	muds_loading_img.src = '".muds_plugin_url('img/loading-page.gif')."';
	muds_loading_img.src = '".muds_plugin_url('img/loading-simple.gif')."';
	if ( typeof tb_pathToImage != 'string' ) {
		var tb_pathToImage = mudslide_url+'/wp-includes/js/thickbox/loadingAnimation.gif';
	}
	</script>
	";
	
	//Declare javascript
	wp_register_script('caroufredsel', $url.'/wp-content/plugins/mudslideshow/scripts/jquery.carouFredSel-5.5.5-packed.js', array('jquery'), MUDS_HEADER_V);
	wp_enqueue_script('caroufredsel');
	wp_register_script('mudslideshow', $url.'/wp-content/plugins/mudslideshow/mudslideshow.js', array('thickbox', 'sack', 'caroufredsel' ), MUDS_HEADER_V);
	wp_enqueue_script('mudslideshow');
	
	//Define custom CSS URI
	$css = get_theme_root()."/".get_template()."/simpleslide.css";
	if(file_exists($css)) {
		$css_register = get_bloginfo('template_directory')."/simpleslide.css";
		wp_register_style('simpleslide-custom', $css_register, false, MUDS_HEADER_V);
		wp_enqueue_style('simpleslide-custom');
	}
	
	//Declare style
	$css_register = muds_plugin_url("/css/simpleslide.css");
	wp_register_style('simpleslide', $css_register, false, MUDS_HEADER_V);
	wp_enqueue_style('simpleslide');
	
	//Define custom CSS URI
	$css = get_theme_root()."/".get_template()."/mudslide.css";
	if(file_exists($css)) {
		$css_register = get_bloginfo('template_directory')."/mudslide.css";
		wp_register_style('mudslideshow-custom', $css_register, array('simpleslide', 'thickbox'), MUDS_HEADER_V);
		wp_enqueue_style('mudslideshow-custom');
	}
	
	//Declare style
	$css_register = muds_plugin_url("/css/mudslide.css");
	wp_register_style('mudslideshow', $css_register, array('simpleslide', 'thickbox'), MUDS_HEADER_V);
	wp_enqueue_style('mudslideshow');
	
	// Declare we use JavaScript SACK library for Ajax
	wp_print_scripts( array( 'mudslideshow' ));
	wp_print_styles( array( 'mudslideshow' ));

?>
