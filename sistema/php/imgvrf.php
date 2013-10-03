<?php 
	
	//
	// Verification Image.
	// v0.1 
	//
	// An antispam image, generates a code, creates an image out of it, and 
	// registers this code in a session. User input will be checked against 
	// this session value. If it is valid no spambot is the one that is submitting 
	// this form.
	//
	// Install instructions:
	// Put the file of your ttf in the same directory as this script. Also note that
	// you call session_start() before using this class in any script.
	// 
	// 
	// As always I appreciate feedback. So don't hesitate to contact me.
	//
	// author: Jaap van der Meer (jaap@web-radiation.nl)
	//

	
	
	class verification_image {
		// the image that will be outputted
		private $image;
		
		// the width of the image thats outputted
		private $_w;
		
		// the height of the image that's outputted
		private $_h;
		
		// the color used for the text
		private $text_color;
		
		// the background used in the the text
		private $bg_color;
		
		// the font to be user
		private $ttf_font;
		
		// constructor to setup the image properties
		// width - the width of the image
		// height - the height of the image
		// font - the font to be used, must be in same directory
		function verification_image($width = 120, $height = 40, $font = "") {
			$this->_w = $width;
			$this->_h = $height;
		    $this->ttf_font = $font;
		}
		
		
		// initializes the image
		function init() {
			
			$this->image = imagecreate($this->_w, $this->_h);
			//$background_color = imagecolorallocate($this->image, 255, 255, 255);
			$this->set_bgcolor(246,248,249);
			$this->set_textcolor(75,97,108);
			
		}		
		
		// sets the bgcolor
		function set_bgcolor($r,$g,$b) {
			$background_color = imagecolorallocate($this->image, $r, $g, $b);	
			
		}
		
		// sets the textcolor
		function set_textcolor($r,$g,$b) {
			$this->text_color = imagecolorallocate($this->image, $r, $g, $b);	
		}
		
		// draws the string
		function draw() {
			$code = $this->generate_code();
			// register the code in the session
			$this->register_code($code);
			
			// offsets for x and y in the image
			$x = 1;
			$y = 20;
			
			// walk through each character in the 
			// code, to print it 
			for($i = 0; $i < strlen($code); $i++) {
			
				$calc_y = rand(200,250) / 10;
				//imagestring( $this->image, 3, $x, $calc_y,  $code{$i}, $this->text_color);	
				$angle = rand(-20,20);
				$this->write_string($x, $calc_y, $angle, $code{$i});
					$x += rand(17,19) ;
			}
			
		}
		
		
		function write_string($x_offset, $y_offset, $angle, $string) {
				
				// check if a font is set
				if($this->ttf_font != "") {
					// does the file font exist on the server
					if(file_exists($this->ttf_font)) {
						putenv('GDFONTPATH=' . realpath('.'));
						$font_size = 15;
						$grey = imagecolorallocate($this->image, 128, 128, 128);
						// draw a shadow
						imagettftext($this->image, $font_size, $angle, $x_offset + 1, $y_offset + 1, $grey, $this->ttf_font, $string);
						// draw the text	
						imagettftext($this->image, $font_size, $angle, $x_offset, $y_offset, $this->text_color, $this->ttf_font, $string);
					
					} else {
						die("Font doesn't exist, or not in same directory as a .ttf");
					}
				} else {
					die("No font set.");
				}
		}
		
		// generates a time based random code
		// offset is the minutes to be added
		function generate_code() {
			// define the seed out of which characters the seed will be constructed
			$string = md5(rand(0,9999));
			$output = substr($string, 14, 6);
			return $output;
		}
		
		
		// returns the code that is registered 
		// in the session
		function get_registered_code() {
			return $_SESSION['verification_key'];
		}
		
		// sets the code, this will be registered as 
		// the code in the session
		function register_code($c) {
			$_SESSION['verification_key'] = $c;
		}
		
		// checks if the code is valid
		function validate_code($code) {
			return $code == $this->get_registered_code(); 
		}
		
		// output it to screen
		function _output() {
			// initialize the image
			$this->init();
			// draw the image
			$this->draw();
			
			header("Content-type: image/png");			
			imagepng($this->image);
			
			// destroy the image to free resources
			imagedestroy($this->image);
		}
	
}




?>