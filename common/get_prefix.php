<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    

    
    $sth = $dbh->prepare("select * from get_expenditure_prefix();"); 
    $sth->execute();
    
    $retorno = $sth->fetchAll();
    
    foreach($retorno as $row) 
    {
        $prefix = $row['get_expenditure_prefix'];
    }    
        
    echo json_encode($prefix);