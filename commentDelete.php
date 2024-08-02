<?php
// Include the database connection file
include 'database.php';

// Check if ID parameter is provided
if(isset($_GET['commentID'])) {
    $id = $_GET['commentID'];

    // SQL to delete a record
    $sql = "DELETE FROM comments WHERE commentID = $id";

    if ($conn->query($sql) === TRUE) {
        //echo "Student deleted successfully";
    } else {
        echo "Error deleting student: " . $conn->error;
    }

    // Redirect back to the view students page
    header("Location: comments.php");
    exit();
} else {
    echo "No comment ID specified.";
}
?>