<?php 
session_start();

if (!empty($_POST["search-course"])) {
  if (mb_strlen($_POST["search-course"]) < 255) {
    $_SESSION["query"] = "SELECT id, title, description FROM courses WHERE
     title LIKE '%".$_POST["search-course"]."%' or description LIKE '%".$_POST["search-course"]."%' ";
    header("Location: ../index.php?page=1");
  } else {
    $_SESSION["message"] = "Search course input must be less than 255 characters";
    $_SESSION["message_type"] = "danger";
    header("Location: ../index.php?page=1");
  }
} else {
  $_SESSION["message"] = "You have to fill the search input";
  $_SESSION["message_type"] = "danger";
  header("Location: ../index.php?page=1");
}

?>