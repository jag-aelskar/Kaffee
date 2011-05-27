<?php
/* Generate a title */
$titlecat=new ooRexSaleCategory();
$titlecat->setLanguage($REX['CUR_CLANG']);
// Categories
if ($REX['ADDON']['REXSALE']['MODE']=="c")
{	$titlecat->setCategory($REX['ADDON']['REXSALE']['RID']);
}
else
{	if (isset($REX['ADDON']['REXSALE']['RCAT'])) {
		$titlecat->setCategory($REX['ADDON']['REXSALE']['RCAT']);
	}
}

if ($titlecat->info['metatitle']!="")
{	$out['rexsaletitle']=$titlecat->info['metatitle'];
}
else
{	$out['rexsaletitle']=$titlecat->info['name'];
}

if ($titlecat->info['metakeywords']!="")
{	$out['rexsalekeywords']=$titlecat->info['metakeywords'];
}

if ($titlecat->info['metatext']!="")
{	$out['rexsaledescription']=$titlecat->info['metatext'];
}

// Products
if ($REX['ADDON']['REXSALE']['MODE']=="p")
{	$titleprod=new ooRexSaleProduct();
	$titleprod->setLanguage($REX['CUR_CLANG']);
	$titleprod->setProduct($REX['ADDON']['REXSALE']['RID']);

	if ($titleprod->info['meta']['title']!="")
	{	$out['rexsaletitle']=$titleprod->info['meta']['title'].=" - ".$out['rexsaletitle'];
	}
	else
	{	$out['rexsaletitle']=$titleprod->info['name'].=" - ".$out['rexsaletitle'];
	}
	
	$out['rexsalekeywords']=$titleprod->info['meta']['keywords'];
	$out['rexsaledescription']=$titleprod->info['meta']['description'];
	
	unset($titleprod);
}
unset($titlecat);
	
# or in the case of shop documents...
if (isset($REX['ADDON']['REXSALE']['PAGENAME'])) {
	if ($REX['ADDON']['REXSALE']['PAGENAME']!="") {	
		$out['rexsaletitle']=$REX['ADDON']['REXSALE']['PAGENAME'];
	}
}

if (isset($REX['ADDON']['REXSALE']['DOCUMENT'])) {
	if ($REX['ADDON']['REXSALE']['DOCUMENT']!="") {	
		$out['rexsaletitle']=ucfirst($REX['ADDON']['REXSALE']['DOCUMENT']);
	}
}
/* End generate Title */
?>