<?php 
session_start();
include "../model/db.php";

if ($_SESSION["actual-id-update"] > 1) { 
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
  $previousId = $coursesId[$actualIdPos - 1];
  $previousTitle = $coursesTitle[$actualIdPos - 1];
  $previousDescription = $coursesDescription[$actualIdPos - 1];

  if ($nItemsInArray > 1) {
    header("Location: ../views/update_view.php?id=$previousId&title=$previousTitle&description=$previousDescription");
  } else {
    header("Location: ../views/update_view.php?id=" . $_SESSION["actual-id-update"] .
    "&title=" . $coursesTitle[$actualIdPos] . "&description=" . $coursesDescription[$actualIdPos]);
  }
} else {
  header("Location: ../views/update_view.php?id=" . $_SESSION["actual-id-update"] . 
  "&title=".$_SESSION["actual-title-update"]."&description=".$_SESSION["actual-description-update"]);
}
?>