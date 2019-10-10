<?php
    header('Content-Type: text/html; charset=utf-8');
    /*
    $user = 'roger';
    $passwd = 'roger';
    $db = 'BrandellDiesel';
    $port = 5432;
    $host = 'localhost';
    $strCnx = "host=$host port=$port dbname=$db user=$user password=$passwd";
    $cnx = pg_connect($strCnx) or die ("Error de conexion. ". pg_last_error());
    echo "Conexion exitosa <hr>"; 
    $statement = pg_prepare($cnx, "dashboard_lookup", "SELECT * FROM dashboard_lookup('')");
    $ValParam = array();
    $recordset = pg_execute($cnx, "dashboard_lookup", $ValParam);
    $retorno = pg_fetch_all($recordset);
    */

    $dbh = new PDO('pgsql:host=localhost port=5432 dbname=BrandellDiesel user=postgres password=123456');