<?php
    header('Content-Type: text/html; charset=utf-8');    
    include_once './connection.php';
    
    $v              = $_GET['v'];
    $valor          = explode("|", $v);
    $iduser         = $valor[0];
    $startdate      = $valor[1];
    $enddate        = $valor[2];
    $jobnumber      = $valor[3];
	$keyword      	= $valor[4];
		
	if ($startdate == '' && $enddate == '' && $jobnumber == '' && $keyword == '')
	{
		$sth = $dbh->prepare("SELECT * FROM dashboard_lookup_print(:iduser);"); 
		$sth->bindParam(':iduser',      $iduser,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
	}		
	else
	{
		$sth = $dbh->prepare("SELECT * FROM dashboard_lookup_print(:iduser,:startdate,:enddate,:jobnumber,:keyword);"); 
		$sth->bindParam(':iduser',      $iduser,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':startdate',   $startdate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':enddate',     $enddate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':jobnumber',   $jobnumber, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
		$sth->bindParam(':keyword',   	$keyword, 	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    };
		
    $sth->execute();
    $retorno = $sth->fetchAll();
    $dashboard  = array();

    foreach($retorno as $row) 
    {
        $dashboard[] = array
        (
            'jobnumber'     => $row['jobnumber'],			
			'techname'    	=> $row['techname'],
            'assignedto'    => $row['assignedto'],
            'requestdate'   => $row['requestdate'], 
			'closedate'   	=> $row['closedate'],
			'atention_time_min' => $row['atention_time_min'],
			'requesttype' 	=> $row['requesttype'], 
            'status'        => $row['status'], 
            'engine'      	=> $row['engine'],
            'vin'  			=> $row['vin'],
            'trans'         => $row['trans'],
			'reqcomment'	=> $row['reqcomment'],
			'idrequest'     => $row['idrequest']
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