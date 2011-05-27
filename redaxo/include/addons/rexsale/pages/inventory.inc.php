<?php
	if (!function_exists('textext'))
	{	function textext($id,$content,$style="")
		{   echo '<textarea style="'.$style.'" name="VALUE['.$id.']" id="TEXEDITOR_'.$id.'">'.$content.'</textarea><br />';
			echo '<input type="hidden" name="LINK['.$id.']" id="LINK_'.$id.'" value="" />';
			echo '<input type="hidden" size="30" name="LINK_NAME['.$id.']" value="" id="LINK_'.$id.'_NAME" readonly="readonly" />';
			echo '<a href="#" onclick="openLinkMap(\'LINK_'.$id.'\', \'&clang=0&category_id=0\');checkFieldsNow(\''.$id.'\');return false;"><img src="media/liste.gif" width="16" height="16" alt="Open Linkmap" title="Open Linkmap" /></a>&nbsp;&nbsp;';
			echo '<input type="hidden" size="30" name="MEDIA['.$id.']" value="" id="REX_MEDIA_'.$id.'" readonly="readonly" />';
			echo '<a href="#" onclick="openREXMedia(\''.$id.'\',\'\');checkFieldsNow(\''.$id.'\');return false;" tabindex="24"><img src="media/file_open.gif" width="16" height="16" title="Open Mediapool" alt="Open Mediapool" /></a><br />';
		}
	}


	##################################################################
	# Editing Categories
	if (isset($_POST['editcat']))
	{	
		$cat=new ooRexSaleCategory();
		if ($_POST['clang']!="")
		{	$cat->setLanguage($_POST['clang']);
		}
		$cat->setCategory($_POST['id']);
		
		if ($_POST['catname']!="")
		{	$cat->changeName($_POST['catname']);
		}
	
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_POST['id']);
	
		
		header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_POST['parent'].'&clang='.$_POST['clang']);
		die();
		
	}
	else if (isset($_POST['delcat']))
	{	
		$cat=new ooRexSaleCategory();
		$cat->setCategory($_POST['id']);
		if (!$cat->suicide())
		{	$smarty->assign('errors',$cat->errors);
		}
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_POST['parent']);
	
		
	}
	else if (isset($_POST['addcat']))
	{		
		if ($_POST['catname']!="")
		{	$cat=new ooRexSaleCategory();
			$cat->setLanguage($_POST['clang']);
			$cat->addCategory();
		}
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_POST['parent']);
		
		header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_POST['parent'].'&clang='.$_POST['clang']);
		die();
		
	}
	else if (isset($_POST['catmeta']))
	{	
	
		$cat=new ooRexSaleCategory();
		$cat->setLanguage($_POST['clang']);
		$cat->setCategory($_POST['id']);
		$cat->setMetaInfo($_POST['VALUE']['metatext'],$_POST['metatitle'],$_POST['metakeywords'],$_POST['REX_MEDIA_1']);
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_POST['id']);
		
		header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_POST['id'].'&clang='.$_POST['clang']."&metaUpdated=1");
		die();
	}
	
	
	if ($_GET['toggleCat']!="")
	{	
	
		$cat=new ooRexSaleCategory();
		$cat->setCategory($_GET['toggleCat']);
		$cat->toggleStatus();
		
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_GET['toggleCat']);
		
		header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_GET['parent'].'&clang='.$_GET['clang']);
		die();		
	}
	
	/* Thanks to Alex for the bugfix 
		http://bugs.rexsale.de/showreport.php?bugid=66
		*/
	
	if ($_GET['toggleProd']!="")
	{ 	$prod=new ooRexSaleProduct();
		$prod->setProduct($_GET['toggleProd']);
		$prod->toggleStatus();
		
		//regenerating the SEF
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_GET['parent']);
		

	}
	
	unset($cat);
	unset($prod);
		
	
	##################################################################
	# Editing Products
	if (isset($_POST['addProduct']))
	{	
	
		$cat=new ooRexSaleCategory();	
		$cat->setLanguage($_REQUEST['clang']);	
		$cat->setCategory($_REQUEST['parent']);
		$cat->addProduct();
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_REQUEST['parent']);	
		
		unset($cat);
	}
		
	if (isset($_POST['delProduct']))
	{	
		$prod=new ooRexSaleProduct();	
		$prod->setProduct($_POST['editProd']);
		$prod->setCategory($_REQUEST['parent']);
		$prod->suicide();
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_REQUEST['parent']);
	
		
		header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_POST['parent']);
		die();
	}
	if (isset($_POST['editProduct']) || isset($_POST['applyProduct']))
	{	
	
		$prod=new ooRexSaleProduct();
		$prod->setLanguage($_REQUEST['clang']);	
		$prod->setProduct($_REQUEST['editProd']);
				
		$prod->updateData($_POST['data'],$_REQUEST['clang']);
		$prod->replaceImages($_REQUEST['REX_MEDIALIST_1']);
		unset($prod);
		
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory($_POST['parent']);
		
		
		if (isset($_POST['editProduct']))
		{	header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_POST['parent']);
			die();
		}
		else
		{	header("Location:index.php?page=rexsale&subpage=inventory&parent=".$_POST['parent'].'&clang='.$_POST['clang']."&editProd=".$_POST['editProd']);
		}
		
		
		die();		
	}
	


	##################################################################
	# Tree for this category
	$tree=new ooRexSaleCategory();	

	if ($_REQUEST['clang']!="")
	{	$tree->setLanguage($_REQUEST['clang']);
	}
	if ($_REQUEST['parent']!="")
	{	$tree->setCategory($_REQUEST['parent']);
	}
	else
	{	$tree->setCategory(0);
	}
	
	# Breadcrumbs for this category
	$crumbs = $tree->getParents();
	$smarty->assign("crumbs",$crumbs);
	
	$tree=$tree->getChildren();
	if (is_array($tree))
	{	foreach ($tree as $leaf)
		{	$cattree[]=$leaf->info;
		}
		unset($tree);
	}
	$smarty->assign("cattree",$cattree);


	$tree=new ooRexSaleCategory();	
	if ($_REQUEST['clang']!="")
	{	$tree->setLanguage($_REQUEST['clang']);
	}
	$tree=$tree->getCategoryTree();
	$smarty->assign("categorymap",$tree);



	$sql = new rex_sql;
	$sql->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'153_cats');
	$prodtree=array();
	 
	for ($i=0;$i<$sql->getRows();$i++) {
		
		$cat=new ooRexSaleCategory();	
		$cat->setLanguage($_REQUEST['clang']);	
	//	$cat->setCategory($sql->getValue('fID'));
			
		$sql->next();
	}
	
	
	$curcat = new ooRexSaleCategory();	
	if ($_REQUEST['parent']!="")
	{	$curcat->setCategory($_REQUEST['parent']);
		$curcatid=$_REQUEST['parent'];
	}
	
/*
	$prods=$curcat->getProducts();
	if (count($prods)>0)
	{	$j=0;
		foreach ($prods as $product)
		{	$prodtree[$curcatid][]=$product->info;
			$j++;
		}
	}
	
 
	
	
	$smarty->assign('prodmap',$prodtree);*/
	

	##################################################################
	# Products for this category
	$cat=new ooRexSaleCategory();	
	$cat->setLanguage($_REQUEST['clang']);	
	$cat->setCategory($_REQUEST['parent']);
	
	$smarty->assign('catinfo',$cat->info);
	
	$prods=$cat->getProducts();
	
	
	if (count($prods)>0)
	{	$i=0;
		foreach ($prods as $product)
		{	$products[$i]=$product->info;
			$i++;
		}
	
	}
	
	
	##################################################################
	# Taxes
	$tax=new ooRexSaleTax();
	$taxes=$tax->getTaxList();
	$smarty->assign("taxes",$taxes);

	##################################################################
	# META Field Labels
	for($i=1;$i<6;$i++)
	{	$metalabels[$i]=ooRexSaleConfig::getSetting('MetaFields','MetaField'.$i);
	}

	$smarty->assign('metalabels',$metalabels);
	$smarty->assign('products',$products);
	
	$smarty->display("backend-inventory.htm");
	
	
	
?>
