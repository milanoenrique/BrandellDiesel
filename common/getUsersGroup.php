<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $v         = $_GET['v'];
    $idgroup  = $v;
    $group    = array();
    $users    = array();
    
    $sth = $dbh->prepare("SELECT * FROM userxgroups_lookup(:idgroup);"); 
    $sth->bindParam(':idgroup',  $idgroup,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    
    $retorno = $sth->fetchAll();
    foreach($retorno as $row) 
    {
        $users[] = array
        (
            'fullname'     => $row['fullname']
        );
    }    
        
    
    $return["USERS"]    = $users;

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }