<?php
	$order = $gw->_tpl_vars[order];
	$config = $gw->_tpl_vars[config];
	$shop = $gw->_tpl_vars[shop];	

	
	$subject = $order[user][fBILL_FIRST_NAME].' '.$order[user][fBILL_LAST_NAME];
	$gw->assign('subject',$subject);
	
	$gw->assign('downloads',$downloads);
	
	
	$total = $order['total'];
	$total = str_replace(',','.',$total);
	$gw->assign('total',$total);
	$gw->assign('user',$_SESSION['rexsale']['user']['id']);
	$hash = $config['Gateway']['userid'].'|'.$config['Gateway']['projectid'].'|||||'.$total.'|EUR|'.$subject.'||||||'.$_SESSION['rexsale']['user']['id'].'|'.$downloads.'|'.$config['Gateway']['projectpass'];
	
	
	
	$gw->assign('hash',md5($hash));
	
	
	# Display Module
	if ($_GET['returnstring']=="")
	{	
		$gw->display('sofortueberweisung.htm');
		
		die(); // die, becasue we don't actually want to carry on unless the user has paid
	}
	
	# Returning from gateway
	if ($_GET['returnstring']!="" /* and check paypal referer here... */)
	{	// Continue to thankyou page.
	}

?>