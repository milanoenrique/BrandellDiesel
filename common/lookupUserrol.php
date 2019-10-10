<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
        
    $sth = $dbh->prepare("SELECT * FROM userrol_lookup();");
    
    $sth->execute();
    $retorno = $sth->fetchAll();
    
    $userRoles  = array();

    foreach($retorno as $row) 
    {
        $userRoles[] = array
        (
            'idrol' => $row['idrol'],
            'name'  => $row['name']
        );
    }

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($userRoles) . ");";	
    }
    else
    {
        echo  json_encode($userRoles);
    }