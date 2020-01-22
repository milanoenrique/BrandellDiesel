<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';

    $v              = $_GET['v'];
    $valor          = explode("|", $v);
    $startdate      = $valor[1];
    $enddate        = $valor[2];
    $keyword      	= $valor[4];
    

    
    $sth = $dbh->prepare("SELECT * FROM search_expenditure(:startdate,:enddate, :keyword);");
    $sth->bindParam(':keyword',   	$keyword, 	PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':startdate',   $startdate, PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':enddate',     $enddate,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

    $sth->execute();
	$retorno = $sth->fetchAll();
    $expenditure  = [];

    foreach ($retorno as $row) {
        $expenditure[] = array
        (
            'id'                     => $row['id'],
            'project_name'           => $row['project_name'],
            'starting_date'          => $row['starting_date'],
            'amount'                 => $row['amount'],
            'requested'  => $row['requested'],
            'requested_date' => $row['requested_date'],
            'approved_date'   => $row['approved_date']
        );
    }

    echo json_encode($expenditure);
