<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
    
    $v              = $_GET['v']; 
    $valor          = explode("|", $v);

    $idgroup         = $valor[0];
    $appuser        = $valor[1];
    
    $sth = $dbh->prepare("SELECT * FROM group_delete(:idgroup, :appuser);");
    
    $sth->bindParam(':idgroup',  $idgroup,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':appuser', $appuser,   PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    
    $sth->execute();
       
    $return[] = array
    (
        'RESULTADO'                 => "0000", 
        'MENSAJE'                   => "DELETED"
    );
    
    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }