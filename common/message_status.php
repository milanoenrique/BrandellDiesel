<?php 
header('Content-Type: text/html; charset=utf-8');
use Twilio\TwiML\MessagingResponse;
use Twilio\Rest\Client;
require_once "../vendor/autoload.php";
require_once './connection.php';
require_once 'log_generator.php';

function parts_message($group, $user_name, $part){
	$body = '';
 $dbh = new PDO('pgsql:host=localhost port=5432 dbname=BrandellDiesel user=postgres password=123456');

$AccountSid = "AC858556eeb30f04e1bc89bfb4f58c843f";
$AuthToken = "fdf0a7fbd7ad4faed96d28efc89ceba7";
$client = new Client($AccountSid, $AuthToken);


	 $sql = "select parts.seg, parts.comment_parts, parts.date_of_delivery, parts.status_order, requests.ro from parts, requests where part = '".$part."' and parts.idrequest = requests.idrequest";
	 $sth = $dbh->prepare($sql);
	 $sth->execute();
	 $details = $sth->fetchAll();
	 

	 foreach ($details as $row) {
	 	$status = '';
	 	if($row['status_order']=='canceled'||$row['status_order']=='received' || $row['status_order']=='quote'){
	 		$body ="RO: ".$row['ro']. "- SEG: ".$row['seg']." - ".$row['comment_parts']." - Status: ".$row['status_order'];	
	 	}else{
	 		if($row['status_order']=='1'){
	 			$status = "N/A";
	 		}else{
	 			$status =$row['status_order'];
	 		}
	 		$body ="RO: ".$row['ro']. "- SEG: ".$row['seg']." - ".$row['comment_parts']." - Est. Delivery: ".$row['date_of_delivery']." - Status: ".$status;	
	 	}
	 	
	 	

	 }

	 	$sql ="select users.phonenum 
            from groups, userxgroup, users 
            where groups.name = '".$group."' and userxgroup.idgroup = groups.idgroup and users.iduser = userxgroup.iduser";
            

     $sth = $dbh->prepare($sql);
	 $sth->execute();

	 $phonenum = $sth->fetchAll();
	 //echo "<br>".$body;
	 foreach ($phonenum as $row) {
	 	  if ($body!=''){
	 	 		log_message('+15873184641',$row['phonenum'],$body);
	 	 	 	  try {
		         $sms = $client->account->messages->create( 
                    "+".$row['phonenum'],
                    array(
                        'From' =>'+15873184641',
                        'body' => $user_name. " says: ".$body
                    )
                    );
		    } catch (Exception $e) {
		        log_message('+13347314677',$row['phonenum'],$e->getMessage());
		    }

	 	 }
                
	 }
}
?>