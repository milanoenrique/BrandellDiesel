<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo $this->getPageTitle(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/ico" href="img/favicon.ico" />
    <!--BDI Meta Tags-->
    <meta http-equiv="Expires" content="Sat, 1 Jul 2000 05:00:00 GMT">
    <meta http-equiv="Last-Modified" content="Mon, 06 May 2019 05:00:00 GMT">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-store">
    <!--BDI Vendor Assets-->
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-table.css" rel="stylesheet" type="text/css" />
    <link href="css/font-awesome.css" rel="stylesheet" />
    <link href="css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />
    <link href="css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
    <!--BDI Main Theme Styles-->
    <link href="css/theme.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/custom-theme-bdi-parch.css?v=1.00.001">
    <!--BDI Theme Styles 2020-->
    <link rel="stylesheet" href="assets/css/bdi-theme.css?v=1.00.011">
    <link rel="stylesheet" href="assets/fonts/bdi/style.css">
    <!--BDI Custom Scripts-->
    <script src="js/readyRederizSoft.js"></script>
    <script src="vendor/Print.js-1.0.18/print.min.js"></script>
    <script type="text/javascript" src="assets/js/main-theme.js?v=1.00.000"></script>

</head>

<body>

    <section class="bdi-thm-header">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">
            <div class="navbar">
                <div class="col-xs-6 ">
                <img class="logo-Size" src="assets/img/Brandell-Diesel.png">
                </div>
                <div class="col-xs-6 ">
                <ul class="nav navbar-nav navbar-right">
                    <li class="text-right"><span class="info-day" id="date">Date</span><br>
                        <?php if ($profile=='TV'): ?>
                            <a href="logout.php?logout=logout<?php echo $_SESSION['perfil']; ?>">
                                <i class="fa fa-sign-in"></i>Logout
                            </a>
                        <?php else: ?>
                            <b><?php echo $techName; ?></b>
                        <?php endif; ?>
                    </li>
                </ul>
                </div>
            </div>
            </div>
        </nav>
    </section>


    <div class="bdi-thm-main-content">

        <section class="sidenav">
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <button class="bdi-menu-collapse bdi-collapse-event">
                        Hide Menu
                        <i class="fa fa-bars"></i>
                    </button>
                </li>
                <?php $items = $this->getPageMenuItems();

                    foreach ($items as $menukey => $menuvalue) : 
                        echo self::buildMenu($menuvalue, $menukey);
                    endforeach;

                ?>
            </ul>
            <div class="bdi-collapsed-button">
                <button class="bdi-collapse-event">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
        </section>