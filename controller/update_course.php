<?php
include "./../model/db.php";
//include_once "./../views/update_view.php";
include "./../layout/header.php";
session_start();

if (!empty($_POST["update-title"]) && !empty($_POST["update-description"]) && !empty($_GET["id"])) {
  try {
    $statusEdit = 0;
    if ($_POST["update-status"] == "on") { $statusEdit = 1; }
    $query = "UPDATE courses SET 
    title = '" . $_POST["update-title"] . "',
    description = '" . $_POST["update-description"] .  "',
    status = '" . $statusEdit . "' 
    WHERE id = " . $_GET["id"] . ";";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $_SESSION["message"] = $stmt->rowCount() . " row was updated successfully";
    $_SESSION["message_type"] = "success";
    header("Location: ../index.php?page=1");
  } catch (PDOException $e) {
    $_SESSION["message"] = "Something goes wrong, try updating again";
    $_SESSION["message_type"] = "danger";
    header("Location: ../index.php?page=1");
  }
} else {
  $_SESSION["message"] = "The fields to update are invalid";
  $_SESSION["message_type"] = "danger";
  if (!empty($_GET["id"])) {
    if (is_int($_GET["id"])) {
      header("Location: ../views/update_view.php?id=" . $_GET["id"]);
    } else {
      header("Location: ../index.php?page=1");
    }
  } else {
    header("Location: ../views/update_view.php");
  }
}

?>