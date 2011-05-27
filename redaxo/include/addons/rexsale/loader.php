<?php
/*
 * RexSale: Loader.php
 * This file allows direct access to certain files
 * from within the protected /include folder
 * Only files within /addons/rexsale/data are allowed.
 *  
 */

$load=stripslashes($_GET['load']);
$load=strip_tags($load);
$load=urldecode($load);
$load=str_replace("/","",$load);
$load=str_replace("\\","",$load);
$load=str_replace("..","",$load);

$load=$REX['INCLUDE_PATH']."/addons/rexsale/data/".$load;

$ext=explode('.',$load);


switch ($ext[count($ext)-1]) {	
	case "js":	
		header("Content-type:text/javascript");
	break;
	
	case "png":	
		header("Content-type:image/png");
	break;
	
	case "gif":	
		header("Content-type:image/gif");
	break;
	
	case "css":	
		header("Content-type:text/css");
	break;
	
	default:
		header("Content-type:text/plain");
	break;
}

$fp=fopen($load, 'rb');

header("Content-Length: " . filesize($load));
fpassthru($fp);
exit;

?>