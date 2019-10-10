<?php
header('Content-Type: text/html; charset=utf-8');
include_once './connection.php';
$v          = $_GET['v'];
$idrequest  = $v;
$requests      = array();
$sth = $dbh->prepare("select * from request_log(:idrequest);"); 
$sth->bindParam(':idrequest',       $idrequest,     PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT);
$sth->execute();
$retorno = $sth->fetchAll();
    
foreach($retorno as $row) 
{
    $requests[] = array
    (
        'idrequest'     => $row['idrequest'], 
        'reqstatusold'  => $row['reqstatusold'], 
        'reqstatusnew'  => $row['reqstatusnew'], 
        'comment'       => $row['comment'], 
        'creation_date' => $row['creation_date'], 
        'appuser'           => $row['appuser'],
        'ro'            => $row['ro']
 
    );
}
$return["REQUESTS"] = $requests;

    if(isset($_GET["callback"]))
    {	
        echo $_GET["callback"]."(" . json_encode($return) . ");";	
    }
    else
    {
        echo  json_encode($return);
    }
 ?>