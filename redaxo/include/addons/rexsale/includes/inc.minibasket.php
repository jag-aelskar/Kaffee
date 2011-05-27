<?php
	# Mini Basket
	$module=new Smart;
	$module->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
	$module->assign('lang',$I18N_A153_REXSALE->text);
	
	$module->assign('url',$shopurl);
	
	
	$basket=new ooRexSaleCart;
	$module->assign('cart',$basket->items);
	$items=0;
	if (count($basket->items)>0)
	{   foreach ($basket->items as $amount)
		{ 	$items=$items+$amount['amount'];
		}
	}
				
	switch ($REX['ADDON']['REXSALE']['MODE'])
	{	# Don't show on basket, account or register pages
		/*	case "b": break; 
			case "a": break;
			case "r": break;
			case "t": break;
		*/
		default:
			ob_start();
			$session=base64_encode(serialize($_SESSION['rexsale']['cart']));			
			
			$module->assign('baskettotalwithoutpostage',$basket->totalwithoutpostage);
			$shopconfig=new ooRexSaleConfig;
			$module->assign('config',$shopconfig->settings);
			unset($shopconfig);
			$module->assign('session',$session);
			$module->assign('items',$items);
			$shopconfig=new ooRexSaleConfig;
			$module->assign('config',$shopconfig->settings);
			unset($shopconfig);
			$module->display('frontend-minibasket.htm');
			$out['minibasket']=ob_get_contents();
			ob_end_clean();
		break;
	}
	unset($module);
	unset($basket);
	
?>