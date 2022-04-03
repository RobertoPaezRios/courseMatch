<?php 
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "coursematch";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  $_SESSION["message"] = "Connection to BBDD failed, reload the page to try again";
  $_SESSION["message_type"] = "danger";
}

?>