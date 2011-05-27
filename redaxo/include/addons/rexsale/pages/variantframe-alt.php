<?php
	if ($_POST['price']!="")
	{	$US['SAVE'] = new sql;
		$US['SAVE']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
		$US['SAVE']->setValue('rVALUEID',$_POST['values'][$_POST['options']]);		
		$US['SAVE']->setValue('rOPTIONID',$_POST['options']);
		
		
		$_POST['price']=str_replace("€","",$_POST['price']);
		$_POST['price']=str_replace("$","",$_POST['price']);
		$_POST['price']=str_replace("£","",$_POST['price']);
		$_POST['price']=str_replace(",",".",$_POST['price']);
		
		$US['SAVE']->setValue('fPRICE',$_POST['price']);
		
		
		$US['SAVE']->setValue('fMODIFIER',$_POST['modifier']);
		$US['SAVE']->wherevar='WHERE (fINDEX='.$_POST['variantID'].')';
		$US['SAVE']->update();
	}
	
	
	if (($_POST['addVariant']!="") || ($_POST['addVariant_x'])!=0)
	{	
		
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
		$AS['ADD']->setValue('rVALUEID',0);		
		$AS['ADD']->setValue('rOPTIONID',0);
		$AS['ADD']->setValue('rPRODID',$_GET['product']);
		$AS['ADD']->setValue('fPRICE',0);
		$AS['ADD']->setValue('fMODIFIER','+');
		$AS['ADD']->insert();

	}
	
	if (!empty($_POST['del']))
	{	foreach ($_POST['del'] as $k=>$v)
		{	$DS['DEL'] = new sql;
			$DS['DEL']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$DS['DEL']->wherevar='WHERE fINDEX = '.$k;
			$DS['DEL']->delete();
		}
	}
	
	

	$variants = new ooRexSaleVariant();
	$variants->setLanguage($_REQUEST['clang']);	
	
	
	$options = $variants->getOptions();
	
	foreach($options as $k=>$v)
	{	$values[$k]=$variants->getValuesForOption($k);
	}
	
	$productvariants=$variants->getVariantsForProduct($_GET['product']);
	
	$page->assign("variants",$productvariants);
	$page->assign("options",$options);
	$page->assign("values",$values);


	
	#dbprint($_POST);
	#dbprint($productvariants);

	$page->display('backend-variantframe.htm');
?>