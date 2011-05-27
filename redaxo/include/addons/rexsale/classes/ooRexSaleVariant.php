<?php

class OORexSaleVariant
{	var $clang;
	var $info;
	var $errors;
	var $config;
	

	function OORexSaleVariant()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
		$this->config=new OORexSaleConfig;
	}
	
	function setLanguage($clang)
	{	if ($clang!="")
		{	$this->clang=$clang;
		}
		else
		{	$this->clang=$this->config->getSetting('Languages','DefaultCLANG');
		}
	}
	
	function getOptions()
	{	$RS['OPTIONS'] = new sql;
		$RS['OPTIONS']->setQuery('	SELECT fID,fNAME
									FROM '.$this->table.'options
									
									LEFT JOIN '.$this->table.'options_names
									ON ('.$this->table.'options.fID='.$this->table.'options_names.rOPTIONID)
									ORDER BY fNAME ASC
								');
		
		unset($options);
		for($i=0;$i<$RS['OPTIONS']->getRows();$i++)
		{	$RS['OPT']=$this->retrieveOption($RS['OPTIONS']->getValue('fID'),$this->clang);
		
			if ($RS['OPT']->getRows()==0)
			{	$RS['OPT']=$this->retrieveOption($RS['OPTIONS']->getValue('fID'),$this->config->getSetting('Languages','DefaultCLANG'));
			}
		
			$options[$RS['OPTIONS']->getValue('fID')]=utf8_encode($RS['OPT']->getValue('fNAME'));
			$RS['OPTIONS']->nextValue();
		}
		return $options;
	}
	
	
	function getValuesForOption($id)
	{	$RS['VALUES'] = new sql;
		$RS['VALUES']->setQuery('	SELECT fID
									FROM '.$this->table.'values
									WHERE (rOPTIONID='.$id.')
									
								');
		
		unset($values);
		for($i=0;$i<$RS['VALUES']->getRows();$i++)
		{	
			$RS['VAL']=$this->retrieveVariant($RS['VALUES']->getValue('fID'),$this->clang);
			
			if ($RS['VAL']->getRows()==0)
			{	$RS['VAL']=$this->retrieveVariant($RS['VALUES']->getValue('fID'),$this->config->getSetting('Languages','DefaultCLANG'));
			}
			
			$values[$RS['VALUES']->getValue('fID')]=utf8_encode($RS['VAL']->getValue('fNAME'));
			$RS['VALUES']->nextValue();
		}
		
		
		return $values;
	}
	
	
	function getVariantsForProduct($productID,$constrain="")
	{	global $REX;
		$RS['OPTIONS'] = new sql;
		$RS['OPTIONS']->setQuery	('	SELECT 
									fINDEX,
									rPRODID,
									rVALUEID,
									rOPTIONID,
									fPRICE,
									fMODIFIER,
									fDEPS,
									fOPTSORT
									
									FROM
									
									'.$this->table.'values2products
									
									WHERE (rPRODID='.$productID.')
									
									ORDER BY fOPTSORT,fSORT
								');

		$RS['PROD'] = new sql;
		$RS['PROD']->setQuery	('	SELECT *
									FROM
									'.$this->table.'products WHERE fID='.$productID);
		$taxid=$RS['PROD']->getValue('rTAXID');
		
		
		
		unset($options);
	
		$tax=new ooRexSaleTax();
		$tax=$tax->getTaxById($taxid);
		
		for ($i=0;$i<$RS['OPTIONS']->getRows();$i++)
		{	
				$serialdeps=$RS['OPTIONS']->getValue('fDEPS');
				if ($serialdeps=='s:0:"";')
				{	$block=1;
				}
				else
				{	$block=0;
				}
				
											
				$deps=unserialize($serialdeps);
								
				#dbprint($deps,"dependencies for: ".$RS['OPTIONS']->getValue('rOPTIONID').":".$RS['OPTIONS']->getValue('rVALUEID'));
				if (is_array($deps) && is_array($constrain))
				{	
					foreach ($deps as $k=>$v)
					{	#dbprint($k);
						$cont[$k]=0;
						foreach ($v as $kk=>$vv)
						{	if (in_array($kk,$constrain))
							{	$cont[$k]=1;
							}
						}
					}
					#dbprint($cont,"cont");
					
					# Set continue to 1
					$continue=1;
					foreach ($cont as $k=>$v)
					{	if ($v==0)
						{	$continue=0;
						}
					}
					
				}
				else
				{	# No deps defined, enable the variant
					$continue=1;
				}
			
	
		
			if (($continue==1 || $REX['REDAXO']) && $block!=1)
			{
				$RS['OPT']=$this->retrieveOption($RS['OPTIONS']->getValue('rOPTIONID'),$this->clang);
				if ($RS['OPT']->getRows()==0)
				{	$RS['OPT']=$this->retrieveOption($RS['OPTIONS']->getValue('rOPTIONID'),$this->config->getSetting('Languages','DefaultCLANG'));
				}
				
				$RS['VAL']=$this->retrieveVariant($RS['OPTIONS']->getValue('rVALUEID'),$this->clang);
				if ($RS['VAL']->getRows()==0)
				{	$RS['VAL']=$this->retrieveVariant($RS['OPTIONS']->getValue('rVALUEID'),$this->config->getSetting('Languages','DefaultCLANG'));
				}
						
				
				$options[$RS['OPTIONS']->getValue('fINDEX')]['option']=utf8_encode($RS['OPT']->getValue('fNAME'));
				$options[$RS['OPTIONS']->getValue('fINDEX')]['optionID']=$RS['OPTIONS']->getValue('rOPTIONID');
				$options[$RS['OPTIONS']->getValue('fINDEX')]['wert']=utf8_encode($RS['VAL']->getValue('fNAME'));
				$options[$RS['OPTIONS']->getValue('fINDEX')]['wertID']=$RS['OPTIONS']->getValue('rVALUEID');
				$options[$RS['OPTIONS']->getValue('fINDEX')]['price']=round($RS['OPTIONS']->getValue('fPRICE'), 2);
				$options[$RS['OPTIONS']->getValue('fINDEX')]['priceGross']=round($RS['OPTIONS']->getValue('fPRICE')*(1+$tax),2);
				$options[$RS['OPTIONS']->getValue('fINDEX')]['modifier']=$RS['OPTIONS']->getValue('fMODIFIER');
			}
			$continue=0;

			
			$RS['OPTIONS']->nextValue();
		}
		if (isset($options)) {
			return $options;
		} 
		
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

	function addOption()
	{	$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."options";
		$AS['ADD']->setValue('fID','');
		$AS['ADD']->insert();
		
		$AS['ADDNAME'] = new sql;
		$AS['ADDNAME']->table=$this->table."options_names";
		$AS['ADDNAME']->setValue('rOPTIONID',$AS['ADD']->last_insert_id);
		$AS['ADDNAME']->setValue('rCLANGID',$this->config->getSetting('Languages','DefaultCLANG'));
		$AS['ADDNAME']->setValue('fNAME','--NEW OPTION--');
		$AS['ADDNAME']->insert();
		
		unset($AS);
	}

	function delOption($optionID)
	{	$DS['A'] = new sql;
		$DS['A']->table=$this->table."options";
		$DS['A']->wherevar='WHERE fID = '.$optionID;
		$DS['A']->delete();
		
		$DS['B'] = new sql;
		$DS['B']->table=$this->table."options_names";
		$DS['B']->wherevar='WHERE rOPTIONID = '.$optionID;
		$DS['B']->delete();
		
		$DS['C'] = new sql;
		$DS['C']->table=$this->table."options2products";
		$DS['C']->wherevar='WHERE rOPTIONID = '.$optionID;
		$DS['C']->delete();
		
		
		$RS['VALUES']=new sql;
		$RS['VALUES']->setQuery('SELECT fID FROM '.$this->table.'values WHERE rOPTIONID = '.$optionID);

		for ($i=0;$i<$RS['VALUES']->getRows();$i++)
		{	$DS['D'.$i] = new sql;
			$DS['D'.$i]->table=$this->table."values_names";
			$DS['D'.$i]->wherevar='WHERE rVALID = '.$RS['VALUES']->getValue('fID');
			$DS['D'.$i]->delete();
			$RS['VALUES']->nextValue();
		}
		
		$DS['D'] = new sql;
		$DS['D']->table=$this->table."values";
		$DS['D']->wherevar='WHERE rOPTIONID = '.$optionID;
		$DS['D']->delete();
		
		$DS['D'] = new sql;
		$DS['D']->table=$this->table."values2products";
		$DS['D']->wherevar='WHERE rOPTIONID = '.$optionID;
		$DS['D']->delete();
		
	}

	
	function addValue($optionID)
	{	$AS['ADD'] = new sql;
		$AS['ADD']->table=$this->table."values";
		$AS['ADD']->setValue('rOPTIONID',$optionID);
		$AS['ADD']->insert();
		
		$AS['ADDNAME'] = new sql;
		$AS['ADDNAME']->table=$this->table."values_names";
		$AS['ADDNAME']->setValue('rVALID',$AS['ADD']->last_insert_id);
		$AS['ADDNAME']->setValue('rCLANGID',$this->config->getSetting('Languages','DefaultCLANG'));
		$AS['ADDNAME']->setValue('fNAME','--NEW VALUE--');
		$AS['ADDNAME']->insert();
	}
	
	function delValue($valueID)
	{	
		$DS['A'] = new sql;
		$DS['A']->table=$this->table."values";
		$DS['A']->wherevar='WHERE fID = '.$valueID;
		$DS['A']->delete();
		
		$DS['B'] = new sql;
		$DS['B']->table=$this->table."values_names";
		$DS['B']->wherevar='WHERE rVALID = '.$valueID;
		$DS['B']->delete();
		
		$DS['C'] = new sql;
		$DS['C']->table=$this->table."values2products";
		$DS['C']->wherevar='WHERE rVALUEID = '.$valueID;
		$DS['C']->delete();
	}
	
	function renameOption($option,$newname,$clang)
	{	if ($clang=="")
		{	$clang=$this->config->getSetting('Languages','DefaultCLANG');
		}
		
		$RS['REN'] = new sql;
		$RS['REN']->setQuery('SELECT * FROM '.$this->table.'options_names WHERE (rCLANGID = '.$clang.') && (rOPTIONID='.$option.')');
		
		$US['REN'] = new sql;
		$US['REN']->table=$this->table."options_names";
		$US['REN']->setValue('fNAME',$newname);
		
		if ($RS['REN']->getRows()==0)
		{	$US['REN']->setValue('rCLANGID',$clang);
			$US['REN']->setValue('rOPTIONID',$option);
			$US['REN']->insert();
		}
		else
		{	$US['REN']->wherevar='WHERE (rCLANGID = '.$clang.') && (rOPTIONID='.$option.')';
			$US['REN']->update();
		}
		
		#dbprint($US);
	}
	
	
	function renameValue($option,$value,$newname,$clang)
	{	if ($clang=="")
		{	$clang=$this->config->getSetting('Languages','DefaultCLANG');
		}
		
		$RS['REN'] = new sql;
		$RS['REN']->setQuery('SELECT * FROM '.$this->table.'values_names WHERE (rCLANGID = '.$clang.') && (rVALID='.$value.')');
		#dbprint($RS);
		
		$US['REN'] = new sql;
		
		$US['REN']->table=$this->table."values_names";
		$US['REN']->setValue('fNAME',$newname);
		
		if ($RS['REN']->getRows()==0)
		{	$US['REN']->setValue('rCLANGID',$clang);
			$US['REN']->setValue('rVALID',$value);
			$US['REN']->insert();
		}
		else
		{	$US['REN']->wherevar='WHERE (rCLANGID = '.$clang.') && (rVALID='.$value.')';
			$US['REN']->update();
		}
	}
	
}
?>