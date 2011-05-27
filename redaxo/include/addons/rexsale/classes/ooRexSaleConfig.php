<?php

class OORexSaleConfig
{	var $settings;
	
	function OORexSaleConfig()
	{	global $REX;
		$cfg = new iniParser($REX['INCLUDE_PATH']."/addons/rexsale/rexsale.ini");
		
		$this->settings=&$cfg->_iniParsedArray;
	}
	
	function getSetting($section,$key)
	{	$config=new OORexSaleConfig;
		return $config->settings[$section][$key];
	}
}
?>