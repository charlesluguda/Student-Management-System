<?php
// Include session.php and database.php
include 'session.php';
include 'database.php';

// Check if subject ID is provided
if (isset($_GET['subject_id']) && !empty($_GET['subject_id'])) {
    $subject_id = $_GET['subject_id'];

    // Prepare SQL statement to delete subject
    $deleteSQL = "DELETE FROM subjects WHERE subject_id=$subject_id";

    // Execute the SQL statement
    if ($conn->query($deleteSQL) === TRUE) {
        // Redirect to view_subjects.php with success message
        header("Location: view_subjects.php?message=Subject deleted successfully.");
        exit();
    } else {
        // Redirect to view_subjects.php with error message
        header("Location: view_subjects.php?error=Error deleting subject: " . $conn->error);
        exit();
    }
} else {
    // Redirect to view_subjects.php if subject ID is not provided
    header("Location: view_subjects.php");
    exit();
}
?>
