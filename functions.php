<?php 
	$vPath = "";
	include "$vPath"."pdodb.php";
			
	$retorno = getPDO_DB("select * from user_lookup('ptech2','123456','A','A');");
	
	//function getSP($retorno) {
	
		$returnDB  = array();
		foreach($retorno as $row) 
		{
			$returnDB[] = array
			(
				'iduser'    => $row['iduser'],
				'surname'	=> $row['surname'],
				'lastname'	=> $row['lastname'], 
				'name'		=> $row['name']		
			);
		}
		//return $returnDB;
		//$_SESSION['perfil'] = '_managerg';
		echo "returnDB[iduser]";
		echo "returnDB[iduser]";
		echo "returnDB[iduser]";

		
	//}

?>