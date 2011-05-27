<?php
	$metacat=new ooRexSaleCategory();
	$metacat->setLanguage($REX['CUR_CLANG']);
	// Categories
	if ($REX['ADDON']['REXSALE']['MODE']=="c")
	{	$metacat->setCategory($REX['ADDON']['REXSALE']['RID']);
	}
	else
	{	if (isset($REX['ADDON']['REXSALE']['RCAT'])) {
			$metacat->setCategory($REX['ADDON']['REXSALE']['RCAT']);
		}
	}
?>