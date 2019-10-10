<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
    
    $v              = $_GET['v']; 
    $valor          = explode("|", $v);
    
    $idgroup        = $valor[0]; 
    $name           = $valor[1];
    $appuser        = $valor[2]; 
    $inphone        = $valor[3];
    $errorInfo      = null;
    $errorCode      = null;
    $sth = $dbh->prepare("SELECT * FROM group_edit(:idgroup, :name, :appuser, :inphone);");
    
    $sth->bindParam(':idgroup',     $idgroup,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':name',        $name,          PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':appuser',     $appuser,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':inphone',     $inphone,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    if (!$sth->execute()) 
    {
        //$errorCode = $sth->errorCode();
        //$errorInfo = $sth->errorInfo()[2];
        
        $return[] = array
        (
            'RESULTADO'                 => "1111", //$errorCode, 
            'MENSAJE'                   => "FAILD" //$errorInfo
        );
    }
    else
    {
        $return[] = array
        (
            'RESULTADO'                 => "0000", 
            'MENSAJE'                   => "INSERTED"
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
    
    