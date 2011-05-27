<?php
if (!empty($vars))
	{	$variations=array();
		$modifiersExist=false;
		
		if (isset($prod)) {
			foreach($vars as $k=>$v)
			{	
				$tmp[0]=$v['wert'];
				$tmp[1]=$v['wertID'];
				$tmp[2]=$v['price'];
					
				$tmp[3]=$v['modifier'];
				$tmp[4]=$v['priceGross'];
				
				# Detect if any variants have price variations
				if ($tmp[4]>0)
				{	$modifiersExist=true;
				}
				
				$modifier="";
				if ($v['modifier']=="-")
				{	$modifier=$v['priceGross']*-1;
				}
				else
				{	$modifier=$v['priceGross'];
				}
				$tmp[5]=$prod->info['priceGross']+$modifier;
				$tmp[4]=number_format(round($tmp[4],2), 2, '.', '');
				$tmp[5]=number_format(round($tmp[5],2), 2, '.', '');
				
				$variations[$prod->info['id']][$v['optionID']]['name']=$v['option'];
				$variations[$prod->info['id']][$v['optionID']]['data'][]=$tmp;
				unset($tmp);
			}
		}
		
		if ($modifiersExist==true)
		{	$module->assign('priceChange','1');
		}
		
	}
?>