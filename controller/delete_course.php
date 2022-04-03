<?php 
session_start();
include "./../model/db.php";

if (isset($_GET["id"])) {
  try {
    $query = "DELETE FROM courses WHERE id = " . $_GET["id"] . ";";
    $conn->exec($query);
    $_SESSION["message"] = "Course deleted successfully";
    $_SESSION["message_type"] = "success";
    header("Location: ../index.php?page=1");
  } catch (PDOException $e) {
    $_SESSION["message"] = "Couldn't delete the course :(";
    $_SESSION["message_type"] = "danger";
    header("Location: ../index.php?page=1");  
  }
} else {
  $_SESSION["message"] = "Couldn't delete the course :(";
  $_SESSION["message_type"] = "danger";
  header("Location: ../index.php?page=!");
}

?>