<?php
//database connection details
$host = ""; //your addres
$user = ""; //your user
$pass = ""; //your password
$db   = ""; //your name db
$port = ""; //your port service db

$connect = pg_connect("host=$host user=$user password=$pass dbname=$db port=$port") or die ("Database or host Error".pg_last_error());

?>
