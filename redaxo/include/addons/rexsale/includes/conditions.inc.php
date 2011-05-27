<?php
##################################################
## special pre-Versandkostenset script start ##

	
	
	##############################################
	# 3% Skonto (Vorkasse)
	
	/*
	
	if ($this->settings['paymentMethod']==3)
	{	$discount=(($this->totalwithoutpostage/100)*3);
		
		$ratio=$this->totalwithoutpostage/$this->includedTax;	
		
		$this->totalwithoutpostage=$this->totalwithoutpostage-$discount;
		$this->total=$this->totalwithoutpostage;
		
		# Discount the tax too
		$this->includedTax=$this->totalwithoutpostage/$ratio;
		
		
		unset($scriptmessage);
		$scriptmessage[0]="Vorkasse: 3% Skonto";
		$scriptmessage[1]="&nbsp;";
		$scriptmessage[2]="-".$this->formatPrice($discount);
		$this->settings['scriptmessage'][]=$scriptmessage;	
	}
	
	*/
	##############################################
	





	##############################################
	# Ab 80.0EUR Freiversand
	/*
	if ($this->totalwithoutpostage>79.99)
	{				
		unset($scriptmessage);
		$scriptmessage[0]="Ab 80 EUR - Versand frei";
		$scriptmessage[1]="&nbsp;";
		$scriptmessage[2]="&nbsp;";
		$this->settings['scriptmessage'][]=$scriptmessage;
		
		$this->setFreePostage(1);
	}*/
	##############################################
	
	
	
	
## special pre-versandkostenset script end ##
##################################################
?>