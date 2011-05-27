<?php
/*
 *	REXSale, by GN2-Netwerk. 
 * 	SVN Version: $id$
 *	http://bugs.rexsale.de/
 */

if (!$REX['REDAXO'])
{	$_REQUEST = array_map('rexsaleclean', $_REQUEST);
	$_GET = array_map('rexsaleclean', $_GET);
	$_POST = array_map('rexsaleclean', $_POST);
	$_COOKIE = array_map('rexsaleclean', $_COOKIE); 
	
	$I18N_A153_REXSALE = new i18n(ooRexSaleConfig::getSetting('Languages',$REX['CUR_CLANG']),$REX['INCLUDE_PATH']."/addons/rexsale/lang");
	if ($REX['VERSION'] == 4 && $REX['SUBVERSION']>1) {
		$I18N_A153_REXSALE->appendFile($REX['INCLUDE_PATH'].'/addons/rexsale/lang/');
	}

	$shopconfig = new ooRexSaleConfig;
	
	$module=new Smart;
	$module->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
	
	if (isset($_SESSION['REXSALE']['ERROR'])) {
		if ($_SESSION['REXSALE']['ERROR']!="") {	
			$module->assign('error',$_SESSION['REXSALE']['ERROR']);
			unset($_SESSION['REXSALE']['ERROR']);
		}	
	}
	
	
	
	$module->assign('CLANG',$REX['CUR_CLANG']);	
	
	$module->assign('base',$REX['ADDON']['REXSALE']['BASE']);
	
	if (!isset($redaxo_shop_id)) {
		$redaxo_shop_id=0;
	}
	$url=strtolower(rex_getUrl($redaxo_shop_id));

	$url=str_replace("index.html","",$url);
	if (!$REX['MOD_REWRITE'])
	{	$url.="&SHOPLANG=".$REX['CLANG'][$REX['CUR_CLANG']]."&SHOPKEY=";
		$_REQUEST['SHOPLANG']=$REX['CLANG'][$REX['CUR_CLANG']];
	}
	if (!isset($_REQUEST['SHOPKEY'])) {
		$_REQUEST['SHOPKEY']="";
	}
	$module->assign('PHPSELF','/'.$url.$_REQUEST['SHOPKEY']);		
	
	# Store SSL address for redirection after login.
	if (		$REX['ADDON']['REXSALE']['MODE']!="a" 
			&& 	$REX['ADDON']['REXSALE']['MODE']!="l"
			&& 	$REX['ADDON']['REXSALE']['MODE']!="r"
		)
	{	$_SESSION['rexsale']['lastpage']=ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$url.$_REQUEST['SHOPKEY'];
	}
	
	if (!isset($_POST['lastpage'])) {
		$_POST['lastpage']="";
	}
	
	if ($_POST['lastpage']!="")
	{	$_SESSION['rexsale']['lastpage']=$_POST['lastpage'];
	}
	$module->assign('lastpage',$_SESSION['rexsale']['lastpage']);
	
	
	# Get the user
	if (!isset($_SESSION['REXSALEUSER'])) {
		$_SESSION['REXSALEUSER']="";
	}
	if ($_SESSION['REXSALEUSER']=="")
	{	$REXSALE['user'] = new ooRexSaleUser;
	}
	else
	{	$REXSALE['user'] = &$_SESSION['REXSALEUSER'];
	}
	
	
	if ($REXSALE['user']->authenticate() == 'sessionerror')
	{	$REXSALE['user']->logout();
	}
	else if ($REXSALE['user']->authenticate() == 'yes')
	{	$REXSALE['authed']=1;
		$module->assign('authed','1');
	}
	else
	{	$REXSALE['authed']=0;
		$module->assign('authed','0');
	}

	$REXSALE['basket'] = new ooRexSaleCart;	
	# Retrieve basket when transferring to SSL
	if (!isset($_REQUEST['basket'])) {
		$_REQUEST['basket']="";
	}
	if ($_REQUEST['basket']!="")
	{	$basket=unserialize(base64_decode($_REQUEST['basket']));
		$REXSALE['basket']->cart=$basket;
	}
	# Retrieve basket settings when transferring
	if (!isset($_REQUEST['settings'])) {
		$_REQUEST['settings']="";
	}
	if ($_REQUEST['settings']!="")
	{	$settings=unserialize(base64_decode($_REQUEST['settings']));
		$REXSALE['basket']->settings=$settings;
	}
		
	# If the user has just logged in and has already confirmed the basket
	if (!isset($_REQUEST['confirmed'])) {
		$_REQUEST['confirmed']="";
	}
	if ($_REQUEST['confirmed']==1)
	{	$_SESSION['rexsale']['settings']['confirmed']=1;
		$REXSALE['basket']->settings['confirmed']=1;
	}
	else
	{	// reset the confirmed to 0 if the user failed login/left the login page after confirmation
		if ($REXSALE['authed']==0 && $REX['ADDON']['REXSALE']['MODE']!="a" && $REX['ADDON']['REXSALE']['MODE']!="r")
		{	$_SESSION['rexsale']['settings']['confirmed']=0;
			$REXSALE['basket']->settings['confirmed']=0;
		}
	}
	//dbprint($_SESSION['rexsale']['settings']);

	# Update the session/basket when the user agrees to tocs
	if (!isset($_POST['TOC'])) {
		$_POST['TOC']="";
	}
	if ($_POST['TOC']=="on")
	{	$_SESSION['rexsale']['settings']['TOC']=1;
		$REXSALE['basket']->settings['TOC']=1;
	}
	
	if (isset($_POST['editBasket']))
	{	$_SESSION['rexsale']['settings']['confirmed']=0;
		$REXSALE['basket']->settings['confirmed']=0;
		header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."basket/index.html");
		die();
	}
	
	if (isset($_POST['editDetails']))
	{	header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."account/update/index.html");
		die();
	}
	
	$module->assign('config',$shopconfig->settings);
	$module->assign('lang',$I18N_A153_REXSALE->text);
	
	//dbprint($_SESSION['rexsale']['settings']);
	
	$session=base64_encode(serialize($_SESSION['rexsale']['cart']));
	$settings=base64_encode(serialize($_SESSION['rexsale']['settings']));
	
	
	
	$module->assign('usersettings',$settings);
	
	
	# Posts
	if (!isset($_REQUEST['action'])) {
		$_REQUEST['action']="";
	}
	switch ($_REQUEST['action'])
	{	case "addUpdateBasket":
			
			$str = "";
			if (isset($_POST['variations'])) {
			if (is_array($_POST['variations'])) {
				foreach ($_POST['variations'] as $k=>$v) {	
					$str.="#".$v;
				}
				}
			}
			$str.="#";
			$str=$_POST['product'].'-'.substr($str,1,strlen($str)-2);
			
			
			$REXSALE['basket']->addUpdateBasket($str,$_POST['amount']);
			
			
			header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url.$_REQUEST['SHOPKEY']);
			die();
		break;
		
		case "continueShopping":
			header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."index.html");
			die();
		break;
			
		case "updateAmounts":
			# Save the post info 
			if ($_GET['returnstring']=="")
			{	$_SESSION['rexsale']['oldpost']=$_POST;
			}
			else
			{	#If the returnstring is set, retrieve the cached POST.
				$_POST=$_SESSION['rexsale']['oldpost'];
			}		
						
			if ($_POST['TOC']=="on")
			{	$_SESSION['rexsale']['settings']['TOC']=1;
				$REXSALE['basket']->settings['TOC']=1;
			}
			else
			{	$_SESSION['rexsale']['settings']['TOC']=0;
				$REXSALE['basket']->settings['TOC']=0;			
			}	
			
			$REXSALE['basket']->updateAmounts($_POST['amounts']);
			
			
			
			if ($REXSALE['basket']->settings['shippingSet']=="")
			{	$REXSALE['basket']->settings['shippingSet']=$_POST['shippingSet'];
			}			

			if ($_POST['shippingSet']!=$REXSALE['basket']->settings['shippingSet'])
			{	$REXSALE['basket']->settings['paymentMethod']=0;
				$REXSALE['basket']->settings['shippingSet']=$_POST['shippingSet'];
			}
			else
			{	$REXSALE['basket']->settings['paymentMethod']=$_POST['paymentMethod'];			
			}
			
			
			$paymentMethod=new ooRexSalePaymentSet();
			$paymentCost=$paymentMethod->getPaymentMethodPrice($REXSALE['basket']->settings['paymentMethod']);
			
			
			
			$REXSALE['basket']->setPostage($paymentCost);
			if ($paymentCost==="0") {
				$REXSALE['basket']->settings[originalpostage] = 0;
				$REXSALE['basket']->postage = $REXSALE['basket']->formatPrice(0);
			}
			
			
			#die('add update');
			
			if (!empty($_POST['bank']))	
			{	# Wird nur ueber SSL gesetzt!!!
				setcookie("bank", base64_encode(serialize($_POST['bank'])), time()+300,'','',1);
			}
			
			if (!empty($_POST['toTill']) && $_POST['TOC']!="on" && $REXSALE['basket']->settings['confirmed']==1)
			{	$_SESSION['REXSALE']['ERROR']=$I18N_A153_REXSALE->msg('noTOC');
			
				header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."basket/index.html");
				die();
			}
			
			
			if (!empty($_POST['toTill']) || (($_GET['returnstring']==$_SESSION['rexsale']['returnID']) && ($_GET['returnstring']!="")))
			{	
				if ($REXSALE['authed']==0)
				{	header("Location:".ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$url."account/index.html&basket=".$session."&settings=".$settings."&confirmed=1");
					die();
				}
				else
				{	if ($REXSALE['basket']->settings['confirmed']!=1)
					{	$_SESSION['rexsale']['settings']['confirmed']=1;
						header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."basket/index.html");
						die();
					}

					
					# Download code
					if ($REX['ADDON']['REXSALE']['MODE']!="t") {
						$items=$REXSALE['basket']->items;
						
						$userID = $_SESSION['rexsale']['user']['id'];				
	
						$downloads = '';					
						foreach ($items as $item) {
							$id = explode('-',$item['ident']);
							$id = $id[0];
							
							$x = new OORexSaleProduct();
							$x->setLanguage($REX['CUR_CLANG']);
							$x->setProduct($id);
							$download = $x->info['download'];
																			
							if ($download!="") {
								OORexSaleDownload::registerDownload($id,$userID);
								$downloads.=','.$id;
							}
	
							
						}
						$downloads = trim($downloads,',');
					}
					
				
					# Mail order
					$benutzer=new ooRexSaleUser();
					
					
					$_SESSION['rexsale']['returnID']=rand().rand();
					
									
					$user=$benutzer->getUserData($_SESSION['rexsale']['user']['id']);
					
										
					##	Gateway redirection
						
						$gateway=new ooRexSalePaymentSet();
						$gateway=$gateway->getPaymentMethodFolderByConnectionID($REXSALE['basket']->settings['paymentMethod']);
						
									
						if ($gateway!="")
						{	$gatewaypath=$REX['INCLUDE_PATH'].'/addons/rexsale/gateways/'.$gateway.'/';
							$gatewayfile='gateway.inc.php';
							
							$gw=new Smart;
							$gw->template_dir=$gatewaypath;
							$user2=$user;
							unset($user2[0]['fPASSWORD']);
							$user2=$user2[0];
							
							
							$orderdata['total']=floatVal($REXSALE['basket']->total);
							$orderdata['totalwithoutpostage']=floatVal($REXSALE['basket']->totalwithoutpostage);
							
							$orderpostage=floatVal($REXSALE['basket']->postage);
							if ($orderpostage=="0") {$orderpostage="0.00";}
							
							$orderdata['postage']=$orderpostage;
							$orderdata['id']=$orderid;
							$orderdata['user']=$user2;
							
							//$basketurl=$shopconfig->getSetting('Security','BaseSSL')."/".$_REQUEST['SHOPLANG']."/".$shopconfig->getSetting('General','ShopDir')."/basket/index.html";
							
							$basketurl=$shopconfig->getSetting('Security','BaseSSL')."/index.php?article_id=".$shopconfig->getSetting('General','ShopArticleID').'&clang='.$_REQUEST['clang'].'&SHOPLANG='.$_REQUEST['SHOPLANG'].'&SHOPKEY=basket/index.html';
							
							$gw->assign('order',$orderdata);
							$gw->assign('gateway',$gatewaysettings);
							$gw->assign('shop',$shopconfig->settings);
							$gw->assign('basketurl',$basketurl);
							$gw->assign('return',$_SESSION['rexsale']['returnID']);
							$gw->assign('lang',$I18N_A153_REXSALE->text);
							
							if (file_exists($gatewaypath.'gateway.ini'))
							{	$cfg = new iniParser($gatewaypath.'gateway.ini');
								$cfg = $cfg->_iniParsedArray;
								$gw->assign('config',$cfg);
							}
							
							if (file_exists($gatewaypath.$gatewayfile))
							{	include($gatewaypath.$gatewayfile);
							}
							
							
						}
											
					##
					$order=new ooRexSaleOrder();
					
					
					
					$user[0]['fBILL_COUNTRY']=$benutzer->getUserCountry($user[0]['rBILL_COUNTRY']);
					$user[0]['fDEL_COUNTRY']=$benutzer->getUserCountry($user[0]['rDEL_COUNTRY']);
					
					echo '<pre>';
										
					$txtmail=new Smart;
					$txtmail->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/emails";
					$txtmail->assign('orderid','temp_id'); // patch bugid=80
					$txtmail->assign('user',$user[0]);
					
					$items=$REXSALE['basket']->items;
					foreach ($items as $key=>$value)
					{	$items[$key]=$value;
						$items[$key]['name']=str_pad($items[$key]['name'], 60 , " "); 
						$items[$key]['price']=str_pad($items[$key]['price'], 20 , " "); 
					}

					$txtmail->assign('config',$shopconfig->settings);
					$txtmail->assign('lang',$I18N_A153_REXSALE->text);
					$txtmail->assign('date',date("d.m.Y"));
					
					$paymentMethod=new ooRexSalePaymentSet;
					$paymentMethod=$paymentMethod->getPaymentMethodByConnectionID($REXSALE['basket']->settings['paymentMethod']);
					$txtmail->assign('payment',$paymentMethod);
					$txtmail->assign('paymentID',$REXSALE['basket']->settings['paymentMethod']);
					
					$txtmail->assign('basket',$items);
					$txtmail->assign('settings',$REXSALE['basket']->settings);
					
					$txtmail->assign('basketpostage',$REXSALE['basket']->postage);
					$txtmail->assign('baskettax',$REXSALE['basket']->includedTax);
					$txtmail->assign('baskettotal',$REXSALE['basket']->total);
					$txtmail->assign('freepostage',$REXSALE['basket']->settings['freepostage']);
					ob_start();
					$txtmail->display('order.txt');
					$txtmail=ob_get_contents();
					$txtmail=str_replace("€","EUR",$txtmail);
					$txtmail=utf8_decode($txtmail);
					ob_end_clean();
					echo '</pre>';


									
					$order->insert($txtmail,$user);
					
					if ($order->inserted!=false)
					{	$orderid=$order->getNewOrderNumber();
					}
					else
					{	die('REXsale - error! - please try again');
					}
												

					$mail = new PHPMailer;
					$mail->AddAddress($user[0]['fEMAIL']);
					$mail->AddAddress($shopconfig->getSetting('General','ShopMail'));
					$mail->From=$shopconfig->getSetting('General','ShopMail');
					$mail->FromName=$shopconfig->getSetting('General','ShopName');
					$mail->Subject = $shopconfig->getSetting('General','ShopName')." ".$I18N_A153_REXSALE->msg('order').": ".$orderid;
					$txtmail=str_replace("temp_id",$orderid,$txtmail); // patch bugid=80
					$mail->Body    = $txtmail;
					$mail->Send();
					
										
					
					if ($REXSALE['basket']->settings['paymentMethod']==1)
					{	# Direct Debit Mail
						$txtmail=new Smart;
						$txtmail->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/emails";
						$txtmail->assign('orderid',$orderid);
						$txtmail->assign('bank',$_POST['bank']);	
						$txtmail->assign('lang',$I18N_A153_REXSALE->text);
						$txtmail->assign('date',date("d.m.Y"));					
						ob_start();
						$txtmail->display('directdebit.txt');
						$txtmail=ob_get_contents();
						$txtmail=utf8_decode($txtmail);
						ob_end_clean();
											
						$mail = new PHPMailer;
						$mail->AddAddress($shopconfig->getSetting('General','ShopMail'));
						$mail->From=$user[0]['fEMAIL'];
						$mail->FromName=$user[0]['fEMAIL'];
						$mail->Subject = $shopconfig->getSetting('General','ShopName')." ".$I18N_A153_REXSALE->msg('bankData')." : ".$I18N_A153_REXSALE->msg('order').": ".$orderid.".";
						$mail->Body    = $txtmail;				
						$mail->Send();
					}				
					
					$REXSALE['basket']->emptyBasket();
					$_SESSION['rexsale']['settings']['TOC']=0;
					
					header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."thanks/index.html");
					
					
					die();
				}
			}
			else
			{	header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."basket/index.html");
				die();
			}
		break;
		
		
		
		
		default:
		break;
	}
	if (!empty($REXSALE['basket']->items)) {
		$module->assign('basket',$REXSALE['basket']->items);
	}
	$module->assign('baskettax',$REXSALE['basket']->includedTax);
	$module->assign('basketpostage',$REXSALE['basket']->postage);
	$module->assign('baskettotal',$REXSALE['basket']->total);
	$module->assign('baskettotalwithoutpostage',$REXSALE['basket']->totalwithoutpostage);


	#dbprint($_SESSION,'Session Output');
	
	
	$cat = new ooRexSaleCategory();
	$cat->setLanguage($REX['CUR_CLANG']);
	
	if ($REX['ADDON']['REXSALE']['MODE']=="p")
	{	$cat->setCategory($REX['ADDON']['REXSALE']['RCAT']);
	}
	else if ($REX['ADDON']['REXSALE']['MODE']=="c")
	{	$cat->setCategory($REX['ADDON']['REXSALE']['RID']);
	}
	
	if (!empty($cat->errors))
	{	#die("Fehler..");
	}
	
	$module->assign('url',$url);
	
	$parents=$cat->getParents();
	
	
	for ($i=0;$i<count($parents);$i++)
	{	$subcat = new ooRexSaleCategory();
		$subcat->setLanguage($REX['CUR_CLANG']);
		$subcat->setCategory($parents[$i][0]);
		
		$parents[$i][0]=$subcat->info['url'];
	}
	
	$module->assign('parents',$parents);

	
	# Shop Navigation

	if ($REXSALE['authed'])
	{	$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$url.'account/index.html',$I18N_A153_REXSALE->msg('account'),'a');
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$url.'logout/index.html',$I18N_A153_REXSALE->msg('logout'),'l');
	}
	else
	{	
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$url.'account/index.html&amp;basket='.$session."&amp;settings=".$settings.'&amp;lastpage='.base64_encode($_SESSION['rexsale']['lastpage']),$I18N_A153_REXSALE->msg('login'),'a');
		$shopnav[]=array(ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$url.'register/index.html&amp;basket='.$session."&amp;settings=".$settings,$I18N_A153_REXSALE->msg('register'),'r');
	}
	
	# Read out site documents and generate navigation
	$cats=OOCategory::getCategoryById($this->article_id);
	$articles=$cats->getArticles();
	
	$SEF=new ooRexSaleSEF;
	# If the docs folder exists
	foreach ($articles as $key)	
	{	if ($key->getId()!=ooRexSaleConfig::getSetting('General','StartPage'))

		if (!$key->isStartArticle())
		{	if ($key->_status == 1) {
				$name=$SEF->prepare($key->getValue('name'));
				$shopnav[]=array($REX['ADDON']['REXSALE']['BASE']."/".$url.'document/'.$name.'/index.html',$key->getValue('name'),'d');
			}
		}
	}
		
		
	
	$module->assign('shopnav',$shopnav);
	$module->assign('shopmode',$REX['ADDON']['REXSALE']['MODE']);
	
	
	# Shop Minibasket
	$items=0;
	if (count($REXSALE['basket']->items)>0)
	{   foreach ($REXSALE['basket']->items as $amount)
		{ 	$items=$items+$amount['amount'];
		}
	}
	$session=base64_encode(serialize($_SESSION['rexsale']['cart']));
	$module->assign('baskettotalwithoutpostage',$REXSALE['basket']->totalwithoutpostage);
	$module->assign('session',$session);
	$module->assign('items',$items);
	
	
	#dbprint($_POST);
	#dbprint($_SESSION);
	
		
	# Display
	
	switch($REX['ADDON']['REXSALE']['MODE'])
	{	case "c":	# Category Mode
			$cats=$cat->getChildren();
			$count = $cat->countProducts();
			$limit = intVal(ooRexSaleConfig::getSetting('CategoryView','pageAmount'));
			if ($limit == 0)
			{	$limit = 10;
			}
			
			if (isset($_GET['start']['cat'])) {
				$start = intVal($_GET['start']['cat']);
			}
			else {
				$start = 0;
			}
			
		
			//fix negative starts;		
			if ($start<0)
			{	$start=$start*-1;
			}
			$prods=$cat->getProducts(1,$start, $limit);
					
			ob_start();

			$pageCount=ceil($count/$limit);
			if ($pageCount>1)
			{	echo '<div class="pager">';
				if (isset($_GET['page']['cat'])) {
					$pageCat = intVal($_GET['page']['cat']);
				}
				else {
					$pageCat = 1;
				}
			
				for ($i=0;$i<$pageCount;$i++)
				{	$newStart=($i*$limit);
					$newEnd=$newStart+$limit;
					
					$val=($i+1);
					if (($i+1)==$pageCat)
					{	$class=' class="active"';
					}
					else
					{	$class='';
					}
					echo '<a'.$class.' href="'.$url.$cat->info['url'].'&amp;start[cat]='.$newStart.'&amp;page[cat]='.($i+1).'" >'.($val).'</a> ';
				}
				echo '</div>';
			}
			$data=ob_get_contents();
			ob_end_clean();
			$module->assign('catpager',$data);
			
						
			
			if (is_array($prods))
			{	
				foreach ($prods as $product)
				{	$products[]=$product->info;
					
					$vars=new ooRexSaleVariant();
					$vars->setLanguage($REX['CUR_CLANG']);
					
					$vars=$vars->getVariantsForProduct($product->info['id']);
					
					$vartree=&$_SESSION['VARTREE'][$product->info['id']];
			
					if (empty($vartree))
					{	$vartree=array("0"=>"enabled");
					}
					
					## Process Variants
					include $REX['INCLUDE_PATH']."/addons/rexsale/includes/makevariants.inc.php";
				}
				
			}
			else
			{	if ($cat->info['metatext']=="" && $cat->info['metabild']=="")
				{	
					$module->assign('message',$I18N_A153_REXSALE->msg('noProductsHere'));	
				}
				
			}
			if (isset($products)) {
				$module->assign('products',$products);
			}
			
			#dbprint($variations);
			if (isset($variations)) {
				$module->assign('variations',$variations);
			}
			
			$tree=$cat->getParents();
			$module->assign('url',$url);
			$module->assign('cattree',$tree);
			
			if (isset($vartree)) {
				$module->assign('vartree',$vartree);
			}
			
			$module->assign('category',$cat->info);
			$module->assign('stage','frontend-category');
			
			## Deal with ajax requests
			include $REX['INCLUDE_PATH']."/addons/rexsale/includes/variants.ajax.php";
		break;
		
		case "p":	# Products Detail Mode
			
			$cat=new ooRexSaleCategory();
			$cat->setLanguage($REX['CUR_CLANG']);
			$cat->setCategory($REX['ADDON']['REXSALE']['RCAT']);
			#dbprint($cat);
			$module->assign('overviewLink',$url.$cat->getValue('url'));
			$prods=$cat->getProducts(1);
			
			
			for ($i=0;$i<count($prods);$i++)
			{	
			
				$prodID=$REX['ADDON']['REXSALE']['RID'];
				$curProdID=$prods[$i]->getValue('id');
						
							
				if ($curProdID==$prodID)
				{					
					if (!empty($prods[$i-1]))
					{	$lastProdID=$prods[$i-1];
						$module->assign('lastProdLink',$url.$prods[$i-1]->getValue('url'));
					}
					else
					{	$module->assign('lastProdLink',$url.$prods[count($prods)-1]->getValue('url'));
					}
					if (!empty($prods[$i+1]))
					{	$nextProdID=$prods[$i+1];
						$module->assign('nextProdLink',$url.$prods[$i+1]->getValue('url'));
					}
					else
					{	$module->assign('nextProdLink',$url.$prods[0]->getValue('url'));
					}
							
				}
			}
			
			
			
			$prod = new ooRexSaleProduct();
			$prod->setLanguage($REX['CUR_CLANG']);
			$prod->setProduct($REX['ADDON']['REXSALE']['RID']);
			
			
			$related = $prod->info['related'];
			
			if (count($related)>0) {
				$related = array_unique($related);
				if (count($related)>0) {
				
					foreach ($related as $k=>$v) {
						$rProd = new ooRexSaleProduct;
						$rProd->setLanguage($REX['CUR_CLANG']);
						$rProd->setProduct($v);
						
						# get a cKey
						if (count($rProd->info['categories'])>0) {
							foreach ($rProd->info['categories'] as $cKey=>$cVal) {
								$cat = $cKey;								
							}
							//dirty dirty horrible horrible hack
							$rProd->info['url']=$REX['ADDON']['REXSALE']['PATHLIST']['PROD'][$cat][$v][0].'.html';
						}
						
						
						$related[$k]=$rProd;
											
						
						if ($rProd->getValue('name')=="") {
							unset($related[$k]);
						}
						
						
						
					}
				}
				
				$module->assign('related',$related);	
			}
			

			
			
			$vars=new ooRexSaleVariant();
			$vars->setLanguage($REX['CUR_CLANG']);
			
			$vartree=&$_SESSION['VARTREE'][$REX['ADDON']['REXSALE']['RID']];
			
			if (empty($vartree))
			{	$vartree=array("0"=>"enabled");
			}
			
			#dbprint($vartree);
			
			$vars=$vars->getVariantsForProduct($prod->info['id'],$vartree);
			
			#dbprint($vars);
			
			## Process Variants
			include $REX['INCLUDE_PATH']."/addons/rexsale/includes/makevariants.inc.php";
		
					
			$module->assign('category',$REX['ADDON']['REXSALE']['RCAT']);
			if (isset($variations)) {
				$module->assign('variations',$variations);
			}
			$module->assign('stage','frontend-product');
			$module->assign('vartree',$vartree);
			
			if (isset($_SESSION['calcPrices'][$prod->info['id']])) {
				$module->assign('calcPrice',$_SESSION['calcPrices'][$prod->info['id']]);
			}
			
			$module->assign('info',$prod->info);
			
			## Deal with ajax requests
			include $REX['INCLUDE_PATH']."/addons/rexsale/includes/variants.ajax.php";
			
		break;
		
		case "t":
			$module->assign('stage','frontend-thanks');
		break;
		
		case "l":					
			if ($REX['ADDON']['REXSALE']['SSL']==1)
			{	$REXSALE['user']->logout();
				header("Location:".ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$url."logout/index.html");
				die();
			}
			else
			{	$REXSALE['user']->logout();
				header("Location:".ooRexSaleConfig::getSetting('Security','BaseNoSSL')."/".$url);
				die();
			}
		break;
		
		case "b":   # Basket mode
			$RS['user']=new rex_sql;
			$RS['user']->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'users WHERE fID="'.$REXSALE['user']->getValue('id').'"');
			
			//dbprint($RS);
			
			if ($RS['user']->getRows()>0)
			{	$billaddr = trim($RS['user']->getValue('fBILL_FIRST_NAME')." ".
							$RS['user']->getValue('fBILL_LAST_NAME')."<br />".
							$RS['user']->getValue('fBILL_COMPANY')."<br />".
							$RS['user']->getValue('fBILL_STREET').", ".
							$RS['user']->getValue('fBILL_POST')." ".$RS['user']->getValue('fBILL_TOWN').".");
				$module->assign('billAddr',$billaddr);
				
				if ($RS['user']->getValue('fDEL_STREET') != "" && $RS['user']->getValue('fDEL_POST')!="" && $RS['user']->getValue('fDEL_TOWN')!="")
				{	$deladdr = trim($RS['user']->getValue('fDEL_FIRST_NAME')." ".
							$RS['user']->getValue('fDEL_LAST_NAME')."<br />".
							$RS['user']->getValue('fDEL_COMPANY')."<br />".
							$RS['user']->getValue('fDEL_STREET').", ".
							$RS['user']->getValue('fDEL_POST')." ".$RS['user']->getValue('fDEL_TOWN').".");
					$module->assign('delAddr',$deladdr);
				}			
			}			
			$module->assign('settings',$REXSALE['basket']->settings);
			
			if ($REXSALE['basket']->settings['freepostage']==1)
			{	$module->assign('freepostage',1);			
			}
			# Retrieve the Bankinfo from HTTPS cookie
			if ($_COOKIE['bank']!="")
			{	$bankinfo=base64_decode($_COOKIE['bank']);
				$bankinfo=unserialize($bankinfo);
				$module->assign('bank',$bankinfo);
			}	
						
			if ($_SESSION['rexsale']['settings']['TOC']==1)
			{	$module->assign('toc',1);
			}
			$TOCs=ooRexSaleConfig::getSetting('General','TermsAndConditionsArticle');
			
			$art=new article;
			$art->setArticleId($TOCs);
			$art->setCLang($REX['CUR_CLANG']);
			ob_start();
			print $art->getArticle();
			$document=ob_get_contents();
			$document=str_replace("\r","",$document);
			$document=str_replace('<br />',"\n",$document);
			$document=str_replace('</p>',"\n\n",$document);
			$document=trim(strip_tags($document));
			$document=str_replace("\n","<br />",$document);
			ob_end_clean();
			$module->assign('document',$document);
			
		
			$shippingSets=new ooRexSalePaymentSet();
			$shippingSets=$shippingSets->getShippingSets();
		
			$i=0;
			foreach ($shippingSets as $key=>$val)
			{	if ($i==0)
				{	$shippingID=$key;
				}
				$i++;
			}
		
			if ($REXSALE['basket']->settings['shippingSet']!="")
			{	$shippingID=$REXSALE['basket']->settings['shippingSet'];
			}
			$module->assign('paymentID',$REXSALE['basket']->settings['paymentMethod']);	
		
			$paymentMethods=new ooRexSalePaymentSet();
			$paymentMethods=$paymentMethods->getPaymentMethodsForSet($shippingID);
			
			$module->assign('url',$url);
			$module->assign('shippingID',$shippingID);
			$module->assign('shippingSets',$shippingSets);
			$module->assign('paymentMethods',$paymentMethods);
		
			$module->assign('bread','basket');
			$module->assign('stage','frontend-basket');
		break;
		
		case "a": # Account
			$module->assign('stage','frontend-account');
			
			if ($REXSALE['authed']==0)
			{
				if (!empty($_POST['action']))
				{	$RS['user']=new sql;
					$RS['user']->setQuery('SELECT fID,fPASSWORD FROM '.$REX['ADDON']['REXSALE']['TABLE'].'users WHERE fEMAIL="'.$_POST['login']['user'].'"');
					
					if ($RS['user']->getRows()==0)
					{	$errors[]=$I18N_A153_REXSALE->msg('loginUserDoesNotExist');
					}
					else
					{	
						if(md5($_POST['login']['password'])!=$RS['user']->getValue('fPASSWORD'))
						{	$errors[]=$I18N_A153_REXSALE->msg('loginIncorrectUserOrPassword');
						}
						else
						{	$REXSALE['user']->login($RS['user']->getValue('fID'));
							
							
							if ($_SESSION['rexsale']['lastpage']!="")
							{	
								header("Location:".$_SESSION['rexsale']['lastpage']);
							}
							else
							{	header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."account/index.html");
							}	
							die();
						}
					}
				}
				$module->assign('errors',$errors);
				$module->assign('bread','login');
			}
			else
			{	$module->assign('bread','account');
			}
		break;
		
		case "o":
		
			$sql=new rex_sql;
			$sql->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'orders WHERE rCUSTOMER='.$REXSALE['user']->getValue('id').' order by fCREATED DESC');
			
			$orders=array();
			for ($i=0;$i<$sql->getRows();$i++)
			{	$orders[$sql->getValue('fID')]=array	(
										'order'=>$sql->getValue('fORDER'),
										'created'=>date("d.m.Y H:i",strtotime($sql->getValue('fCREATED'))),
										'modified'=>date("d.m.Y H:i",strtotime($sql->getValue('fMODIFIED'))),
										'status'=>$sql->getValue('fSTATUS'),
										'status_label'=>$I18N_A153_REXSALE->msg($sql->getValue('fSTATUS')),
									);
				$sql->next();
			}
			$module->assign('orders',$orders);
			
			$module->assign('bread','orders');
			$module->assign('stage','frontend-account-orders');
			
		break;
		
		case "ed":
			$dID = rex_request('id','int');
			if ($dID>0) {
				$sql = new rex_sql;
				$query = 'SELECT 
							d.fID as dlID,
							d.rDOWNLOAD,
							p.fDOWNLOADLINK,
							d.fCOUNT
							
							
				
							FROM 
							'.$REX['TABLE_PREFIX'].'153_downloads as d
							
							LEFT JOIN 
							'.$REX['TABLE_PREFIX'].'153_products as p
							ON (d.rDOWNLOAD = p.fID)
							
							WHERE rUSER = '.$_SESSION['rexsale']['user']['id'].'
							&& rDOWNLOAD = '.$dID.' && fDOWNLOADLINK <> "" && d.fSTATUS = 1
							
								';				
				$sql->setQuery($query);
		
				$u = new OOREXsaleUser;
				$RS['user']=new sql;
				$RS['user']->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'users WHERE fID="'.$u->getValue('id').'"');
				$to = $RS['user']->getValue('fEMAIL');
				
				if ($sql->getRows()>0) {
					if ($sql->getValue('fCOUNT')>0) {
						
						
						$fCount = $sql->getValue('fCOUNT');
						$file = getCwd()."/".$sql->getValue('fDOWNLOADLINK');
						
						$mail = new PHPMailer;
						$mail->AddAddress($to);
						$mail->From=$shopconfig->getSetting('General','ShopMail');
						$mail->FromName=$shopconfig->getSetting('General','ShopName');
						$mail->Subject = $shopconfig->getSetting('General','ShopName')." ".$I18N_A153_REXSALE->msg('order').": ".$orderid.' - Download - '.basename($file);
						$mail->AddAttachment($file);
						$mail->Body    = ' ';
						$mail->Send();	
						
					
						// Decrease Counter							
						$sql = new rex_sql;
						$sql->setTable($REX['TABLE_PREFIX'].'153_downloads');
						
						$fCount--;
						
						$sql->setValue('fCOUNT',$fCount);
						$sql->wherevar = ' WHERE rUSER = '.$_SESSION['rexsale']['user']['id'].'
						&& rDOWNLOAD = '.$dID;
						$sql->update();
						
										
						$module->assign('stage','frontend-account-emaildownload');
						
						
						
					}
				}
			}
		
		break;
		
		
		case "gd":
			$dID = rex_request('id','int');
			if ($dID>0) {
				$sql = new rex_sql;
				$query = 'SELECT 
							d.fID as dlID,
							d.rDOWNLOAD,
							p.fDOWNLOADLINK,
							d.fCOUNT
							
							
				
							FROM 
							'.$REX['TABLE_PREFIX'].'153_downloads as d
							
							LEFT JOIN 
							'.$REX['TABLE_PREFIX'].'153_products as p
							ON (d.rDOWNLOAD = p.fID)
							
							WHERE rUSER = '.$_SESSION['rexsale']['user']['id'].'
							&& rDOWNLOAD = '.$dID.' && fDOWNLOADLINK <> "" && d.fSTATUS = 1
							
								';				
				$sql->setQuery($query);
				
				
				if ($sql->getRows()>0) {
					if ($sql->getValue('fCOUNT')>0) {
						
						$fCount = $sql->getValue('fCOUNT');
						
						$file = getCwd()."/".$sql->getValue('fDOWNLOADLINK');
						
						
						
						if (file_exists($file)) {
							
							// Set headers
							
							header("Cache-Control: public");
							header("Content-Description: File Transfer");
							header("Content-Disposition: attachment; filename=".basename($file));
							header("Content-Type: application/zip");
							header("Content-Transfer-Encoding: binary");
							
							// Decrease Counter
							
							$sql = new rex_sql;
							$sql->setTable($REX['TABLE_PREFIX'].'153_downloads');
							
							$fCount--;
							
							$sql->setValue('fCOUNT',$fCount);
							$sql->wherevar = ' WHERE rUSER = '.$_SESSION['rexsale']['user']['id'].'
							&& rDOWNLOAD = '.$dID;
							$sql->update();
							
							
							
							// Read the file from disk
							readfile($file);
							die();
						} else {
							die('File does not exist.');
						}
						
					} else {
						die('Your download limit has been exceeded.');
					}
				} else {
					die('File does not exist.');
				}
			}			
			
			die();
		break;
		
		case "dl":
			$sql = new rex_sql;
			$query = 'SELECT 
						d.fID as dlID,
						d.rDOWNLOAD,
						d.fCOUNT,
						pn.fNAME
						
						
			
						FROM 
						'.$REX['TABLE_PREFIX'].'153_downloads as d
						
						LEFT JOIN 
						'.$REX['TABLE_PREFIX'].'153_products_names as pn
						ON (d.rDOWNLOAD = pn.rPRODID)
						
						WHERE rUSER = '.$_SESSION['rexsale']['user']['id'].'
						&& d.fSTATUS = 1
						
						ORDER BY pn.fNAME ASC
						
							';
			$sql->setQuery($query);
			$downloads = $sql->getArray();
			$module->assign('downloads',$downloads);
		
		
			$module->assign('stage','frontend-account-downloads');
			
		break;
		
		
		
		case "u": # Update Details
			$RS['COUNTRIES']=new sql;
			$RS['COUNTRIES']->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'countries ORDER BY fNAME ASC');
		
			for ($i=0;$i<$RS['COUNTRIES']->getRows();$i++)
			{	$countries[$i]['id']=$RS['COUNTRIES']->getValue('fID');
				$countries[$i]['name']=$RS['COUNTRIES']->getValue('fNAME');
				$RS['COUNTRIES']->nextValue();
			}
			$module->assign('countries',$countries);
			$RS['user']=new sql;
			$RS['user']->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'users WHERE fID="'.$REXSALE['user']->getValue('id').'"');

			if ($RS['user']->getRows()==0)
			{	$REXSALE['user']->logout();
				header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url);
				die();
			}
			else
			{	$module->assign('bread','account');
				
				if (!isset($_POST['action']))
				{	$_POST['reg']['regEmail']=$RS['user']->getValue('fEMAIL');
					$_POST['reg']['regPhone']=$RS['user']->getValue('fPHONE');
					$_POST['reg']['regBillFirstName']=$RS['user']->getValue('fBILL_FIRST_NAME');
					$_POST['reg']['regBillLastName']=$RS['user']->getValue('fBILL_LAST_NAME');
					
					$_POST['reg']['regBillCompany']=$RS['user']->getValue('fBILL_COMPANY');
					$_POST['reg']['regBillStreet']=$RS['user']->getValue('fBILL_STREET');
					$_POST['reg']['regBillTown']=$RS['user']->getValue('fBILL_TOWN');
					$_POST['reg']['regBillState']=$RS['user']->getValue('fBILL_STATE');
					$_POST['reg']['regBillPostcode']=$RS['user']->getValue('fBILL_POST');
					$_POST['reg']['regBillCountry']=$RS['user']->getValue('rBILL_COUNTRY');					
					
					
					$_POST['reg']['regDelFirstName']=$RS['user']->getValue('fDEL_FIRST_NAME');
					$_POST['reg']['regDelLastName']=$RS['user']->getValue('fDEL_LAST_NAME');
					$_POST['reg']['regDelCompany']=$RS['user']->getValue('fDEL_COMPANY');
					$_POST['reg']['regDelStreet']=$RS['user']->getValue('fDEL_STREET');
					$_POST['reg']['regDelTown']=$RS['user']->getValue('fDEL_TOWN');
					$_POST['reg']['regDelState']=$RS['user']->getValue('fDEL_STATE');
					$_POST['reg']['regDelPostcode']=$RS['user']->getValue('fDEL_POST');
					$_POST['reg']['regDelCountry']=$RS['user']->getValue('rDEL_COUNTRY');					
				}
				else
				{	$_POST['reg']['regEmail']=$RS['user']->getValue('fEMAIL');
				
					$user=new ooRexSaleUser();
					$user->setLanguage($REX['CUR_CLANG']);
					
					if (!$user->updateUser($_POST['reg'],'update'))
					{	
						$module->assign('errors',$user->errors);
					}
					else
					{	# Redirect
						header("Location:".$REX['ADDON']['REXSALE']['BASE']."/".$url."account");
						die();
					}
				}
			}
		
			$module->assign('stage','frontend-account-update');
		
		break;
		
		
		case "r":
			$module->assign('stage','frontend-register');
			
			
			$RS['COUNTRIES']=new sql;
			$RS['COUNTRIES']->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'countries ORDER BY fNAME ASC');
		
			for ($i=0;$i<$RS['COUNTRIES']->getRows();$i++)
			{	$countries[$i]['id']=$RS['COUNTRIES']->getValue('fID');
				$countries[$i]['name']=$RS['COUNTRIES']->getValue('fNAME');
				$RS['COUNTRIES']->nextValue();
			}
			$module->assign('countries',$countries);
			
			if (!empty($_POST['action']))
			{	
				$user=new ooRexSaleUser();
				$user->setLanguage($REX['CUR_CLANG']);
				
				if (!$user->updateUser($_POST['reg']))
				{	
					if ($user->userexists==1)
					{	$module->assign('message',$I18N_A153_REXSALE->msg('regUserAlreadyExists'));
						$module->assign('stage','frontend-account');
					}
					else
					{	$module->assign('errors',$user->errors);
					}
				}
				else
				{	$REXSALE['user']->login($user->last_inserted_id);
					if ($_SESSION['rexsale']['lastpage']!="")
					{	header("Location:".$_SESSION['rexsale']['lastpage']);
						die();
					}
					else
					{	header("Location:".ooRexSaleConfig::getSetting('Security','BaseSSL')."/".$url."account/index.html");
						die();
					}
				}
			}
			
			$module->assign('bread','register');
			
		break;
		
		
		
		case "fp":
			//forgot password
			
			if ($REXSALE['authed']==1)
			{	header("Location:".$REX['ADDON']['REXSALE']['BASE']."/");
				die();
			}
			
			if (rex_request('pEMAIL')!="")
			{	$sql = new rex_sql;
				$sql->setQuery('SELECT fID,fEMAIL FROM '.$REX['ADDON']['REXSALE']['TABLE'].'users WHERE fEMAIL="'.rex_request("pEMAIL",'string').'"');
				if ($sql->getRows()==1)
				{	//make a random password using rand(), md5() and substr();
					$pwd = substr(substr(md5(rand()),0,5).rand(),0,8);
					
					$usql = new rex_sql;
					$usql->setTable($REX['ADDON']['REXSALE']['TABLE'].'users');
					$usql->wherevar = ' WHERE fEMAIL="'.$sql->getValue('fEMAIL').'"';
					$usql->setValue('fPASSWORD',md5($pwd));
					$usql->update();
					
					
					$mail = new PHPMailer();
					$mail->From     = ooRexSaleConfig::getSetting('General','ShopMail');
					$mail->FromName = ooRexSaleConfig::getSetting('General','ShopName');
					$mail->Subject = ooRexSaleConfig::getSetting('General','ShopName').' : '.$I18N_A153_REXSALE->msg('sendMeThePassword');
					// $mail->AltBody = $I18N_A153_REXSALE->msg('YourNewPasswordIs').' : '.$pwd;
					$mail->Body = $I18N_A153_REXSALE->msg('YourNewPasswordIs').' : '.$pwd;
					$mail->AddAddress($sql->getValue('fEMAIL'));
					$mail->Send();
					
					$module->assign('substage','sent');
					
					
				}
				else
				{	$module->assign('error','notexist');
				}
				
			}
			$module->assign('stage','frontend-password');			
			
			
			
		break;
		
		
		case "d": # Document viewer
			$cat=OOCategory::getCategoryById($this->article_id);
			$articles=$cat->getArticles();
			$SEF=new ooRexSaleSEF;
			# If the docs folder exists
			
			if (count($articles)>0)
			{	foreach ($articles as $key)	
				{	$name=$SEF->prepare($key->getValue('name'));
					$docs[$name]=$key->getValue('id');
				}
			}
			
			if ($docs[$REX['ADDON']['REXSALE']['DOCUMENT']]!="")
			{	$art=new article;
				$art->setArticleId($docs[$REX['ADDON']['REXSALE']['DOCUMENT']]);
				$art->setCLang($REX['CUR_CLANG']);
				ob_start();
				print $art->getArticle();
				$document=ob_get_contents();
				ob_end_clean();
				$module->assign('document',$document);
			}
			
			$module->assign('stage','frontend-document');
		break;
		
		default:	# Main
			$art=new article;
			$art->setArticleId(ooRexSaleConfig::getSetting('General','StartPage'));
			$art->setCLang($REX['CUR_CLANG']);
			ob_start();
			print $art->getArticle();
			$startpage=ob_get_contents();
			ob_end_clean();
			$module->assign('startpage',$startpage);
			
			
			$module->assign('stage','frontend-main');
		break;
	}

	$module->display('frontend-index.htm');
	unset($module);	
	unset($moduletemplate);
}

?>
