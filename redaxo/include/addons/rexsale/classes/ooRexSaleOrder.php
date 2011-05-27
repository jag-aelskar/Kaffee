<?php
class ooRexSaleOrder
{
	# Full functionality of this file is not finished..
	# This file just produces an order number for in ordernumbers.txt.. 
	# Es wird für das Redaxo Backend angepasst in RexSale Alpha 0.2
	
	
	function ooRexSaleOrder()
	{	$this->inserted=false;
	}
	
	function getNewOrderNumber()
	{	return $this->inserted;
	}
	
	
	function insert($text,$user)
	{	global $REX;

		$sql=new rex_sql;
		$sql->setTable($REX['ADDON']['REXSALE']['TABLE'].'orders');
		$sql->setValue('fCUSTOMER',$user[0]['fBILL_FIRST_NAME'].' '.$user[0]['fBILL_LAST_NAME']);	
		$sql->setValue('fORDER',utf8_encode($text));
		$date=date('Y-m-d H:i:s');
		echo $date;
		$sql->setValue('rCUSTOMER',$user[0]['fID']);
		
		$sql->setValue('fCREATED',$date);
		$sql->setValue('fMODIFIED',$date);
		$sql->setValue('fSTATUS','OPEN');
		
		if ($sql->insert())
		{	$this->inserted=$sql->last_insert_id;
			return true;
		}
		else
		{	return false;
		}
	}
	
}
?>