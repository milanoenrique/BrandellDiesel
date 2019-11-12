<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';


    $v              = $_GET['v'];
    $valor          = explode("|", $v);
    $startdate      = $valor[1];
    $enddate        = $valor[2];
	$keyword      	= $valor[4];

    $sth = $dbh->prepare("SELECT * FROM writeups_lookup(:keyword,:startdate,:enddate);");
    $sth->bindParam(':keyword',   	$keyword, 	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':startdate',   $startdate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':enddate',     $enddate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

	
	$sth->execute();
	$retorno = $sth->fetchAll();
	$dashboardwp  = array();

	foreach($retorno as $row) 
	{

		$trade=str_replace(',', '<br>', $row['violationtype']);

		$dashboardwp[] = array
		(
			'writeupidwriteup'       	=> $row['idwriteup'],
			'writeupemployee'        	=> $row['employee'],			
			'writeupdate'	 	=> $row['writeupdate'],	
			'department'      	=> $row['department'],		
			'writeupsupervisor'   	 	=> $row['supervisor'],        
			'writeuptradelevel'      	=> $row['tradelevel'],
			'writeupdisaction'       	=> $row['disaction'],
			'writeupviolationtype'   	=> $trade,//$row['violationtype'],
			'writeuplastwarn' 	 		=> $row['lastwarn'],
			'writeuppreviouswarn' 		=> $row['previouswarn'],
			'writeupwarnings'		 	=> $row['warnings'],
			'view'          	=> $row['idwriteup'],
			'delete'        	=> $row['idwriteup'],		
		);
	}

	if(isset($_GET["callback"]))
	{	
		echo $_GET["callback"]."(" . json_encode($dashboardwp) . ");";	
	}
	else
	{
		echo  json_encode($dashboardwp);
	}

	