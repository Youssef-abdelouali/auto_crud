<?php
    require_once('pdo.php');
    session_start(); 
    if (! isset($_SESSION['name'])) {
        die('ACCES DENIED');
    }
    if (isset($_POST['cancel'])) {
        header('Location: index.php');
    }

    if (isset($_POST['Save'])) {
        if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['model']) && isset($_POST['mileage'])) {
            if (!(is_numeric($_POST['year']) && is_numeric($_POST['mileage']))) {
                $_SESSION['error'] = "Year and mileage must be numeric";
                header('Location: edit.php?auto_id='.$_POST['auto_id']);
                return;
            }

            if (strlen($_POST['make']) < 2 || strlen($_POST['model']) < 2) {
                $_SESSION['error'] = "Make and model are required";
                header('Location: edit.php?auto_id='.$_POST['auto_id']);
                return; 
            }
            $stmt = $pdo->prepare('UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage WHERE auto_id = :id'); 
            $stmt->execute(array(
                ':id' => $_POST['auto_id'],
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']
            )); 
            $_SESSION['success'] = "Record updated"; 
            header('Location: index.php');
            return; 
        } else {
            $_SESSION['error'] = "All fields are required";
            header('Location: edit.php?auto_id='.$_POST['auto_id']);
            return; 
        }
    }

    $stmt = $pdo->prepare('SELECT auto_id, make, model, year, mileage FROM autos WHERE auto_id = :id');
    $stmt->execute(array(
        ":id" => $_GET['auto_id']
    )); 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row == false) {
        $_SESSION['error'] = 'Bad auto id';
        header('Location: index.php');
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
    <link rel="stylesheet" href="./Style_css/Edit_css.css">
</head>
<body>
    <div class="text-white text-center w-100 p-5">
        <?php 
            if (isset($_SESSION['error'])) {
                echo "<p class='bg-danger'>".$_SESSION['error']."</p>"; 
                unset($_SESSION['error']);
            }
        ?>
        <h1>New changes for <?= $row['make']." ".$row['model'] ?></h1>
        <form method="post" class="d-flex flex-column w-25 m-auto">
            <label for="make">Make: </label>
            <input type="text" name="make" id="make" value="<?= $row['make'] ?>"><br/>
            <label for="model">Model: </label>
            <input type="text" name="model" id="model" value="<?= $row['model'] ?>"><br/>
            <label for="year">Year: </label>
            <input type="text" name="year" id="year" value="<?= $row['year'] ?>"><br/>
            <label for="mileage">Mileage: </label>
            <input type="text" name="mileage" id="mileage" value="<?= $row['mileage'] ?>"><br/>
            <input type="hidden" name="auto_id" value="<?= $row['auto_id']?>">
            <div class='d-flex flex-row position-relative m-auto w-100'>
                <input class="btn btn-success m-2 w-50" type="submit" name="Save" value="Save">
                <input class="btn btn-light m-2 w-50" type="submit" name="cancel" value="Cancel">
            </div>
        </form>
    </div>
</body>
</html>