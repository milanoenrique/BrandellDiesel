<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $v          = $_GET['v'];
    $idrequest  = $v;
    $request    = array();
    $parts      = array();
    
    $sth = $dbh->prepare("SELECT * FROM request_parts_lookup(:idrequest);"); 
    $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    
    $retorno = $sth->fetchAll();
    
    foreach($retorno as $row) 
    {
        $parts[] = array
        (
            'idrequest'     => $row['idrequest'], 
            'seg'           => $row['seg'], 
            'part'          => $row['part'], 
            'description'   => $row['description'], 
            'quantity'      => $row['quantity'], 
            'ord'           => $row['ord'],
            'edit'          => $row['idrequest']."|".$row['part'], 
            'delete'        => $row['idrequest']."|".$row['part'],
            'date_of_delivery' => $row['date_of_delivery'],
            'comment_parts' => $row['comments_parts']
        );
    }
    
    
    
    
    
    
    $sth = $dbh->prepare("SELECT * FROM request_lookup(:idrequest);"); 
    $sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    
    $retorno = $sth->fetchAll();
    foreach($retorno as $row) 
    {
        $request[] = array
        (
            'idrequest'     => $row['idrequest'], 
            'jobnumber'     => $row['jobnumber'], 
            'techname'      => $row['techname'], 
            'requestdate'   => $row['requestdate'], 
            'assignedto'    => $row['assignedto'], 
            'ro'            => $row['ro'], 
            'vin'           => $row['vin'], 
            'trans'         => $row['trans'],
            'engine'        => $row['engine'], 
            'reqcomment'    => $row['reqcomment'],
            'idrequesttype' => $row['idrequesttype'],
            'idpriority'    => $row['idpriority']
        );
    }
    
    $return["REQUESTS"] = $request;
    $return["PARTS"]    = $parts;

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }