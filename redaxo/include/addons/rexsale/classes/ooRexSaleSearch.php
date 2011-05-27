<?php
class ooRexSaleSearch
{	var $limit = 20;
	
	function ooRexSaleSearch()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
		$this->config=new OORexSaleConfig;
	}
	
	function setQuery($str)
	{	$str = str_replace('INSERT','',$str);
		$str = str_replace('DELETE','',$str);
		$str = str_replace('UPDATE','',$str);
		$str = str_replace('--','',$str);
		$str = str_replace(';','',$str);
		$str = str_replace('"','',$str);
		$str = str_replace("'",'',$str);
		$this->query=$str;
	}
	
	
	
	
	function search()
	{	global $REX;
		$RS['SEARCH']=new sql;
		$RS['SEARCH']->setQuery('	SELECT '.$this->table.'products.fID as fID FROM '.$this->table.'products

									LEFT JOIN '.$this->table.'products_names
									ON ('.$this->table.'products.fID = '.$this->table.'products_names.rPRODID)
									
									LEFT JOIN '.$this->table.'products_descs
									ON ('.$this->table.'products.fID = '.$this->table.'products_descs.rPRODID)
									
									
									WHERE (
												('.$this->table.'products_names.rCLANG=0)
											&&	('.$this->table.'products_descs.rCLANG=0)
											
											&& 	(		('.$this->table.'products_descs.fDESC1 LIKE "%'.$this->query.'%")
													||	('.$this->table.'products_descs.fDESC2 LIKE "%'.$this->query.'%")
													||	('.$this->table.'products_descs.fDESC3 LIKE "%'.$this->query.'%")
													||	('.$this->table.'products_descs.fDESC4 LIKE "%'.$this->query.'%")
													||	('.$this->table.'products_descs.fDESC5 LIKE "%'.$this->query.'%")
													||	('.$this->table.'products_names.fNAME LIKE "%'.$this->query.'%")
												)
									)
									
									LIMIT '.$this->limit.'
									
								');
		
		unset($this->results);
		for ($i=0;$i<$RS['SEARCH']->getRows();$i++)
		{	$this->results[]=$RS['SEARCH']->getValue('fID');
			$RS['SEARCH']->next();
		}
	}
	
	function resultCount()
	{	return count($this->results);
	}
	
	function getResults()
	{	return $this->results;
	}
	
}
?>