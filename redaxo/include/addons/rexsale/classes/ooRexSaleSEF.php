<?php
class ooRexSaleSEF
{
	function ooRexSaleSEF()
	{	$this->SEF=&$_SESSION['REXSALESEF'];
	
	
			
	}

	function prepare($str)
	{
		return strtolower(rex_parse_article_name($str));
	}


	function regenerateCategory($id=0) {
		$id = intVal($id);
		
		
		$catIds = $this->getSubCats($id);	
		
		//and this id too..
		$catIds[] = $id;
		
		global $REX;
		
		foreach (glob($REX['INCLUDE_PATH']."/generated/files/rexsale.cache.tree."."*.txt") as $filename)
		{	unlink($filename);
		}	
		
		
		foreach (glob($REX['INCLUDE_PATH']."/generated/files/rexsale.cache.cat.children."."*.txt") as $filename)
		{	//echo $filename.'<br>';		
			unlink($filename);
		}	
		
		foreach (glob($REX['INCLUDE_PATH']."/generated/files/rexsale.cache.cat.products.".$id."*.txt") as $filename)
		{	//echo $filename.'<br>';		
			unlink($filename);
		}	

		foreach ($catIds as $id) {
			foreach (glob($REX['INCLUDE_PATH']."/generated/files/rexsale.cache.cat.".$id."."."*.txt") as $filename)
			{	//echo $filename.'<br>';		
				unlink($filename);
			}		
		}
		
	
		if (count($catIds)>0) {
			$prodIds = $this->getSubProds($catIds);
			
			if (is_array($prodIds)) {
				foreach ($prodIds as $id) {
					foreach (glob($REX['INCLUDE_PATH']."/generated/files/rexsale.cache.prod.".$id."."."*.txt") as $filename)
					{	//echo $filename.'<br>';		
						unlink($filename);
					}		
				}
			}
		
		}
		$this->regenerate();
		
		$pathlist=@file_get_contents($REX['INCLUDE_PATH'].'/generated/files/rexsale.paths.txt');
		$pathlist=@unserialize($pathlist);
		
	}
	
	
	function getSubCats($catId,$list=array()) {
		global $REX;
		//find all sub categories of $id
		$subcats = array();
		$sql = new rex_sql();
		$sql->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'153_cats WHERE rPARENT = '.$catId);
	
		for ($i=0;$i<$sql->getRows();$i++) {
			$list[] = $sql->getValue('fID');		
			$this->getSubCats($sql->getValue('fID'),$list);
			$sql->next();
		}
		return $list;		
	}
	
	function getSubProds($catsArray) {
		global $REX;

		$subcats = array();
		$sql = new rex_sql();
		$sql->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'153_products2cats WHERE rCAT IN ('.implode(',',$catsArray).')');
		
		for ($i=0;$i<$sql->getRows();$i++) {
			$list[] = $sql->getValue('rPROD');		
			$sql->next();
		}
		return $list;		
	}


	function regenerate($id=0,$clang=0)
	{	
		global $REX;
		
		
		
		$SEF=array();
		$sql=new rex_sql;
		
		############# generate category list ####
		$results=$sql->getArray("SELECT * FROM ".$REX['TABLE_PREFIX']."153_cats_names LEFT JOIN rex_153_cats ON rex_153_cats_names.rCATID = rex_153_cats.fID");
		foreach ($results as $v)
		{	$cats[$v['fID']][$v['rCLANG']]['name']=$v['fNAME'];
			$cats[$v['fID']][$v['rCLANG']]['parent']=$v['rPARENT'];
		}
		
		foreach ($results as $k=>$v)
		{	$parent=$v['rPARENT'];
			$id=$v['rCATID'];
			$l=$v['rCLANG'];
			$path=array();				
			while ($id>0)
			{	// remember, we can't just blindly use the $name here. Some categories
				// don't have translations and we have to use the fallback language!
			
				if ($cats[$id][$l]['name']!="")
				{	$name=$cats[$id][$l]['name'];
				}
				else
				{	$name=$cats[$id][ooRexSaleConfig::getSetting('Languages','DefaultCLANG')]['name'];
				}
				
				$path[]=$this->prepare($name);
				
				$id=$cats[$id][$l]['parent'];
				$parent=$results[$id][$l]['rPARENT'];
				$path=array_reverse($path);
			}
			if (is_array($path))
			{	$url="";
				foreach ($path as $key=>$str)
				{	$url.=$str.'/';
				}
				$SEF['CAT'][$v['rCATID']][$l]=$url;
			}				
		}
	
	
		
		############# generate product list ####
		$sql=new rex_sql;
		$results = $sql->getArray("SELECT *
FROM `rex_153_products2cats`
LEFT JOIN rex_153_products_names ON rex_153_products2cats.rPROD = rex_153_products_names.rPRODID
ORDER BY rCAT");

		foreach ($results as $k=>$v)
		{			
			// check if SEF URL exists for the PRODUCT
			// and generate links accordingly
			$name=$this->prepare($v['fNAME']);
			
			if (isset($SEF['CAT'][$v['rCAT']][$v['rCLANG']]))
			{	$clang=$v['rCLANG'];
			}
			else
			{	$clang=ooRexSaleConfig::getSetting('Languages','DefaultCLANG');
			}
			
			if (isset($SEF['CAT'][$v['rCAT']][$clang]))
			{	if ($name!="")
				{	$prefix=$SEF['CAT'][$v['rCAT']][$clang];
					$prefix=$prefix.$v['rPROD'].'_'.$name;
				}				
				$SEF['PROD'][$v['rCAT']][$v['rPROD']][$v['rCLANG']]=$prefix;
			}
		}
		
		
		
		
		############# save pathlist ####
		$myFile = $REX['INCLUDE_PATH'].'/generated/files/rexsale.paths.txt';
		$fh = fopen($myFile, 'w') or die("Please check permissions on the GENERATED folder.");
		$stringData = serialize($SEF);
		fwrite($fh, $stringData);
		fclose($fh);
		
		$REX['ADDON']['REXSALE']['PATHLIST']=$SEF;
	
	}

}
?>