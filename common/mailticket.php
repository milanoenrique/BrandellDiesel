<?php
session_start();
require_once "../PHPMailer/vendor/autoload.php";
include_once './configMail.php';

$mail=new PHPMailer;
$eMail = $mail;
$mail->SMTPDebug = 0;                               
$mail->isSMTP();                                   
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;                           
$mail->Username = $from;                 
$mail->Password = $pass;                           
$mail->SMTPSecure = "tls";                           
$mail->Port = 587;
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);  

$mail->addAddress($recipient_ticket); 
$mail->addAddress('enrique@tecbound.com');
$mail->setFrom($from, $user = $_SESSION['getValidateUser']['idUser']);

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = $_POST['subject'];
$mail->Body    = $_POST['comments'];


$mail->send();