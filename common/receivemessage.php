
<?php
header('Content-Type: text/html; charset=utf-8');
require_once "../vendor/autoload.php";
include_once './connection.php';
include_once 'log_generator.php';
use Twilio\TwiML\MessagingResponse;
use Twilio\Rest\Client;
$AccountSid = "AC858556eeb30f04e1bc89bfb4f58c843f";
$AuthToken = "fdf0a7fbd7ad4faed96d28efc89ceba7";
$client = new Client($AccountSid, $AuthToken); //Create client for send message


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

            

$media = (int)$_REQUEST['NumMedia'];


    if ($media>0){
    		

    	for ($i = 0; $i < $_REQUEST['NumMedia']; $i++) {
                $x[]= $_REQUEST['MediaUrl'.$i]; 
	
		} 
		foreach ($retorno as $key => $value) {
		log_message($from,$retorno[$key]['phonenum'],$body);
			$client->account->messages->create( 
        		$retorno[$key]['phonenum'],
        		array(
            		'from' => $_REQUEST['To'], 

            		'body' => $name. " says: ".$body,
            		'mediaUrl'=> $x
        		)
        	);
        	log_message($from,$retorno[$key]['phonenum'],'Message sent');

			
		}
    	
}
if ($media==0){
    foreach ($retorno as $key => $value) 
    {
				log_message($from,$retorno[$key]['phonenum'],$body);
                $sms = $client->account->messages->create( 
                    "+".$retorno[$key]['phonenum'],
                    array(
                        'from' => $_REQUEST['To'], //+15873175836
                        'body' => $name. " says: ".$body
                    )
                    );
				log_message($from,$retorno[$key]['phonenum'],'Message sent');
    }

}

// Message Acknowlege response
/*$response = new MessagingResponse();
$response->message("Your message was sent successfully!");
echo $response;
log_message($to,$from,'Your message was sent successfully');*/

?>