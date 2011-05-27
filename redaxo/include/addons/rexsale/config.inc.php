<?php
/*
 *	REXSale, by GN2-Netwerk. 
 * 	SVN Version: $id$
 *	http://bugs.rexsale.de/
 */

# Session Handling is needed for authentication
if (session_id() || !$REX['REDAXO']) {
	session_start();
}

$theaddon = "rexsale";
$REX['ADDON']['rxid'][$theaddon] = '153';
$REX['ADDON']['page'][$theaddon] = $theaddon;    
$REX['ADDON']['name'][$theaddon] = 'REXsale';
$REX['ADDON']['perm'][$theaddon] = 'rexsale[]';
$REX['PERM'][] = 'rexsale[]';


# Include Shop OOP Classes.
if ($REX['REDAXO'])
{	include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleREXForm.php";
}

include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleConfig.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleCart.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleOrder.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleDownload.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleSEF.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleCategory.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleProduct.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleVariant.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleUser.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleTax.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSalePaymentSet.php";
include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/ooRexSaleSearch.php";

if (!class_exists('iniParser'))
{	include $REX['INCLUDE_PATH']."/addons/$theaddon/classes/class.iniparser.php";
}

# Include Custom Debug Function
if (!function_exists('dbprint'))
{	function dbprint($obj,$str='')
	{	echo '<pre class="dbprint" style="width:500px;height:150px;overflow:auto;margin:10px auto;padding:15px;border:1px solid #999999;background-color:#FFFFFF;color:#000000;font-size:12px;">';
		if ($str!="")
		{	echo '<strong>'.$str.'</strong>'."\n\n";
		}
		print_r($obj);
		echo '</pre>';
	}
}
if (!function_exists('rexsaleclean'))
{	function rexsaleclean($x)
	{	if (is_array($x))
		{	foreach ($x as $k=>$v)
			{	$x[$k]=rexsaleclean($x[$k]);
			}
		}
		else
		{	$x=str_replace(';','',$x);
			$x=str_replace('==','',$x);
			$x=strip_tags($x);
			$x=urldecode($x);
		}
		return $x;
	}
}

$rexsalelang=new sql;
$rexsalelang->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'clang');
for ($i=0;$i<$rexsalelang->getRows();$i++)
{	if ($rexsalelang->getValue('name')==$_REQUEST['SHOPLANG'])
	{	$rexsaleclang=$rexsalelang->getValue('id');
	}
	$rexsalelang->nextValue();
}
unset($rexsalelang);



# #########################################################################################################

# Create Language Objects
$I18N_A153_REXSALE = new i18n($REX['LANG'],$REX['INCLUDE_PATH']."/addons/$theaddon/lang");
$_SESSION['REXSALELANG'] = $I18N_A153_REXSALE;
$I18N_A153_REXSALE = &$_SESSION['REXSALELANG'];

if ($REX['VERSION'] == 4 && $REX['SUBVERSION']>1) {
	$I18N_A153_REXSALE->appendFile($REX['INCLUDE_PATH'].'/addons/rexsale/lang/');
}


# Import product links
$pathlist=@file_get_contents($REX['INCLUDE_PATH'].'/generated/files/rexsale.paths.txt');
$pathlist=@unserialize($pathlist);
if (!is_array($pathlist))
{	// regenerate paths if the pathlist cannot be found
	$sef=new ooRexSaleSEF;
	$sef->regenerate();
	$pathlist=@file_get_contents($REX['INCLUDE_PATH'].'/generated/files/rexsale.paths.txt');
	$pathlist=@unserialize($pathlist);
	if (!is_array($pathlist))
	{	// die if the pathlist still cannot be found
		die('Please check permissions on GENERATED folder.');
	}
}


$REX['ADDON']['REXSALE']['PATHLIST']=$pathlist;


# Check authentication
if ($_SESSION['REXSALEUSER']=="")
{	$REXSALE['user'] = new ooRexSaleUser;
}
else
{	$REXSALE['user'] = &$_SESSION['REXSALEUSER'];
}
$REX['ADDON']['REXSALE']['BASE']=ooRexSaleConfig::getSetting('Security','BaseNoSSL');

if ($REXSALE['user']->authenticate() == 'yes')
{	$REX['ADDON']['REXSALE']['BASE']=ooRexSaleConfig::getSetting('Security','BaseSSL');
	$REX['ADDON']['REXSALE']['SSL']=1;
}

# Parse the SHOPKEY
$REX['ADDON']['REXSALE']['TABLE']=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
if (isset($_REQUEST['SHOPKEY']))
{	
	$shopkey=explode('/',$_REQUEST['SHOPKEY']);
	
	switch ($shopkey[0])
	{	case "basket":
			$REX['ADDON']['REXSALE']['MODE']='b';
			$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('basket');
		break;
		case "register":
			$REX['ADDON']['REXSALE']['MODE']='r';
			$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('register');
		break;
		case "password":
			$REX['ADDON']['REXSALE']['MODE']='fp';
			$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('forgotpassword');
		break;
		case "logout":
			$REX['ADDON']['REXSALE']['MODE']='l';
			$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('logout');
		break;
		case "thanks":
			$REX['ADDON']['REXSALE']['MODE']='t';
			$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('thanks');
		break;
		case "document":
			$REX['ADDON']['REXSALE']['DOCUMENT']=$shopkey[1];
			$REX['ADDON']['REXSALE']['MODE']='d';
		break;
		case "account":
			$REX['ADDON']['REXSALE']['BASE']=ooRexSaleConfig::getSetting('Security','BaseSSL');
			
			if ($REXSALE['user']->authenticate() == 'yes')
			{	$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('account');
			}
			else
			{	$REX['ADDON']['REXSALE']['PAGENAME']=$I18N_A153_REXSALE->msg('login');
			}
			
			
			switch ($shopkey[1])
			{	case "basket":
					$REX['ADDON']['REXSALE']['MODE']='b';
				break;
				case "update":
					$REX['ADDON']['REXSALE']['MODE']='u';
				break;
				case "orders":
					$REX['ADDON']['REXSALE']['MODE']='o';
				break;
				case "downloads":
					$REX['ADDON']['REXSALE']['MODE']='dl';
				break;
				case "getdownload":
					$REX['ADDON']['REXSALE']['MODE']='gd';
				break;
				case "emaildownload":
					$REX['ADDON']['REXSALE']['MODE']='ed';
				break;
				default:
					$REX['ADDON']['REXSALE']['MODE']='a';
				break;
			}
			
		break;
		
		
		
		# No predefined keys, search in sef.dat
		default:		
			$shopkey=urlencode($_REQUEST['SHOPKEY']);
			$shopkey=str_replace('%2F','/',$shopkey);
			$shopkey=str_replace('index.html','',$shopkey);
			$shopkey=str_replace('.html','',$shopkey);

			
			//first, look for products with they path key
			if (is_array($pathlist['PROD']))
			{	$found=false;
				$REX['ADDON']['REXSALE']['MODE']="p";
				foreach($pathlist['PROD'] as $catID=>$prods)
				{	

					foreach ($prods as $prodID=>$prodVAL)
					{
						if ($prodVAL[$rexsaleclang]==$shopkey)
						{	$REX['ADDON']['REXSALE']['RID']=$prodID;
							$REX['ADDON']['REXSALE']['RCAT']=$catID;
							$found=true;
						}
						else if ($prodVAL[ooRexSaleConfig::getSetting('Languages','DefaultCLANG')]==$shopkey)
						{	$REX['ADDON']['REXSALE']['RID']=$prodID;
							$REX['ADDON']['REXSALE']['RCAT']=$catID;
							$found=true;
						}
					}
				}
			}
			//if the product isn't found, look for a category
			if ($found==false)
			{	$REX['ADDON']['REXSALE']['MODE']="c";
				if (is_array($pathlist['CAT']))
				{	
					foreach ($pathlist['CAT'] as $catID=>$links)
					{	if ($links[$rexsaleclang]==$shopkey)
						{	$REX['ADDON']['REXSALE']['RCAT']=$catID;
							$REX['ADDON']['REXSALE']['RID']=$catID;
							$found=true;
						}
						else if ($links[ooRexSaleConfig::getSetting('Languages','DefaultCLANG')]==$shopkey)
						{	$REX['ADDON']['REXSALE']['RCAT']=$catID;
							$REX['ADDON']['REXSALE']['RID']=$catID;
							$found=true;
						}
					}
				}
			}
			
			//if still not found, set to the start page
			if ($found==false)
			{	$REX['ADDON']['REXSALE']['MODE']="s";
			}
			
		break;
	}

}
else
{	$REX['ADDON']['REXSALE']['MODE']="s";
}



# jquery einbinden

// css einbinden für module  /layout/css/backend.css
if(!function_exists('rexsale_jquery')) {	
	function rexsale_jquery($params) {	
		global $REX;

		$content = $params['subject'];
		
		if (!$REX['REDAXO']) {	
			//frontend
			$insert = '';
	
	if ($REX['VERSION'] == 4 && $REX['SUBVERSION']>1) {
		$insert .= '<script type="text/javascript" src="redaxo/media/jquery.min.js"></script>';
	} else {
		$insert .= '<script type="text/javascript" src="redaxo/media/jquery-1.2.3.pack.js"></script>';
	}
	
			$insert .= '
	<link rel="stylesheet" type="text/css" href="files/_css/jquery.autocomplete.css" media="all" />
	<script type="text/javascript" src="files/_js/jquery.liveSearch.js"></script>
	<script type="text/javascript" src="files/_js/jquery.bgiframe.min.js"></script>
	<script type="text/javascript" src="files/_js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="files/_js/jquery.ajaxQueue.js"></script>
	<script type="text/javascript" src="files/_js/jquery.autocomplete.pack.js"></script>
	<script type="text/javascript" src="files/_js/advajax.js"></script>
	<script type="text/javascript" src="files/_js/init.js"></script>
';
			$content = str_replace('</head>', $insert.'</head>', $content);
		}
		return $content;
	}
}

rex_register_extension('OUTPUT_FILTER', 'rexsale_jquery');

?>
