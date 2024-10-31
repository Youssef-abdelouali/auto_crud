<?php
    // Destroy the session to erase $_SESSION['name'] and the rest of the values stored there
    // So the user can't log in again unless the correct password is provided
    session_start();
    session_destroy();
    header('Location: index.php');
    return; 
?>