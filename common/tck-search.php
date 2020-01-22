<?php
session_start();
include_once './connection.php';

$v              = $_GET['v'];
$valor          = explode("|", $v);
$startdate      = $valor[1];
$enddate        = $valor[2];
$keyword      	= $valor[4];

    $sth=$dbh->prepare("SELECT * from search_ticket(:startdate,:enddate, :keyword);");
    $sth->bindParam(':keyword',   	$keyword, 	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':startdate',   $startdate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':enddate',     $enddate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

	$sth->execute();
	$retorno = $sth->fetchAll();
    $dashboard=[];
    
	foreach ($retorno  as $row) {
		$dashboard[] = array
        (
            'created_by'             =>$row['created_by'],
            'id'                     => $row['id'],
            'created_at'                   => $row['created_at'],
            'subject'                => $row['subject'],
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