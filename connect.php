<?php

$host	= 'localhost';
$user	= 'root';
$pass	= '';
$dbname = 'online-library';

$connect = mysqli_connect($host, $user, $pass) or die('Could not connect to mysql server.');

mysqli_select_db($connect, $dbname) or die('Could not select database.');

?>