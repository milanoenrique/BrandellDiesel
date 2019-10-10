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
		
		$retorno = getPDO_DB("SELECT * FROM user_list('".$idusertype."','".$rol."','".$status."','".$phoneNum."');");
	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			if ($row['phonenum'] != null || $row['phonenum'] != '') {
				echo '<option value="+'.$row['phonenum'].'|'.$row['fullname'].'">'.$row['fullname'].' (+'.$row['phonenum'].')</option>';
			}
			/*
			$returnDB = array
			(
				'iduser'    => $row['iduser']."",
				'fullname'  => $row['fullname']."",
				'rolname'   => $row['rolname']."",
				'rol'       => $row['rol']."",
				'phonenum' 	=> $row['phonenum']."",
				'status'		=> 'success'
			);
			*/
		}
		//return $returnDB;
	}
?>