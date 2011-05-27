<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
#	RexSale, dave@gn2-netwerk.de	
#	index.inc.php
#
#	Last Modified: 2007-04-26
######################################################################

// GET PARAMS
////////////////////////////////////////////////////////////////////////////////
$subpage  = rex_request('subpage', 'string');

// extension point jquery_sortable
if(!function_exists('rexsale_jquery_backend'))
{	function rexsale_jquery_backend($params)
	{	global $REX;			
		$content = $params['subject'];
		
		$insert .= '
			<!-- Insert the latest jquery + sortable addons -->
			<link rel="stylesheet" type="text/css" href="index.php?page=rexsale&load=rexsale_backend.css" media="screen" />
			<script type="text/javascript" src="index.php?page=rexsale&load=jquery-1.2.4a.js"></script>
			<script type="text/javascript" src="index.php?page=rexsale&load=ui.base.js"></script>
			<script type="text/javascript" src="index.php?page=rexsale&load=ui.sortable.js"></script>
			<script type="text/javascript" src="index.php?page=rexsale&load=jquery-init.js"></script>
		';
		$content = str_replace('</head>', $insert.'</head>', $content);
		
		return $content;
	}
}
rex_register_extension('OUTPUT_FILTER', 'rexsale_jquery_backend');


//------------------------------> AJAX Requests

	if (rex_request('jqueryAjax')=='resort' && rex_request('order')!="" && rex_request('what')=="cats")
	{	$order = rex_request('order');
		$order = str_replace('sort','',$order);
		$order = explode('~~',$order);
	
		foreach ($order as $k=>$v)
		{	if ($v == "")
			{	unset($order[$k]);
			}
			else
			{	$order[$k]=intVal($v);				
			}
		}
		$order=array_flip($order);
					
		$cat=new ooRexSaleCategory();
		$cat->setLanguage(rex_request('clang'));
		$cat->setCategory(rex_request('id'));
		$cat->resortPriorities($order);
		
		$sef = new ooRexSaleSEF;
		$sef->regenerateCategory(rex_request('id'));
		die();
	}

	if (rex_request('jqueryAjax')=='resort' && rex_request('order')!="" && rex_request('what')=="prods")
	{	$order = rex_request('order');
		$order = str_replace('sort','',$order);
		$order = explode('~~',$order);
	
		foreach ($order as $k=>$v)
		{	if ($v == "")
			{	unset($order[$k]);
			}
			else
			{	$order[$k]=intVal($v);				
			}
		}
		$order=array_flip($order);
					
		$prod=new ooRexSaleProduct();
		$prod->setLanguage(rex_request('clang'));
		$prod->resortPriorities($order);
		foreach (glob($REX['INCLUDE_PATH']."/generated/files/rexsale.cache.tree."."*.txt") as $filename)
		{	unlink($filename);
		}		
		die();
	}





$rsl=&$I18N_A153_REXSALE;

	$smarty = new Smart();
	$smarty->template_dir=$REX['INCLUDE_PATH']."/addons/rexsale/templates";
	$smarty->assign('lang',$I18N_A153_REXSALE->text);
	$smarty->assign('langs',$REX['CLANG']);
	# Assign needed variables to smarty
	$smarty->assign('clang',$_REQUEST['clang']);
	$smarty->assign('parent',$_REQUEST['parent']);



# Enable External File Loading
if($_GET['load']!="")
{	@require($REX['INCLUDE_PATH']."/addons/rexsale/loader.php");
	exit;
}
# IFRAMEs
if($_GET['iframe']!="")
{	@require($REX['INCLUDE_PATH']."/addons/rexsale/iframe.php");
	exit;
}
# Enable AJAX Mode
if($_POST['ajax']!="")
{	@require($REX['INCLUDE_PATH']."/addons/rexsale/ajax.php");
	exit;
}

$Basedir = dirname(__FILE__);
ob_start();
include $REX['INCLUDE_PATH'].'/layout/top.php';
$head=ob_get_contents();
ob_end_clean();

# Include Javascripts :-) 
$files.='<script type="text/javascript" src="index.php?page=rexsale&load=advajax.js"></script>'."\n";
$files.='<script type="text/javascript" src="index.php?page=rexsale&load=behaviour.js"></script>'."\n";
$files.='<script type="text/javascript" src="index.php?page=rexsale&load=init.js"></script>'."\n";

$head=str_replace("</head>",$files."</head>\n",$head);
print $head;

function rex_shop_msg($msg)
{
	$echo .= "<table width=770 cellpadding=5 cellspacing=1 border=0>";
	$echo .= "<tr><td class=warning>".$msg."</td></tr>";
	$echo .= "</table><br />";
	
	return $echo;	
}


#####################################################################
?>
	<style type="text/css">
		#page-products table textarea
		{	width:100%;height:90px;
		}
		#page-products table table
		{	width:100%;
			margin:10px 0 10px 0;
		}
		#page-products table table table
		{	margin:0;
		}
		#page-products input.text,
		#page-products select
		{	width:100%;
		}
		
	</style>
<?php

if (!isset ($func))
{
  $func = '';
}

# Build Subnavigation 
$subpages =
array
(	#array('',$rsl->msg('home')),
	array('inventory',$rsl->msg('categories')),
	array('variants',$rsl->msg('variants')),
	array('users',$rsl->msg('users')),
	array('orders',$rsl->msg('orders')),
	array('tax',$rsl->msg('tax')),
	array('config',$rsl->msg('config')),
	
);

$version=@file_get_contents($REX['INCLUDE_PATH']."/addons/rexsale/rexsale.ver");

if ($version!="")
{	$version=date("d.m.Y",strtotime($version));
}
else
{	$version="";
}

rex_title('REXSale <span style="font-weight:normal;text-transform:uppercase;font-size:9px;color:#999999;">Alpha 0.31: '.$version.'</span>', $subpages);




echo '<div id="rxs">';
	
switch($subpage)
{	case 'config':
		require $Basedir .'/admin.inc.php';
	break;

    case 'inventory':
        require $Basedir .'/inventory.inc.php';
    break;
    case 'variants':
        require $Basedir .'/variants.inc.php';
    break;
    case 'users':
     	require $Basedir .'/users.inc.php';
     	break;
    case 'orders':
     	require $Basedir .'/orders.inc.php';
    break;
    case 'tax':
     	require $Basedir .'/tax.inc.php';
    break;
    default:
        require $Basedir .'/inventory.inc.php';
}


echo '</div>';

#####################################################################
include $REX['INCLUDE_PATH'].'/layout/bottom.php';
?>