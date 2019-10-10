<?php
header('Content-Type: text/html; charset=utf-8');
require_once "../vendor/autoload.php";
include_once './connection.php';
include_once 'log_generator.php';
use Twilio\TwiML\MessagingResponse;
use Twilio\Rest\Client;
$AccountSid = "ACac1d6fac54a042941ce50bf650250b01";
$AuthToken = "f8e99c8c3d88e6313c4d0fe0e241b0da";
$client = new Client($AccountSid, $AuthToken); //Create client for send message
$media = $client->messages('MMa6e4120df18c22a4e700f58060f6c0a8')
                ->media
                ->read();

foreach ($media as $record) {
    $x[] ='https://api.twilio.com/2010-04-01/Accounts/'.$AccountSid.'/Messages/'.$_REQUEST["SmsMessageSid"].'/Media/'.$record->sid;
}

$body = $_REQUEST['Body'];
$to= $_REQUEST['To'];

$from= $_REQUEST['From'];
$to=str_replace("+",'',$to);
$to=trim($to);
$from=str_replace("+",'',$from);
$from = trim($from);

log_message($from,$to,'Log Star');

$sql = "select users.phonenum 
            from groups, userxgroup, users 
            where groups.phone = '".$to."' and userxgroup.idgroup = groups.idgroup and users.iduser = userxgroup.iduser and groups.phone <> '".$from."' and users.phonenum <> '".$from."'";
$sth = $dbh->prepare($sql);
$sth->execute();

$sql2 = "select name(surname ||' '|| lastname) from users where phonenum = '".$from."'";
$sth2= $dbh->prepare($sql2);
$sth2->execute();
$nombres = $sth2->fetchAll();
$name='';
foreach ($nombres as $key => $value){
    $name = $nombres[$key]['name'];


}


$retorno = $sth->fetchAll();
            //var_dump($retorno);

            foreach ($retorno as $key => $value) {
		log_message($from,$retorno[$key]['phonenum'],$body);
                $sms = $client->account->messages->create( 
                    "+".$retorno[$key]['phonenum'],
                    array(
                        'from' => $_REQUEST['To'], //+15873175836
                        'body' => $name. " says: ".$body,
			            'mediaUrl'=> $x
                    )
                    );
		log_message($from,$retorno[$key]['phonenum'],'Message sent');
            }

// Message Acknowlege response
/*$response = new MessagingResponse();
$response->message("Your message was sent successfully!");
echo $response;
log_message($to,$from,'Your message was sent successfully');*/