<?php
// Include session.php and database.php

include 'database.php';

// Check if the teacher ID is set and not empty
if (isset($_GET['teacherID']) && !empty($_GET['teacherID'])) {
    // Prepare SQL statement to delete the teacher
    $teacher_id = $_GET['teacherID'];
    $sql = "DELETE FROM teachers WHERE teacherID = $teacher_id";

    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        // Redirect to view_teachers.php with success message
        header("Location: view_teachers.php?message=Teacher deleted successfully.");
        exit();
    } else {
        // Redirect to view_teachers.php with error message
        header("Location: view_teachers.php?error=Error deleting teacher: " . $conn->error);
        exit();
    }
} else {
    // Redirect to view_teachers.php if teacher ID is not provided
    header("Location: view_teachers.php");
    exit();
}
?>
