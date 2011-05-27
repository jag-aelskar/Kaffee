<?php
	# Shop Menu
	unset($art);
	
	ob_start();
	$module=new Smart;
	$module->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
	
	$I18N_A153_REXSALE = new i18n(ooRexSaleConfig::getSetting('Languages',$REX['CUR_CLANG']),$REX['INCLUDE_PATH']."/addons/rexsale/lang");
	if ($REX['VERSION'] == 4 && $REX['SUBVERSION']>1) {
		$I18N_A153_REXSALE->appendFile($REX['INCLUDE_PATH'].'/addons/rexsale/lang/');
	}

	$url=$REX['CLANG'][$REX['CUR_CLANG']]."/".ooRexSaleConfig::getSetting('General','ShopDir')."/";
	
	if (!isset($settings)) {
		$settings="";
	}
	
	$REXSALE['user'] = new ooRexSaleUser;
	if ($REXSALE['user']->authenticate() == 'yes')
	{	$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$shopurl.'account/index.html',$I18N_A153_REXSALE->msg('account'),'a');
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$shopurl.'logout/index.html',$I18N_A153_REXSALE->msg('logout'),'l');
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$shopurl.'basket/index.html&amp;basket='.$session."&amp;settings=".$settings,$I18N_A153_REXSALE->msg('basket'),'b');
	}
	else
	{	
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$shopurl.'account/index.html&amp;basket='.$session."&amp;settings=".$settings.'&amp;lastpage='.base64_encode($_SESSION['rexsale']['lastpage']),$I18N_A153_REXSALE->msg('login'),'a');
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$shopurl.'basket/index.html&amp;basket='.$session."&amp;settings=".$settings,$I18N_A153_REXSALE->msg('basket'),'b');
	}
	
	
	# Read out site documents and generate navigation
	$cats=OOCategory::getCategoryById($redaxo_shop_id);
	$articles=$cats->getArticles();
	
	$SEF=new ooRexSaleSEF;
	# If the docs folder exists
	foreach ($articles as $key)	
	{	if ($key->getId()!=ooRexSaleConfig::getSetting('General','StartPage'))
		if (!$key->isStartArticle() && $key->_status == 1)
		{	$name=$SEF->prepare($key->getValue('name'));
			$shopnav[]=array($REX['ADDON']['REXSALE']['BASE']."/".$shopurl.'document/'.$name.'/index.html',$key->getValue('name'),'d',$name);
		}
	}

	$module->assign('shopnav',$shopnav);
		
	if ($REX['ADDON']['REXSALE']['DOCUMENT']!="")
	{	$module->assign('shopmode',$REX['ADDON']['REXSALE']['DOCUMENT']);
		
	}
	else
	{	$module->assign('shopmode',$REX['ADDON']['REXSALE']['MODE']);
	}
	$module->display('frontend-module-shopmenu.htm');
	unset($shopnav);
	unset($module);
	$out['shopnavi']=ob_get_contents();
	ob_end_clean();
?>
