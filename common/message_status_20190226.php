<?php 
header('Content-Type: text/html; charset=utf-8');
use Twilio\TwiML\MessagingResponse;
use Twilio\Rest\Client;
require_once "../vendor/autoload.php";
require_once './connection.php';
require_once 'log_generator.php';

function parts_message($group, $user_name, $part){
 $dbh = new PDO('pgsql:host=localhost port=5432 dbname=BrandellDiesel user=postgres password=123456');

$AccountSid = "ACac1d6fac54a042941ce50bf650250b01";//"AC858556eeb30f04e1bc89bfb4f58c843f";
$AuthToken = "f8e99c8c3d88e6313c4d0fe0e241b0da";//"fdf0a7fbd7ad4faed96d28efc89ceba7";
$client = new Client($AccountSid, $AuthToken);


	 $sql = "select parts.seg, parts.comment_parts, parts.date_of_delivery, parts.status_order, requests.ro from parts, requests where part = '".$part."' and parts.idrequest = requests.idrequest";
	 $sth = $dbh->prepare($sql);
	 $sth->execute();
	 $details = $sth->fetchAll();
	 

	 foreach ($details as $row) {
	 	
	 	
	 	$body ="RO: ".$row['ro']. "- SEG: ".$row['seg']." - ".$row['comment_parts']." - Est. Delivery: ".$row['date_of_delivery']." - Status: ".$row['status_order'];

	 }

	 	$sql ="select users.phonenum 
            from groups, userxgroup, users 
            where groups.name = '".$group."' and userxgroup.idgroup = groups.idgroup and users.iduser = userxgroup.iduser";
            

     $sth = $dbh->prepare($sql);
	 $sth->execute();

	 $phonenum = $sth->fetchAll();
	 //echo "<br>".$body;
	 foreach ($phonenum as $row) {
	 	 log_message('+13347314677',$row['phonenum'],$body);
                $sms = $client->account->messages->create( 
                    "+".$row['phonenum'],
                    array(
                        'From' =>'+13347314677',
                        'body' => $user_name. " says: ".$body
                    )
                    );
                
	 }
}
?>