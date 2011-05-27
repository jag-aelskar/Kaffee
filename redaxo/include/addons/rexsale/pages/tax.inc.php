<?php
$Basedir = dirname(__FILE__);
$field_id = rex_request('field_id', 'int');


//------------------------------> Eintragsliste
if ($func == '')
{
	$list = new rex_list('SELECT * from '.$REX['ADDON']['REXSALE']['TABLE'].'tax');

	
	$imgHeader = '<a href="'. $list->getUrl(array('func' => 'add')) .'"><img src="media/metainfo_plus.gif" alt="add" title="add" /></a>';
	$list->setColumnSortable('fNAME');
	$list->setColumnSortable('fAMOUNT');
	
	$list->addColumn(	$imgHeader, 
						'<img src="media/metainfo.gif" alt="field" title="field" />', 
						0, 
						array('<th class="rex-icon">###VALUE###</th>',
								'<td class="rex-icon">###VALUE###</td>')
					);					
	$list->setColumnParams	(	$imgHeader, 
								array('func' => 'edit', 'fID' => '###fID###')
							);
							
	$list->setColumnLabel('fID', "ID");
	$list->setColumnLabel('fNAME', $I18N_A153_REXSALE->msg('taxlabel'));	
	$list->setColumnLabel('fAMOUNT', $I18N_A153_REXSALE->msg('taxvalue'));
	
	$list->setColumnLayout	(	'fID',
								array('<th class="rex-icon">###VALUE###</th>','<td class="rex-icon">###VALUE###</td>')
							);
	$list->setColumnParams('fNAME', array('func' => 'edit', 'fID' => '###fID###'));
	$list->show();
}
//------------------------------> Formular
elseif ($func == 'edit' || $func == 'add')
{	$form = new rex_form($REX['ADDON']['REXSALE']['TABLE'].'tax', $I18N_A153_REXSALE->msg('tax'),"fID=".$fID,"post",false);

	# First Fieldset
	$field = &$form->addTextField('fNAME');
    $field->setLabel($I18N_A153_REXSALE->msg('taxlabel'));
    
    $field = &$form->addTextField('fAMOUNT');
    $field->setLabel($I18N_A153_REXSALE->msg('taxvalue'));


	
	if($func == 'edit')
    {	$form->addParam('fID', $fID);
    }

	$form->show();
	
}

?>