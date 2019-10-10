<?php
include_once("config.php");
unset($_SESSION['token']);
unset($_SESSION['google_data']); //Google session data unset
$gClient->revokeToken();
session_destroy();
if($_GET["logout"]=='logout_tech') {
	header("Location:index_tech.php");
} else if($_GET["logout"]=='logout_managerg') {
	header("Location:index_managerg.php");
} else if($_GET["logout"]=='logout_manager') {
	$_SESSION['google_data']=null;
	header("Location:index_manager.php");
}
?>