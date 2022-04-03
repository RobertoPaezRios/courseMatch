<?php session_start(); ?>
<?php include "./layout/header.php"; ?>
<?php include "./model/db.php"; ?>
<?php if (empty($_GET["page"])) { $_GET["page"] = 1; } ?>
<?php include "./views/main.php"; ?>

<?php include "./layout/footer.php"; ?>