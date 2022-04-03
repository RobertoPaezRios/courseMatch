<?php session_start(); ?>
<?php include "./../layout/header.php"; ?>

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="../index.php">Inicio</a>
  </div>
</nav>

<div class="container">
  <div class="vh-100 row justify-content-center align-items-center"> 
    <div class="col-md-6">
      <div class="card card-body"> 
        <!-- Pagination -->
        <div>
          <nav aria-label="item-pagination">
            <ul class="pagination">
              <?php $_SESSION["actual-id-update"] = $_GET["id"]; ?>
              <?php $_SESSION["actual-title-update"] = $_GET["title"]; ?>
              <?php $_SESSION["actual-description-update"] = $_GET["description"]; ?>
              <li class="page-item">
                <form action="../controller/update_operation_previous.php" method="POST">
                  <input type="submit" name="previous-course" value="<" class="btn btn-outline-primary">
                </form>
              </li>
              <li>
                <form action="../controller/update_operation_next.php" method="POST">
                  <input type="submit" name="next-course" value=">" class="btn btn-outline-primary">
                </form>
              </li>  
            </ul>
          </nav>
        </div>
        <h1 class="text text-center">Update Course</h1><br>
          <form action="./../controller/update_course.php?id=<?= $_GET["id"]; ?>" method="POST">
            <div class="form-group">
              <input type="text" name="update-title" class="form-control" value="<?php echo $_GET["title"]; unset($_GET["title"]); ?>" placeholder="New Title" autofocus required>
            </div><br>
            <div class="form-group">
              <textarea name="update-description" rows="8" class="form-control" placeholder="New Description" required><?php echo $_GET["description"]; unset($_GET["description"]); ?></textarea>
            </div><br>
            <input type="submit" name="update_course" class="btn btn-warning col-md-12 btn-block" value="Save Course">
          </form><br>
          <!-- MESSAGES/ALERTS -->
          <?php if (isset($_SESSION['message'])) { ?>
            <div class="alert alert-<?= $_SESSION["message_type"] ?> alert-dismissible fade show" role="alert">
              <?= $_SESSION["message"]; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php unset($_SESSION["message"], $_SESSION["message_type"]); } ?>
      </div>
    </div>
  </div>
</div>
<?php include "./../layout/footer.php"; ?>