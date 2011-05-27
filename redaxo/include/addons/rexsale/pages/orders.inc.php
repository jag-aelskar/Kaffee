<?php
	// order management
	
	
	$func = rex_request('func');
	$fID = rex_request('fID','int');
	
?>

<style type="text/css">
	#rex_153_orders_Bestellung_fORDER
	{	display:block;
		white-space:pre;
		font-family:"Courier New",monospace;
		font-size:12px;
		overflow:auto;
	}
</style>

<?php

//------------------------------> Eintragsliste
if ($func == '')
{
	$list = new rex_list('SELECT fID,fCUSTOMER,fCREATED,fMODIFIED,fSTATUS FROM '.$REX['ADDON']['REXSALE']['TABLE'].'orders ORDER BY fID DESC');

	
	$list->setColumnSortable('fID');
	$list->setColumnSortable('fCUSTOMER');
	$list->setColumnSortable('fCREATED');
	$list->setColumnSortable('fMODIFIED');	
	$list->setColumnSortable('fSTATUS');
	
	
	
	$list->addColumn(	"", 
						'<img src="media/metainfo.gif" alt="field" title="field" />', 
						0, 
						array('<th class="rex-icon">###VALUE###</th>',
								'<td class="rex-icon">###VALUE###</td>')
					);					
	$list->setColumnParams	(	$imgHeader, 
								array('func' => 'edit', 'fID' => '###fID###')
							);
							
	$list->setColumnLabel('fID', "ID");
	$list->setColumnLabel('fCUSTOMER', $I18N_A153_REXSALE->msg('order_customer'));
	$list->setColumnLabel('fCREATED', $I18N_A153_REXSALE->msg('order_created'));
	$list->setColumnLabel('fMODIFIED', $I18N_A153_REXSALE->msg('order_modified'));
	$list->setColumnLabel('fSTATUS', $I18N_A153_REXSALE->msg('order_status'));
	

	
	$list->setColumnLayout	(	'fID',
								array('<th class="rex-icon">###VALUE###</th>','<td class="rex-icon">###VALUE###</td>')
							);
							
					
							
	$list->setColumnLayout	(	'fSTATUS',
								array('<th>###VALUE###</th>','<td>###VALUE###</td>')
							);						
							
	$list->setColumnParams('fCUSTOMER', array('func' => 'edit', 'fID' => '###fID###'));
	$list->show();
}
//------------------------------> Formular
elseif ($func == 'edit' || $func == 'add')
{	$form = new ooRexSaleREXForm($REX['ADDON']['REXSALE']['TABLE'].'orders',$I18N_A153_REXSALE->msg('order'),"fID=".$fID,"post",false);

	$field = &$form->addReadOnlyField('fID');
    $field->setLabel("ID");

	$field = &$form->addReadOnlyField('fCREATED');
	$date=strtotime($field->getValue());
	$field->setValue(date('d.m.Y H:i:s',$date));
 	$field->setLabel($I18N_A153_REXSALE->msg('order_created'));
	
	$field = &$form->addReadOnlyField('fMODIFIED');
	$date=strtotime($field->getValue());
	$field->setValue(date('d.m.Y H:i:s',$date));
	$field->setLabel($I18N_A153_REXSALE->msg('order_modified'));
	
   	
	$field = &$form->addReadOnlyField('fCUSTOMER');
    $field->setLabel($I18N_A153_REXSALE->msg('order_customer'));
	
	$field->setSuffix('<a href="?page=rexsale&subpage=users&func=edit&fID='.$form->sql->getValue('rCUSTOMER').'"><img src="media/user.gif" /></a>');

	//change the modified time
	$field = &$form->addHiddenField('fMODIFIED');
	$date=date('Y-m-d H:i:s');
	$field->setValue($date);
	
	// status
	$field =& $form->addSelectField('fSTATUS');
    $field->setLabel($I18N_A153_REXSALE->msg('order_status'));
   
    $select =& $field->getSelect();
    $select->setSize(1);
    $select->addOption($I18N_A153_REXSALE->msg('OPEN'),'OPEN');
    $select->addOption($I18N_A153_REXSALE->msg('PROCESS'),'PROCESS');
    $select->addOption($I18N_A153_REXSALE->msg('SENT'),'SENT');
    $select->addOption($I18N_A153_REXSALE->msg('CANCELLED'),'CANCELLED');
    $select->addOption($I18N_A153_REXSALE->msg('FRAUDULENT'),'FRAUDULENT');
    
    $select->setAttribute('style','width:200px');
    //standartwert : 1
    if ($field->getValue()=="")
    {	$field->setValue('PROCESS');
    }

	
	$field = &$form->addReadOnlyField('fORDER');
    $field->setLabel($I18N_A153_REXSALE->msg('order_order'));
 	$field->setAttribute('class','pre');
 
 	

	if($func == 'edit')
    {	$form->addParam('fID', $fID);
    }

	$form->show();
	
}

?>