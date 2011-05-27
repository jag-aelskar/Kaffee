<?php
			# Check if form is filled out
			if (!empty($_POST))
			{	dbprint($_POST);
				$RS['USER'] = new sql;
				$RS['USER']->setQuery('SELECT fEMAIL FROM '.$REX['ADDON']['REXSHOP']['TABLE'].'users');	
				if ($RS['USER']->getRows()>0 && $updateuser!=1)
				{	$module->assign('message',$I18N_A153_REXSHOP->msg('regUserAlreadyExists'));
				}
				else
				{	if ($_POST['mode']=='add')
					{	if ($_POST['reg']['regPassword1']!=$_POST['reg']['regPassword2'])
						{	$errors[]=$I18N_A153_REXSHOP->msg('regPasswordsDontMatch');
						}
						
						if ($_POST['reg']['regPassword1']=="")
						{	$errors[]=$I18N_A153_REXSHOP->msg('regPasswordsEmpty');
						}
					}
					$regex = '/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/';
					if (!preg_match($regex, $_POST['reg']['regEmail']))
					{	$errors[]=$I18N_A153_REXSHOP->msg('regIncorrectEmail');
					}
					
					
					
					if 	(		$_POST['reg']['regBillFirstName'] == ""
							||	$_POST['reg']['regBillLastName'] == ""
							||	$_POST['reg']['regBillStreet'] == ""
							||	$_POST['reg']['regBillTown'] == ""
							||	$_POST['reg']['regBillState'] == ""
							||	$_POST['reg']['regBillPostcode'] == ""
							||	$_POST['reg']['regBillCountry'] == ""
						)
					{	$errors[]=$I18N_A153_REXSHOP->msg('regCheckRequiredFields');
					}
					if (!empty($errors))
					{	$module->assign('errors',$errors);
					}
					else
					{	
						$AS['ADD'] = new sql;
						$AS['ADD']->table=$REX['ADDON']['REXSHOP']['TABLE']."users";
						
						$AS['ADD']->setValue('fEMAIL',$_POST['reg']['regEmail']);
						$AS['ADD']->setValue('fPHONE',$_POST['reg']['regPhone']);
						$AS['ADD']->setValue('fPASSWORD',md5($_POST['reg']['regPassword1']));
						$AS['ADD']->setValue('fPHONE',$_POST['reg']['regPhone']);
						
						$AS['ADD']->setValue('fBILL_FIRST_NAME',$_POST['reg']['regBillFirstName']);
						$AS['ADD']->setValue('fBILL_LAST_NAME',$_POST['reg']['regBillLastName']);
						$AS['ADD']->setValue('fBILL_STREET',$_POST['reg']['regBillStreet']);
						$AS['ADD']->setValue('fBILL_COMPANY',$_POST['reg']['regBillCompany']);
						$AS['ADD']->setValue('fBILL_TOWN',$_POST['reg']['regBillTown']);
						$AS['ADD']->setValue('fBILL_STATE',$_POST['reg']['regBillState']);
						$AS['ADD']->setValue('fBILL_POST',$_POST['reg']['regBillPostcode']);
						$AS['ADD']->setValue('rBILL_COUNTRY',$_POST['reg']['regBillCountry']);
						
						
						$AS['ADD']->setValue('fDEL_FIRST_NAME',$_POST['reg']['regDelFirstName']);
						$AS['ADD']->setValue('fDEL_LAST_NAME',$_POST['reg']['regDelLastName']);
						$AS['ADD']->setValue('fDEL_STREET',$_POST['reg']['regDelStreet']);
						$AS['ADD']->setValue('fDEL_COMPANY',$_POST['reg']['regBillCompany']);
						$AS['ADD']->setValue('fDEL_TOWN',$_POST['reg']['regDelTown']);
						$AS['ADD']->setValue('fDEL_STATE',$_POST['reg']['regDelState']);
						$AS['ADD']->setValue('fDEL_POST',$_POST['reg']['regDelPostcode']);
						$AS['ADD']->setValue('rDEL_COUNTRY',$_POST['reg']['regDelCountry']);
						
						if ($updateuser==1)
						{	$AS['ADD']->update();
						}
						else
						{	$AS['ADD']->insert();
						}
						unset($AS['ADD']);
						$module->assign('stage','frontend-register-success');
					}
				}#eoIF
			}
			
			?>