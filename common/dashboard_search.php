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

    $sth = $dbh->prepare("SELECT * FROM dashboard_lookup_search(:iduser,:startdate,:enddate,:jobnumber,:keyword);"); 
    $sth->bindParam(':iduser',      $iduser,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':startdate',   $startdate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':enddate',     $enddate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':jobnumber',   $jobnumber, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
	$sth->bindParam(':keyword',   	$keyword, 	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    
    $sth->execute();
    $retorno = $sth->fetchAll();
    $dashboard  = array();

    foreach($retorno as $row) 
    {
        $dashboard[] = array
        (
            'idrequest'     => $row['idrequest'],
            'assignedto'    => $row['assignedto'],
            'colorflag'     => $row['colorflag'],
            'deadline'      => $row['deadline'], 
            'jobnumber'     => $row['jobnumber'],
			'idrequesttype' => $row['idrequesttype'], 
            'idpriority'    => $row['idpriority'], 
            'status'        => $row['status'], 
            'techname'      => $row['techname'],
            'visualeffect'  => $row['visualeffect'],
            'assign'        => $row['jobnumber'],
            'view'          => $row['jobnumber']."|".$row['reqcomment'],
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