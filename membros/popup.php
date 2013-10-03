<?php 
$hora = date("H");

if ($hora < 5 || $hora > 18)
	$swf = "sitenoturno.swf";
else
	$swf = "site.swf";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:: Meu Condom&iacute;nio ::</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-image: url(img/bg_predio.gif);
	background-repeat: no-repeat;
	background-attachment: fixed;
	background-position: right bottom;
	background-color: #F4E5C3;
}
-->
</style>
</head>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="800" height="600">
      <param name="movie" value="<?php=$swf?>">
      <param name="quality" value="high">
      <param name="wmode" value="transparent">
      <embed src="<?php=$swf?>" width="800" height="600" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent"></embed>
    </object></td>
  </tr>
</table>
</body>
</html>
