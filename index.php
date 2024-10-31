<?php
    session_start();
    function displayLoginMessage(){
        echo "<a style='color:purple;' href='login.php'>Please log in</a>";
        echo "<p> Do not attempt to <a a style='color:red;' href='add.php'>Add data</a> without logging in </p>"; 
    }

    function displayRow(array $row){
        echo "<tr class='bg-white'><td>";
        echo(htmlentities($row['make']));
        echo "</td><td>";
        echo (htmlentities($row['model']));
        echo "</td><td>";
        echo (htmlentities($row['year']));
        echo "</td><td>";
        echo (htmlentities($row['mileage']));
        echo "</td><td>";
        echo "<a class='link-primary' href='edit.php?auto_id=".$row['auto_id']."'>Edit</a> / ";
        echo "<a class='link-primary' href='delete.php?auto_id=".$row['auto_id']."'>Delete</a>";
        echo "</td></tr>";
    }

    function displayRecords(){
        require_once('pdo.php'); 
        $stmt = $pdo->query('SELECT auto_id, make, year, mileage, model FROM autos ORDER BY make');
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<table border='2' class='table'>"; 
            echo "<thead class='thead-dark'><tr><th scope='col'>Make</th><th scope='col'>Model</th><th scope='col'>Year</th><th scope='col'>Mileage</th><th scope='col'>Action</th></tr></thead>"; 
            echo "<tbody>";
            displayRow($row); 
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                displayRow($row);
            }
            echo "</tbody>"; 
            echo  "</table>";
        } else {
            echo "<p>No rows found</p><br/>"; 
        }
    }

    function displayCube(){
        echo('<div class="cube">
        <div class="cuboid slice">
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
        </div>
        <div class="cuboid slice">
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
        </div>
        <div class="cuboid slice">
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
        </div>
        <div class="cuboid slice">
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
            <div class="cuboid__face"></div>
        </div>
        <div class="drop">
            <div class="shadow slice"></div>
            <div class="shadow slice"></div>
            <div class="shadow slice"></div>
            <div class="shadow slice"></div>
        </div>
        </div>'); 
    }
?>

<!DOCTYPE html>
<html>
<head>
<title>Youssef abdelouali - Autos database</title>
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
<link rel="stylesheet" href="./Style_css/index.css">
</head>
<body>
    <div class="text-white text-center w-100 p-5"> 
        <h1 class="h-100">Welcome to the Autos database!</h1>
        
        <?php
        // Display success message before the table
            if (isset($_SESSION['success'])) {
                echo('<p class="bg-success">'.htmlentities($_SESSION['success'])."</p>\n");
                unset($_SESSION['success']); 
            }

            if (isset($_SESSION['error'])) {
                echo('<p class="bg-danger">'.htmlentities($_SESSION['error'])."</p>\n");
                unset($_SESSION['error']); 
            }

            if (!isset($_SESSION['name'])) {
                displayLoginMessage();
            } else {
                displayRecords();
                echo '<a style="color:white;" href="add.php">Add New Entry</a> <br/>';
                echo '<a style="color:white;" href="logout.php">Logout</a>';
            }
        ?>
    </div>
    <?php
        if (!isset($_SESSION['name'])) {
            displayCube();
        }
    ?>
</body>