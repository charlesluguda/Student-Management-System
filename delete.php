<?php
// Include the database connection file
include 'database.php';

// Check if ID parameter is provided
if(isset($_GET['studentID'])) {
    $id = $_GET['studentID'];

    // SQL to delete a record
    $sql = "DELETE FROM students WHERE studentID = $id";

    if ($conn->query($sql) === TRUE) {
        //echo "Student deleted successfully";
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    // Redirect back to the view students page
    header("Location: view_students.php");
    exit();
} else {
    echo "No student ID specified.";
}
?>
