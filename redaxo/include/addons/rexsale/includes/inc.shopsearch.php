<?php
//deal with ajax requests here
if (isset($_REQUEST["q"]))
{	if (strlen($_REQUEST["q"])>2)
	{	$x = new ooRexSaleSearch;
		
		$x->setQuery(rex_request('q','string'));
		$x->search();
		$x = $x->getResults();
		
		if (count($x)>0) {
			foreach ($x as $id) {
				$prod = new OORexSaleProduct();
				$prod->setProduct($id);
				$prod->setLanguage($REX['CUR_CLANG']);
				
				$url=str_replace("index.html","",$shopurl).$prod->info['url'];
				$url=str_replace('&amp;','&',$url);
				echo $prod->info['name']."~~~".$url."\n";	
			}
		} else {
			echo $I18N_A153_REXSALE->msg('noResults');
		}
		
	}
	die();
}


ob_start();
$module=new Smart;
$module->assign('lang',$I18N_A153_REXSALE->text);
$module->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
$module->assign('base',$REX['ADDON']['REXSALE']['BASE']);
$module->assign('url',str_replace("index.html","",$shopurl));
$module->display('frontend-shopsearch.htm');
unset($module);
$out['shopsearch']=ob_get_contents();
ob_end_clean();	
?>