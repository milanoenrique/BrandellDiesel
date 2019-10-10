<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once "../vendor/autoload.php";
    use Twilio\Rest\Client;
	
	$v 				= $_GET['v'];
    $valor 			= explode("|", $v);

    $phoneNumber	= $valor[0];
    $NameTech    	= $valor[1];
    $Comment		= $valor[2];
    
    $AccountSid = "AC82f4d0f19f246bf08bd34985d1e5a900";
    $AuthToken = "89939b8dcbce7d337ec3a9a580e0e9ee";

    $client = new Client($AccountSid, $AuthToken);

    $people = array(
        $phoneNumber => $NameTech
    );

    foreach ($people as $number => $name) {

        $sms = $client->account->messages->create(

            $number,

            array(
                'from' => "+12569523589", 
                // the sms body
				'body' => "Hello $name, you have sent the following message: ".$Comment
            )
        );

		$return[] = array
		(
			'RESULTADO'                 => "0000", 
			'MENSAJE'                   => "SENDMESSAGE"
		);

		if(isset($_GET["callback"]))
		{	
			echo $_GET["callback"]."(" . json_encode($return) . ");";	
		}
		else
		{
			echo  json_encode($return);
		}
    }
?>