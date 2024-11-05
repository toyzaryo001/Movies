<?php
$host = "localhost";
$user = "root";
$pass = "12345678";
$dbname = "movie";

$con = mysqli_connect($host, $user, $pass, $dbname);
mysqli_query($con,"set char set utf8");

?>