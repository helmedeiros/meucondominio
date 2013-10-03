<?php 
class email{

	function sendMail($subject, $message, $to){
		$headers = 'From: no-reply@meucondominio.net'."\r\n".'Reply-To: webmaster@example.com.'."\r\n".'Content-Type: text/html; charset="utf-8"';
        mail($to, $subject, $message, $headers);
	}
}
?>