<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

$servername = "localhost";
$username = "root";
$password = "";
$database = "shivani";

$conn = new mysqli($servername, $username, $password, $database);
if(!$conn){
	die("Error:".mysqli_error());
}
// else{
// 	echo "successfully connected";
// }
