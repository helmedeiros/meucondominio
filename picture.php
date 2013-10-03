<?php 
	//
	// The image script for the verification image script
	//
	// author: Jaap van der Meer(jaap_at_web-radiation_dot_nl)
	//

	session_start();
	
	include("sistema/php/imgvrf.php");
	
	$image = new verification_image(114,32,"sistema/inc/arial.ttf");
	
	$image->_output();
	
?>
