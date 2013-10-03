<?php  session_start(); 

	include("imgvrf.php");
	
	$image = new verification_image();
		

	// do this when the form is submitted $_SESSION['verification_key']
	if (isset($_GET['go'])){
	echo $image->validate_code($vc) ? "true" : "false"; }
		
?>

<form action="index.php" method="get">
Code:<img src="picture.php"/> <input name="vc" type="text" />
<label>
<input type="submit" name="go" value="Submit" />
</label>
</form>