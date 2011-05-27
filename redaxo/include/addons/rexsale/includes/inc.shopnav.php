<?php
	# Shop Navigation
	$cat = new ooRexSaleCategory();
	
	$cat->setLanguage($REX['CUR_CLANG']);
	$cat->setCategory(0);
	

	$cachefile=$REX['INCLUDE_PATH'].'/generated/files/rexsale.cache.tree.'.$REX['CUR_CLANG'].'.txt';
	if (file_exists($cachefile))
	{	$data=file_get_contents($cachefile);
		$tree=unserialize($data);	
	}
	else
	{	$tree=$cat->getCategoryTree();
	
		# Write cache file				
		$fh = fopen($cachefile, 'w') or die("Please check permissions on the GENERATED folder.");
		$stringData = serialize($tree);
		fwrite($fh, $stringData);
		fclose($fh);
	} //end cache
	
	
	if (isset($REX['ADDON']['REXSALE']['RID'])) {
		$activeShopCat=$REX['ADDON']['REXSALE']['RID'];
	}
	else {
		$activeShopCat="";
	}
	
	if (isset($REX['ADDON']['REXSALE']['RCAT'])) {
		if ($REX['ADDON']['REXSALE']['RCAT']!=0) {
			$activeShopCat=$REX['ADDON']['REXSALE']['RCAT'];
		}
	}
	
	
	$parents=$cat->getParents($activeShopCat);
	
	if (count($parents)>0)
	{	$pars=$parents;
		unset($parents);
		foreach ($pars as $k=>$v)
		{	$parents[$v[0]]=1;
		}
	}
	
	
	
	ob_start();
	$module=new Smart;
	$module->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
	$module->assign('base',$REX['ADDON']['REXSALE']['BASE']);
	$module->assign('shopcatnav',$tree);
	$module->assign('activeShopCat',$activeShopCat);
	$module->assign('shopcatparents',$parents);
	$module->assign('url',str_replace("index.html","",$shopurl));
	$module->display('frontend-shopnav.htm');
	unset($module);
	$out['shopcats']=ob_get_contents();
	ob_end_clean();
?>