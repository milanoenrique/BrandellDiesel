<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
    
    $v              = $_GET['v']; 
    $iduser         = $v;
    
    $sth = $dbh->prepare("SELECT * FROM dashboard_totals(:iduser);");
    $sth->bindParam(':iduser',       $iduser,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    $retorno = $sth->fetchAll();
    
    $totals  = array();
       
    foreach($retorno as $row) 
    {
        $totals[] = array
        (
            'colorflag'     => $row['colorflag'],
            'quantity'      => $row['quantity']
        );
    }
    
    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($totals) . ");";	
    }
    else
    {
        echo  json_encode($totals);
    }