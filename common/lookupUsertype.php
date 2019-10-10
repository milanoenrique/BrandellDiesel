<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
        
    $sth = $dbh->prepare("SELECT * FROM usertype_lookup();");
    
    $sth->execute();
    $retorno = $sth->fetchAll();
    
    $userTypes  = array();
       
    foreach($retorno as $row) 
    {
        $userTypes[] = array
        (
            'idusertype'    => $row['idusertype'],
            'typename'      => $row['typename']
        );
    }
    
    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($userTypes) . ");";	
    }
    else
    {
        echo  json_encode($userTypes);
    }