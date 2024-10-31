<?php
    session_start(); 
    require_once("pdo.php");
    // Die if the user is not logged in 
    if (! isset($_SESSION['name'])) {
        die('ACCESS DENIED');
    }

    // Redirect to view.php if the cancel button has been pressed 
    if (isset($_POST['Cancel'])) {
        header('Location: index.php');
        return; 
    }
    // If the "Add" button has been pressed, proceed to validate the data provided by the user
    if (isset($_POST['Add']) && isset($_POST['year']) && isset($_POST['mileage'])){
        if(!isset($_POST['make']) || strlen($_POST['make']) < 1){
            $_SESSION['error'] = "All fields are required";
            header('Location: add.php');
            return;
        }
        else if (is_numeric($_POST['year']) && is_numeric($_POST['mileage'])) {
            $stmt = $pdo->prepare('INSERT INTO autos(make, model, year, mileage) VALUES (:make, :model, :year, :mileage)');
            $stmt->execute(array(
                ':make' => $_POST['make'],
                ':model' => $_POST['model'],
                ':year' => $_POST['year'],
                ':mileage' => $_POST['mileage']
            ));
            $_SESSION['success'] = "Added";
            header('Location: index.php');
            return;
        }
        else {
            $_SESSION['error'] = "Mileage and year must be numeric";
            header('Location: add.php');
            return; 
        }
    }
?>


<!DOCTYPE html>
<html>
<head>
<title>Youssef abdelouali's Autos Database</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="text-white text-center w-100 p-5">
        <h1>Autos Database</h1>
        <?php
        if ( isset($_SESSION['name']) ) {
            echo "<h2>Tracking autos for: ";
            echo htmlentities($_SESSION['name']);
            echo "</h2>\n";
        }

        if (isset($_SESSION['error'])) {
            echo('<p class="bg-danger">'.htmlentities($_SESSION['error'])."</p>\n");
            unset($_SESSION['error']); 
        }
        ?>

        <h2>Add a new vehicle to the database: </h2>
        <form method="post" class="d-flex flex-column w-25 m-auto">
            <label for="make">Make: </label>
            <input type="text" name="make" id="make"><br/>
            <label for="model">Model: </label>
            <input type="text" name="model" id="model"><br/>
            <label for="year">Year: </label>
            <input type="text" name="year" id="year"><br/>
            <label for="mileage">Mileage: </label>
            <input type="text" name="mileage" id="mileage"><br/>
            <div class="d-flex flex-row position-relative m-auto w-100">
                <input class="btn btn-success m-2 w-50" type="submit" name="Add" value="Add">
                <input class="btn btn-danger m-2 w-50" type="submit" name="Cancel" value="Cancel">
            </div>
        </form>
    </div>
</body>
</html>