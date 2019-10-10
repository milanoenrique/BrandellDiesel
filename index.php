<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once("config.php");
include_once("includes/functions.php");

//print_r($_GET);die;

if(isset($_REQUEST['code'])){
	$gClient->authenticate();
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	$userProfile = $google_oauthV2->userinfo->get();
	//DB Insert
	//$gUser = new Users();
	//$gUser->checkUser('google',$userProfile['id'],$userProfile['given_name'],$userProfile['family_name'],$userProfile['email'],$userProfile['gender'],$userProfile['locale'],$userProfile['link'],$userProfile['picture']);
	$_SESSION['google_data'] = $userProfile; // Storing Google User Data in Session
	header("location: dashboard.php");
	$_SESSION['token'] = $gClient->getAccessToken();
} else {
	$authUrl = $gClient->createAuthUrl();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Freelancer - Start Bootstrap Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Theme CSS -->
    <link href="css/freelancer.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]--> 

    <!-- Bootstrap -->
    <link href='https://fonts.googleapis.com/css?family=Questrial' rel='stylesheet' type='text/css'>
    <link href="<?php echo "$vPath" ?>css/style.css" rel="stylesheet">
	
	<link  href="<?php echo "$vPath" ?>css/morris.css" rel="stylesheet">
	<link href="<?php echo "$vPath" ?>css/admin.css" rel="stylesheet">
	
	<link href="<?php echo "$vPath" ?>css/style-color-3.css" rel="stylesheet">
	
	<link href="<?php echo "$vPath" ?>css/style-color-4.css" rel="stylesheet">
	
	<style type="text/css">
		fieldset.scheduler-border {
			width: 100%; 
			border: 2px groove #0063CB !important;
			padding: 0 1.4em 1.4em 1.4em !important;
			margin: 0 0 1.5em 0 !important;
			border:#f00 1px solid;
			-webkit-border-radius: 8px;
			-moz-border-radius: 8px;
			border-radius: 8px;
		}

		legend.scheduler-border {
			font-size: 0.9em !important;
			font-weight: bold !important;
			text-align: left !important;
			width:auto;
			padding:0 10px;
			border-bottom:none;
			--background-color: #00a94f !important;
		}	

		#div11,#div21,#div31 {
			display: none
		}
		
		h1
		{
		font-family:Arial, Helvetica, sans-serif;
		color:#999999;
		}
		.wrapper{width:600px; margin-left:auto;margin-right:auto;}
		.welcome_txt{
			margin: 20px;
			background-color: #EBEBEB;
			padding: 10px;
			border: #D6D6D6 solid 1px;
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border-radius:5px;
		}
		.google_box{
			margin: 20px;
			background-color: #FFF0DD;
			padding: 10px;
			border: #F7CFCF solid 1px;
			-moz-border-radius:5px;
			-webkit-border-radius:5px;
			border-radius:5px;
		}
		.google_box .image{ text-align:center;}
	
	</style>

</head>

<body id="page-top" class="index">
	<div hidden>
		<img src="https://mail.google.com/mail/u/0/?logout&hl=en"/>
	</div>
    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
			<div class="row">
				<div class="col-lg-4">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header page-scroll">
						<a class="navbar-brand" href="#page-top"><font color='#04B404'>Brandell Diesel Inc.</font></a>
					</div>
				</div>
				<div class="col-lg-6"></div>
				<div class="col-lg-2">
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
						<img src="img/logo_bdi_der.png" alt="" border="0" class="fill img-responsive" width="100" height="100">
					</div>
				</div>
				<!-- /.navbar-collapse -->
			</div>
			<!-- /.container-fluid -->
		</div>
    </nav>

    <!-- Header -->
    <header>
			<div class="container">
				<div class="row">
					<div class="col-lg-2"></div>
					<div class="col-lg-4">
						<fieldset class="scheduler-border" style="height:240px">
							<legend class="scheduler-border">Login with personal account</legend>
							<div class="intro-text">
								<!--<form id="form-login" method="POST" action="callCenter/callCenter.php">-->
								<form>
									<label>Email:</label>
									<input class="form-control" type="text" name="mail">
									<label>Contraseña:</label>
									<input class="form-control" type="password" name="password"><p></p>
									<div class="message">
										<?php echo '$message'; ?>
										<a href="perro.html"><button  class="btn btn-default pull-right" ><i class="fa fa-power-off"></i> Iniciar sesión</button></a>
									</div>        
								</form>
							</div>
						</fieldset>
					</div>
					<div class="col-lg-4">
						<!-- <img src="img/technical.png" alt="" border="0" class="fill img-responsive" width="100" height="100"> -->
						<fieldset class="scheduler-border" style="height:240px">
							<legend class="scheduler-border">Login with email account</legend>
							<div class="intro-text">
								<?php
								if(isset($authUrl)) {
									if (strpos($authUrl, '/ServiceLogin?')===false) {
										$authUrl = str_replace("approval_prompt=force","approval_prompt=auto",$authUrl);
									}
									echo '<a href="'.$authUrl.'"><img src="images/glogin.png" alt=""/></a>';
								} else {
									echo '<a href="logout.php?logout">Logout</a>';
								}
								?>
							</div>
						</fieldset>
					</div>
					<div class="col-lg-2"></div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="intro-text">
							<span class="name">Brandell Diesel Inc.</span>
							<hr class="star-light">
							<span class="skills">Common Sense Service.</span>
						</div>
					</div>
				</div>
			</div>
		
    </header>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
					<font color='#04B404'>
                        <h3>Location</h3>
                        <p>4985 72nd Ave SE, Calgary,<br> AB T2C 3H3, Canada</p>
					</font>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Around the Web</h3>
                        <ul class="list-inline">
                            <li>
                                <a href="https://www.facebook.com/Brandell-Diesel-Inc-137099949803619/?fref=nf" class="btn-social btn-outline"><i class="fa fa-fw fa-facebook"></i></a></font>
                            </li>
                            <li>
                                <a href="http://www.brandelldiesel.com/contact-us/" class="btn-social btn-outline"><i class="fa fa-fw fa-google-plus"></i></a>
                            </li>
                            <li>
                                <a href="http://www.brandelldiesel.com/contact-us/" class="btn-social btn-outline"><i class="fa fa-fw fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="http://www.brandelldiesel.com/contact-us/" class="btn-social btn-outline"><i class="fa fa-fw fa-linkedin"></i></a>
                            </li>
                            <li>
                                <a href="http://www.brandelldiesel.com/contact-us/" class="btn-social btn-outline"><i class="fa fa-fw fa-dribbble"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="footer-col col-md-4">
					<font color='#04B404'>
                        <h3>About BDI</h3>
                        <p>BDI has experienced rapid growth with a reputation as being one of Calgary’s Premier Diesel specialists.</p>
					</font>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Your Website 2016
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>


</body>

</html>
