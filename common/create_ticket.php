<?php
include_once './connection.php';
include_once './log_generator.php';

session_start();
$data[]=[
      'subject' =>$_POST['subject'],
      'description'=>$_POST['comments'],
      'created_by'=>$_SESSION['getValidateUser']['idUser'],
      'updated_by' =>$_SESSION['getValidateUser']['idUser']
    ];

$data = json_encode($data);
echo $data;

$sth = $dbh->prepare("SELECT * FROM insert_ticket_support(:data_json::json);");
$sth->bindParam(':data_json', $data,    PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT);

$sth->execute();

    $error = $sth->errorInfo();
    if($error[0]!='00000'){
       log_bd($error[1].$error[2]);
    }else{
        log_bd('transaction successfully');
    }

