<?php
session_start();
include_once("src/Google_Client.php");
include_once("src/contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = '1070163607201-n5m1k6ovlmdp60su9b6474tr8qes9714.apps.googleusercontent.com'; //Google CLIENT ID
$clientSecret = 'HE9sl3LWBWKi4lcgvKZ-jleL'; //Google CLIENT SECRET
$redirectUrl = 'http://ec2-35-160-187-229.us-west-2.compute.amazonaws.com/BrandellDiesel/index.php';  //return url (url to script)
$homeUrl = 'http://ec2-35-160-187-229.us-west-2.compute.amazonaws.com/BrandellDiesel/index.php';  //return to home

##################################

$gClient = new Google_Client();
$gClient->setApplicationName('Login to codexworld.com');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>