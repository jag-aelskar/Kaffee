<?php


# Check for REXSmarty
if ($REX['ADDON']['status']['rexsmarty']!=1)
{	$REX['ADDON']['installmsg']['rexsale']='Bitte installieren/aktivieren Sie REXsmarty von <a href="http://www.redaxo.de/180-Addondetails.html?addon_id=243">REDAXO.de</a>';
}

# Check for PHPMailer
if ($REX['ADDON']['status']['phpmailer']!=1)
{	$REX['ADDON']['installmsg']['rexsale']='Bitte installieren/aktivieren Sie PHPMailer.';
}

# Check for URLRewrite
if ($REX['ADDON']['status']['url_rewrite']!=1)
{	$REX['ADDON']['installmsg']['rexsale']='Bitte installieren/aktivieren Sie URLRewrite (auch wenn sie URLRewerite nicht brauchen!!!).';
}


$REX['ADDON']['install']['rexsale'] = 1;


//make folders for the demo files (if the user ever installs them)
@mkdir($REX['INCLUDE_PATH'].'/../../files/_templates');
@mkdir($REX['INCLUDE_PATH'].'/../../files/_css');
@mkdir($REX['INCLUDE_PATH'].'/../../files/_img');
@mkdir($REX['INCLUDE_PATH'].'/../../files/_js');





if ($REX['ADDON']['installmsg']['rexsale']=="")
{	//header("Location:index.php?page=rexsale&subpage=config");
	//die();
}

?>