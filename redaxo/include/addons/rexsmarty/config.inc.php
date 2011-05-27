<?php

/**
 * Smarty Addon
 *  
 * @author dh[at]gn2-netwerk[dot].de Dave Holloway
 * 
 */

$mypage = 'rexsmarty';

$REX['ADDON']['rxid'][$mypage] = '243';
$REX['ADDON']['page'][$mypage] = $mypage;    
#$REX['ADDON']['name'][$mypage] = 'REXsmarty';
$REX['ADDON']['perm'][$mypage] = 'rexsmarty[]';
$REX['ADDON']['version'][$mypage] = "1.0";
$REX['ADDON']['author'][$mypage] = "Dave Holloway, GN2 Netwerk";

$REX['PERM'][] = 'rexsmarty[]';
$I18N_A93 = new i18n($REX['LANG'], $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/lang/'); 


require_once($REX['INCLUDE_PATH']. '/addons/'.$mypage.'/functions/inlinetemplates.inc.php');

if (!class_exists('Smarty'))
{	require_once($REX['INCLUDE_PATH']. '/addons/'.$mypage.'/classes/Smarty.class.php');
}

require_once($REX['INCLUDE_PATH']. '/addons/'.$mypage.'/classes/Smart.class.php');

?>