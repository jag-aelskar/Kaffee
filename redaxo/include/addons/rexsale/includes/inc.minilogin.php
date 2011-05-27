<?php
	# Mini Login
	$module=new Smart;
	$module->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
	$url=str_replace("index.html","",$shopurl);
	$module->assign('url',$url);
	$shopconfig=new ooRexSaleConfig();
	$module->assign('config',$shopconfig->settings);
	$module->assign('lang',$I18N_A153_REXSALE->text);
	
	$REXSALE['user'] = new ooRexSaleUser;
	$module->assign('userdata',$REXSALE['user']->getUserData($_SESSION['rexsale']['user']['id']));
	if ($REXSALE['user']->authenticate() == 'yes')
	{	$module->assign('authed','1');
	}
	else
	{	$module->assign('authed','0');
	}
	
	$url=str_replace("index.html","",$shopurl);
	ob_start();
	$module->assign('session',$session);
	$module->display('frontend-minilogin.htm');
	$out['minilogin']=ob_get_contents();
	ob_end_clean();			
	unset($module);
	unset($shopconfig);
?>