<?php
class ooRexSaleREXForm extends rex_form
{



	function preSave($fieldsetName, $fieldName, $fieldValue, &$saveSql)
	{	global $REX;
	
		if ($fieldName=="fPASSWORD" && ($fieldValue=="********" || $fieldValue==""))
		{	$sql = new rex_sql;
			$sql->setQuery('SELECT fPASSWORD FROM '.$REX['TABLE_PREFIX'].'153_users WHERE fID='.rex_request('fID'));
			if ($sql->getRows()>0)
			{	$fieldValue=$sql->getValue('fPASSWORD');
			}	
		}
		else if ($fieldName=="fPASSWORD" && $fieldValue!="********")
		{	$fieldValue=md5($fieldValue);
		}
			
		return parent::preSave($fieldsetName, $fieldName, $fieldValue, $saveSql);
	}




	function preView($fieldsetName, $fieldName, $fieldValue)
	{	
		if ($fieldName=="fPASSWORD")
		{	$fieldValue="********";
		}
	
	
		return parent::preView($fieldsetName, $fieldName, $fieldValue);
	}



}
?>