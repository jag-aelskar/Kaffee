<?php
include "paypal.php";	

$order = $gw->_tpl_vars[order];
$config = $gw->_tpl_vars[config];


//pp object
if ($config['Gateway']['sandbox']=="yes") {
	$pay=new paypal($config['Gateway']['sbUser'], $config['Gateway']['sbPass'], $config['Gateway']['sbSig'], true);
} else {
	$pay=new paypal($config['Gateway']['ppUser'], $config['Gateway']['ppPass'], $config['Gateway']['ppSig'], false);
}
echo 'Please configure your Paypal gateway.ini';


$total = $order['total'];
$total = str_replace(',','.',$total);




# Display Paypal Module
if ($_GET['token']=="")
{	$_SESSION['REXSALE_DOWNLOADS']=$downloads;

	$pay->addvalue('METHOD', 'SetExpressCheckout');
	//$pay->addvalue('VERSION', '57.0');
	$pay->addvalue('CURRENCYCODE', 'EUR');
	$pay->addvalue('LOCALECODE', 'DE');
	$pay->addvalue('MAXAMT', "10,000.00");
	$pay->addvalue('RETURNURL', $config['Gateway']['returnurl']);
	$pay->addvalue('CANCELURL', $config['Gateway']['cancelurl']);
	$pay->addvalue('AMT', $total);
	
	
	$data=$pay->call_paypal();
	
	
	
	if ($data['TOKEN']!="") {
		$url = 'Location:'.$config['Gateway']['ppApi'].urlencode($data['TOKEN']);
		
		header($url);
		die();
	}

	
	die(); // die, becasue we don't actually want to carry on unless the user has paid
}

# Returning from Paypal
if ($_GET['token']!="" /* and check paypal referer here... */)
{	// Continue to thankyou page.
	

	//get custom data
	$pay->resetdata();
	$pay->addvalue('METHOD', 'GetExpressCheckoutDetails');
	$pay->addvalue('TOKEN',$_GET['token']);
	$data=$pay->call_paypal();
	

	//get custom data
	$pay->resetdata();
	$pay->addvalue('METHOD', 'DoExpressCheckoutPayment');
	$pay->addvalue('TOKEN',$_GET['token']);
	$pay->addvalue('PAYMENTACTION','Sale');
	$pay->addvalue('PAYERID',$_GET['PayerID']);
	$pay->addvalue('AMT', $total);
	$data=$pay->call_paypal();


	if ($data['PAYMENTSTATUS']=="Completed") {
		// enable your downloads

		ooRexSaleDownload::enableDownloadsForUser($downloads,$_SESSION['rexsale']['user']['id']);
		
	}

}

?>