<?php 
session_start();
include "../model/db.php";

$query = "SELECT id, title, description FROM courses";
if (!empty($_SESSION["query"])) { $query = $_SESSION["query"]; }
//$conn->prepare($query);
$result = $conn->query($query);
$coursesId = array();
$coursesTitle = array();
$coursesDescription = array();

while ($row = $result->fetch()) {
  $coursesId[] = $row["id"];
  $coursesTitle[] = $row["title"];
  $coursesDescription[] = $row["description"];
}
$nItemsInArray = sizeof($coursesId);
$actualIdPos = array_search($_SESSION["actual-id-update"], $coursesId);
$nextId = $coursesId[$actualIdPos + 1];
$nextTitle = $coursesTitle[$actualIdPos + 1];
$nextDescription = $coursesDescription[$actualIdPos + 1];

if ($nItemsInArray > 1) {
  header("Location: ../views/update_view.php?id=$nextId&title=$nextTitle&description=$nextDescription");
} else {
  header("Location: ../views/update_view.php?id=" . $_SESSION["actual-id-update"] .
  "&title=" . $coursesTitle[$actualIdPos] . "&description=" . $coursesDescription[$actualIdPos]);
}
?>