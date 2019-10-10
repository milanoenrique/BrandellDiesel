<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
    
    $v              = $_GET['v']; 
    $valor          = explode("|", $v);
    
    $iduser         = $valor[0];
    $surname        = $valor[1];
    $lastname       = $valor[2];
    $password       = $valor[3];
    $idusertype     = $valor[4]; 
    $appuser        = $valor[5]; 
    $idrol          = $valor[6];
    $errorInfo      = null;
    $errorCode      = null;
   
    $sth = $dbh->prepare("SELECT * FROM user_update(:iduser, :surname, :lastname, :password, :idusertype, :appuser, :idrol);");
    
    $sth->bindParam(':iduser',      $iduser,        PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':surname',     $surname,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':lastname',    $lastname,      PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':password',    $password,      PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':idusertype',  $idusertype,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':appuser',     $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':idrol',       $idrol,         PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    
    if (!$sth->execute()) 
    {
        $errorCode = $sth->errorCode();
        $errorInfo = $sth->errorInfo()[2];
        
        $return[] = array
        (
            'RESULTADO'                 => $errorCode, 
            'MENSAJE'                   => $errorInfo
        );
    }
    else
    {
        $return[] = array
        (
            'RESULTADO'                 => "0000", 
            'MENSAJE'                   => "UPDATED"
        );
    }
    
    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }
    
    