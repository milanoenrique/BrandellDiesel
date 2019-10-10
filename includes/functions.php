<?php

	function getPDO_DB($SP) {
		
		$dbh = new PDO('pgsql:host=localhost port=5432 dbname=BrandellDiesel user=postgres password=123456');
		$sth = $dbh->prepare($SP);
		$sth->execute();
		$retorno = $sth->fetchAll();
		
		return $retorno;
	}
		
	function getValidateUser($user, $pass, $userType, $status) {
		
		$retorno = getPDO_DB("select * from user_lookup('".$user."','".$pass."','".$userType."','".$status."');");
	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			$returnDB = array
			(
				'fullNameUser' 	=> $row['surname']." ".$row['lastname'],
				'idUser'     	=> $row['iduser']."",
				'name' 			=> $row['name']."",
				'rol' 			=> $row['rol']."",
				'status'		=> 'success'
			);
			
		}
		return $returnDB;
	}
	
	function getlistUser($idusertype, $rol, $status, $phoneNum) {
		
		$retorno = getPDO_DB("SELECT * FROM user_list_msg('".$idusertype."','".$rol."','".$status."','".$phoneNum."');");
	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			if ($row['phonenum'] != null || $row['phonenum'] != '') {
				echo '<option value="+'.$row['phonenum'].'|'.$row['fullname'].'">'.$row['fullname'].' (+'.$row['phonenum'].')</option>';
			}
		}
		//return $returnDB;
	}

	function getEmployeeList($idusertype, $rol, $status, $phoneNum) {
		
		$retorno = getPDO_DB("SELECT * FROM user_list_msg('".$idusertype."','".$rol."','".$status."','".$phoneNum."');");
	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
				echo '<option value="'.$row['fullname'].'">'.$row['fullname'].'</option>';
		}
		//return $returnDB;
	}

    function getGroups($status) {
		$retorno = getPDO_DB("SELECT * FROM groups_lookup('".$status."');");	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			if($row['phone']==''){
				echo '<option value="'.$row['idgroup'].'">'.$row['name'].'</option>';
			}
			

		}

	}

    function getTypeOfViolation() {
		$retorno = getPDO_DB("SELECT * FROM violationtype_lookup();");	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			if ($row['typename']!='Others'){
				echo '<label class="btn type-options"><input class="messageCheckbox" type="checkbox" name="violationType" value="'.$row['typename'].'">&nbsp;&nbsp;&nbsp;'.$row['typename'].'</label>';
			}else{
				echo '<label class="btn type-options"><input class="messageCheckbox" type="checkbox" name="violationType" value="'.$row['typename'].'" id="'.$row['typename'].'">&nbsp;&nbsp;&nbsp;'.$row['typename'].'</label>';
			}
			
		}

	}

?>