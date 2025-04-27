<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // User is not logged in, redirect to the main index page
    header('Location: ../index.php');
    exit;
}

// Continue with authenticated page content if the user is logged in
?>