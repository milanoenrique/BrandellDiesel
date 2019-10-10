<?php 
    header('Content-Type: text/html; charset=utf-8');
    
    include_once './connection.php';
    $v         = $_GET['v'];
    $sth = $dbh->prepare("SELECT * FROM log_status_part(:inidpart)"); 
    $sth->bindParam(':inidpart',$v,       PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
    $sth->execute();
    $retorno = $sth->fetchAll();
    foreach($retorno as $row) 
    {
        $detail[] = array
        (   'status_old'  => $row['status_old'],
            'status_new'     => $row['status_new'],
            'creation_date'    => $row['creation_date'],
            'comment'       => $row['comment'],
            'appuser'      =>$row['appuser']

        );
    }    
        
    
    $return["DETAILS"]    = $detail;

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }
?>