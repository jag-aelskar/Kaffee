<?php	
	if (isset($_POST['addProduct']))
	{	$cat=new ooRexSaleCategory();	
		$cat->setLanguage($_REQUEST['clang']);	
		$cat->setCategory($_REQUEST['parent']);
		$cat->addProduct();
		#dbprint($_POST);
	}

	

	if (empty($_GET['mode']))
	{	$cat=new ooRexSaleCategory();	
		$cat->setLanguage($_REQUEST['clang']);	
		$cat->setCategory($_REQUEST['parent']);
		$prods=$cat->getProducts();	
	}
	else
	{	$prods[0]=new ooRexSaleProduct();
		$prods[0]->setLanguage($_REQUEST['clang']);	
		$prods[0]->setProduct($_REQUEST['product']);
	}
	
	
	if (!empty($_POST['mode']))
	{	switch ($_POST['mode'])
		{	case "save":
				
				
				
				$prod=new ooRexSaleProduct();
				$prod->setLanguage($_REQUEST['clang']);	
				$prod->setProduct($_REQUEST['product']);
				
				$prod->replaceImages($_REQUEST['REX_MEDIALIST_1']);
			
			break;
		}

	}

	
	$page->display("backend-products.htm");
?>