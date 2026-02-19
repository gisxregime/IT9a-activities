<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$db_server = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$db_name = 'socmed';
$db_port = 3306;

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name, $db_port);

if(!$conn){
  die('Connection failed: ' . mysqli_connect_error());
}
// echo "You are now connected.";
?>