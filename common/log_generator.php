<?php 
function log_message($from,$numero,$texto){ 
$ddf = fopen('../log/message_log.log','a'); 
date_default_timezone_set("America/Denver");
$micro=microtime();
$micro_array = explode(" ",$micro);
$micro=substr($micro_array[0],2);
fwrite($ddf,"[".date("Y-m-d H:i:s.").$micro."] From:".$from." To: ". $numero." Sms:".$texto."\r\n"); 
fclose($ddf); 
} 

function log_bd($texto){
	$ddf = fopen('../log/bd_log.log','a'); 
date_default_timezone_set("America/Denver");
$micro=microtime();
$micro_array = explode(" ",$micro);
$micro=substr($micro_array[0],2);
fwrite($ddf,"[".date("Y-m-d H:i:s.").$micro."] ".$texto."\r\n"); 
fclose($ddf); 

} 
?>