<?php
class ooRexSaleTax
{
	function ooRexSaleTax()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
	}
	
	function getTaxList()
	{	$RS['TAX']=new sql;
		$RS['TAX']->setQuery('SELECT * FROM '.$this->table.'tax');
		
		for ($i=0;$i<$RS['TAX']->getRows();$i++)
		{	$this->taxes[$RS['TAX']->getValue('fID')]['name']=$RS['TAX']->getValue('fNAME');
			$this->taxes[$RS['TAX']->getValue('fID')]['amount']=$RS['TAX']->getValue('fAMOUNT');
			$RS['TAX']->nextValue();
		}
		
		return $this->taxes;
	}

	function getTaxById($taxid)
	{	
		$RS['TAX']=new sql;
		$RS['TAX']->setQuery('SELECT fAMOUNT FROM '.$this->table.'tax WHERE fID='.$taxid);
		
		if ($RS['TAX']->getRows()>0)
		{	return $RS['TAX']->getValue('fAMOUNT');
		}
	}
	
}
?>