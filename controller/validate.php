<?php 
session_start();

$_SESSION["n-items"] = $_POST["n-items"];

header("Location: ../index.php?page=1");

?>