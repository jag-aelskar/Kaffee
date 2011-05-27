<?php
class ooRexSalePaymentSet
{	
	function ooRexSalePaymentSet()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
		$this->config=new OORexSaleConfig;
	}
	
	
	function getShippingSets()
	{	$RS['SET'] = new sql;
		$RS['SET']->setQuery('SELECT * FROM '.$this->table.'shipping');
		
		for($i=0;$i<$RS['SET']->getRows();$i++)
		{	$shipping[$RS['SET']->getValue('fID')]=$RS['SET']->getValue('fNAME');
			$RS['SET']->nextValue();
		}
		
		return $shipping;
	}
	
	function getPaymentMethodsForSet($shippingID)
	{	$shippingID = intVal($shippingID);
		$RS['SET'] = new sql;
		$RS['SET']->setQuery('SELECT '.$this->table.'shipping2payments.fID as fID,
									rSHIPPINGID,rPAYMENTID,fCOST,fNAME 
		
								FROM '.$this->table.'shipping2payments 
								
							  LEFT JOIN '.$this->table.'payments 
							  ON ('.$this->table.'shipping2payments.rPAYMENTID='.$this->table.'payments.fID)
		
								
								WHERE rSHIPPINGID='.$shippingID);

		for($i=0;$i<$RS['SET']->getRows();$i++)
		{	$payments[$RS['SET']->getValue('fID')]=array($RS['SET']->getValue('rPAYMENTID'),$RS['SET']->getValue('fNAME'),$RS['SET']->getValue('fCOST'));
			$RS['SET']->nextValue();
		}
		
		return $payments;
	}
	
	function getPaymentMethodPrice($connectionID)
	{	$connectionID = intVal($connectionID);
		$RS['SET'] = new sql;
		$RS['SET']->setQuery('SELECT fCOST FROM '.$this->table.'shipping2payments WHERE fID='.$connectionID);
		return $RS['SET']->getValue('fCOST');
	}
	
	function getPaymentMethodByConnectionID($connectionID)
	{	$connectionID = intVal($connectionID);
		$RS['MET'] = new sql;
		$RS['MET']->setQuery('SELECT fNAME FROM '.$this->table.'shipping2payments 
							LEFT JOIN '.$this->table.'payments 
							ON ('.$this->table.'shipping2payments.rPAYMENTID = '.$this->table.'payments.fID)
		
							WHERE '.$this->table.'shipping2payments.fID='.$connectionID);
		
		return $RS['MET']->getValue('fNAME');
	}
	
	function getPaymentMethodFolderByConnectionID($connectionID)
	{	$connectionID = intVal($connectionID);
		$RS['MET'] = new sql;
		$RS['MET']->setQuery('SELECT fNAME,fFOLDER FROM '.$this->table.'shipping2payments 
							LEFT JOIN '.$this->table.'payments 
							ON ('.$this->table.'shipping2payments.rPAYMENTID = '.$this->table.'payments.fID)
		
							WHERE '.$this->table.'shipping2payments.fID='.$connectionID);
		
		return $RS['MET']->getValue('fFOLDER');
	}
	
}
?>