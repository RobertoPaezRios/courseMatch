<?php
session_start();
include "./../model/db.php";

if (!empty($_POST["title"]) && !empty($_POST["description"])) {
  if (mb_strlen($_POST["title"]) < 255 && mb_strlen($_POST["description"]) < 255) {
    try {
      $status = 0;
      if ($_POST["status"] == "on") { $status = 1; }
      $query = "INSERT INTO courses (title, description, status, created_at, updated_at) 
      VALUES ('" . trim($_POST["title"]) . "', '" . trim($_POST["description"]) . "', '" . $status . "',
      CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

      $conn->exec($query);
      $_SESSION["message"] = "Course created successfully";
      $_SESSION["message_type"] = "success";
      header("Location: ../index.php?page=1");
    } catch (PDOException $e) {
      $_SESSION["message"] = "Something ocurred while creating the course";
      $_SESSION["message_type"] = "danger";
      header("Location: ../index.php?page=1");
    }
  } else {
    $_SESSION["message"] = "Title and Description must be less than 255 characters and the image must be png or jpg";
    $_SESSION["message_type"] = "warning";
    header("Location: ../index.php?page=1");
  }
} else {
  $_SESSION["message"] = "Title and Description are required";
  $_SESSION["message_type"] = "warning";
  header("Location: ../index.php?page=1");
}

?>
