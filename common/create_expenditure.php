<?php
include_once 'log_generator.php';
include_once './connection.php';

$new_expenditure = json_encode([$_POST['new_expenditure']]);
$sth = $dbh->prepare("SELECT * FROM insert_expenditure(:inexpenditure::json);");
$sth->bindParam(':inexpenditure',      $new_expenditure,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);
$sth->execute();

$error = $sth->errorInfo();
if($error[0]!='00000'){
    log_bd($error[1].$error[2]);
 }else{
     log_bd('transaction successfully registration expenditure complete');
 }
 $result= $sth->fetchall();
 foreach ($result as $row) {
     $id = $row['insert_expenditure'];
 }
 $return[] = array
 (
     'RESULTADO'                 => "00000", 
     'MENSAJE'                   => "REGISTER COMPLETE",
     'id'                        => $id
 );
 $return2[] = array
 (
     'RESULTADO'                 => $error[1], 
     'MENSAJE'                   => "FAIL"
 );

 if( $error[0]==='00000')
 {	
     echo json_encode($return);	
 }
 else
 {
      echo  json_encode($return2);  
 }

 