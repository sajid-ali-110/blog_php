<?php
    session_start();  // Start the session
    session_unset();  // Unset all session variables
    session_destroy(); // Destroy the session

    // Redirect to login page or any other page
    header("Location: login.php");
    exit();
?>