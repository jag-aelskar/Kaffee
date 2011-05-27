<?php
$Basedir = dirname(__FILE__);
$field_id = rex_request('field_id', 'int');
$func = rex_request('func');
$fID = rex_request('fID','int');


//------------------------------> Eintragsliste
if ($func == '')
{
	$list = new rex_list('SELECT '.$REX['ADDON']['REXSALE']['TABLE'].'users.fID as fID,fEMAIL,fBILL_FIRST_NAME,fBILL_LAST_NAME,fBILL_TOWN,fNAME as fBILL_COUNTRY FROM '.$REX['ADDON']['REXSALE']['TABLE'].'users LEFT JOIN '.$REX['ADDON']['REXSALE']['TABLE'].'countries ON '.$REX['ADDON']['REXSALE']['TABLE'].'users.rBILL_COUNTRY='.$REX['ADDON']['REXSALE']['TABLE'].'countries.fID');

	
	$imgHeader = '<a href="'. $list->getUrl(array('func' => 'add')) .'"><img src="media/metainfo_plus.gif" alt="add" title="add" /></a>';
	$list->setColumnSortable('fEMAIL');
	$list->setColumnSortable('fBILL_COUNTRY');
	$list->setColumnSortable('fBILL_FIRST_NAME');
	$list->setColumnSortable('fBILL_LAST_NAME');	
	$list->setColumnSortable('fBILL_TOWN');
	
	
	
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
	$list->setColumnLabel('fEMAIL', $I18N_A153_REXSALE->msg('regEmail'));	
	$list->setColumnLabel('fBILL_FIRST_NAME', $I18N_A153_REXSALE->msg('regBillFirstName'));
	$list->setColumnLabel('fBILL_LAST_NAME', $I18N_A153_REXSALE->msg('regBillLastName'));
	$list->setColumnLabel('fBILL_TOWN', $I18N_A153_REXSALE->msg('regBillStreet'));	
	$list->setColumnLabel('fBILL_COUNTRY', $I18N_A153_REXSALE->msg('regBillCountry'));
	
	$list->setColumnLayout	(	'fID',
								array('<th class="rex-icon">###VALUE###</th>','<td class="rex-icon">###VALUE###</td>')
							);
	$list->setColumnParams('fEMAIL', array('func' => 'edit', 'fID' => '###fID###'));
	$list->show();
}
//------------------------------> Formular
elseif ($func == 'edit' || $func == 'add')
{	$form = new ooRexSaleREXForm($REX['ADDON']['REXSALE']['TABLE'].'users',"Benutzerverwaltung","fID=".$fID,"post",false);

	# First Fieldset
	$field = &$form->addTextField('fEMAIL');
    $field->setLabel($I18N_A153_REXSALE->msg('regEmail'));
    $field = &$form->addTextField('fPASSWORD');
    $field->setAttribute('onclick','this.value=\'\'');
    $field->setLabel($I18N_A153_REXSALE->msg('regPassword1'));
    $field = &$form->addTextField('fPHONE');
    $field->setLabel($I18N_A153_REXSALE->msg('regPhone'));



	# Second Fieldset/ Billing Address
    $form->addFieldset($I18N_A153_REXSALE->msg('regBillAddress'));
	$field = &$form->addTextField('fBILL_FIRST_NAME');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillFirstName'));
	$field = &$form->addTextField('fBILL_LAST_NAME');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillLastName'));
	$field = &$form->addTextField('fBILL_COMPANY');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillCompany'));
	$field = &$form->addTextField('fBILL_STREET');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillStreet'));
	$field = &$form->addTextField('fBILL_TOWN');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillTown'));	
	$field = &$form->addTextField('fBILL_STATE');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillState'));	
	$field = &$form->addTextField('fBILL_POST');
    $field->setLabel($I18N_A153_REXSALE->msg('regBillPostcode'));	

	// select box for countries
	$field = &$form->addSelectField('rBILL_COUNTRY');
	$field->setLabel($I18N_A153_REXSALE->msg('regBillCountry'));
	$select =& $field->getSelect();
	$select->setSize(1);
    $qry = 'SELECT fNAME as label,fID as id FROM '.$REX['ADDON']['REXSALE']['TABLE'].'countries ORDER BY fNAME ASC';
   	$select->addSqlOptions($qry);


	# Third Fieldset/ Delivery Address
    $form->addFieldset($I18N_A153_REXSALE->msg('regDelAddress'));
	$field = &$form->addTextField('fDEL_FIRST_NAME');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelFirstName'));
	$field = &$form->addTextField('fDEL_LAST_NAME');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelLastName'));
	$field = &$form->addTextField('fDEL_COMPANY');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelCompany'));
	$field = &$form->addTextField('fDEL_STREET');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelStreet'));
	$field = &$form->addTextField('fDEL_TOWN');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelTown'));	
	$field = &$form->addTextField('fDEL_STATE');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelState'));	
	$field = &$form->addTextField('fDEL_POST');
    $field->setLabel($I18N_A153_REXSALE->msg('regDelPostcode'));	

	// select box for countries
	$field = &$form->addSelectField('rDEL_COUNTRY');
	$field->setLabel($I18N_A153_REXSALE->msg('regDelCountry'));
	$select =& $field->getSelect();
	$select->setSize(1);
    $qry = 'SELECT fNAME as label,fID as id FROM '.$REX['ADDON']['REXSALE']['TABLE'].'countries ORDER BY fNAME ASC';
   	$select->addSqlOptions($qry);

/*
    $notices = '';
    for($i = 1; $i < REX_A62_FIELD_COUNT; $i++)
    {
      if($I18N_META_INFOS->hasMsg('field_params_notice_'. $i))
      {
        $notices .= '<span class="rex-notice" id="a62_field_params_notice_'. $i .'" style="display:none">'. $I18N_META_INFOS->msg('field_params_notice_'. $i) .'</span>'. "\n";
      }
    }
    $notices .= '
    <script type="text/javascript">
      var needle = new getObj("'. $field->getAttribute('id') .'");

      checkConditionalFields(needle.obj, new Array('. REX_A62_FIELD_SELECT .','. REX_A62_FIELD_RADIO .','. REX_A62_FIELD_CHECKBOX .'));
    </script>';
*/


	









    
	#$field = &$form->addTextAreaField('fFIELDS');
	#$field->setLabel("Antworten");
	#$field->setValue("mediafile",$I18N_110->msg('image'),"image",0);
	
	if($func == 'edit')
    {	$form->addParam('fID', $fID);
    }

	$form->show();
	
	

	# Downloads	
	if (rex_request('toggledownload','int')>0) {
		$usql = new rex_sql;
		$usql->setTable($REX['TABLE_PREFIX'].'153_downloads');
		$usql->setValue('fSTATUS',rex_request('status','int'));
		$usql->wherevar = ' WHERE fID = '.rex_request('toggledownload','int');
		$usql->update();
	}
	
	
	if (rex_request('resetdownload','int')>0) {
		$usql = new rex_sql;
		$usql->setTable($REX['TABLE_PREFIX'].'153_downloads');
		$usql->setValue('fCOUNT',5);
		$usql->wherevar = ' WHERE fID = '.rex_request('resetdownload','int');
		$usql->update();
	}
	
	
	
	
	$sql = new rex_sql;
		$query = 'SELECT 
					d.fID as dlID,
					d.rDOWNLOAD,
					d.fCOUNT,
					d.fSTATUS,
					pn.fNAME
					
					
		
					FROM 
					'.$REX['TABLE_PREFIX'].'153_downloads as d
					
					LEFT JOIN 
					'.$REX['TABLE_PREFIX'].'153_products_names as pn
					ON (d.rDOWNLOAD = pn.rPRODID)
					
					WHERE rUSER = '.$fID.'
					
					ORDER BY pn.fNAME ASC
					
						';
		$sql->setQuery($query);
		
		if ($sql->getRows()>0) {
			echo '<h2 style="clear:both;padding-top:30px;margin-bottom:10px;">Downloads</h2>';
			
			echo '<table class="rex-table">';
			echo '<tr>';
			echo '<th><em>Datei</em></th>';
			echo '<th><em>Zugriffe</em></th>';
			echo '<th><em>Status</em></th>';
			echo '</tr>';
			
			
			for ($i=0;$i<$sql->getRows();$i++) {
				echo '<tr>';
				echo '<td>'.$sql->getValue('fNAME').'</td>';
				$resetlink = 'index.php?&page=rexsale&subpage=users&func=edit&fID='.$fID.'&resetdownload='.$sql->getValue('dlID');
				echo '<td>'.$sql->getValue('fCOUNT').'/5 (<a href="'.$resetlink.'">zur&uuml;cksetzen</a>)</td>';
				
				echo '<td>';
				if ($sql->getValue('fSTATUS')==0) {
					$togglelink = 'index.php?&page=rexsale&subpage=users&func=edit&fID='.$fID.'&toggledownload='.$sql->getValue('dlID').'&status=1';
					echo '<a href="'.$togglelink.'">inaktiv</a>';
				} else {
					$togglelink = 'index.php?&page=rexsale&subpage=users&func=edit&fID='.$fID.'&toggledownload='.$sql->getValue('dlID').'&status=0';
					echo '<a href="'.$togglelink.'">aktiv</a>';
				}
				echo '</td>';
				
				echo '</tr>';
				$sql->next();
			}
			
			
			echo '</table>';
		}
	
}

?>
