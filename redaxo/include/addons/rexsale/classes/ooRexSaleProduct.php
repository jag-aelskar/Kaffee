<?php

class OORexSaleProduct
{	var $clang;
	var $info;
	var $errors;
	var $config;
	

	function OORexSaleProduct()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
		$this->config=new OORexSaleConfig;
	}
	
	function setLanguage($clang)
	{	$this->clang=$clang;
	}
	
	function setProduct($id)
	{	
		global $REX;
		
		$this->info['id']=$id;
		$this->clang=$REX['CUR_CLANG'];
		

		$cachefile=$REX['INCLUDE_PATH'].'/generated/files/rexsale.cache.prod.'.$id.'.'.$this->clang.'.txt';

		if (file_exists($cachefile))
		{	$data=file_get_contents($cachefile);
			$this->info=unserialize($data);
		}
		else	
		{	$RS['PROD']=$this->retrieveProduct($id,$REX['CUR_CLANG']);
			if ($RS['PROD']->getRows() == 0)
			{	$RS['PROD']=$this->retrieveProduct($id,$this->config->getSetting('Languages','DefaultCLANG'));
			}	
		
			$this->info['status']=$RS['PROD']->getValue('fSTATUS');
			$this->info['name']=$RS['PROD']->getValue('fNAME');
			$this->info['sortorder']=$RS['PROD']->getValue('fSORTORDER');
			$this->info['manufacturer']=$RS['PROD']->getValue('fMANU');
			$this->info['artnr']=$RS['PROD']->getValue('fARTNR');
			$this->info['make']=$RS['PROD']->getValue('fMAKE');
			$this->info['ean']=$RS['PROD']->getValue('fEAN');
			$this->info['upc']=$RS['PROD']->getValue('fUPC');
			$this->info['isbn']=$RS['PROD']->getValue('fISBN');
			$this->info['special']=$RS['PROD']->getValue('fSPECIAL');
			$this->info['download']=$RS['PROD']->getValue('fDOWNLOADLINK');
			$this->info['related']=explode('|',$RS['PROD']->getValue('fRELATED'));
			if ($this->info['related'][0]==0) {
				$this->info['related']=array();
			}
			
					
			$tex=new Textile;
			
			$this->info['desc'][1]=$RS['PROD']->getValue('fDESC1');
			$this->info['desc'][2]=$RS['PROD']->getValue('fDESC2');
			$this->info['desc'][3]=$RS['PROD']->getValue('fDESC3');
			$this->info['desc'][4]=$RS['PROD']->getValue('fDESC4');
			$this->info['desc'][5]=$RS['PROD']->getValue('fDESC5');
			
			$this->info['deschtml'][1]=$tex->textilethis($RS['PROD']->getValue('fDESC1'));
			$this->info['deschtml'][2]=$tex->textilethis($RS['PROD']->getValue('fDESC2'));
			$this->info['deschtml'][3]=$tex->textilethis($RS['PROD']->getValue('fDESC3'));
			$this->info['deschtml'][4]=$tex->textilethis($RS['PROD']->getValue('fDESC4'));
			$this->info['deschtml'][5]=$tex->textilethis($RS['PROD']->getValue('fDESC5'));
			
			$this->info['price']=$RS['PROD']->getValue('fPRICE');

			// Meta keywords
						
			$this->info['meta']['title']=$RS['PROD']->getValue('fMETATITLE');
			$this->info['meta']['keywords']=$RS['PROD']->getValue('fMETAKEYWORDS');
			$this->info['meta']['description']=$RS['PROD']->getValue('fMETADESC');
					
	
			if ($RS['PROD']->getValue('rTAXID')!=0)
			{	$this->info['taxid']=$RS['PROD']->getValue('rTAXID');
				$tax=new ooRexSaleTax();
				$this->info['tax']=$tax->getTaxById($RS['PROD']->getValue('rTAXID'));
				$this->info['priceGross']=$RS['PROD']->getValue('fPRICE')*(1+$this->info['tax']);
			}
			else
			{	$this->info['priceGross']=$RS['PROD']->getValue('fPRICE');
			}
			
			if ($this->config->getSetting('Currency','Position')=="L")
			{	$this->info['priceGrossFormatted']=$this->config->getSetting('Currency','Symbol')." ".number_format(round($this->info['priceGross'],2), 2, '.', '');
			
			
			
			
			}
			else
			{	$this->info['priceGrossFormatted']=number_format(round($this->info['priceGross'],2), 2, '.', '')." ".$this->config->getSetting('Currency','Symbol');
			}	
			
			
		
		
			# Retrieve Images
			$RS['IMAGES'] = new sql;
			$RS['IMAGES']->setQuery	('	SELECT 
										fFILE
										FROM '.$this->table.'images
										WHERE (rPROD='.$this->info['id'].')
										ORDER BY fID ASC;
									');
			
		
			for ($i=0;$i<$RS['IMAGES']->getRows();$i++)
			{	$this->info['images'][0]=""; # Just to get the array to 1 instead of 0.
				$this->info['imagesizes'][0]=""; 
				
				$this->info['images'][]=$RS['IMAGES']->getValue('fFILE');
				
				
				$filename=$REX['INCLUDE_PATH']."/../../files/".$RS['IMAGES']->getValue('fFILE');
				if (file_exists($filename))
				{	 $dims = getimagesize($filename);
					 $this->info['imagesizes'][]=array($dims[0],$dims[1]);
				}
				
				$RS['IMAGES']->nextValue();
				unset($this->info['images'][0]);
				unset($this->info['imagesizes'][0]);	
			}
		
			# Write cache file				
			$fh = fopen($cachefile, 'w') or die("Please check permissions on the GENERATED folder.");
			$stringData = serialize($this->info);
			fwrite($fh, $stringData);
			fclose($fh);
			 //end cache
		
		}
		
	
		$RS['SEF']=$this->getSEFLink($this->clang);
		if ($RS['SEF']=="")
		{	$RS['SEF']=$this->getSEFLink($this->config->getSetting('Languages','DefaultCLANG'));
		}
		
		$this->info['url']=$RS['SEF'];



		# Multiple Categories
		$RS['CATS'] = new sql;
		$RS['CATS']->setQuery	('	SELECT 
									rCAT
									FROM '.$this->table.'products2cats
									WHERE (rPROD='.$this->info['id'].')
								');
		for ($i=0;$i<$RS['CATS']->getRows();$i++)
		{	$this->info['categories'][$RS['CATS']->getValue('rCAT')]=$RS['CATS']->getValue('rCAT');
			$RS['CATS']->nextValue();
		}

	}
	
	
	function toggleStatus()
	{	if ($this->info['status']==1)
		{	$status=0;
		}
		else
		{	$status=1;
		}
		$AS['TOGGLE'] = new sql;
		$AS['TOGGLE']->table=$this->table."products";
		$AS['TOGGLE']->setValue('fSTATUS',$status);
		$AS['TOGGLE']->wherevar="WHERE (fID=".$this->info['id'].")";
		$AS['TOGGLE']->update();
	}
	
	
	
	function getSEFLink($clang)
	{	global $REX;
		
		if (isset($REX['ADDON']['REXSALE']['RCAT'])) {
			$cat=$REX['ADDON']['REXSALE']['RCAT'];
		}
		else {
			$cat="";
		}
		
		
		
		
		
		// fix for search pages and pages where no category is defined.
		if ($cat=="")
		{	if (is_array($REX['ADDON']['REXSALE']['PATHLIST']['PROD'])) {
				foreach ($REX['ADDON']['REXSALE']['PATHLIST']['PROD'] as $k=>$v)
				{	foreach ($v as $kk=>$vv)
					{	if ($kk==$this->info['id'])
						{	$cat = $kk;
							return $vv[$clang].'.html';
						}
					}	
				}
			}
		}
						
		
		
		$path="";
		

		if (isset($REX['ADDON']['REXSALE']['PATHLIST']['PROD'][$cat][$this->info['id']][$clang]))
		{	$path.=$REX['ADDON']['REXSALE']['PATHLIST']['PROD'][$cat][$this->info['id']][$clang];
		}
		else
		{	
			if (!isset($REX['ADDON']['REXSALE']['PATHLIST']['PROD'][$cat][$this->info['id']])) {
				$REX['ADDON']['REXSALE']['PATHLIST']['PROD'][$cat][$this->info['id']][ooRexSaleConfig::getSetting('Languages','DefaultCLANG')]="";
			}
			$path.=$REX['ADDON']['REXSALE']['PATHLIST']['PROD'][$cat][$this->info['id']][ooRexSaleConfig::getSetting('Languages','DefaultCLANG')];
		}
		
		
		return $path.".html";
	}
	
	
	function updateSEF($id,$catid)
	{	
	}
	
	
	
	function retrieveOption($id,$clang)
	{	$RS['OPT'] = new sql;
		$RS['OPT']->setQuery	('	SELECT 
									fNAME,rOPTIONID
									FROM '.$this->table.'options
									
									LEFT JOIN '.$this->table.'options_names
									ON ('.$this->table.'options.fID='.$this->table.'options_names.rOPTIONID)
									
									WHERE (	
											(fID='.$id.')
										&& 	(rCLANGID='.$clang.')
										)
								 ');				 
		return $RS['OPT'];
	}
	

	
	function retrieveVariant($id,$clang)
	{	$RS['VAR'] = new sql;
		$RS['VAR']->setQuery	('	SELECT 
									fNAME
									FROM '.$this->table.'values
									
									LEFT JOIN '.$this->table.'values_names
									ON ('.$this->table.'values.fID='.$this->table.'values_names.rVALID)
									
									WHERE (	
											(fID='.$id.')
										&& 	(rCLANGID='.$clang.')
										)
								 ');
		return $RS['VAR'];
	}

	
	function retrieveProduct($id,$clang)
	{	$RS['PROD'] = new rex_sql;
		#$RS['PROD']->debugsql = 1;
		$RS['PROD']->setQuery	('	SELECT 
									
									'.$this->table.'products.fID as fID,
									fSTATUS,
									fPRICE,
									fNAME,fSORTORDER,
									fMANU,fMAKE,fARTNR,fEAN,fUPC,fISBN,rTAXID,fSPECIAL,fDOWNLOADLINK,fRELATED, 
									fDESC1,fDESC2,fDESC3,fDESC4,fDESC5,fMETATITLE,fMETAKEYWORDS,fMETADESC
									
									
									FROM '.$this->table.'products
									
									LEFT JOIN '.$this->table.'products_names 
									ON ( '.$this->table.'products.fID = '.$this->table.'products_names.rPRODID)
									
									LEFT JOIN '.$this->table.'products_descs
									ON ( '.$this->table.'products.fID = '.$this->table.'products_descs.rPRODID)
									
									
									WHERE
									(
										fID = '.$id.' 
										&& '.$this->table.'products_names.rCLANG = '.$clang.'
										&& '.$this->table.'products_descs.rCLANG = '.$clang.'
									)'

									
								);
								
							
		return $RS['PROD'];
	}
	
	
	
	function replaceImages($str)
	{	$str=explode(',',$str);
		
		$DS['DEL'] = new sql;
		$DS['DEL']->table=$this->table."images";
		$DS['DEL']->wherevar='WHERE rPROD='.$this->info['id'];
		$DS['DEL']->delete();
		
		foreach ($str as $file)
		{	if ($file!="")
			{	$AS['ADD'] = new sql;
				$AS['ADD']->table=$this->table."images";
				$AS['ADD']->setValue('rPROD',$this->info['id']);
				$AS['ADD']->setValue('fFILE',$file);
				$AS['ADD']->insert();
			}
		}
		
		#dbprint($AS);
	}
	
	
	function resortPriorities($array)
	{	if (count($array)>0)
		{
			foreach ($array as $k=>$v)
			{	$sql = new rex_sql;
				$sql->setTable($this->table."products");
				$sql->setValue('fSORTORDER',intVal($v));
				$sql->wherevar = " WHERE ( fID=".intVal($k)." )";
				$sql->update();
			}
			
		}
	
	}
	
	
	function updateData($array,$clang)
	{	if ($clang=="")
		{	$clang=$this->config->getSetting('Languages','DefaultCLANG');
		}
		
		# Update Product Info
		$array['price']=str_replace(',','.',$array['price']);
		
		
		$US['PROD'] = new sql;
		$US['PROD']->setTable($this->table.'products');
		//$US['PROD']->setValue('fSORTORDER',$array['prio']);
		$US['PROD']->setValue('fPRICE',$array['price']);
		$US['PROD']->setValue('rTAXID',$array['tax']);
		$US['PROD']->setValue('fARTNR',$array['artnr']);
		$US['PROD']->setValue('fMANU',$array['manufacturer']);
		$US['PROD']->setValue('fMAKE',$array['make']);
		$US['PROD']->setValue('fEAN',$array['ean']);
		$US['PROD']->setValue('fUPC',$array['upc']);
		$US['PROD']->setValue('fISBN',$array['isbn']);
		$US['PROD']->setValue('fDOWNLOADLINK',$array['download']);
		
		if ($array['special']=="on")
		{	$array['special']=1;
		}
		else
		{	$array['special']=0;
		}
		
		$US['PROD']->setValue('fSPECIAL',$array['special']);
		
		# Related Products
		$US['PROD']->setValue('fRELATED',implode('|',$array['related']));

		
		
		$US['PROD']->wherevar='WHERE (fID='.$this->info['id'].')';
		$US['PROD']->update();
		
				
		# Update Product Name
		$RS['PRODNAME'] = new sql;
		$RS['PRODNAME']->setQuery('SELECT * FROM '.$this->table.'products_names
								WHERE 	(	(rCLANG='.$clang.')	&& (rPRODID='.$this->info['id'].'))');
		$US['PRODNAME'] = new sql;
		$US['PRODNAME']->setTable($this->table.'products_names');
		$US['PRODNAME']->setValue('fNAME',$array['name']);
	
		
		if ($RS['PRODNAME']->getRows()==0)
		{	$US['PRODNAME']->setValue('rCLANG',$clang);
			$US['PRODNAME']->setValue('rPRODID',$this->info['id']);
			$US['PRODNAME']->insert();
			
		}
		else
		{	$US['PRODNAME']->wherevar='WHERE 
									(	(rCLANG='.$clang.')
										&& (rPRODID='.$this->info['id'].')	
									)';
			$US['PRODNAME']->update();
		}
		$this->updateSEF($this->info['id'],$_POST['parent']);
		
		# Update Product Desc
		$RS['PRODDESC'] = new sql;
		$RS['PRODDESC']->setQuery('SELECT * FROM '.$this->table.'products_descs
								WHERE 	(	(rCLANG='.$clang.')	&& (rPRODID='.$this->info['id'].'))');
		$US['PRODDESC'] = new sql;
		$US['PRODDESC']->setTable($this->table.'products_descs');
		$US['PRODDESC']->setValue('fDESC1',$array['desc'][1]);
		$US['PRODDESC']->setValue('fDESC2',$array['desc'][2]);
		$US['PRODDESC']->setValue('fDESC3',$array['desc'][3]);		
		$US['PRODDESC']->setValue('fDESC4',$array['desc'][4]);
		$US['PRODDESC']->setValue('fDESC5',$array['desc'][5]);		
		$US['PRODDESC']->setValue('fMETATITLE',$array['meta']['title']);
		$US['PRODDESC']->setValue('fMETAKEYWORDS',$array['meta']['keywords']);		
		$US['PRODDESC']->setValue('fMETADESC',$array['meta']['description']);		
		
		if ($RS['PRODDESC']->getRows()==0)
		{	$US['PRODDESC']->setValue('rCLANG',$clang);
			$US['PRODDESC']->setValue('rPRODID',$this->info['id']);
			$US['PRODDESC']->insert();
		}
		else
		{	$US['PRODDESC']->wherevar='WHERE 
									(	(rCLANG='.$clang.')
										&& (rPRODID='.$this->info['id'].')	
									)';
			$US['PRODDESC']->update();
		}
		
		global $REX;
	
		# Categories		
		if (!empty($array['categories']))
		{	$DS['DEL'] = new sql;
			$DS['DEL']->table=$this->table."products2cats";
			$DS['DEL']->wherevar='WHERE rPROD='.$this->info['id'];
			$DS['DEL']->delete();		
			
			foreach ($array['categories'] as $k=>$v)
			{	$AS['ADD'] = new sql;
				$AS['ADD']->table=$this->table."products2cats";
				$AS['ADD']->setValue('rPROD',$this->info['id']);
				$AS['ADD']->setValue('rCAT',$v);				
				$AS['ADD']->insert();
				
				$p="";
				foreach ($REX['CLANG'] as $clangID=>$clangName)
				{	
					$p=new ooRexSaleProduct();
					$p->setProduct($this->info['id']);
					$p->setLanguage($clangID);
					$p->updateSEF($this->info['id'],$v);
				}
				
			}
			
			
		}
		
		
		
		
		
		
		
		
		unset($US);
	}
	
	
	function setCategory($id)
	{	$this->category=$id;
	}
	
	
	function suicide()
	{	
		$DS['A'] = new sql;
		$DS['A']->table=$this->table."products";
		$DS['A']->wherevar='WHERE fID = '.$this->info['id'];
		$DS['A']->delete();
		
		$DS['B'] = new sql;
		$DS['B']->table=$this->table."products_names";
		$DS['B']->wherevar='WHERE rPRODID = '.$this->info['id'];
		$DS['B']->delete();
		
		$DS['C'] = new sql;
		$DS['C']->table=$this->table."products2cats";
		$DS['C']->wherevar='WHERE rPROD = '.$this->info['id'];
		$DS['C']->delete();
		
		$DS['D'] = new sql;
		$DS['D']->table=$this->table."options2products";
		$DS['D']->wherevar='WHERE rPRODID = '.$this->info['id'];
		$DS['D']->delete();

		$DS['E'] = new sql;
		$DS['E']->table=$this->table."options2products";
		$DS['E']->wherevar='WHERE rPRODID = '.$this->info['id'];
		$DS['E']->delete();

		$DS['F'] = new sql;
		$DS['F']->table=$this->table."sef";
		$DS['F']->wherevar='WHERE ( (fMODE="p") && (rID = '.$this->info['id'].') && (rCATID='.$this->category.') )';
		$DS['F']->delete();
	}
	
	
	function getValue($key)
	{	return $this->info[$key];
	}
}
?>
