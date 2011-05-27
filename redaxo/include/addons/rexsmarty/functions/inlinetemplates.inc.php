<?php
function rex_get_template ($tpl_name, &$tpl_source, &$smarty_obj)
{	global $REX;

	if (isset($REX['ADDON']['SMARTY']['TEMPLATES'][$tpl_name]))
	{	$src=$REX['ADDON']['SMARTY']['TEMPLATES'][$tpl_name];
		
		# Do a *little* source formatting
		$src=trim($src);
		$src=str_replace("\n\t","\n",$src);
		$src=str_replace("\t","    ",$src);
		$src="\n".$src."\n\n";
		$tpl_source=$src;
	}
	else
	{	$tpl_source="";
	}
	return true;
}

function rex_get_timestamp($tpl_name, &$tpl_timestamp, &$smarty_obj)
{	return true;
}

function rex_get_secure($tpl_name, &$smarty_obj)
{
    // assume all templates are secure
    return true;
}

function rex_get_trusted($tpl_name, &$smarty_obj)
{
    // not used for templates
}

?>