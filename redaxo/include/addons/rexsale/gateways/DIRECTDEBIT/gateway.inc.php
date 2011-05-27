<?php
	// Send off a mail to the buyer
	$lang = $I18N_A153_REXSALE->text;
	$mail = new PHPMailer;
	$mail->AddAddress($user[0]['fEMAIL']);
	$mail->From=$shopconfig->getSetting('General','ShopMail');
	$mail->FromName=$shopconfig->getSetting('General','ShopName');
	$subject =  $I18N_A153_REXSALE->text['gw_dd_mailsubject'];
	$subject = utf8_decode($subject);
	$mail->Subject = $shopconfig->getSetting('General','ShopName').' '.$subject.' '.date('m.d.Y');
	$body = $I18N_A153_REXSALE->text['gw_dd_mailbody'];
	$body = str_replace('<br>',"\n",$body);
	
	$body = '-----------------------------------------------------------------------------------------------------
'.$shopconfig->getSetting('General','ShopName').' '.$lang['order'].' von '.$user[0]['fBILL_FIRST_NAME'].' '.$user[0]['fBILL_LAST_NAME'].' ('.$user[0]['fEMAIL'].')
-----------------------------------------------------------------------------------------------------
	
'.$body;
	
	$mail->Body    = utf8_decode($body);
	$mail->AddAttachment($REX['INCLUDE_PATH'].'/addons/rexsale/gateways/DIRECTDEBIT/directdebit.pdf', 'directdebit.pdf');
	
	$mail->Send();

	

	// Continue to thankyou page.

?>