<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $v         = $_GET['v'];
    $idgroup  = $v;
    $groups    = array();
    $users    = array();
    
    $sth = $dbh->prepare("SELECT * FROM groups_lookup('A');"); 
    $sth->execute();
    
    $retorno = $sth->fetchAll();
    foreach($retorno as $row) 
    {
        $groups[] = array
        (   'idgroup'  => $row['idgroup'],
            'name'     => $row['name'],
            'phone'    => $row['phone'],
        );
    }    
        
    
    $return["GROUPS"]    = $groups;

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }