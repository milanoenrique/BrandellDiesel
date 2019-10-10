<?php 
    header('Content-Type: text/html; charset=utf-8');
    include_once './connection.php';
    
    $v              = $_GET['v']; 
    $valor          = explode("|", $v);

    $idusertype     = $valor[0];
    $rol            = $valor[1];
    $status         = $valor[2];
    
    $sth = $dbh->prepare("SELECT * FROM user_list(:idusertype, :rol, :status);");
    
    $sth->bindParam(':idusertype',  $idusertype,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':rol',         $rol,           PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->bindParam(':status',      $status,        PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    
    $sth->execute();
    $retorno = $sth->fetchAll();
    
    $users  = array();
       
    foreach($retorno as $row) 
    {
        $users[] = array
        (
            'iduser'    => $row['iduser'],
            'fullname'  => $row['fullname'],
            'rolname'   => $row['rolname'],
            'rol'       => $row['rol'] 
        );
    }
    
    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($users) . ");";	
    }
    else
    {
        echo  json_encode($users);
    }