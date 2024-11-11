<?php
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "cursosonline";
try{
	$conn = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password );
	$conn -> setAttribute(PDO :: ATTR_ERRMODE, PDO :: ERRMODE_EXCEPTION);
	echo "Connection succesfully";
	} 
	catch(PDOException $e) {
	echo "Connection failed: ", $e -> getMessage();
	} 
?>