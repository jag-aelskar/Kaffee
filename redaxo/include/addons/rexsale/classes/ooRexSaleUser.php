<?php
class ooRexSaleUser
{
	function ooRexSaleUser()
	{	global $REX;
		$this->user=&$_SESSION['rexsale']['user'];
		$this->lang=new i18n($REX['LANG'],$REX['INCLUDE_PATH']."/addons/rexsale/lang");
		$this->table=$REX['TABLE_PREFIX'].$REX['ADDON']['rxid']['rexsale']."_";	
	}
	
	function setLanguage($clang)
	{	$this->clang=$clang;
	}
	
	function authenticate()
	{	if ($this->user['id']!="")
		{	if ($this->user['ip']==$_SERVER['REMOTE_ADDR'])	
			{	return 'yes';
			}
			else
			{	return 'sessionerror';
			}
		}
	}
	
	function login($userID)
	{	$this->user="";
		$this->user['ip']=$_SERVER['REMOTE_ADDR'];
		$this->user['id']=$userID;
		
	}
	
	function logout()
	{	$this->user="";
		unset($_SESSION['rexsale']['cart']);
		unset($_SESSION['rexsale']['settings']);
	}
	
	
	function getValue($val)
	{	return $this->user[$val];
	}

	function getUserCountry($cid)
	{	$RS['COUNTRY'] = new sql;
		$RS['COUNTRY']->setQuery('SELECT * FROM '.$this->table.'countries WHERE (fID="'.$cid.'")');
		
		return $RS['COUNTRY']->getValue('fNAME');
	}
	
	function getUserData($id)
	{	$RS['USER'] = new sql;
		$RS['USER']->setQuery('SELECT * FROM '.$this->table.'users WHERE (fID="'.$id.'")');
		
		$this->userdata=$RS['USER']->get_array();
				
		return $this->userdata;
	}
	
	
	function getUserNameById($id)
	{	$RS['USER'] = new sql;
		$RS['USER']->setQuery('SELECT fEMAIL FROM '.$this->table.'users WHERE (fEMAIL="'.$id.'")');
		return $RS['USER']->getValue('fEMAIL');
	}
	
	
	function updateUser($data,$mode='add')
	{	
		if ($mode=='add' && $data['regEmail']!="")
		{
			$RS['USER'] = new sql;
			$RS['USER']->setQuery('SELECT fEMAIL FROM '.$this->table.'users WHERE (fEMAIL="'.$data['regEmail'].'")');
			
			if ($RS['USER']->getRows()>0)
			{
				$this->userexists=1;
				return false;
			}
		}
		
			if ($mode=="add")
			{	
				if ($data['regPassword1']!=$data['regPassword2'])
				{	$this->errors[]=$this->lang->msg('regPasswordsDontMatch');
				}
				
				if ($data['regPassword1']=="")
				{	$this->errors[]=$this->lang->msg('regPasswordsEmpty');
				}
				
				$regex = '/^[A-z0-9][\w.-]*@[A-z0-9][\w\-\.]+\.[A-z0-9]{2,6}$/';
				if (!preg_match($regex, $data['regEmail']))
				{	$this->errors[]=$this->lang->msg('regIncorrectEmail');
				}
			}
			if 	(		$data['regBillFirstName'] == ""
					||	$data['regPhone'] == ""
					||	$data['regBillLastName'] == ""
					||	$data['regBillStreet'] == ""
					||	$data['regBillTown'] == ""
					||	$data['regBillPostcode'] == ""
					||	$data['regBillCountry'] == "0"
				)
			{	$this->errors[]=$this->lang->msg('regCheckRequiredFields');
			}
			if (!empty($this->errors))
			{	
				return false;
			}
			else
			{	//changes in rex4.1 send "" values as NULL
				if (!isset($data['regEmail'])) 	{ $data['regEmail']="" ;}
				if (!isset($data['regPhone'])) 	{ $data['regPhone']="" ;}
				if (!isset($data['regPassword1'])) 	{ $data['regPassword1']="" ;}
				
				if (!isset($data['regBillFirstName'])) 	{ $data['regBillFirstName']="" ;}
				if (!isset($data['regBillLastName'])) 	{ $data['regBillLastName']="" ;}
				if (!isset($data['regBillStreet'])) 	{ $data['regBillStreet']="" ;}
				if (!isset($data['regBillCompany'])) 	{ $data['regBillCompany']="" ;}
				if (!isset($data['regBillTown'])) 	{ $data['regBillTown']="" ;}
				if (!isset($data['regBillState'])) 	{ $data['regBillState']="" ;}
				if (!isset($data['regBillPostcode'])) 	{ $data['regBillPostcode']="" ;}
				if (!isset($data['regBillCountry'])) 	{ $data['regBillCountry']="" ;}
				
				if (!isset($data['regDelFirstName'])) 	{ $data['regDelFirstName']="" ;}
				if (!isset($data['regDelLastName'])) 	{ $data['regDelLastName']="" ;}
				if (!isset($data['regDelStreet'])) 	{ $data['regDelStreet']="" ;}
				if (!isset($data['regDelCompany'])) 	{ $data['regDelCompany']="" ;}
				if (!isset($data['regDelTown'])) 	{ $data['regDelTown']="" ;}
				if (!isset($data['regDelState'])) 	{ $data['regDelState']="" ;}
				if (!isset($data['regDelPostcode'])) 	{ $data['regDelPostcode']="" ;}
				if (!isset($data['regDelCountry'])) 	{ $data['regDelCountry']="" ;}


			
			
			
				$AS['ADD'] = new sql;
				$AS['ADD']->table=$this->table."users";
				
				if ($mode=='add')
				{	$AS['ADD']->setValue('fEMAIL',$data['regEmail']);
				}					
				
				$AS['ADD']->setValue('fPHONE',$data['regPhone']);
				
				if ($mode=='add')
				{	$AS['ADD']->setValue('fPASSWORD',md5($data['regPassword1']));
				}
				
				$AS['ADD']->setValue('fPHONE',$data['regPhone']);
				
				$AS['ADD']->setValue('fBILL_FIRST_NAME',$data['regBillFirstName']);
				$AS['ADD']->setValue('fBILL_LAST_NAME',$data['regBillLastName']);
				$AS['ADD']->setValue('fBILL_STREET',$data['regBillStreet']);
				$AS['ADD']->setValue('fBILL_COMPANY',$data['regBillCompany']);
				$AS['ADD']->setValue('fBILL_TOWN',$data['regBillTown']);
				$AS['ADD']->setValue('fBILL_STATE',$data['regBillState']);
				$AS['ADD']->setValue('fBILL_POST',$data['regBillPostcode']);
				$AS['ADD']->setValue('rBILL_COUNTRY',$data['regBillCountry']);
				
				
				$AS['ADD']->setValue('fDEL_FIRST_NAME',$data['regDelFirstName']);
				$AS['ADD']->setValue('fDEL_LAST_NAME',$data['regDelLastName']);
				$AS['ADD']->setValue('fDEL_STREET',$data['regDelStreet']);
				$AS['ADD']->setValue('fDEL_COMPANY',$data['regDelCompany']);
				$AS['ADD']->setValue('fDEL_TOWN',$data['regDelTown']);
				$AS['ADD']->setValue('fDEL_STATE',$data['regDelState']);
				$AS['ADD']->setValue('fDEL_POST',$data['regDelPostcode']);
				$AS['ADD']->setValue('rDEL_COUNTRY',$data['regDelCountry']);
				
				dbprint($AS);
				
				if ($mode=='update')
				{	$AS['ADD']->wherevar=' WHERE (fEMAIL="'.$data['regEmail'].'")';
					$AS['ADD']->update();
				}
				else
				{	$AS['ADD']->insert();
					$this->last_inserted_id=$AS['ADD']->last_insert_id;
				}
				
				dbprint($AS);
				
				unset($AS['ADD']);
				return true;
			}
		
		
	}
}
?>