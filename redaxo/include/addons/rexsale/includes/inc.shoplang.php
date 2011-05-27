<?php
	# Shop Languages
	if ($REX['MOD_REWRITE']) {
		$rexsalelang=new rex_sql;
		$rexsalelang->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'clang where `name`="'.rex_parse_article_name(rex_request('SHOPLANG')).'"');
		
		if ($rexsalelang->getRows()>0) {
			$REX['CUR_CLANG']=$rexsalelang->getValue('id');
		}
	}
	
	$I18N_A153_REXSALE = new i18n(ooRexSaleConfig::getSetting('Languages',$REX['CUR_CLANG']),$REX['INCLUDE_PATH']."/addons/rexsale/lang");
	if ($REX['VERSION'] == 4 && $REX['SUBVERSION']>1) {
		$I18N_A153_REXSALE->appendFile($REX['INCLUDE_PATH'].'/addons/rexsale/lang/');
	}

	$shopurl=strtolower(rex_getUrl($redaxo_shop_id));
	$shopurl=str_replace("index.html","",$shopurl);
	if (!$REX['MOD_REWRITE'])
	{	$shopurl.="&SHOPLANG=".$REX['CLANG'][$REX['CUR_CLANG']]."&SHOPKEY=";
		$_REQUEST['SHOPLANG']=$REX['CLANG'][$REX['CUR_CLANG']];
	}
?>