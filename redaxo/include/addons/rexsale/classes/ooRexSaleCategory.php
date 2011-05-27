<?php
class OORexSaleCategory
{	var $clang;
	var $info;
	var $children;
	var $products;
	var $errors;
	var $tree;
	var $parents;

	function OORexSaleCategory()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
		$this->config=new OORexSaleConfig;
		$this->lang=$_SESSION['REXSALELANG'];
	}
	
	function setLanguage($clang)
	{	$this->clang=$clang;
	}
		
	function setCategory($id)
	{	global $REX;
		
		$this->info['id']=$id;
		
		if ($id!=0)	
		{	
			if ($this->clang=="")
			{	$this->clang=$REX['CUR_CLANG'];
			}	
			
			
			###########################
			# Category information is now cached.
			###########################
			
			$cachefile=$REX['INCLUDE_PATH'].'/generated/files/rexsale.cache.cat.'.$id.'.'.$this->clang.'.txt';
			$this->fallback=0;


			if (file_exists($cachefile))
			{	$data=file_get_contents($cachefile);
				$this->info=unserialize($data);
			}
			else
			{
				// no cache file found, regenerate data and cache it
				$RS['CAT']=$this->retrieveCategory($id,$this->clang);
				
				if ($RS['CAT']->getRows() == 0)
				{	$RS['CAT']=$this->retrieveCategory($id,$this->config->getSetting('Languages','DefaultCLANG'));
					$this->fallback=1;
				}
								
				if ($RS['CAT']->getRows() == 1)
				{	
					$this->info['name']=$RS['CAT']->getValue('fNAME');
					$this->info['sortorder']=$RS['CAT']->getValue('fSORTORDER');
					$this->info['status']=$RS['CAT']->getValue('fSTATUS');
					$this->info['parent']=$RS['CAT']->getValue('rPARENT');
					
				}
				else
				{	$this->errors[]='The category ID:'.$id.' doesn\'t exist.';
					return false;
				} #eoIF
			
				
				$RS['SEF']=$this->getSEFLink($this->clang);
				if ($RS['SEF']!="")
				{	$RS['SEF']=$RS['SEF']=$this->getSEFLink($this->config->getSetting('Languages','DefaultCLANG'));
				}
				$this->info['url']=$RS['SEF'];
				
				
				$RS['METATEXT']=$this->getMetaText($this->clang);				
				if ($RS['METATEXT']->getRows() == 0)
				{	$RS['METATEXT']=$this->getMetaText($this->config->getSetting('Languages','DefaultCLANG'));
				}
				if ($RS['METATEXT']->getRows() > 0)
				{
					$this->info['metatext']=$RS['METATEXT']->getValue('fVALUE');
					$tex=new textile;
					$this->info['metatexthtml']=$tex->TextileThis($this->info['metatext']);
				}
				else {
					$this->info['metatext']="";
				}
				
				$RS['METABILD']=$this->getMetaImage($this->clang);				
				if ($RS['METABILD']->getRows() == 0)
				{	$RS['METABILD']=$this->getMetaImage($this->config->getSetting('Languages','DefaultCLANG'));
				}
				if ($RS['METABILD']->getRows() > 0) {
					$this->info['metabild']=$RS['METABILD']->getValue('fVALUE');
				}
				else {
					$this->info['metabild']="";
				}
				
				# Keywords
				$RS['METATITLE']=$this->getMetaTitle($this->clang);				
				if ($RS['METATITLE']->getRows() == 0)
				{	$RS['METATITLE']=$this->getMetaTitle($this->config->getSetting('Languages','DefaultCLANG'));
				}
				if ($RS['METATITLE']->getRows() > 0) {
					$this->info['metatitle']=$RS['METATITLE']->getValue('fVALUE');
				}
				else {
					$this->info['metatitle']="";
				}
				
				
				# Keywords
				$RS['METAKEYWORDS']=$this->getMetaKeywords($this->clang);				
				if ($RS['METAKEYWORDS']->getRows() == 0)
				{	$RS['METAKEYWORDS']=$this->getMetaKeywords($this->config->getSetting('Languages','DefaultCLANG'));
				}
				if ($RS['METAKEYWORDS']->getRows() > 0) {
					$this->info['metakeywords']=$RS['METAKEYWORDS']->getValue('fVALUE');
				}
				else {
					$this->info['metakeywords']="";
				}
					
				
				# Write cache file				
				$fh = fopen($cachefile, 'w') or die("Please check permissions on the GENERATED folder.");
				$stringData = serialize($this->info);
				fwrite($fh, $stringData);
				fclose($fh);
				
			} //end cache;
			
		}
		//$this->retrieveChildren();
		//$this->retrieveProducts();			
	}
	
	
	function getMetaText($clang)
	{	$RS['METATEXT'] = new sql;
		$RS['METATEXT']->setQuery	('	SELECT * FROM '.$this->table.'cats_meta 
										WHERE (
													(fTYPE="t")
												&&  (rCATID='.$this->info['id'].')
												&&  (rCLANG='.$clang.')
											)
								');
		return $RS['METATEXT'];
	}
	
	
	function getMetaKeywords($clang)
	{	$RS['METAKEYWORDS'] = new sql;
		$RS['METAKEYWORDS']->setQuery	('	SELECT * FROM '.$this->table.'cats_meta 
										WHERE (
													(fTYPE="k")
												&&  (rCATID='.$this->info['id'].')
												&&  (rCLANG='.$clang.')
											)
								');
		return $RS['METAKEYWORDS'];
	}
	
	
	function getMetaTitle($clang)
	{	$RS['METATITLE'] = new sql;
		$RS['METATITLE']->setQuery	('	SELECT * FROM '.$this->table.'cats_meta 
										WHERE (
													(fTYPE="s")
												&&  (rCATID='.$this->info['id'].')
												&&  (rCLANG='.$clang.')
											)
								');
		return $RS['METATITLE'];
	}
	
	
	
	function getMetaImage($clang)
	{	$RS['METAIMG'] = new sql;
		$RS['METAIMG']->setQuery	('	SELECT * FROM '.$this->table.'cats_meta 
										WHERE (
													(fTYPE="i")
												&&  (rCATID='.$this->info['id'].')
												&&  (rCLANG='.$clang.')
											)
								');
					
		return $RS['METAIMG'];
	}
	function setMetaInfo($text="",$title="",$keywords="",$image="")
	{	
		
		$DS['DEL'] = new sql;
		$DS['DEL']->table=$this->table."cats_meta";
		$DS['DEL']->wherevar='WHERE (  (rCATID='.$this->info['id'].') && (rCLANG='.$this->clang.') )';
		$DS['DEL']->delete();
		
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats_meta";
		$AS['ADD']->setValue('fVALUE',$text);
		$AS['ADD']->setValue('rCLANG',$this->clang);
		$AS['ADD']->setValue('fTYPE','t');
		$AS['ADD']->setValue('rCATID',$this->info['id']);
		$AS['ADD']->insert();
		
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats_meta";
		$AS['ADD']->setValue('fVALUE',$title);
		$AS['ADD']->setValue('rCLANG',$this->clang);
		$AS['ADD']->setValue('fTYPE','s');
		$AS['ADD']->setValue('rCATID',$this->info['id']);
		$AS['ADD']->insert();
		
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats_meta";
		$AS['ADD']->setValue('fVALUE',$keywords);
		$AS['ADD']->setValue('rCLANG',$this->clang);
		$AS['ADD']->setValue('fTYPE','k');
		$AS['ADD']->setValue('rCATID',$this->info['id']);
		$AS['ADD']->insert();
			
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats_meta";
		$AS['ADD']->setValue('fVALUE',$image);
		$AS['ADD']->setValue('rCLANG',$this->clang);
		$AS['ADD']->setValue('fTYPE','i');
		$AS['ADD']->setValue('rCATID',$this->info['id']);
		$AS['ADD']->insert();
	
	}
	
	
	
	function getSEFLink($clang)
	{	global $REX;
		
		$path="";
		
		if (isset($REX['ADDON']['REXSALE']['PATHLIST']['CAT'][$this->info['id']][$this->clang]))
		{	$path.=$REX['ADDON']['REXSALE']['PATHLIST']['CAT'][$this->info['id']][$this->clang];
		}
		else
		{	$path.=$REX['ADDON']['REXSALE']['PATHLIST']['CAT'][$this->info['id']][ooRexSaleConfig::getSetting('Languages','DefaultCLANG')];
		}
		return $path."index.html";
	}
	
	
	# Delete a category and all associated languages
	function suicide()
	{	if ($this->info['children']>0)
		{	# Category has children, don't delete. Just cause an error.
			
			
			$this->errors[]=$this->lang->msg('errorCatNotEmpty');
			return false;
		}
		else
		{	$DS['DEL'] = new sql;
			$DS['DEL']->table=$this->table."cats_names";
			$DS['DEL']->wherevar='WHERE rCATID='.$this->info['id'];
			$DS['DEL']->delete();
					
			$DS['DEL'] = new sql;
			$DS['DEL']->table=$this->table."cats";
			$DS['DEL']->wherevar='WHERE fID='.$this->info['id'];
			$DS['DEL']->delete();
		}
	}
	
	# Add a category and add default language
	function addCategory()
	{	$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats";
		$AS['ADD']->setValue('rPARENT',$_POST['parent']);
		$AS['ADD']->insert();
		
		$catID=$AS['ADD']->last_insert_id;
		
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats";
		$AS['ADD']->wherevar = ' WHERE fID='.$catID;
		$AS['ADD']->setValue('fSORTORDER',1000000+$catID);
		$AS['ADD']->update();
		
		
	
		$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."cats_names";
		$AS['ADD']->setValue('rCATID',$catID);
		$AS['ADD']->setValue('rCLANG',$this->config->getSetting('Languages','DefaultCLANG'));
		$AS['ADD']->setValue('fNAME',$_POST['catname']);
		$AS['ADD']->insert();
		
		$this->updateSEF($catID);
		
	}
	
	
	function updateSEF($id)
	{	$sef=new ooRexSaleSEF;
		$sef->regenerate();
	}
	
	function toggleStatus()
	{	if ($this->info['status']==1)
		{	$status=0;
		}
		else
		{	$status=1;
		}
		$AS['TOGGLE'] = new sql;
		$AS['TOGGLE']->table=$this->table."cats";
		$AS['TOGGLE']->setValue('fSTATUS',$status);
		$AS['TOGGLE']->wherevar="WHERE (fID=".$this->info['id'].")";
		$AS['TOGGLE']->update();
	}
	
	function setSort($val)
	{	$AS['TOGGLE'] = new sql;
		$AS['TOGGLE']->table=$this->table."cats";
		$AS['TOGGLE']->setValue('fSORTORDER',$val);
		$AS['TOGGLE']->wherevar="WHERE (fID=".$this->info['id'].")";
		$AS['TOGGLE']->update();
	}
	
	function resortPriorities($array)
	{	if (count($array)>0)
		{
			foreach ($array as $k=>$v)
			{	$sql = new rex_sql;
				$sql->setTable($this->table."cats");
				$sql->setValue('fSORTORDER',intVal($v));
				$sql->wherevar = " WHERE ( fID=".intVal($k)." )";
				$sql->update();
			}
			
		}
	
	}
	
	
	
	# Read out a sitemap
	
	function getCategoryTree($id=0,$key="",$i=0)
	{			
		if ($this->clang=="") {
			$this->clang = $this->config->getSetting('Languages','DefaultCLANG');
		}
		
				
		$RS['CHILDREN'] = new rex_sql;
		$RS['CHILDREN']->setQuery	('	SELECT 
									
									*
									
									FROM '.$this->table.'cats
									LEFT JOIN '.$this->table.'cats_names
									
									ON ( '.$this->table.'cats.fID = '.$this->table.'cats_names.rCATID)
									
									WHERE
									(
										rPARENT = '.$id.' && '.$this->table.'cats_names.rCLANG = '.$this->clang.'
									)
									
									ORDER BY fSORTORDER
									');

		if ($RS['CHILDREN']->getRows()==0) {
			$RS['CHILDREN']->setQuery	('	SELECT 
									
									*
									
									FROM '.$this->table.'cats
									LEFT JOIN '.$this->table.'cats_names
									
									ON ( '.$this->table.'cats.fID = '.$this->table.'cats_names.rCATID)
									
									WHERE
									(
										rPARENT = '.$id.' && '.$this->table.'cats_names.rCLANG = '.$this->config->getSetting('Languages','DefaultCLANG').'
									)
									
									ORDER BY fSORTORDER
									');

		}
	
		if ($key=="")
		{	$key='$this->tree';
		}
		else
		{	$key=$key.'['.$i.']["children"]';
		}
		
		global $REX;
			
		
		for ($j=0;$j<$RS['CHILDREN']->getRows();$j++) {
			$arr = array();
			eval($key.'['.$j.']["metainfo"]["id"]="'.$RS['CHILDREN']->getValue('fID').'";');
			eval($key.'['.$j.']["metainfo"]["name"]="'.$RS['CHILDREN']->getValue('fNAME').'";');
			eval($key.'['.$j.']["metainfo"]["status"]="'.$RS['CHILDREN']->getValue('fSTATUS').'";');
			eval($key.'['.$j.']["metainfo"]["childrenOnline"]="1";');
			
			$id = $RS['CHILDREN']->getValue('fID');
			$url = $REX['ADDON']['REXSALE']['PATHLIST']['CAT'][$id][$this->clang];
			
			eval($key.'['.$j.']["metainfo"]["url"]="'.$url.'";');
			
			$this->getCategoryTree($RS['CHILDREN']->getValue('fID'),$key,$j);
			$RS['CHILDREN']->next();
		}
			
		return $this->tree;
	}
	
	
	function getInfo()
	{	return $this->info;
	}
	
	
	
	# Internal function to retrieve children for the current category.
	function retrieveChildren()
	{	# Get Children for this category.
		$RS['CHILDREN'] = new sql;
		$RS['CHILDREN']->setQuery	('	SELECT fID FROM '.$this->table.'cats 
										WHERE (rPARENT='.$this->info['id'].')'
									);
		$this->info['children']=$RS['CHILDREN']->getRows();
		
		for ($i=0;$i<$RS['CHILDREN']->getRows();$i++)
		{	$cat=new ooRexSaleCategory();
			$cat->setCategory($RS['CHILDREN']->getValue('fID'));
			if ($cat->info['status']==1)
			{	$this->info['childrenOnline']=1;
			}
			
			$RS['CHILDREN']->nextValue();
		}
		
	}

	# Internal function to retrieve children for the current category.
	function retrieveProducts()
	{	# Get Products for this category.
		$RS['PRODUCTS'] = new sql;
		$query = '	SELECT * FROM '.$this->table.'products2cats 
										WHERE (rCAT='.$this->info['id'].')';
		$RS['PRODUCTS']->setQuery($query);
		
		$this->info['products']=$RS['PRODUCTS']->getRows();
				
		for ($i=0;$i<$RS['PRODUCTS']->getRows();$i++)
		{	$prod=new ooRexSaleProduct();
			$prod->setProduct($RS['PRODUCTS']->getValue('rPROD'));
			if ($prod->info['status']==1)
			{	$this->info['productsOnline']=1;
			}
			$RS['PRODUCTS']->nextValue();
		}
		
	}

	
	
	# Internal function to retrieve the current category.
	function retrieveCategory($id,$clang)
	{	$RS['CAT'] = new sql;
		$RS['CAT']->setQuery	('	SELECT 
									
									*
									
									FROM '.$this->table.'cats
									LEFT JOIN '.$this->table.'cats_names
									
									ON ( '.$this->table.'cats.fID = '.$this->table.'cats_names.rCATID)
									
									WHERE
									(
										fID = '.$id.' && '.$this->table.'cats_names.rCLANG = '.$clang.'
									)'

									
								);
		return $RS['CAT'];
	}
	
	
	function getParents($id="",$pars=array())
	{	
		if (!empty($this->errors))
		{	return false;
		}
		if ($id=="")
		{	$id=$this->info['id'];
		}
		
		if ($id>0) {
			$sql = new rex_sql;
			$sql->setQuery('SELECT 
									
									*
									
									FROM '.$this->table.'cats
									LEFT JOIN '.$this->table.'cats_names
									
									ON ( '.$this->table.'cats.fID = '.$this->table.'cats_names.rCATID)
									
									WHERE
									(
										fID = '.$id.' && '.$this->table.'cats_names.rCLANG = '.$this->clang.'
									)');
			if ($sql->getRows()==0) {
				$sql = new rex_sql;
				$sql->setQuery('SELECT 
									
									*
									
									FROM '.$this->table.'cats
									LEFT JOIN '.$this->table.'cats_names
									
									ON ( '.$this->table.'cats.fID = '.$this->table.'cats_names.rCATID)
									
									WHERE
									(
										fID = '.$id.' && '.$this->table.'cats_names.rCLANG = '.$this->config->getSetting('Languages','DefaultCLANG').'
									)');
			}
								
			if ($sql->getRows()>0) {
				$data = $sql->getArray();
				$data = $data[0];
				
				$pars[] = array($data['fID'],$data['fNAME']);
					
				if ($data['rPARENT']>0) {
					$this->getParents($data['rPARENT'],&$pars);
				} else {
					$pars = array_reverse($pars);
					return $pars;
				}
			}
			
		}
		
		
		return $pars;
	}
	
	
	function changeParent($parent)
	{	if ($parent!=$this->info['id'])
		{	$US['CAT'] = new sql;
			$US['CAT']->setTable($this->table.'cats');
			$US['CAT']->setValue('rPARENT',intVal($parent));
			$US['CAT']->where('fID='.$this->info['id']);
			$US['CAT']->update();
		}
	}
	
	function changeName($name)
	{	
		$name=str_replace('/','',$name);
		$US['CAT'] = new sql;
		$US['CAT']->setTable($this->table.'cats_names');
		$US['CAT']->setValue('fNAME',$name);
		
		$RS['CAT']= new rex_sql;
		$RS['CAT']->setQuery('SELECT * FROM '.$this->table.'cats_names WHERE (rCATID='.$this->info['id'].') && (rCLANG='.$this->clang.')');		
		
		if ($RS['CAT']->getRows()>0)
		{	$US['CAT']->where('(rCATID='.$this->info['id'].') && (rCLANG='.$this->clang.')');
			$US['CAT']->update();
		}
		else
		{	$US['CAT']->setValue('rCATID',$this->info['id']);
			$US['CAT']->setValue('rCLANG',$this->clang);
			$US['CAT']->insert();
		}
	}
	
	
	function addProduct()
	{	$US['PROD'] = new sql;
		$US['PROD']->setTable($this->table.'products');
		$US['PROD']->setValue('fSTATUS',0);
		$US['PROD']->insert();
				
		$US['PRODNR'] = new sql;
		$US['PRODNR']->setTable($this->table.'products');
		$US['PRODNR']->setValue('fARTNR',$US['PROD']->last_insert_id);
		$US['PRODNR']->setValue('fSORTORDER',1000000+$US['PROD']->last_insert_id);
		$US['PRODNR']->wherevar = ' WHERE fID='.$US['PROD']->last_insert_id;
		$US['PRODNR']->update();

		

		$US['PRODNAME'] = new sql;
		$US['PRODNAME']->setTable($this->table.'products_names');
		$US['PRODNAME']->setValue('rPRODID',$US['PROD']->last_insert_id);
		$US['PRODNAME']->setValue('fNAME',$_POST['data']['name']);		
		$US['PRODNAME']->setValue('rCLANG',$this->config->getSetting('Languages','DefaultCLANG'));
		$US['PRODNAME']->insert();
		
		$US['PRODDESC'] = new sql;
		$US['PRODDESC']->setTable($this->table.'products_descs');
		$US['PRODDESC']->setValue('rPRODID',$US['PROD']->last_insert_id);
		$US['PRODDESC']->setValue('rCLANG',$this->config->getSetting('Languages','DefaultCLANG'));
		$US['PRODDESC']->insert();
		
		$US['PRODCAT'] = new sql;
		$US['PRODCAT']->setTable($this->table.'products2cats');
		$US['PRODCAT']->setValue('rCAT',$_POST['parent']);
		$US['PRODCAT']->setValue('rPROD',$US['PROD']->last_insert_id);
		$US['PRODCAT']->insert();
		
		$product=new ooRexSaleProduct();
		$product->setLanguage($this->clang);
		$product->setProduct($US['PROD']->last_insert_id);
		$product->updateSEF($US['PROD']->last_insert_id,$_POST['parent']);
		
		unset($product);
	}
	
	
	# Return category value information
	function getValue($key)
	{	return $this->info[$key];
	}	
	
	
	# Return an array of category objects under the current category.
	function getChildren()
	{	global $REX;
	
		if (empty($this->info['children'])) {
			$this->retrieveChildren();
		}
	
		if ($this->clang=="")
		{	$this->clang=ooRexSaleConfig::getSetting('Languages','DefaultCLANG');
		}
	
		$cachefile=$REX['INCLUDE_PATH'].'/generated/files/rexsale.cache.cat.children.'.$this->info['id'].'.'.$this->clang.'.txt';
	
	
		if (file_exists($cachefile))
		{
			$data=file_get_contents($cachefile);
			$this->children=unserialize($data);
		}
		else
		{
			$RS['CHILDREN'] = new sql;
			$RS['CHILDREN']->setQuery	('	SELECT fID FROM '.$this->table.'cats 
											WHERE (rPARENT='.$this->info['id'].') ORDER BY fSORTORDER ASC'
										);
			for ($i=0;$i<$RS['CHILDREN']->getRows();$i++)
			{	# Get Children for this category.
				
				$this->children[$i]=new OORexSaleCategory;
				$this->children[$i]->setLanguage($this->clang);
				$this->children[$i]->setCategory($RS['CHILDREN']->getValue('fID'));
				$RS['CHILDREN']->nextValue();
			}
			
			# Write cache file				
			$fh = fopen($cachefile, 'w') or die("Please check permissions on the GENERATED folder.");
			$stringData = serialize($this->children);
			fwrite($fh, $stringData);
			fclose($fh);
			
		} //end cache
		return $this->children;
	}
	
	
	
	# Count the products in this category
	function countProducts()
	{	$RS['PRODUCTS'] = new sql;
		$query='	SELECT * FROM '.$this->table.'products2cats 
										LEFT JOIN '.$this->table.'products
										ON ('.$this->table.'products2cats.rPROD='.$this->table.'products.fID)
		
										WHERE ( (rCAT='.$this->info['id'].')';
		if (isset($onlyOnline)) {
			if ($onlyOnline==1) {	
				$query.='							&& (fSTATUS=1)';
			}
		}
										
		$query.='						) ORDER BY fSORTORDER ASC';
		
		
		$RS['PRODUCTS']->setQuery($query);
		return $RS['PRODUCTS']->getRows();
	}
	
	
	# Get Products in current category
	function getProducts($onlyOnline=0,$start="",$limit="")
	{	//$this->retrieveProducts();
		global $REX;
	
		if ($this->clang=="")
		{	$this->clang=ooRexSaleConfig::getSetting('Languages','DefaultCLANG');
		}
	
		
		$cachefile=$REX['INCLUDE_PATH'].'/generated/files/rexsale.cache.cat.products.'.$this->info['id'].'.'.$this->clang.'-V'.intVal($start).'-B'.intVal($limit).'.txt';
		
		
		if (file_exists($cachefile)) 
		{
			$data=file_get_contents($cachefile);
			$this->products=unserialize($data);
		}
		else
		{	$RS['PRODUCTS'] = new sql;
			$query='	SELECT * FROM '.$this->table.'products2cats 
											LEFT JOIN '.$this->table.'products
											ON ('.$this->table.'products2cats.rPROD='.$this->table.'products.fID)
			
											WHERE ( (rCAT='.$this->info['id'].')';
			if ($onlyOnline==1)
			{	$query.='							&& (fSTATUS=1)';
			}
											
			$query.='						) ORDER BY fSORTORDER ASC';
			
			if (!$REX['REDAXO'] && $start!=="" && $limit!=="")
			{	$query.=' LIMIT '.intVal($start).','.intVal($limit);
			}
			
			//print_r($query);
											
											
			$RS['PRODUCTS']->setQuery($query);
			
					
			for ($i=0;$i<$RS['PRODUCTS']->getRows();$i++)
			{	# Get Children for this category.
				
				$this->products[$i]=new OORexSaleProduct;
				$this->products[$i]->setLanguage($this->clang);
				$this->products[$i]->setCategory($this->info['id']);
				$this->products[$i]->setProduct($RS['PRODUCTS']->getValue('rPROD'));
				$RS['PRODUCTS']->nextValue();
			}
			# Write cache file
			if (intVal($start)>0 && intVal($limit)>0) {	
			$fh = fopen($cachefile, 'w') or die("Please check permissions on the GENERATED folder.");
			$stringData = serialize($this->products);
			fwrite($fh, $stringData);
			fclose($fh);
			}
			
		}	//end cache
		
		return $this->products;
	}
}
?>