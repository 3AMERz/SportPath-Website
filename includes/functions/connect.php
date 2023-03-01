<?php

// $dsn = 'mysql:host=localhost;dbname=project';
// $user = 'root';
// $pass = '';
// $option = array(
//     PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
// );

// try{
//     $conn = new PDO($dsn,$user,$pass,$option);
//     $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// }
// catch(PDOException $e){
//     echo 'Filed To Connect ' . $e -> getMessage();
// }





$servername = "localhost";
$username = "u677478709_sportpath";
$password = "2x*Uk];3Tx?4";
$dbname = "u677478709_sportpath";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

