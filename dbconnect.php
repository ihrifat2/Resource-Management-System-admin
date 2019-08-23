<?php

//database connection variable
$host 	= "localhost";
$user 	= "root";
$pass 	= "";
$db 	= "rms_db";

//database connection
$dbconnect = mysqli_connect($host, $user, $pass, $db) or die ("Error while connecting to database.");

?>