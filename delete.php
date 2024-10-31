<?php
    require_once('pdo.php');
    session_start();
    if (!isset($_SESSION['name'])) {
        die('ACCESS DENIED'); 
    }

    if (isset($_POST['cancel'])) {
        header('Location: index.php');
        return; 
    }

    if (isset($_POST['Delete'])) {
        $stmt = $pdo->prepare('DELETE FROM autos WHERE auto_id = :id');
        $stmt->execute(array(
            ":id" => $_POST['auto_id']
        ));
        $_SESSION['success'] = "Record deleted"; 
        header('Location: index.php'); 
        return; 
    }

    $stmt = $pdo->prepare('SELECT auto_id, make, model FROM autos WHERE auto_id = :id');
    $stmt->execute(array(
        ":id" => $_GET['auto_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row == false) {
        $_SESSION['error'] = "Bad value for id";
        header("Location: index.php");
        return; 
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youssef abdelouali's Autos Database</title>
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
    <link rel="stylesheet" href="./Style_css/delete_css.css">
</head>
<body>
    <div class="text-white text-center w-100 p-5 position-absolute top-50">
        <h3>Confirm deleting <?= htmlentities($row['make'])." ". htmlentities($row['model'])?> ?</h3>
        <form method="post">
            <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
            <input class="btn btn-danger" type="submit" name="Delete" value="Delete">
            <input class="btn btn-light" type="submit" name= "cancel" value = "Cancel">
        </form>
    </div>
</body>
</html>