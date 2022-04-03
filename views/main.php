<?php session_start(); ?>
<?php include "./model/db.php"; ?>

<?php
//Count items
$query = "SELECT id, title, description FROM courses";
if (!empty($_SESSION["query"])) { $query = $_SESSION["query"]; }
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll();
$itemsPerPage = 5;
if (isset($_SESSION["n-items"])) {
  $itemsPerPage = intval($_SESSION["n-items"]);
}
$nItems = $stmt->rowCount();
//echo $nItems;
$pages = $nItems / $itemsPerPage;
$pages = ceil($pages);
if ($_GET["page"] > $pages || $_GET["page"] <= 0) { $_GET["page"] = 1; }
//Show items
$start = ($_GET["page"] - 1) * $itemsPerPage;
$queryCourses = $query . " LIMIT :start, :nitems;";
$resultCourses = $conn->prepare($queryCourses);
$resultCourses->bindParam(":start", $start, PDO::PARAM_INT);
$resultCourses->bindParam(":nitems", $itemsPerPage, PDO::PARAM_INT);
$resultCourses->execute();
$rsCourses = $resultCourses->fetchAll();
?>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="./index.php?page=1">Inicio</a>
    <!-- Search Course Form -->
    <?php if (isset($_SESSION["query"])) { 
      if ($_SESSION["query"] != "SELECT id, title, description FROM courses;") { ?>
      <form action="./controller/validate_search.php" method="POST">
        <input type="submit" name="reload-default" value="Reload by Default" class="btn btn-primary">
      </form>
    <?php }} ?>
    <form class="d-flex" action="./controller/search_course.php" method="POST">
      <input class="form-control me-2" type="search" required name="search-course" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-warning" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
  </div>
</nav>

<main class="container p-4">
  <div class="row">
    <div class="col-md-4">
      <!-- MESSAGES -->
      <?php if (isset($_SESSION['message'])) { ?>
        <div class="alert alert-<?= $_SESSION["message_type"] ?> alert-dismissible fade show" role="alert">
          <?= $_SESSION["message"]; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php unset($_SESSION["message"], $_SESSION["message_type"]); } ?>
      <?php if (!$_GET) { header("Location: index.php?page=1"); }?>
      <!-- ADD COURSE FORM -->
      <div class="card card-body">
        <form action="./controller/create_course.php" method="POST">
          <div class="form-group">
            <input type="text" name="title" class="form-control" placeholder="Course Title" autofocus required>
          </div><br>
          <div class="form-group">
            <textarea name="description" rows="6" class="form-control" placeholder="Course Description" required></textarea>
          </div><br>
          <input type="submit" name="save_course" class="btn btn-success col-md-12 btn-block" value="Save Course">
        </form><br>
        <!-- Items per Page Form -->
        <form action="./controller/validate.php" method="POST">
          <span>Items per Page:</span>
          <select aria-label="Items per Page" name="n-items">
            <option value="5"  <?php if (isset($_SESSION["n-items"]) && $_SESSION["n-items"] == 5) { echo "selected"; } ?>>5</option>
            <option value="10" <?php if (isset($_SESSION["n-items"]) && $_SESSION["n-items"] == 10) { echo "selected"; } ?>>10</option>
            <option value="15" <?php if (isset($_SESSION["n-items"]) && $_SESSION["n-items"] == 15) { echo "selected"; } ?>>15</option>
            <option value="20" <?php if (isset($_SESSION["n-items"]) && $_SESSION["n-items"] == 20) { echo "selected"; } ?>>20</option>
          </select> 
          <input type="submit" value="Apply Changes" class="btn btn-primary text-light">
        </form>
      </div>
    </div>
    <div class="col-md-8">
      <div class="justify-content-center align-items-center">
        <!-- Pagination Buttons -->
        <nav aria-label="Page Navigation">
          <ul class="pagination">
            <?php if ($_GET["page"] >= 5 && $_GET["page"] != $pages) { ?>
              <!-- Page - 1 -->
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"] - 1;?>"
                aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=1">
                  <span aria-hidden="true">1</span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"]; ?>">
                  <span aria-hidden="true">...</span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"] - 5; ?>">
                  <span aria-hidden="true"><?php echo $_GET["page"] - 5; ?></span>
                </a>
              </li>
              <li class="page-item active">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"]; ?>">
                  <span aria-hidden="true"><?php echo $_GET["page"]; ?></span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"] + 5; ?>">
                  <span aria-hidden="true"><?php echo $_GET["page"] + 5; ?></span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"]; ?>">
                  <span aria-hidden="true">...</span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $pages; ?>">
                  <span aria-hidden="true"><?php echo $pages; ?></span>
                </a>
              </li>
              <!-- Page + 1 -->
              <li class="page-item">
                <a class="page-link"
                href="index.php?page=<?php echo $_GET["page"] + 1;?>"
                aria-label="Previous">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>    
            <?php } else { ?>
              <li class="page-item">
                <a class="page-link <?php if($_GET["page"] == 1) { echo "d-none"; } ?>"
                href="index.php?page=<?php echo $_GET["page"] >= 2 ? $_GET["page"] - 1 : $_GET["page"]; ?>"
                aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php if ($pages >= 5) { ?>
                <?php for ($i = 0; $i < 5; $i++) { ?>
                  <li class="page-item <?php echo $_GET["page"] == $i + 1 ? "active" : ""; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i + 1; ?>">
                      <?php echo $i + 1; ?>
                    </a>
                  </li>
                <?php } ?>
              <?php } else { ?>
                <?php for ($i = 0; $i < $pages; $i++) { ?>
                  <li class="page-item <?php echo $_GET["page"] == $i + 1 ? "active" : ""; ?>">
                    <a class="page-link" href="index.php?page=<?php echo $i + 1; ?>">
                      <?php echo $i + 1; ?>
                    </a>
                  </li>
                <?php } ?>
              <?php } ?>
              <li class="page-item">
                <a class="page-link" href="index.php?page=6">
                  <span aria-hidden="true">...</span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link" href="index.php?page=20004">
                  <span aria-hidden="true">20004</span>
                </a>
              </li>
              <li class="page-item">
                <a class="page-link <?php if ($_GET["page"] == $pages || $pages == 0) { echo "d-none"; } ?>" href="index.php?page=<?php echo $_GET["page"] < $pages ? $_GET["page"] + 1 : $_GET["page"]; ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            <?php  } ?>
          </ul>
        </nav>
      </div>
      <?php if ($pages >= 1) { ?>
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <th>Id</th>
            <th>Title</th>
            <th>Description</th>
            <th>Actions</th>
          </thead>
          <tbody>
            <?php 
              foreach ($rsCourses as $row) { ?>
                <tr>
                  <td><?= $row["id"]; ?></td>
                  <td><?= $row["title"]; ?></td>
                  <td><?= $row["description"]; ?></td>
                  <td> 
                    <a class="text-decoration-none" href="./views/update_view.php?id=<?= $row["id"]; ?>&title=<?= $row["title"]?>&description=<?= $row["description"];?>">
                      <button class="btn btn-warning">
                        <i class="fa-solid fa-pen"></i>
                      </button>
                    </a>
                    <a href="./controller/delete_course.php?id=<?= $row ["id"]; ?>">
                      <button class="btn btn-danger">
                        <i class="fa-solid fa-trash-can"></i>
                      </button>
                    </a>
                  </td>
                </tr>
              <?php } ?>
          </tbody>
        </table>
      </div>
      <?php } else { ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Something ocurred while charging the courses! 0 results found!</strong>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      <?php } ?>
    </div>
  </div>
</main>