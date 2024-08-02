<?php
 session_start();

// Check if the user is not logged in, redirect to login page
if (!isset($_SESSION['Email'])) {
    header("location: teacher_login.php");
    exit;
}
?>
