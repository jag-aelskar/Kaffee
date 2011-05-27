<?php
if (!isset($_POST['ajax'])) {
	$_POST['ajax']="";
}
if ($_POST['ajax']=='variants')
{	# Tidy up the posts
	$level=str_replace('level','',$_POST['level']);
	$option=str_replace('variant','',$_POST['option']);
	$product=str_replace('variations','',$_POST['product']);
	$value=$_POST['value'];

	# Store the selected values in the session
	$vartree[$level]=$value;
		
	# If the top levels change, erase the selected under-levels.
	if (count($vartree)>0)
	{	foreach ($vartree as $k=>$v)
		{	if ($k>$level)
			{	unset($vartree[$k]);
			}
		}
	}
	
	# Enable the next level to be selected
	$vartree[$level+1]='enabled';
	
	#dbprint($_SESSION);

	
	# Reassign the vartree to smarty
	$module->clear_assign('vartree');
	$module->assign('vartree',$vartree);
	
	# Find and display the variants
	$vars=new ooRexSaleVariant();
	$vars->setLanguage($REX['CUR_CLANG']);
	$vars=$vars->getVariantsForProduct($prod->info['id'],&$vartree);

	
	## Re-Process Variants
	include $REX['INCLUDE_PATH']."/addons/rexsale/includes/makevariants.inc.php";


	# Reassign variants
	$module->clear_assign('variations');
	$module->assign('ajaxmode',1);
	$module->assign('variations',$variations);
	
	$module->display('frontend-variants.htm');
	
	
	die();
}

if ($_POST['ajax']=="recalc")
{	
	# Tidy posts
	$productID=str_replace('variations','',$_POST['product']);
	
	$product=new ooRexSaleProduct();
	$product->setLanguage($REX['CUR_CLANG']);
	$product->setProduct($productID);
	$price=round($product->info['priceGross'],2);
	
	#print_r($product);
	
	$vars=new ooRexSaleVariant();
	$vars->setLanguage($REX['CUR_CLANG']);
	$vars=$vars->getVariantsForProduct($prod->info['id'],$vartree);
	
	if (is_array($vars))
	{	foreach ($vars as $k=>$v)
		{	if (in_array($v['wertID'],$vartree))
			{	$diff=floatVal($v['priceGross']);
				if ($v['modifier']=="-")
				{	$diff=$diff*-1;
				}
				$price=$price+$diff;
			}
		}
	}
	$price=number_format(round($price,2), 2, '.', '');
		
	if (OORexSaleConfig::getSetting('Currency','Position')=="L")
	{	$price=OORexSaleConfig::getSetting('Currency','Symbol')." ".$price;
	}
	else
	{	$price=$price." ".OORexSaleConfig::getSetting('Currency','Symbol');
	}
	$price=str_replace('.',OORexSaleConfig::getSetting('Currency','Separator'),$price);
	echo $price;
	
	$_SESSION['calcPrices'][$prod->info['id']]=$price;
	
	die();
}

?>