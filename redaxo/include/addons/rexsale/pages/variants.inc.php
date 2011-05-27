<?php
	
	if (isset($_POST['addOption_x']))
	{	$variant=new ooRexSaleVariant();
		$variant->addOption();
		unset($variant);
	}
	if (isset($_POST['delOption_x']))
	{	$variant=new ooRexSaleVariant();
		$variant->delOption($_POST['options']);
		unset($variant);
	}
	
	if ($_POST['mode']=="renOption")
	{	if ($_POST['modevalue']!="")
		{	$variant=new ooRexSaleVariant();
			$variant->renameOption($_POST['options'],utf8_decode($_POST['modevalue']),$_POST['clang']);
		}
		unset($variant);
	}
	
	if ($_POST['mode']=="renValue")
	{	if ($_POST['modevalue']!="")
		{	$variant=new ooRexSaleVariant();
			$variant->renameValue($_POST['options'],$_POST['values'][$_POST['options']],utf8_decode($_POST['modevalue']),$_POST['clang']);
		}
		unset($variant);
	}
	
	if (!empty($_POST['addValue']))
	{	$variant=new ooRexSaleVariant();
		
		foreach($_POST['addValue'] as $k=>$v)
		{	$variant->addValue($k);
		}
		unset($variant);
	}
	if (!empty($_POST['delValue']))
	{	$variant=new ooRexSaleVariant();
		foreach($_POST['values'] as $k=>$v)
		{	$variant->delValue($v);
		}
		unset($variant);
	}
	
	

	$variants = new ooRexSaleVariant();
	$variants->setLanguage($_REQUEST['clang']);	
	$options = $variants->getOptions();

	
	if (is_array($options))
	{
		foreach($options as $k=>$v)
		{	$values[$k]=$variants->getValuesForOption($k);
		}
	}
	$smarty->assign("options",$options);
	$smarty->assign("values",$values);
	$smarty->display("backend-variants.htm");
?>