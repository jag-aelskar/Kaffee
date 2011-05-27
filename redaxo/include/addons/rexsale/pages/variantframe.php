<?php
	session_start();

	#### Load and parse variants/options from the db
	################################################
	$variants = new ooRexSaleVariant();
	$variants->setLanguage($_REQUEST['clang']);	
	$options = $variants->getOptions();

	foreach($options as $k=>$v)
	{	$values[$k]=$variants->getValuesForOption($k);
	}
		
	$productvariants=$variants->getVariantsForProduct($_GET['product']);
	# Get the product info, bzw. Tax
	$prod = new ooRexSaleProduct();
	$prod->setLanguage($_REQUEST['clang']);
	$prod->setProduct($_GET['product']);
	$tax=$prod->info['tax'];


	# Clear out the session variables
	unset($_SESSION['prodvals']);

	$action=$_POST['action'];
	
	$prodOptions=&$_SESSION['prodopts'][$_GET['product']];
	$prodValues=&$_SESSION['prodvals'][$_GET['product']];
	
	# Get Prices for the Current Option/Values from the DB
	$prodPrices=array();
	$sql=new sql;
	$sql->setQuery('SELECT * FROM '.$REX['ADDON']['REXSALE']['TABLE'].'values2products WHERE rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product']);

	
	for ($i=0;$i<$sql->getRows();$i++)
	{	$price=$sql->getValue('fPRICE');
		$mod=$sql->getValue('fMODIFIER');
		if ($mod=="-")
		{	$price=$price*-1;
		}
	
		$prodPrices[$sql->getValue('rVALUEID')]=str_replace(",",".",$price);
		$sql->nextValue();
	}
		
	if (count($productvariants)>0)
	{	# Loop options
		foreach ($productvariants as $k=>$v)
		{	if (!in_array($v['optionID'],$prodOptions))
			{	$prodOptions[]=$v['optionID'];
			}
			
			if (!in_array($v['wertID'],$prodValues[$v['optionID']]))
			{	$prodValues[$v['optionID']][]=$v['wertID'];
			}
		}
	}
	
	
	#### Option Management
	#######################
	# Add new option
	if ($action['addOption']!="")
	{	$option=$_POST['addOption'];
		
		if (!in_array($prodOptions,$option))
		{	$prodOptions[]=$option;
		}
	}
	
	# Del existing option
	if ($action['delOption']!="")
	{	if (is_array($prodOptions))
		{	foreach ($prodOptions as $k=>$v)
			{	if ($v!=$action['delOption'])
				{	$arr2[]=$v;
				}
			}
			$prodOptions=$arr2;
			unset($arr2);
			
			# Del from the db
			$DS['DEL'] = new sql;
			$DS['DEL']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$DS['DEL']->wherevar=' WHERE rOPTIONID='.$action['delOption'].' && rPRODID='.$_GET['product'];
			$DS['DEL']->delete();
		}
	}
	
	# Move existing option up
	if ($action['moveOptionUp']!="")
	{	if ($action['moveOptionUp']>0)
		{	$tmp=$prodOptions[$action['moveOptionUp']-1];
			$cur=$prodOptions[$action['moveOptionUp']];
			
			$prodOptions[$action['moveOptionUp']-1]=$prodOptions[$action['moveOptionUp']];
			$prodOptions[$action['moveOptionUp']]=$tmp;

			# update db
			// move previous item to a random negative sort
			$x=rand()*-1;
			$US['MOVE']=new sql;
			$US['MOVE']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE']->setValue('fOPTSORT',$x);
			$US['MOVE']->wherevar=' WHERE rOPTIONID='.$tmp.' && rPRODID='.$_GET['product'];
			$US['MOVE']->update();
			
			// shift current to previous
			$US['MOVE2']=new sql;
			$US['MOVE2']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE2']->setValue('fOPTSORT',$action['moveOptionUp']-1);
			$US['MOVE2']->wherevar=' WHERE rOPTIONID='.$cur.' && rPRODID='.$_GET['product'];
			$US['MOVE2']->update();
			
			
			// shift previous to current
			$US['MOVE3']=new sql;
			$US['MOVE3']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE3']->setValue('fOPTSORT',$action['moveOptionUp']);
			$US['MOVE3']->wherevar=' WHERE fOPTSORT='.$x.' && rPRODID='.$_GET['product'];
			$US['MOVE3']->update();
			
		}
	}
	
	# Move existing option down
	if ($action['moveOptionDown']!="")
	{	if ($action['moveOptionDown']<count($prodOptions)-1)
		{	$tmp=$prodOptions[$action['moveOptionDown']+1];
			$cur=$prodOptions[$action['moveOptionDown']];
			$prodOptions[$action['moveOptionDown']+1]=$prodOptions[$action['moveOptionDown']];
			$prodOptions[$action['moveOptionDown']]=$tmp;
			
			
			
			# update db
			// move previous item to a random negative sort
			$x=rand()*-1;
			$US['MOVE']=new sql;
			$US['MOVE']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE']->setValue('fOPTSORT',$x);
			$US['MOVE']->wherevar=' WHERE rOPTIONID='.$tmp.' && rPRODID='.$_GET['product'];
			$US['MOVE']->update();
			
			// shift current to previous
			$US['MOVE2']=new sql;
			$US['MOVE2']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE2']->setValue('fOPTSORT',$action['moveOptionDown']+1);
			$US['MOVE2']->wherevar=' WHERE rOPTIONID='.$cur.' && rPRODID='.$_GET['product'];
			$US['MOVE2']->update();
			
			
			// shift previous to current
			$US['MOVE3']=new sql;
			$US['MOVE3']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE3']->setValue('fOPTSORT',$action['moveOptionDown']);
			$US['MOVE3']->wherevar=' WHERE fOPTSORT='.$x.' && rPRODID='.$_GET['product'];
			$US['MOVE3']->update();
						
		}
	}











	#### Value Management
	#######################
	# Add new value
	if ($action['addValue']!="")
	{	$value=$_POST['addValue'];
		if (!in_array($value,$prodValues[$_GET['editOption']]))
		{	$prodValues[$_GET['editOption']][]=$value;
		
			$optPos=array_search($_GET['editOption'],$prodOptions);

			$valPos=count($prodValues[$_GET['editOption']])-1;
			#dbprint($valPos);
		
			# Insert into the DB
			$AS['ADD'] = new sql;
			$AS['ADD']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$AS['ADD']->setValue('rVALUEID',$value);
			$AS['ADD']->setValue('rOPTIONID',intVal($_GET['editOption']));
			$AS['ADD']->setValue('rPRODID',$_GET['product']);
			$AS['ADD']->setValue('fPRICE',0);
			$AS['ADD']->setValue('fOPTSORT',$optPos);
			$AS['ADD']->setValue('fSORT',$valPos);
			$AS['ADD']->setValue('fMODIFIER','+');
			$AS['ADD']->insert();
		}
		
	}
	
	# Del existing value
	if ($action['delValue']!="")
	{	if (is_array($prodValues[$_GET['editOption']]))
		{	foreach ($prodValues[$_GET['editOption']] as $k=>$v)
			{	if ($v!=$action['delValue'])
				{	$arr2[]=$v;
				}
			}
			$prodValues[$_GET['editOption']]=$arr2;
			unset($arr2);
		}
		
		# Del from the db
		$DS['DEL'] = new sql;
		$DS['DEL']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
		$DS['DEL']->wherevar=' WHERE rVALUEID='.$action['delValue'].' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
		$DS['DEL']->delete();
	}
	
	# Move existing value up
	if ($action['moveValueUp']!="")
	{	if ($action['moveValueUp']>0)
		{	$tmp=$prodValues[$_GET['editOption']][$action['moveValueUp']-1];
			$cur=$prodValues[$_GET['editOption']][$action['moveValueUp']];
			$prodValues[$_GET['editOption']][$action['moveValueUp']-1]=$prodValues[$_GET['editOption']][$action['moveValueUp']];
			$prodValues[$_GET['editOption']][$action['moveValueUp']]=$tmp;
					
			# update db
			// move previous item to a random negative sort
			$x=rand()*-1;
			$US['MOVE']=new sql;
			$US['MOVE']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE']->setValue('fSORT',$x);
			$US['MOVE']->wherevar=' WHERE rVALUEID='.$tmp.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
			$US['MOVE']->update();
			
			// shift current to previous
			$US['MOVE2']=new sql;
			$US['MOVE2']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE2']->setValue('fSORT',$action['moveValueUp']-1);
			$US['MOVE2']->wherevar=' WHERE rVALUEID='.$cur.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
			$US['MOVE2']->update();
			
			
			// shift previous to current
			$US['MOVE3']=new sql;
			$US['MOVE3']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE3']->setValue('fSORT',$action['moveValueUp']);
			$US['MOVE3']->wherevar=' WHERE fSORT='.$x.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
			$US['MOVE3']->update();
			
		}
	}
	
	# Move existing value down
	if ($action['moveValueDown']!="")
	{	if ($action['moveValueDown']<count($prodValues[$_GET['editOption']])-1)
		{	$tmp=$prodValues[$_GET['editOption']][$action['moveValueDown']+1];
			$cur=$prodValues[$_GET['editOption']][$action['moveValueDown']];
			$prodValues[$_GET['editOption']][$action['moveValueDown']+1]=$prodValues[$_GET['editOption']][$action['moveValueDown']];
			$prodValues[$_GET['editOption']][$action['moveValueDown']]=$tmp;
			
			# update db
			// move next item to a random negative sort
			$x=rand()*-1;
			$US['MOVE']=new sql;
			$US['MOVE']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE']->setValue('fSORT',$x);
			$US['MOVE']->wherevar=' WHERE rVALUEID='.$tmp.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
			$US['MOVE']->update();
			
			// shift current to next
			$US['MOVE2']=new sql;
			$US['MOVE2']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE2']->setValue('fSORT',$action['moveValueDown']+1);
			$US['MOVE2']->wherevar=' WHERE rVALUEID='.$cur.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
			$US['MOVE2']->update();
			
			
			// shift previous to current
			$US['MOVE3']=new sql;
			$US['MOVE3']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
			$US['MOVE3']->setValue('fSORT',$action['moveValueDown']);
			$US['MOVE3']->wherevar=' WHERE fSORT='.$x.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
			$US['MOVE3']->update();
			
		}
	}

	# Save prices
	if ($action['savePrices']!="")
	{	if (count($_POST['price'])>0)
		{		
			foreach ($_POST['price'] as $k=>$v)
			{	$v=str_replace(",",".",$v);
				$prodPrices[$k]=floatVal($v);
				$prodPrices[$k]=number_format($prodPrices[$k], 3, '.', '');
				
				// shift current to next
				$US['PRICE']=new sql;
				$US['PRICE']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
				
				$price=$prodPrices[$k];
				if ($prodPrices[$k]<0)
				{	$US['PRICE']->setValue('fMODIFIER','-');
					$price=floatVal($price*-1);
					$price=number_format($price, 3, '.', '');
				}
				else
				{	$US['PRICE']->setValue('fMODIFIER','+');
				}
				
				$US['PRICE']->setValue('fPRICE',$price);
								
				$US['PRICE']->wherevar=' WHERE rVALUEID='.$k.' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
				$US['PRICE']->update();				
				
			}	
		}
	}


	#### Abhängigkeiten
	#######################
	if ($_GET['editOption']>0 && $_GET['editValue']>0)
	{	
		# Retrieve Dependencies
		$sql=new sql;
		$sql->setQuery('SELECT fDEPS FROM '.$REX['ADDON']['REXSALE']['TABLE'].'values2products  WHERE rVALUEID='.$_GET['editValue'].' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product']);

		if ($sql->getValue('fDEPS')!="")
		{	$prodDeps=unserialize($sql->getValue('fDEPS'));
		}
		else
		{	$prodDeps=array();
		}

		#dbprint($sql->get_array());
		
	
	
		$optPos=array_search($_GET['editOption'],$prodOptions);
		
		for ($i=0;$i<$optPos;$i++)
		{	$abh[]=array("id"=>$prodOptions[$i],"array"=>$prodValues[$prodOptions[$i]]);
		}	
	}
	
	if ($action['saveDependencies']!="")
	{	$prodDeps="";
		foreach ($_POST['abhaengigkeiten'] as $k=>$v)
		{	if ($v!="-1")
			{	$tmp=explode('-',$v);
				$prodDeps[$tmp[0]][$tmp[1]]=1;
			}
		}

		
		$serialized=serialize($prodDeps);
		
		$US['DEPS']=new sql;
		$US['DEPS']->table=$REX['ADDON']['REXSALE']['TABLE']."values2products";
		$US['DEPS']->setValue('fDEPS',$serialized);
		$US['DEPS']->wherevar=' WHERE rVALUEID='.$_GET['editValue'].' && rOPTIONID='.$_GET['editOption'].' && rPRODID='.$_GET['product'];
		$US['DEPS']->update();	
		
	}
	

	$smarty->assign("variants",$productvariants);
	$smarty->assign("options",$options);
	$smarty->assign("values",$values);
	
	$smarty->assign("tax",$tax);
	
	$smarty->assign('prodOptions',$prodOptions);
	$smarty->assign('prodValues',$prodValues);
	$smarty->assign('prodDeps',$prodDeps);
	$smarty->assign('prodPrices',$prodPrices);
	$smarty->assign('prodAbh',$abh);

	//print_r($values);

	#dbprint($_POST);
	#dbprint($productvariants);
	#dbprint($prodDeps);
	#dbprint($prodOptions,"Options");
	#dbprint($prodValues,"Values");
	#dbprint($prodPrices);
	#dbprint($prodOptions);

	$smarty->display('backend-variantframe.htm');
?>