<?php
class ooRexSaleCart
{	
	var $cart;
	var $items;
	var $total;
	var $includedTax;
	var $totalwithoutpostage;
	
	function ooRexSaleCart()
	{	global $REX;
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";
		$this->config=new OORexSaleConfig;
		
		$this->cart=&$_SESSION['rexsale']['cart'];	
		$this->items=&$_SESSION['rexsale']['items'];
		$this->settings=&$_SESSION['rexsale']['settings'];
		$this->recalculate();
	}
	
	function emptyBasket()
	{	$this->cart="";
		$this->items="";
		$this->settings="";
	}
	 
	function formatPrice($betrag)
	{	$betrag=number_format(round($betrag,2), 2, $this->config->getSetting('Currency','Separator'), '');
	
		if ($this->config->getSetting('Currency','Position')=="L")
		{	$betrag=$this->config->getSetting('Currency','Symbol')." ".$betrag;
		}
		else
		{	$betrag=$betrag." ".$this->config->getSetting('Currency','Symbol');
		}
		return $betrag;
	}
	
	function setFreePostage($x)
	{	$this->settings['freepostage']=$x;
	}
	
	function addUpdateBasket($ident,$quantity,$increment=1)
	{	
		if ($quantity>0)
		{	if ($this->cart[$ident]>0 && $increment==1)
			{	$quantity=$quantity+$this->cart[$ident];
			}
			$this->cart[$ident]=$quantity;	
		}
		else if ($quantity<=0)
		{	unset($this->cart[$ident]);
		}
		
	}
	
	
	function updateAmounts($array)
	{	if (is_array($array))
		{	foreach ($array as $ident=>$quantity)
			{					
				$this->addUpdateBasket($ident,$quantity,0);
			}
		}
	}
	
	function setPostage($val)
	{	if ($this->settings['freepostage']!=1)
		{	$this->settings['postage']=$val;
		}
		else
		{	$this->settings['postage']="0.00";
		}
	}
	
	
	function recalculate()
	{	if (!empty($this->cart))
		{	
			$this->includedTax=0;
			foreach ($this->cart as $k=>$v)
			{	$item=explode('-',$k);
				
				
				unset($this->items);
				if (count($item)>1 && count($item)<3)
				{	$item[0] = intVal($item[0]);
					$product=new ooRexSaleProduct();
					$product->setLanguage($REX['CUR_CLANG']);
					$product->setProduct($item[0]);		
				
					$tmp['name']=$product->info['name'];
					$tmp['desc']=$product->info['desc'][2];
					
					# Get Price (Net)
					$tmp['price']=$product->info['price'];		
					$tmp['origprice']=$product->info['price'];
				
				
					$tmp['amount']=$v;
					$tmp['ident']=$k;

									
					# Scan Variants (Net Prices)
					if ($item[1]!="")
					{	$item[1]=explode('#',$item[1]);
						$vars=new ooRexSaleVariant();
						$vars->setLanguage($REX['CUR_CLANG']);
						$vars=$vars->getVariantsForProduct($item[0]);
						
						
						
						foreach ($item[1] as $variant)
						{	if ($item[1]!="")
							{	if (is_array($vars))
								{
									foreach ($vars as $varkey=>$varmeta)
									{	if ($varmeta['wertID']==$variant)
										{	$tmp['variants'][]=$varmeta['option'].": ".$varmeta['wert'];
											if ($varmeta['modifier']=="-")
											{	$varmeta['price']=$varmeta['price']*-1;
											}
											$tmp['price']=$tmp['price']+$varmeta['price'];	
											$tmp['origprice']=$tmp['price'];
										}
									}
								}
							}
						}
					}


					# Calculate included tax so far
					$theTaxPercent=($product->info['tax']*100)+100;
					$priceRounded=round($tmp['price']*($product->info['tax']+1),2);
					
					$this->includedTax=$this->includedTax+( ($priceRounded*$v)  /  $theTaxPercent ) * ($theTaxPercent-100);
					
					
										
					# Add tax to the price (for display purposes)
					$tmp['price']=$tmp['price']*(1+$product->info['tax']);
					$tmp['origprice']=$tmp['origprice']*(1+$product->info['tax']);		
					
					$tmp['price']=number_format(round($tmp['price'],2)*$tmp['amount'], 2, '.', '');
					
					
					
					# Format the price
					$tmp['price']=$tmp['price'];
					$tmp['origprice']=number_format($tmp['origprice'], 2, '.', '');
					
					if ($this->config->getSetting('Currency','Position')=="L")
					{	$tmp['price']=$this->config->getSetting('Currency','Symbol').$tmp['price'];
						$tmp['origprice']=$this->config->getSetting('Currency','Symbol')." ".$tmp['origprice'];
					}
					else
					{	$tmp['price']=$tmp['price']." ".$this->config->getSetting('Currency','Symbol');
						$tmp['origprice']=$tmp['origprice']." ".$this->config->getSetting('Currency','Symbol');
					}
					
					
					
					$this->total=$this->total+$tmp['price'];
					
					# Save total without postage
					$this->totalwithoutpostage=$this->total;
									
					
					$products[]=$tmp;
					unset($tmp);
				}
			}
		}
		
		if ($this->settings['postage']!="0.00")
		{	$this->settings['originalpostage']=$this->settings['postage'];
		}
		
		$this->settings['scriptmessage']="";
		$this->setFreePostage(0);
		global $REX;
		include $REX['INCLUDE_PATH']."/addons/rexsale/includes/conditions.inc.php";
		
		
		# Add postage cost
		if ($this->settings['freepostage']==1)
		{	$this->postage="0.00";
			$this->settings['postage']="0.00";
		}
		else
		{	$this->settings['postage']=$this->settings['originalpostage'];
		}
		
		
		$this->total=$this->total+$this->settings['postage'];
		
	
		# Increment Tax
		$taxPercent=($this->config->getSetting('General','PostageTax')+1)*100;
	
		
		$this->includedTax=$this->includedTax + (($this->settings['postage']/$taxPercent) * ($taxPercent-100));
		
		$this->includedTax=number_format(round($this->includedTax,2), 2, '.', '');
		$this->postage=number_format(round($this->settings['postage'],2), 2, '.', '');
		
		$this->total=number_format(round($this->total,2), 2, '.', '');
		$this->totalwithoutpostage=number_format(round($this->totalwithoutpostage,2), 2, '.', '');

		if ($this->total==""){$this->total="";}
	
		if ($this->config->getSetting('Currency','Position')=="L")
		{	$this->includedTax=$this->config->getSetting('Currency','Symbol').$this->includedTax;
			$this->postage=$this->config->getSetting('Currency','Symbol').$this->postage;
			
			if ($this->total!="")
			{	$this->total=$this->config->getSetting('Currency','Symbol').$this->total;
				$this->totalwithoutpostage=$this->config->getSetting('Currency','Symbol').$this->totalwithoutpostage;
			}
			
		}
		else
		{	$this->includedTax=$this->includedTax." ".$this->config->getSetting('Currency','Symbol');
			$this->postage=$this->postage." ".$this->config->getSetting('Currency','Symbol');
			if ($this->total!="")
			{	$this->total=$this->total." ".$this->config->getSetting('Currency','Symbol');
				$this->totalwithoutpostage=$this->totalwithoutpostage." ".$this->config->getSetting('Currency','Symbol');
			}
		}
		if (isset($products)) {
			$this->items=$products;
		}
		else {
			$this->items=array();
		}
	
	}

}
?>