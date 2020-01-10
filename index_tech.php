<?php
include_once("config.php");
include_once("includes/functions.php");

/* Creamos la sesión */
$_SESSION['perfil'] = '_tech';
	
//print_r($_GET);die;
$message = "Enter username and password";
if(count($_POST)>0) {
	if (isset($_POST['userName']) && isset($_POST['password']) ) {
		// Compruebo si los datos introducidos son correctos    
		$resultArray = getValidateUser($_POST['userName'], $_POST['password'], 'A', 'A');	
		if ( ( $resultArray["status"]=='success' ) or ( $resultArray["status"]=='true' ) ) {
			$_SESSION['getValidateUser']=$resultArray;
			$_SESSION["expire"]=time();
			header("Location:dashboard.php");
			//echo '$_SESSION[getValidateUser][iduser]1111='.$_SESSION['getValidateUser']["idUser"];
			//echo '$_SESSION[expire] 1111='.$_SESSION["expire"] ;
		} else {
			//si no existe se va a login.php
			$message='Invalid Username or Password';
		}
	} else {
		session_unset();
		$message = "Invalid Username or Password";
	}
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

    <title>Brandell Diesel - Diesel, Deletes, Tuning and Trucks Repair</title>
	
	<link rel="shortcut icon" type="image/ico" href="img/favicon.ico"/>

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
			border: 2px groove #009207 !important;
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
		
		.cn {
		  vertical-align: middle;
		  text-align: center;
		  align-items: center;
		}
		
		.phone-number-seccion {
			margin-top: 20px;
			font-size: 18px;
			font-weight: bold;
		}
		
		.phone-number-seccion, .phone-number-seccion a {
			color: #009207;
		}
	
	</style>

</head>

<body id="page-top" class="index">
	<div hidden>
		<!-- <img src="https://mail.google.com/mail/u/0/?logout&hl=en"/> -->
	</div>
	<!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
			<div class="row">
				<div class="content-header col-xs-16 col-sm-16 col-md-16 col-lg-16">
					
					<div class="col-xs-16 col-sm-16 link-logos" href="/" title="Brandell Diesel" rel="home">
						<div class="row logos">
							<div class="logo-left col-xs-2 col-sm-2 col-md-2 col-lg-2">
								<a href="https://www.brandelldiesel.com/">
									<img width="100%" class="wp-post-image" src="/BrandellDiesel_new/images/logo_bdi_izq.png">
								</a>
							</div>
							<div class="cn logo-center col-xs-7 col-sm-7 col-md-7 col-lg-7">
								<br><br>
								<a href="https://www.brandelldiesel.com">
									<img width="100%" class="wp-post-image" src="/BrandellDiesel_new/images/header-icono3.png">
								</a>
								<!--<p class="phone-number-seccion">Contact us: <a onclick="goog_report_conversion ('tel:403-271-0101')" href="tel:403-271-0101" class="tracking-phone-number"><font color='#fff'>403-271-0101</font></a> - info@bdicalgary.com</p>-->
							</div>
							<div class="logo-right col-xs-2 col-sm-2 col-md-2 col-lg-2">
								<a href="https://www.brandelldiesel.com">
																	</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /.container-fluid -->
		</div>
    </nav>
    <!-- Header -->
    <header>
			<div class="container">
				<div class="row">
					<div class="col-lg-4"></div>
					<div class="col-lg-4">
						<br>
						<fieldset class="scheduler-border" style="height:240px;">
	<br>						<div class="intro-text">
								<form id="form-login" method="post" action="">
									<label>User:</label>
									<input class="form-control" type="text" name="userName">
									<label>Password:</label>
									<input class="form-control" type="password" name="password"><p></p>
									<div class="message">
										<?php echo $message; ?>
										<button type="submit" class="btn btn-default pull-right"><i class="fa fa-power-off"></i>Log on</button>    
									</div>									
								</form>
							</div>
						</fieldset>
					</div>
					<div class="col-lg-4"></div>
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
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; Brandell Diesel 2016
                    </div>
                </div>
				<div class="row">
                    <div class="col-lg-12">
                        
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
