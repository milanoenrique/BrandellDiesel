<?php
	header('Content-Type: text/html; charset=utf-8');
	require_once "../vendor/autoload.php";
    use Twilio\Rest\Client;
	
	$v 				= $_GET['v'];
    $valor 			= explode("|", $v);

    $phoneNumber	= $valor[0];
    $NameTech    	= $valor[1];
    $Comment		= $valor[2];
	$techName		= $valor[3];
    
    $AccountSid = "AC858556eeb30f04e1bc89bfb4f58c843f";
    $AuthToken = "fdf0a7fbd7ad4faed96d28efc89ceba7";

    $client = new Client($AccountSid, $AuthToken);

    $people = array(
        $phoneNumber => $NameTech
    );

    foreach ($people as $number => $name) {

        $sms = $client->account->messages->create(

            $number,

            array(
                'from' => "+15873175836", 
                // the sms body
				//'body' => "Hello $name, you have sent the following message: ".$Comment
				'body' => "$techName says: ".$Comment
            )
        );

		$return[] = array
		
		(
			'RESULTADO'                 => "0000", 
			'MENSAJE'                   => "The message to $name was sent successfully."
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