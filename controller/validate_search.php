<?php
session_start();

//$_SESSION["query"] = "SELECT id, title, description FROM courses";
unset($_SESSION["query"]);

header("Location: ../index.php?page=1");
?>