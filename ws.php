<?php 
	$vPath = "";
	include "$vPath"."pdodb.php";
			
	$retorno = getPDO_DB("SELECT * FROM dashboard_lookup('')");
	
	$dashboard  = array();
	foreach($retorno as $row) 
	{
		$dashboard[] = array
		(
			'assignedto'    => $row['assignedto'],
			'colorflag'     => $row['colorflag'],
			'deadline'      => $row['deadline'], 
			'jobnumber'     => $row['jobnumber'], 
			'status'        => $row['status'], 
			'techname'      => $row['techname'],
			'visualeffect'  => $row['visualeffect'],
			'assign'        => $row['jobnumber'],
			'view'          => $row['jobnumber'],
			'edit'          => $row['jobnumber'],
			'delete'        => $row['jobnumber'],
			'update'        => $row['jobnumber']
			
		);
	}

	if(isset($_GET["callback"]))
	{	
		echo $_GET["callback"]."(" . json_encode($dashboard) . ");";	
	}
	else
	{
		echo  json_encode($dashboard);
	}

?>