<?php
class ooRexSaleDownload
{
	function ooRexSaleDownload()
	{
	}
	
	
	function registerDownload($downloadID=0,$userID=0) {
		global $REX;
		
		
		$sql = new rex_sql;
		$sql->setQuery('SELECT * FROM '.$REX['TABLE_PREFIX'].'153_downloads WHERE rUSER='.$userID.' && rDOWNLOAD='.$downloadID);		
		if ($sql->getRows()==0) {				
			$sql = new rex_sql;
			$sql->setTable($REX['TABLE_PREFIX'].'153_downloads');
			$sql->setValue('rUSER',$userID);
			$sql->setValue('rDOWNLOAD',$downloadID);
			$sql->setValue('fCOUNT',5);
			$sql->setValue('fSTATUS',0);
			$sql->insert();
		}
		
	}	
	
	
	function enableDownloadsForUser($downloads='',$userID) {
		global $REX;
		if ($downloads!="") {
			$downloads = explode(',',$downloads);
			foreach ($downloads as $download) {
				$usql = new rex_sql;
				$usql->setTable($REX['TABLE_PREFIX'].'153_downloads');
				$usql->setValue('fSTATUS','1');
				$usql->wherevar = ' WHERE rDOWNLOAD = '.intVal($download).' && rUSER='.intVal($userID);
				$usql->update();
				
				echo '<pre>';
				print_r($usql);
				echo '</pre>';	
			}	
			
		}
	}
	
	
}
?>