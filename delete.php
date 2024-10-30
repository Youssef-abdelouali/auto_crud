
<?php


session_start();
require_once "pdo.php";

// if we attempt to access delete.php without loggin in
if (! isset($_SESSION['email'])) {

  die("ACCESS DENIED");
}


// here we take the auto_id from the GET
$deleteSelection = $_GET['auto_id'];
error_log("to delete:".$deleteSelection);

############################# Input Validation #################################

$stmt = $pdo -> prepare("SELECT * FROM autos WHERE auto_id = :xyz");
$stmt -> execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt -> fetch(PDO::FETCH_ASSOC);

if ($row === false) {
 $_SESSION['error'] = 'Deleted ';
 header('Location: index.php');
 return;
}

// if we have clicked the delete button, runs the SQL command to delete based on ID
if (isset($_POST['delete'])) {

  $_SESSION['delete'] = $_POST['delete'];

  $stmt = $pdo->prepare("DELETE FROM autos WHERE auto_id = :xyz");
  $stmt->execute(array(":xyz" => $_GET['auto_id']));
  header('Location: index.php');
  return;

  }

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Youssef abdelouali - Autos DB CRUD</title>
    <link rel="stylesheet" href="./Style_css/delete_css.css">
    <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
    <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
    

  </head>
  <body>

    <section class="nes-container is-dark" id="gameContainer">

    <p>Confirm: Deleting <?= htmlentities($row['make']) ?> </p>

    <form method="post">
      <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
      <button class="nes-btn is-success" type="submit" name="delete" value="Delete">Delete</button>
      <a class="nes-btn is-error" href="index.php">Cancel</a>
    </form>

    </section>

  </body>
</html>