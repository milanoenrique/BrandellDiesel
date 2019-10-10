<?php

    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    
    $v          = $_GET['v'];
    $valor              = explode("|", $v);

    $idrequest       = $valor[0];
    $appuser         = $valor[1];
        
    $sth = $dbh->prepare("SELECT * FROM request_close(:idrequest, :appuser);");
            
    $sth->bindParam(':idrequest',   $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':appuser',     $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    
    $sth->execute();

    $return[] = array
    (
        'RESULTADO'                 => "0000", 
        'MENSAJE'                   => "CLOSED"
    );

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }