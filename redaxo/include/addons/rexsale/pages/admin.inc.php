<?php # Config Editor

switch ($_GET['action'])
{	case 'regenerate':
		# Start timer
		$mtime = microtime(); 
		$mtime = explode(' ', $mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$starttime = $mtime; 
		
		$SEF=new ooRexSaleSEF;
		
		$SEF->regenerate();
		
		#$SEF->recache();
		#$SEF->updateNav();
		#dbprint($_SESSION['REXSALESEF']);
		#$new=count($_SESSION['REXSALESEF']);
		#echo $old."/".$new;
		
		# Execution Time 	
		$mtime = microtime(); 
		$mtime = explode(" ", $mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$endtime = $mtime; 
		$totaltime = ($endtime - $starttime); 
		echo "<br />".$totaltime;
		
	break;
	
	
	default:
	break;
	
}





if ($_POST['ini']!="")
{	
	$myFile = $REX['INCLUDE_PATH'].'/addons/rexsale/rexsale.ini';
	$fh = fopen($myFile, 'w') or die("Can't open rexsale.ini.");
	$stringData = stripslashes($_POST['ini']);
	fwrite($fh, $stringData);
	fclose($fh);
}


?>
<style type="text/css">
	textarea
	{	width:100%;
		height:300px;
		border:1px solid #CCCCCC;
		font-family:monospace;
		font-size:12px;
	}
</style>
<!--<p><a href="?page=rexsale&subpage=config&action=regenerate">Remake pathlist</a></p>-->

<form action="?page=rexsale&subpage=config" method="post">
<textarea name="ini"><?php echo file_get_contents($REX['INCLUDE_PATH'].'/addons/rexsale/rexsale.ini'); ?></textarea><br /><br />
<input type="submit" name="save" value="<?php echo $rsl->msg('save'); ?>" />
</form>