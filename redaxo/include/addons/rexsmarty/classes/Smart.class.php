<?php
	class Smart extends Smarty
	{	
		function Smart()
		{	global $REX;
			$mypage = 'rexsmarty';
			$this->template_dir = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/templates';
			$this->compile_dir = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/templates_c';
			$this->cache_dir = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/cache';
			$this->config_dir = $REX['INCLUDE_PATH'].'/addons/'.$mypage.'/configs';
			$this->force_compile = 1;
			$this->register_resource("rex", array("rex_get_template",
                                       "rex_get_timestamp",
                                       "rex_get_secure",
                                       "rex_get_trusted"));
		}
		
		function registerTemplate($name,$src)
		{	global $REX;
			
			if (!isset($REX['ADDON']['SMARTY']['TEMPLATES'][$name]))
			{	$REX['ADDON']['SMARTY']['TEMPLATES'][$name]=$src;
			}
			return true;
		}
		
	}
?>